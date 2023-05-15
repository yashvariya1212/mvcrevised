<?php 



class Controller_Salesman extends Controller_Core_Action
{
	
	public function gridAction()
	{
		$grid = new Block_Salesman_Grid();
		$layout = new Block_Core_Layout();
		$layout->getChild('content')->addChildren('grid',$grid);
		$layout->render();
	}


	public function addAction()
	{
		try {
			
			$row = Ccc::getModel('Salesman_Row');
			if (!$row) {
				throw new Exception("Error Processing Request", 1);
				
			}
			$edit = new Block_Salesman_Edit();
			$edit->setData($row);

			$layout = new Block_Core_Layout();
			$layout->getChild('content')->addChildren('edit',$edit);
			$layout->render();
		} catch (Exception $e) {
			$this->getMessageObject()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
			header("Location:index.php?c=Salesman&a=grid");
		}
	}

	public function editAction()
	{
		try {
			
			$request = $this->getRequest();
			$id = (int)$request->getParams('id');
			if (!$id) {
				throw new Exception("invalid ID.", 1);
			}

			$query = "SELECT * FROM `salesman` LEFT JOIN `salesmanaddress` ON salesman.salesman_id = salesmanaddress.salesman_id WHERE salesman.salesman_id = '{$id}'"; 
			$row = Ccc::getModel('Salesman_Row');
			$salesman = $row->fetchRow($query);
			if (!$row) {
				throw new Exception("Error Processing Request", 1);
				
			}
			$edit = new Block_Salesman_Edit();
			$edit->setData($salesman);

			$layout = new Block_Core_Layout();
			$layout->getChild('content')->addChildren('edit',$edit);
			$layout->render();
		} catch (Exception $e) {
			$this->getMessageObject()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
			header("Location:index.php?c=Salesman&a=grid");
		}
	}

	public function saveAction()
	{
		try {

			$request = $this->getRequest();
			if (!$request->isPost()) {
				throw new Exception("Error Processing Request", 1);
			}

			$salesmanPost = $request->getPost('salesman');
			if (!$salesmanPost) {
				throw new Exception("Salesman Data Not Posted.", 1);
			}

			$salesmanRow = Ccc::getModel('Salesman_Row');
			if (!$salesmanRow) {
				throw new Exception("Error Processing Request", 1);
			}

			date_default_timezone_set('Asia/Kolkata');
			if ($id = (int)$request->getParams('id')) {
				$salesmanRow->load($id);
				$salesmanRow->updated_at = date('Y:m:d H:i:s');
			} else {
				$salesmanRow->created_at = date('Y:m:d H:i:s');
			}

			$salesmanRow->setData($salesmanPost);
			if (!$salesmanRow->save()) {
				throw new Exception("Data Not Saved Succsesfully.", 1);
			}

			$addressPost = $request->getPost('salesmanaddress');
			if (!$addressPost) {
				throw new Exception("Address Data Not Posted.", 1);
			}

			$addressRow = Ccc::getModel('Salesman_Address_Row');
			if (!$addressRow) {
				throw new Exception("Error Processing Request", 1);
			}

			$addressRow->salesman_id = $salesmanRow->salesman_id;
			if ($id = (int)$request->getParams('id')) {
				$addressRow->load($salesmanRow->salesman_id,'salesman_id');
			}

			$addressRow->setData($addressPost);
			if (!$addressRow->save()) {
				throw new Exception("Data Not Saved Succsesfully.", 1);
			}

			$this->getMessageObject()->addMessage('Data Saved Succsesfully.',Model_Core_Message::SUCCESS);
			header("Location:index.php?c=Salesman&a=grid");
			
		} catch (Exception $e) {
			$this->getMessageObject()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
			header("Location:index.php?c=Salesman&a=grid");
		}
	}

	public function deleteAction()
	{
		try {

			$request = $this->getRequest();
			$id = (int)$request->getParams('id');
			if (!$id) {
				throw new Exception("Invalid ID.", 1);
			}

			$row = Ccc::getModel('Salesman_Row');
			$row->load($id)->delete();

			$this->getMessageObject()->addMessage('Data Deleted Succsesfully.',Model_Core_Message::SUCCESS);
			header("Location:index.php?c=Salesman&a=grid");
			
		} catch (Exception $e) {
			$this->getMessageObject()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
			header("Location:index.php?c=Salesman&a=grid");
		}
	}


}


?>