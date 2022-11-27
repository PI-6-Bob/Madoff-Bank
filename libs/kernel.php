<?php

require_once 'libs/autoloader.php';
require_once 'libs/attributes.php';
require_once 'libs/database.php';
require_once 'libs/error_pages.php';
require_once 'libs/sessions.php';
require_once 'libs/utils.php';

use libs\Attribute\Route;
use libs\Attribute\Service;
use libs\Attribute\Task;

const TMP_DIR = __DIR__ . '/../.tmp';

# Load ini files for configuration
$_ENV += parse_ini_file(__DIR__ . '/../site.env', true);
if (file_exists(__DIR__ . '/../local.ini')) # Load local file if exists
	$_ENV += parse_ini_file(__DIR__ . '/../local.env', true);

# Set the configuration for php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
ini_set('session.name', $_ENV['SESSION_NAME'] ?? null);
ini_set('session.cookie_samesite', 'Lax');
ini_set('session.cookie_httponly', 1);
ini_set('session.save_path', TMP_DIR);
ini_set('upload_tmp_dir', TMP_DIR);
header_remove('X-Powered-By');

class App
{
	private array $services = [];
	private array $routes = [ 'paths' => [], 'routes' => [] ];
	private array $tasks = [];
	
	public function __construct(array $workers) {
		$workers = array_merge([ 
			NotFound::class,
			InternalError::class,
	    Database::class,
			Session::class,
		], $workers);
		foreach ($workers as $class) {
			$reflection = new ReflectionClass($class);
			/** @var ReflectionAttribute */
			foreach ($reflection->getAttributes() as $attr) {
				$meta = $attr->newInstance();
				$meta->class = $class;
				switch ($meta::class) {
					case Service::class:
						$this->add_service($meta);
						break;
				}
			}

			foreach ($reflection->getMethods() as $method_rf) {
				foreach($method_rf->getAttributes() as $attr) {
					$meta = $attr->newInstance();
					$meta->class = $class;
					$meta->fn = $method_rf->getName();
					switch ($meta::class) {
						case Route::class:
							$this->add_route($meta);
							break;
						case Task::class:
							$attributes = $reflection->getAttributes(Service::class);
							if (empty($attributes))
								throw new Exception('Task has no service');
							$attr = reset($attributes);
							/** @var Service */
							$service = $attr->newInstance();
							$meta->service = $service->name;
							$this->add_task($meta);
							break;
					}
				} // attr
			} // method_rf
		} // workers
	}

	private function add_task(Task $task) {
		if (!isset($this->tasks[$task->task]))
			$this->tasks[$task->task] = new SplPriorityQueue();
		/** @var SplPriorityQueue */
		$task_queue = $this->tasks[$task->task];
		$task_queue->insert($task, $task->weight);
	}

	private function add_service(Service $service) {
		$this->services[$service->name] = new $service->class($this);
	}

	private function add_route(Route $route) {
		if (isset($route->path))
			$this->routes['paths'][$route->path] = $route->name;
		$this->routes['routes'][$route->name] = $route;
	}

	public function route(string $name): ?Route {
		return $this->routes['routes'][$name] ?? null;
	}

	public function run(string $uri, string $method) {
		try {
			$url_path = parse_url($uri, PHP_URL_PATH);
			$method = strtolower($method);
			$route_name = $this->routes['paths'][$url_path] ?? 'error.not_found';
			$request = [
				'headers' => getallheaders(),
				'cookies' => $_COOKIE,
				'params' => $_GET,
				'data' => $_POST,
				'path' => $url_path,
				'method' => $method,
				'route' => $this->route($route_name),
			];
			$this->execute('router.before', $request, $route_name);
			$route = $this->route($route_name);
			$request['route'] = $route;
			/** @var Route */
			if (isset($route->method) && strcmp($method, $route->method) != 0)
				$route = $this->routes['routes']['error.not_found'];
			$controller = new $route->class($this);
			$response = $controller->{$route->fn}($request);
			$this->execute('router.after', $request, $response);
			echo $response;
		} catch(Error|Exception $e) {
			$route = $this->route('error.internal');
			$controller = new $route->class($this);
			$response = $controller->{$route->fn}($request);
		}
	}

	public function service(string $name): ?object {
		return $this->services[$name] ?? null;
	}

	public function execute(string $task_name, &...$args) {
		/** @var SplPriorityQueue */
		$task_queue = $this->tasks[$task_name] ?? [];
		/** @var Task */
		foreach ($task_queue as $task) {
			$service = $this->service($task->service);
			$service->{$task->fn}(...$args);
		}
	}
}

abstract class Controller 
{
	protected Session $session;
	protected Database $db;

	public function __construct(App $app) {
		$this->session = $app->service('session.manager');
		$this->db = $app->service('database');
	}

	final protected function page(string $file, array $data = []) {
		if ($this->session->isLogged())
			$data['_session'] = $_SESSION;
		page($file, $data);
	}
}
