<?php 



class Model_Core_Pager
{
	
	public $totalRecord = 0;
	public $recordPerPage = 0;
	public $numberOfPages = 0;
	public $currentPage = 0;
	public $start = 0;
	public $previous = 0;
	public $next = 0;
	public $end = 0;
	public $startLimit = 0;
	public $recordPerPageOption = [5,10,20,50,100];


	function __construct()
	{
		$this->setCurrentPage();
	}

	public function setTotalRecord($totalRecord)
	{
		$this->totalRecord = $totalRecord;
		return $this;
	}
	public function getTotalRecord()
	{
		return $this->totalRecord;
	}



	public function setRecordPerPage($recordPerPage)
	{
		$this->recordPerPage = $recordPerPage;
		return $this;
	}

	public function getRecordPerPage()
	{
		return $this->recordPerPage;
	}



	public function setNumberOfPages($numberOfPages)
	{
		$this->numberOfPages = $numberOfPages;
		return $this;
	}

	public function getNumberOfPages()
	{
		return $this->numberOfPages;
	}



	public function setCurrentPage()
	{
		$request = Ccc::getModel('Core_Request');
		$this->currentPage = (int)$request->getParams('p',1);
		return $this;
	}
	public function getCurrentPage()
	{
		return $this->currentPage;
	}




	public function calculate()
	{
		 //number of pages
		 $numberOfPages = ceil($this->getTotalRecord()/$this->getRecordPerPage());
		 $this->setNumberOfPages($numberOfPages);

		 //number of currentpage
		 if ($this->getNumberOfPages() == 0) {
		 		$this->currentPage = 0;
		 }
		 if ($this->getNumberOfPages() == 1 || ($this->getNumberOfPages()>1 && $this->getCurrentPage()<=0)) {
		 		$this->currentPage = 1;
		 }
		 if ($this->getNumberOfPages() < $this->getCurrentPage()) {
		 		$this->currentPage = $this->getNumberOfPages();
		 }


		 // start
		 $this->start = 1;
		 if (!$this->getNumberOfPages()) {		//  <= or == ???
		 	$this->start = 0;
		 }
		 if ($this->getCurrentPage() <= 1) {
		 	$this->start = 0;
		 }


		 //end
		 $this->end = $this->getNumberOfPages();
		 if ($this->getCurrentPage() == $this->getNumberOfPages()) {
			 $this->end = 0;
		 }

		 //previous
		 $this->previous = ($this->getCurrentPage()-1);
		 if ($this->getCurrentPage() <= 1) {
		 	$this->previous = 0;
		 }

		 //next
		 $this->next = $this->getCurrentPage()+1;
		 if ($this->getCurrentPage() == $this->getNumberOfPages()) {
			 $this->next = 0;
		 }

		 //startLimit
		 $this->startLimit = ($this->getCurrentPage()-1)*($this->getRecordPerPage());

		 return $this;
	}

}

?>