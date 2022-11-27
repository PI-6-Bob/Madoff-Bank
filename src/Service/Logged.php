<?php

namespace src\Service;


use libs\Attribute\Service;
use libs\Attribute\Task;
use ReflectionClass;
use src\Attribute\Logged as AttributeLogged;
use Session;
use App;

#[Service('madoff.session')]
class Logged
{
	protected Session $session;

	public function __construct(App $app) {
		$this->session = $app->service('session.manager');
	}

	#[Task('router.before', 10)]
	public function checkSession(array &$request, string &$route_name) {
		$reflection = new ReflectionClass($request['route']->class);
		$attributes = $reflection->getAttributes(AttributeLogged::class);
		foreach ($attributes as $attr) {
			/** @var AttributeLogged */
			$meta = $attr->newInstance();
			if (!$this->session->isLogged() || isset($meta->role) && $request['session']['role'] == $meta->role) {
				$request['_referer'] = $request['route']->path;
				$route_name = 'madoff.index';
				break;
			}
		}
	}
}
