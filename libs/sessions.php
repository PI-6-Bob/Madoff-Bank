<?php

use libs\Attribute\Service;
use libs\Attribute\Task;

#[Service('session.manager')]
class Session
{
	private bool $started = false;

	#[Task('router.before')]
	public function processRequest(array &$request) {
		$_sessid = $request['cookies']['SSID'] ?? null;
		$_sess_path = session_save_path() . "/$_sessid";
		if (!isset($_sessid))
			return $request['session'] = false;
		if (!file_exists($_sess_path))
			return $request['session'] = false;
		$this->start();
		return $request['session'] = $_SESSION;
	}

	public function isLogged(): bool {
		return $this->started;
	}

	public function start() {
		$this->started = true;
		session_start();
	}

	public function set(string $key, mixed $value) {
		if (!$this->isLogged())
			$this->start();
		$_SESSION[$key] = $value;
	}

	public function get(string $key) {
		return $this->isLogged()? $_SESSION[$key] ?? null : null;
	}

	public function __destruct() {
		if ($this->isLogged())
			session_commit();
	}
}
