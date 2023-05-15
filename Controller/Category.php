<?php 



class Controller_Category extends Controller_Core_Action
{
	
	public function gridAction()
	{
		$query = "SELECT * FROM `categories` ORDER BY `category_id` ASC";
		$model = Ccc::getModel('Category');
		$categories = $model->fetchAll($query);
		$this->getView()->setTemplate('category/grid.phtml')->setData(['categories'=>$categories])->render();
	}

	public function addAction()
	{
		try {

			$model = Ccc::getModel('Category');
			if (!$model) {
				throw new Exception("Error Processing Request", 1);
			}

			$query = "SELECT * FROM `categories`";
			$categories = $model->fetchAll($query);

			$this->getView()->setTemplate('category/edit.phtml')->setData(['model'=>$model,'categories'=>$categories])->render();
			
		} catch (Exception $e) {
			$this->getMessageObject()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
			header('location:index.php?c=Category&a=grid');
		}
	}

	public function editAction()
	{
		try {

			$request = Ccc::getModel('Core_Request');
			$id = (int)$request->getParams('id');
			if (!$id) {
				throw new Exception("Invalid ID.", 1);
			}

			$model = Ccc::getModel('Category');
			if (!$model) {
				throw new Exception("Error Processing Request", 1);
			}

			$model->load($id);

			$sql = "SELECT * FROM `categories` WHERE `path` NOT LIKE '{$model->path}=%' AND `path` NOT LIKE '{$model->path}';";
			$categories = Ccc::getModel('Category')->fetchAll($sql); 

			$this->getView()->setTemplate('category/edit.phtml')->setData(['model'=>$model,'categories'=>$categories])->render();
			
		} catch (Exception $e) {
			$this->getMessageObject()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
			header('location:index.php?c=Category&a=grid');
		}
	}

	public function saveAction()
	{
		try {

			$request = $this->getRequest();
			if (!$request->isPost()) {
				throw new Exception("Error Processing Request", 1);
			}

			$postCategory = $request->getPost('category');
			if (!$postCategory) {
				throw new Exception("Data Not Founded.", 1);
			}

			$model = Ccc::getModel('Category');
			if (!$model) {
				throw new Exception("Error Processing Request", 1);
			}

			date_default_timezone_set('Asia/Kolkata');
			if ($id = (int)$request->getParams('id')) {   
				$model->load($id);
				$model->updated_at = date('Y-m-d h:i:s');
			}else{
				$model->created_at = date('Y-m-d h:i:s');
			}

			$model->setData($postCategory);
			if (!$model->save()) {
				throw new Exception("Data Not Saved.", 1);
			}
			
			$model->updatePath();

			$this->getMessageObject()->addMessage('Data Saved Succsesfully.',Model_Core_Message::SUCCESS);
			header('location:index.php?c=Category&a=grid');
		} catch (Exception $e) {
			$this->getMessageObject()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
			header('location:index.php?c=Category&a=grid');
		}
	}

	public function deleteAction()
	{
		try {

			$request = Ccc::getModel('Core_Request');
			$id = (int)$request->getParams('id');
			if (!$id) {
				throw new Exception("Invalid ID.", 1);
			}

			$model = Ccc::getModel('Category');
			if (!$model) {
				throw new Exception("Error Processing Request", 1);
			}

			$model->load($id);
			$model->deleteChild();
			$model->load($id)->delete();
			
			$this->getMessageObject()->addMessage('Data Deleted Succsesfully.',Model_Core_Message::SUCCESS);
			header('location:index.php?c=Category&a=grid');

		} catch (Exception $e) {
			$this->getMessageObject()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
			header('location:index.php?c=Category&a=grid');
		}
	}


}

?>