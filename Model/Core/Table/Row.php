<?php 



class Model_Core_Table_Row
{
	protected $table = NULL;
	protected $tableClass = NULL;
	protected $data = [];

	public function getPrimaryKey()
	{
		return $this->getTable()->getPrimaryKey();
	}

	public function getTableName()
	{
		return $this->getTable()->getTableName();
	}

	public function getId()
	{
		$id = (int)$this->getData($this->getPrimaryKey());
		return $id; 
	}

	public function setTable(Model_Core_Table $table)
	{
		$this->table = $table;
		return $this;
	}

	public function getTable()
	{
		if ($this->table) {
			return $this->table;
		}
		$tableClass = $this->tableClass;
		$table = new $tableClass();
		$this->setTable($table);
		return $table;
	}

	public function addData($key,$value)
	{
		$this->data[$key] = $value;
		return $this;
	}

	public function setData($data)
	{
		$this->data = array_merge($this->data,$data);
		return $this;
	}

	public function getData($key = NULL)
	{
		if (!$key) {
			return $this->data;
		}
		if (!array_key_exists($key, $this->data)) {
			return NULL;
		}
		return $this->data[$key];
	}

	public function removeData($key = NULL)
	{
		if ($key == NULL) {
			$this->data = [];
		}
		if (array_key_exists($key, $this->data)) {
			unset($this->data[$key]);
		}
		return $this;
	}

	public function __set($key, $value)
	{
		$this->data[$key] = $value;
		return $this;
	}

	public function __get($key)
	{
		if (!array_key_exists($key, $this->data)) {
			return NULL;
		}
		return $this->data[$key];
	}

	public function __unset($key)
	{
		if (array_key_exists($key, $this->data)) {
			unset($this->data[$key]);
		}
		return $this;
	}

	public function fetchAll($query)
	{
		$table = $this->getTable();
		$result = $table->getAdapter()->fetchAll($query);
		if (!$result) {
			return false;
		}

		foreach ($result as &$row) {
			$row = (new $this)->setData($row)->setTable($this->getTable());
		}

		return $result;
	}

	public function fetchRow($query)
	{
		$table = $this->getTable();
		$row = $this->getTable()->fetchRow($query);
		if ($row) {
			$this->data = $row;
			return $this;
		}
		return false;
	}

	public function load($id, $column=NULL)
	{
		if ($column == NULL) {
			$column = $this->getPrimaryKey();
		}
		echo $query = "SELECT * FROM `{$this->getTableName()}` WHERE $column = '{$id}'";
		$table = $this->getTable();
		$row = $table->fetchRow($query);
		if ($row) {
			$this->data = $row;
		}
		return $this;
	}

	public function save()
	{
		if ($id = $this->getId()) {
				$id = $this->getId();
				$this->getTable()->update($id,$this->getData());
				return $this;
		}else{
				$table = $this->getTable();
				$insertId = $table->insert($this->getData());
				return $this->load($insertId);
		}
	}

	public function delete()
	{
		$id = (int)$this->getData($this->getPrimaryKey());
		if (!$id) {
			return false;
		}
		$table = $this->getTable();
		$table->delete($id);
		return $this->removeData();
	}	

}


?>