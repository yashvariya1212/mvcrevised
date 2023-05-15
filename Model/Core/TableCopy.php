<?php 

//row to table

class Model_Core_TableCopy
{
	protected $resource = NULL;
	protected $resourceClass = 'Model_Core_Table_Resource';
	protected $data = [];
	protected $collectionClass = 'Model_Core_Table_Collection';

	public function getPrimaryKey()
	{
		return $this->getResource()->getPrimaryKey();
	}

	public function getResourceName()
	{
		return $this->getResource()->getResourceName();
	}

	public function getId()
	{
		$id = (int)$this->getData($this->getPrimaryKey());
		return $id; 
	}

	public function setResource(Model_Core_Table_Resource $resource)
	{
		$this->resource = $resource;
		return $this;
	}

	public function getResource()
	{
		if ($this->resource) {
			return $this->resource;
		}
		$resourceClass = $this->resourceClass;
		$resource = new $resourceClass();
		$this->setResource($resource);
		return $resource;
	}

	public function setCollection(Model_Core_Table_Collection $collection)
	{
		$this->collection = $collection;
		return $this;
	}

	public function getCollection()
	{
		if ($this->collection) {
			return $this->collection;
		}
		$collectionClass = $this->collectionClass;
		$collection = new $collectionClass();
		$this->setCollection($collection);
		return $collection;
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
		$resource = $this->getResource();
		$result = $resource->fetchAll($query);
		if (!$result) {
			return false;
		}

		foreach ($result as &$row) {
			$row = (new $this)->setData($row)->setResource($this->getResource());
		}

		$collection = $this->getCollection()->setData($result);
		return $collection;

	}

	public function fetchRow($query)
	{
		$row = $this->getResource()->fetchRow($query);
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
		echo $query = "SELECT * FROM `{$this->getResourceName()}` WHERE $column = '{$id}'";
		$resource = $this->getResource();
		$row = $resource->fetchRow($query);
		if ($row) {
			$this->data = $row;
		}
		return $this;
	}

	public function save()
	{
		if ($id = $this->getId()) {
				$id = $this->getId();
				$this->getResource()->update($id,$this->getData());
				return $this;
		}else{
				$table = $this->getResource();
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
		$resource = $this->getResource();
		$resource->delete($id);
		return $this->removeData();
	}	

}


?>