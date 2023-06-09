<?php 


class Model_Core_Table
{
	protected $adapter = NULL;
	protected $tableName = NULL;
	protected $primaryKey = NULL;

	public function setAdapter(Model_Core_Adapter $adapter)
	{
		$this->adapter = $adapter;
		return $this;
	}

	public function getAdapter()
	{
		if ($this->adapter) {
			return $this->adapter;
		}
		$adapter = new Model_Core_Adapter();
		$this->setAdapter($adapter);
		return $adapter;
	}

	public function setTableName($tableName)
	{
		$this->tableName = $tableName;
		return $this;
	}

	public function getTableName()
	{
		return $this->tableName;
	}

	public function setPrimaryKey($primaryKey)
	{
		$this->primaryKey = $primaryKey;
		return $this;
	}

	public function getPrimaryKey()
	{
		return $this->primaryKey;
	}

	public function fetchAll($query)
	{
		$adapter = $this->getAdapter();
		$result = $adapter->fetchAll($query);
		return $result;
	}

	public function insert($data)
	{
		if (is_array($data)) {

			$keyString = implode("`,`", array_keys($data));
			$valueString = implode("','", array_values($data));
			echo $query = "INSERT INTO `{$this->getTableName()}` (`$keyString`) VALUE ('$valueString')";
			return $this->getAdapter()->insert($query);
		}
	}

	public function fetchRow($query)
	{
		$adapter = $this->getAdapter();
		$result = $adapter->fetchRow($query);
		return $result;	
	}

	public function update($condition,$data)
	{
		$set = [];
		foreach ($data as $key => $value) {
				$set[] = "`".$key."`='".$value."'";
		}

		// echo "<pre>";
		// echo "111";
		// print_r($set);
		// die();

		$where = "";
		if (is_array($condition)) {
			 	foreach ($condition as $column => $value) {
				$where .= '`'.$column.'` = "'.$value.'" AND ' ;
			}
		} else {
			$where = "`".$this->getPrimaryKey()."` = '".$condition."'" ;
		}

		echo $query = "UPDATE `{$this->getTableName()}` SET ".implode(",", $set)."  where $where";
		return $this->getAdapter()->update($query);
	}

	public function delete($condition) //id
	{
		$where = "";
		if (is_array($condition)) {
			foreach ($condition as $column => $value) {
				$where .= '`'.$column.'` = "'.$value.'" AND ' ;
			}
		} else {
			$where = "`".$this->primaryKey."`='".$condition."'";
		}

		$query = "DELETE FROM `{$this->getTableName()}` WHERE $where";
		return $this->getAdapter()->insert($query);
	}

}


?>