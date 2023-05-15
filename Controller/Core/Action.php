<?php 


class Controller_Core_Action
{

	public $request = NULL ;
	public $adapter = NULL ;
	public $view = NULL ;
	public $message = NULL ;


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

	public function setView(Model_Core_View $view)
	{
		$this->view = $view;
		return $this;
	}

	public function getView()
	{
		if ($this->view) {
			return $this->view;
		}
		$view = new Model_Core_View();
		$this->setView($view);
		return $view;
	}

	public function setMessageObject(Model_Core_Message $message)
	{
		$this->message = $message;
		return $this;
	}

	public function getMessageObject()
	{
		if ($this->message) {
			return $this->message;
		}
		$message = new Model_Core_Message();
		$this->setMessageObject($message);
		return $message;
	}

}


?>