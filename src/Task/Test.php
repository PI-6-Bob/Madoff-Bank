<?php

namespace src\Task;

use libs\Attribute\Task;
use App;

#[Task('router.before', 'test')]
class Test
{
	public function test(App $app, array $request) {
	}
}
