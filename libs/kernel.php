<?php

require_once 'libs/autoloader.php';
require_once 'libs/attributes.php';
require_once 'libs/database.php';
require_once 'libs/routes.php';
require_once 'libs/utils.php';

use libs\Attribute\Route;
use libs\Attribute\Service;
use libs\Attribute\Task;

# Load ini files for configuration
$_ENV += parse_ini_file(__DIR__ . '/../site.env', true);
if (file_exists(__DIR__ . '/../local.ini')) # Load local file if exists
	$_ENV += parse_ini_file(__DIR__ . '/../local.env', true);

# Set the configuration for php
ini_set('session.cookie_samesite', 'Lax');
ini_set('session.cookie_httponly', 1);
header_remove('X-Powered-By');

class App
{
	private array $services = [];
	private array $routes = [ 'paths' => [], 'routes' => [] ];
	private array $tasks = [];
	
	public function __construct(array $workers) {
		$workers[] = NotFound::class;
		foreach ($workers as $class) {
			$reflection = new ReflectionClass($class);
			/** @var ReflectionAttribute */
			foreach ($reflection->getAttributes() as $attr) {
				$meta = $attr->newInstance();
				$meta->class = $class;
				switch ($meta::class) {
					case Task::class:
						$this->add_task($meta);
						break;
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

	public function run(string $uri, string $method) {
		$url_path = parse_url($uri, PHP_URL_PATH);
		$method = strtolower($method);
		$route = $this->routes['paths'][$url_path] ?? 'error.not_found';
		$request = [
			'headers' => getallheaders(),
			'cookies' => $_COOKIE,
			'params' => $_GET,
			'data' => $_POST,
			'path' => $url_path,
			'method' => $method,
			'route' => &$route
		];
		$this->execute('router.before', $request);
		/** @var Route */
		$route_data = $this->routes['routes'][$route] ?? null;
		if (isset($route_data->method) && strcmp($method, $route_data->method) != 0)
			$route_data = $this->routes['routes']['error.not_found'];
		$controller = new $route_data->class($this);
		$response = $controller->{$route_data->fn}($this, $request);
		$this->execute('router.after', $request, $response);
		echo $response;
	}

	public function service(string $name): ?object {
		return $this->services[$name] ?? null;
	}

	public function execute(string $task_name, ...$args) {
		/** @var SplPriorityQueue */
		$task_queue = $this->tasks[$task_name] ?? [];
		/** @var Task */
		foreach ($task_queue as $task) {
			$executor = new $task->class($this);
			$executor->{$task->fn}($this, ...$args);
		}
	}
}

