<?php 



class Model_Core_Adapter
{
	public $serverName = "localhost";
	public $userName = "root";
	public $password = "";
	public $dbName = "01-05";
	
	public function connect()
	{
		$connect = mysqli_connect($this->serverName, $this->userName, $this->password, $this->dbName);
		return $connect;
	}

	public function fetchAll($query)
	{
		$connect = $this->connect();
		$result = $connect->query($query);
		if (!$result) {
			return false;
		} else {
			return $result->fetch_All(MYSQLI_ASSOC);
		}
	}

	public function insert($query)
	{
		$connect = $this->connect();
		$result = $connect->query($query);
		if (!$result) {
			return false;
		} else {
			return $connect->insert_id;
		}
	}

	public function fetchRow($query)
	{
		$connect = $this->connect();
		$result = $connect->query($query);
		if (!$result) {
			return false;
		}
		return $result->fetch_assoc();
	}

	public function update($query)
	{
		$connect = $this->connect();
		$result = $connect->query($query);
		if (!$result) {
			return false;
		}
		return true;
	}

}



?>