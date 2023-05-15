<?php 



class Block_Product_Grid extends Block_Core_Template
{

	function __construct()
	{
		parent::__construct();
		$this->setTemplate('product/grid.phtml');
		$this->getProducts();
	}
	
	public function getProducts()
	{
		$query = "SELECT * FROM `product` ORDER BY `product_id` ASC";
		$row = Ccc::getModel('Product_Row');
		$products = $row->fetchAll($query);
		$this->setData($products);
	}


}


?>