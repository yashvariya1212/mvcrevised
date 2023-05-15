<?php 



class Block_Core_Template extends Model_Core_View
{
	
	protected $children = [];
	protected $pager = NULL;

	public function setPager(Model_Core_Pager $pager)
	{
		$this->pager = $pager;
		return $this;
	}

	public function getPager()
	{
		if ($this->pager) {
			return $this->pager;
		}
		$pager = new Model_Core_Pager();
		$this->setPager($pager);
		return $pager;
	}

	function __construct()
	{
		parent::__construct();
	}

	public function setChildren(array $children)
	 {
	 	$this->children = $children;
	 	return $this;
	 } 

	public function getChildren()
	{
		return $this->children;
	}

	public function getChild($key)
	{
		if (!array_key_exists($key, $this->children)) {
			return NULL;
		}
		return $this->children[$key];
	}

	public function addChildren($key,$value)
	{
		$this->children[$key] = $value;
		return $this;
	}

	public function removeChildren($key)
	{
		if (array_key_exists($key, $this->children)) {
			unset($this->children[$key]);
		}
		return $this;
	}

}


?>