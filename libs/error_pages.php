<?php

use libs\Attribute\Route;

class NotFound extends Controller
{
	#[Route('error.not_found')]
	public function content(array &$request) {
		$this->page('error/404.php', [ 
			'title' => 'Pagina no encontrada',
			'referer' => $request['headers']['Referer'] ?? null
		]);
	}
}

class MessagePage extends Controller
{
	#[Route('message')]
	public function content(array &$request, Message $message) {
		http_response_code($message->getCode());
		$this->page('_message.php', [ 
			'title' => $message->getTitle(),
			'message' => $message,
			'referer' => $request['headers']['Referer'] ?? null
		]);
	}
}

class InternalError extends Controller
{
	#[Route('error.internal')]
	public function content(array &$request, Error|Exception $error) {
		$this->page('error/50x.php', [ 
			'title' => 'Error', 
			'error' => $error,
			'referer' => $request['headers']['Referer'] ?? null
		]);
	}
}
