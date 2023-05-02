<?php 



class Controller_Product extends Controller_Core_Action 
{
	
	public function gridAction()
	{
			$query = "SELECT * FROM `product`";

			$adapter = $this->getAdapter();
			$products = $adapter->fetchAll($query);
			if (!$products) {
				throw new Exception("products not found.", 1);
			}

			require_once 'view/product/grid.phtml';
	}

	public function addAction()
	{
			require_once 'view/product/add.phtml';
	}

	public function insertAction()
	{
			$request = $this->getRequest();
			$postData = $request->getPost('Product');

			$query = "INSERT INTO `product`(`product_name`, `cost`, `price`, `sku`, `status`, `quantity`, `discription`, `color`, `material`) VALUES ('$postData[productName]','$postData[cost]','$postData[price]','$postData[sku]','$postData[status]','$postData[quantity]','$postData[discription]','$postData[color]','$postData[material]')";
			$adapter = $this->getAdapter();
			$adapter->insert($query);
			header("Location:index.php?c=Product&a=grid");
	}

	public function editAction()
	{
			$request = $this->getRequest();
			$id = $request->getParams('id');
			$query = "SELECT * FROM `product` WHERE `product_id`={$id}";
			$adapter = $this->getAdapter();
			$productRow = $adapter->fetchRow($query);
			require_once 'view/product/edit.phtml';
	}

	public function updateAction()
	{
			$request = $this->getRequest();
			$postData = $request->getPost('Product');
			$id = $request->getParams('id');

			$query = "UPDATE `product` SET 
							`product_name`='$postData[productName]',
							`cost`='$postData[cost]',
							`price`='$postData[price]',
							`sku`='$postData[sku]',
							`status`='$postData[status]',
							`quantity`='$postData[quantity]',
							`discription`='$postData[discription]',
							`color`='$postData[color]',
							`material`='$postData[material]' 
							WHERE `product_id` = {$id}";
			$adapter = $this->getAdapter();
			$adapter->update($query);
			header("Location:index.php?c=Product&a=grid");
	}

	public function deleteAction()
	{
		$request = $this->getRequest();
		$id = $request->getParams('id');
		$query = "DELETE FROM `product` WHERE `product_id` = {$id}";
		$adapter = $this->getAdapter();
		$adapter->update($query);
		header("Location:index.php?c=Product&a=grid");
	}

}
?>