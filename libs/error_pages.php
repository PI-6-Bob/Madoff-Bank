<?php

use libs\Attribute\Route;

class NotFound
{
	#[Route('error.not_found')]
	public function content() {
		page('error/404.html');
	}
}

class InternalError 
{
	#[Route('error.internal')]
	public function content() {
		page('error/50x.html');
	}
}
