<?php

class Database
{
	private $host = 'localhost';
	private $db_name = 'todoapp2';
	private $user = 'root';
	private $password;
	private $connection;

	public function getConnection()
	{
		$this->connection = null;

		try {
			$this->connection = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->user, $this->password);
			$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->connection->exec('SET NAMES "utf8"');
		} catch (PDOException $e) {
			$_SESSION['error'] = "Database connection error: " . $e->getMessage();
            return;
		}

		return $this->connection;
	}
}