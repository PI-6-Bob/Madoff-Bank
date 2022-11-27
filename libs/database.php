<?php

use libs\Attribute\Service;

#[Service('database')]
class Database 
{
	private ?mysqli $connection = null;
	private ?string $user;
	private ?string $password;
	private ?string $database;
	private ?string $host;
	private ?int $port;

	public function __construct() {
		$this->user = $_ENV['MYSQL_USER'] ?? null;
		$this->password = $_ENV['MYSQL_PASSWORD'] ?? null;
		$this->database = $_ENV['MYSQL_DATABASE'] ?? null;
		$this->host = $_ENV['MYSQL_HOST'] ?? null;
		$this->port = $_ENV['MYSQL_PORT'] ?? null;
	}

	public function getConnection() {
		if (!isset($this->connection)) {
			$this->connection = new mysqli(
				$this->host,
				$this->user,
				$this->password,
				$this->database,
				$this->port
			);
			if ($this->connection->connect_errno != 0)
				throw new Exception($this->connection->connect_error);
		}
		return $this->connection;
	}

	public function repo(string $class) {
		return new $class($this->getConnection());
	}

	public function __destruct() {
		if (isset($this->connection))
			$this->connection->close();
	}
}

class Repository 
{
	public function __construct(protected mysqli $connection) {
	}

	protected function prepare(string $query): mysqli_stmt {
		$stmt = $this->connection->prepare($query);
		if ($stmt->errno != 0)
			throw new Exception("Could not prepare statement {$stmt->error}");
		return $stmt;
	}
}

