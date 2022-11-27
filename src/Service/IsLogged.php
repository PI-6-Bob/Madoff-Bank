<?php

namespace src\Service;


use libs\Attribute\Service;
use libs\Attribute\Task;
use ReflectionClass;
use src\Attribute\IsLogged as Logged;
use src\Attribute\NotLogged;
use libs\Attribute\Route;
use Session;
use App;

#[Service('madoff.logged')]
class IsLogged
{
	protected Session $session;
	protected Route $_login;
	protected Route $_home;

	public function __construct(App $app) {
		$this->session = $app->service('session.manager');
		$this->_login = $app->route('madoff.index');
		$this->_home = $app->route('madoff.home');
	}

	#[Task('router.before', 0)]
	public function checkSession(array &$request, string &$route_name) {
		$reflection = new ReflectionClass($request['route']->class);
		$attributes = $reflection->getAttributes();
		foreach ($attributes as $attr) {
			/** @var Logged | NotLogged */
			$meta = $attr->newInstance();
			$is_in = $meta->validate($this->session->get('role'));
			switch ($meta::class) {
				case Logged::class:
					if (!$this->session->isLogged() || !$is_in)
						redirect("{$this->_login->path}?_target={$request['route']->path}");
					break;
				case NotLogged::class:
					if ($this->session->isLogged() && $is_in)
						redirect($this->_home->path);
					break;
			}
		}
	}
}
