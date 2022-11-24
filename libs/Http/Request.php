<?php

namespace libs\Http;

class Request
{
	public function __construct(
		private array $headers = [],
		private string $body
	) {
	}
}
