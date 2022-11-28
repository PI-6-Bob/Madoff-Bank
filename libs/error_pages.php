<?php

use libs\Attribute\Route;

class NotFound extends Controller
{
	#[Route('error.not_found')]
	public function content() {
		$this->page('error/404.html');
	}
}

class InternalError extends Controller
{
	#[Route('error.internal')]
	public function content(array &$request, Error|Exception $error) {
		$this->page('error/50x.php', [ 'error' => $error ]);
	}
}
