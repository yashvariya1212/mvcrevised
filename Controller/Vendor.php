<?php 



class Controller_Vendor extends Controller_Core_Action
{
	
	public function gridAction()
	{
		$grid = new Block_Vendor_Grid();
		$layout = new Block_Core_Layout();
		$layout->getChild('content')->addChildren('grid',$grid);
		$layout->render();
	}

	public function addAction()
	{
		try {
			
			$row = Ccc::getModel('Vendor_Row');
			if (!$row) {
				throw new Exception("Error Processing Request", 1);
				
			}
			$edit = new Block_Vendor_Edit();
			$edit->setData($row);

			$layout = new Block_Core_Layout();
			$layout->getChild('content')->addChildren('edit',$edit);
			$layout->render();
		} catch (Exception $e) {
			$this->getMessageObject()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
			$this->redirect("Vendor","grid");
		}
	}

	public function editAction()
	{
		try {
			
			$request = $this->getRequest();
			$id = $request->getParams('id');
			if (!$id) {
				throw new Exception("invalid ID.", 1);
			}

			$query = "SELECT * FROM `vendor` LEFT JOIN `vendoraddress` ON vendor.vendor_id = vendoraddress.vendor_id WHERE vendor.vendor_id = '{$id}'";
			$row = Ccc::getModel('Vendor_Row');
			$vendor = $row->fetchRow($query);

			$edit = new Block_Vendor_Edit();
			$edit->setData($vendor);

			$layout = new Block_Core_Layout();
			$layout->getChild('content')->addChildren('edit',$edit);
			$layout->render();

		} catch (Exception $e) {
			$this->getMessageObject()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
			header("Location:index.php?c=Vendor&a=grid");
		}
	}

	public function saveAction()
	{
		try {

			$request = $this->getRequest();
			if (!$request->isPost()) {
				throw new Exception("Error Processing Request", 1);
			}

			$vendorPost = $request->getPost('vendor');
			if (!$vendorPost) {
				throw new Exception("Data Not Posted.", 1);
			}

			$vendorRow = Ccc::getModel('Vendor_Row');
			if (!$vendorRow) {
				throw new Exception("Error Processing Request", 1);
			}

			date_default_timezone_set('Asia/Kolkata');
			if ($id = (int)$request->getParams('id')) {
				$vendorRow->load($id);
				$vendorRow->updated_at = date('Y:m:d H:i:s');
			} else {
				$vendorRow->created_at = date('Y:m:d H:i:s');
			}

			$vendorRow->setData($vendorPost);
			if (!$vendorRow->save()) {
				throw new Exception("Data Not Saved Succsesfully.", 1);
			}
			$addressPost = $request->getPost('vendoraddress');
			if (!$addressPost) {
				throw new Exception("Data Not Posted.", 1);
			}

			$addressRow = Ccc::getModel('Vendor_Address_Row');
			if (!$addressRow) {
				throw new Exception("Error Processing Request", 1);
			}

			$addressRow->vendor_id = $vendorRow->vendor_id;
			if ($id = (int)$request->getParams('id')) {
				$addressRow->getTable()->setPrimaryKey('vendor_id');
				$addressRow->load($id);
			}

			$addressRow->setData($addressPost);
			if (!$addressRow->save()) {
				throw new Exception("Data Not Saved Succsesfully.", 1);
			}

			$this->getMessageObject()->addMessage('Data Deleted Succsesfully.',Model_Core_Message::SUCCESS);
			header("Location:index.php?c=Vendor&a=grid");
			
		} catch (Exception $e) {
			$this->getMessageObject()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
			header("Location:index.php?c=Vendor&a=grid");
		}
	}

	public function deleteAction()
	{
		try {
			
			$request = $this->getRequest();
			$id = $request->getParams('id');
			if (!$id) {
				throw new Exception("invalid ID.", 1);
			}

			$row = Ccc::getModel('Vendor_Row');
			$row->load($id)->delete();
			
			$this->getMessageObject()->addMessage('Data Deleted Succsesfully.',Model_Core_Message::SUCCESS);
			header("Location:index.php?c=Vendor&a=grid");

		} catch (Exception $e) {
			$this->getMessageObject()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
			header("Location:index.php?c=Vendor&a=grid");
		}
	}


}

?>