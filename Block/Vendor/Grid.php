<?php 



class Block_Vendor_Grid extends Block_Core_Template
{

	function __construct()
	{
		parent::__construct();
		$this->setTemplate('vendor/grid.phtml');
		$this->getVendors();
	}
	
	public function getVendors()
	{
		$query = "SELECT * FROM `vendor`";
		$row = Ccc::getModel('Vendor_Row');
		$vendors = $row->fetchAll($query);
		$this->setData($vendors);
	}


}


?>