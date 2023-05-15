<?php 


//table to resource

class Model_Core_Table_Resource
{
	protected $adapter = NULL;
	protected $resourceName = NULL;
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

	public function setResourceName($resourceName)
	{
		$this->resourceName = $resourceName;
		return $this;
	}

	public function getResourceName()
	{
		return $this->resourceName;
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
		echo"<br>".	$query = "INSERT INTO `{$this->getResourceName()}` (`$keyString`) VALUE ('$valueString')";
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

		$where = "";
		if (is_array($condition)) {
			 	foreach ($condition as $column => $value) {
				$where .= '`'.$column.'` = "'.$value.'" AND ' ;
			}
		} else {
			$where = "`".$this->getPrimaryKey()."` = '".$condition."'" ;
		}

		echo $query = "UPDATE `{$this->getResourceName()}` SET ".implode(",", $set)."  where $where";
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

		$query = "DELETE FROM `{$this->getResourceName()}` WHERE $where";
		return $this->getAdapter()->insert($query);
	}

}


?>