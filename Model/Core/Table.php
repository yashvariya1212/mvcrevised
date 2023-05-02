<?php 


class Model_Core_Table
{
	public $adapter = NULL;

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

	public function fetchAll($query)
	{
		$adapter = $this->getAdapter();
		$result = $adapter->fetchAll($query);
		return $result;
	}		

}


?>