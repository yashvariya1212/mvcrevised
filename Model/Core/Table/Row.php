<?php 



class Model_Core_Table_Row
{
	public $table = NULL;

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
		$table = new Model_Core_table();
		$this->setTable($table);
		return $table;
	}

	public function fetchAll($query)
	{
		$table = 
	}	

}


?>