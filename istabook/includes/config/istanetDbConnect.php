<?php
class IstanetDbconnect {
	private $host = "localhost";
	private $dbname = "istanet";
	private $username = "root";
	private $password = "";

	public function connect(){
		$con = new PDO('mysql:host='. $this->host .';dbname=' . $this->dbname, $this->username, $this->password);
		$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		return $con;
	}
}