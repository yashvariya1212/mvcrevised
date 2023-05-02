<?php 


class Controller_Core_Action
{

	public $request = NULL ;
	public $adapter = NULL ;

	protected function setRequest(Model_Core_Request $request)
	{
		$this->request = $request ;
		return $this;
	}

	public function getRequest()
	{
		if ($this->request) {
			return $this->request;
		} 
		$request = new Model_Core_Request();
		$this->setRequest($request);
		return $request;
	}

	protected function setAdapter(Model_Core_Adapter $adapter)
	{
		$this->adapter = $adapter ;
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

}


?>