<?php 


class Controller_Core_Front
{
	public $request = NULL;

	public function setRequest(Model_Core_Request $request)
	{
		$this->request = $request;
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

	public function init()
	{
		$request = new Model_Core_Request();
		$controllerName = $request->getParams('c');
		$actionName = $request->getParams('a')."Action";

		$controllerClassName = 'Controller_'.ucwords($controllerName,'_');
		$controllerClassPath = str_replace('_', '/', $controllerClassName);

		require_once $controllerClassPath.'.php';
		$controller = new $controllerClassName();

		if (method_exists($controller, $actionName) == false) {
				$controller->errorAction($actionName);
		} else {
				$controller->$actionName();
		}
	}

}


?>