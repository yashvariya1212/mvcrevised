<?php 


class Controller_Customer extends Controller_Core_Action
{
	
	public function gridAction()
	{
		$query = "SELECT * FROM `customer` ORDER BY `customer_id` ASC";
		$row = Ccc::getModel('Customer_Row');
		$customers = $row->fetchAll($query);

		$this->getView()->setTemplate('customer/grid.phtml')->setData(['customers'=>$customers])->render();
	}

	public function addAction()
	{
		$this->getView()->setTemplate('customer/add.phtml')->render();
	}

	public function saveAction()
	{
		try {

			$request = $this->getRequest();
			if (!$request->isPost()) {
				throw new Exception("Error Processing Request", 1);
			}

			$postCustomer = $request->getPost('customer');

			$customerRow = Ccc::getModel('Customer_Row');
			if ($id = (int)$request->getParams('id')) {   
				$customerRow->load($id);
				$customerRow->updated_at = date('Y-m-d h:i:s');
			}else{
				$customerRow->created_at = date('Y-m-d h:i:s');
			}
			$customerRow->setData($postCustomer);
			$customerRow->save();



			$postBilling = $request->getPost('billing');
			$addressRow1 = Ccc::getModel('Customer_Address_Row');
			if ($id = (int)$request->getParams('id')) {   
					$addressRow1->load($customerRow->billing_id);
			}
			$addressRow1->customer_id = $customerRow->customer_id;
			$addressRow1->setData($postBilling);
			$addressRow1->save();
			$customerRow->billing_id = $addressRow1->address_id;


			$postShipping = $request->getPost('shipping');
			$addressRow2 = Ccc::getModel('Customer_Address_Row'); 
			if ($id = (int)$request->getParams('id')) {   
					$addressRow2->load($customerRow->shipping_id);
			}
			$addressRow2->customer_id = $customerRow->customer_id;
			$addressRow2->setData($postShipping);
			$addressRow2->save();
			$customerRow->shipping_id = $addressRow2->address_id;
			unset($customerRow->updated_at);
			$customerRow->setData($postCustomer);
			$customerRow->save();
			$this->getMessageObject()->addMessage('Data Saved Succsesfully.',Model_Core_Message::SUCCESS);
			header('location:index.php?c=Customer&a=grid');
		} catch (Exception $e) {
			$this->getMessageObject()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
			header('location:index.php?c=Customer&a=grid');
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

			$query = "SELECT * FROM `customer` WHERE `customer_id`=	'{$id}'";
			$customerRow = Ccc::getModel('Customer_Row');
			$customerData = $customerRow->fetchRow($query);
			if (!$customerData) {
				throw new Exception("Error Processing Request", 1);
			}

			$addressRow = Ccc::getModel('Customer_Address_Row');
			$addressBilling = $addressRow->load($customerData->billing_id);
			$addressRow = Ccc::getModel('Customer_Address_Row');
			$addressShipping = $addressRow->load($customerData->shipping_id);

			$this->getView()->setTemplate('customer/edit.phtml')->setData(['customerData'=>$customerData,'addressBilling'=>$addressBilling,'addressShipping'=>$addressShipping])->render();
			
		} catch (Exception $e) {
			$this->getMessageObject()->addMessage($e->getMessage(),Model_Core_Message::SUCCESS);
			header('location:index.php?c=Customer&a=grid');
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

			$row = Ccc::getModel('Customer_Row');
			$row->load($id)->delete(); 

			$this->getMessageObject()->addMessage('Data Deleted Succsesfully.',Model_Core_Message::SUCCESS);
			header('location:index.php?c=Customer&a=grid');
			
		} catch (Exception $e) {
			$this->getMessageObject()->addMessage($e->getMessage(),Model_Core_Message::SUCCESS);
			header('location:index.php?c=Customer&a=grid');
		}
	}

}


?>