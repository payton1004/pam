<?php

class Pam_Db_Db {
	protected $dbName;
	protected $user;
	protected $pass;
	protected $port = 5432;
	protected $host = "localhost";

	public $conn;

	public function __construct($dbName, $user, $pass) {
		$this->dbName = $dbName;
		$this->user = $user;
		$this->pass = $pass;
	}

	public function init() {
		$this->conn = pg_connect("host={$this->host} port={$this->port} dbname={$this->dbName} user={$this->user} password={$this->pass}");
	}

	public function query($sql, $params = NULL) {
		if (!$this->conn) {
			$this->init();
		}

		if (!$params) {
			$result = pg_query($this->conn, $sql);
		} else {
			$result = pg_query_params($this->conn, $sql, $params);
		}

		if (!$result) {
		    return false;
		}

		$ret = pg_fetch_all($result);

		return $ret;

	}

	public function close() {
		if ($this->conn) {
			pg_close($this->conn);
		}
	}

}