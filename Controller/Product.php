<?php 



class Controller_Product extends Controller_Core_Action 
{

	public function gridAction()
	{
		$grid = new Block_Product_Grid();
		$layout = new Block_Core_Layout();
		$layout->getChild('content')->addChildren('grid',$grid);
		$layout->render();
	}

	public function addAction()
	{
		try {
			
			$row = Ccc::getModel('Product_Row');
			if (!$row) {
				throw new Exception("Error Processing Request", 1);
				
			}
			$edit = new Block_Product_Edit();
			$edit->setData($row);

			$layout = new Block_Core_Layout();
			$layout->getChild('content')->addChildren('edit',$edit);
			$layout->render();
		} catch (Exception $e) {
			$this->getMessageObject()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
			$this->redirect("Product","grid");
		}
	}

	public function saveAction()
	{
			try {

				$request = $this->getRequest();
				if (!$request->isPost()) {
					throw new Exception("invalid request.", 1);
				}

				$postData = $request->getPost('Product');
				if (!$postData) {
					throw new Exception("Data Not Posted.", 1);
				}

				$row = Ccc::getModel('Product_Row');
				if (!$row) {
					throw new Exception("Error Processing Request", 1);
				}

				date_default_timezone_set('Asia/Kolkata');
				if ($id=(int)$request->getParams('id')) {
					$postData['updated_at'] = date('Y:m:d H:i:s');
					$row->load($id);
				}else {
					$row->created_at = date('Y:m:d H:i:s');
				}

				$row->setData($postData);
				if (!$row->save()) {
					throw new Exception("Data Not Saved.", 1);
				}

				$this->getMessageObject()->addMessage('Data Saved Succsesfully.',Model_Core_Message::SUCCESS);
				header("Location:index.php?c=Product&a=grid");

			} catch (Exception $e) {
				$this->getMessageObject()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
				header("Location:index.php?c=Product&a=grid");
			}
	}

	public function editAction()
	{
		try {
			
			$request = $this->getRequest();
			$id = (int)$request->getParams('id');
			if (!$id) {
				throw new Exception("Invalid ID.", 1);
			}

			$productRow = Ccc::getModel('Product_Row')->load($id);
			if (!$productRow) {
				throw new Exception("Data Not Founded.", 1);
			}

			$edit = new Block_Product_Edit();
			$edit->setData($productRow);

			$layout = new Block_Core_Layout();
			$layout->getChild('content')->addChildren('edit',$edit);
			$layout->render();

		} catch (Exception $e) {
			$this->getMessageObject()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
			header("Location:index.php?c=Product&a=grid");
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

			$row = Ccc::getModel('Product_Row');
			$row->load($id)->delete();

			$this->getMessageObject()->addMessage('Data Deleted Succsesfully.',Model_Core_Message::SUCCESS);
			header("Location:index.php?c=Product&a=grid");

		} catch (Exception $e) {
			$this->getMessageObject()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
			header("Location:index.php?c=Product&a=grid");
		}
	}

}
?>