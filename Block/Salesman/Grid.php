<?php 




class Block_Salesman_Grid extends Block_Core_Template
{
	
	function __construct()
	{
		parent::__construct();
		$this->setTemplate('salesman/grid.phtml');
		$this->getSalesmans();
	}

	public function getSalesmans()
	{
		$query1 = "SELECT count(`salesman_id`) FROM `salesman`";
		$adapter = Ccc::getModel('Core_Adapter');
		$totalRecord = $adapter->fetchOne($query1);
		$pager = $this->getPager();
		$pager->setTotalRecord($totalRecord)->setRecordPerPage(10)->calculate();
		$query = "SELECT * FROM `salesman` ORDER BY `salesman_id` ASC LIMIT {$pager->startLimit},{$pager->recordPerPage}";
		
		$row = Ccc::getModel('Salesman_Row');
		$salesmans = $row->fetchAll($query);
		$this->setData($salesmans);
	}
}


?>