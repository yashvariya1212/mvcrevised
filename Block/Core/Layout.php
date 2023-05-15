<?php 



class Block_Core_Layout extends Block_Core_Template
{
	function __construct()
	{	
		parent::__construct();
		$this->setTemplate('core/layout/3columns.phtml');
		$this->prapareChildren();
	}

	public function prapareChildren()
	{
		$content = new Block_Html_Content();
		$this->addChildren('content',$content);
		$header = new Block_Html_Header();
		$this->addChildren('header',$header);
		$message = new Block_Html_Message();
		$this->addChildren('message',$message);
		$footer = new Block_Html_Footer();
		$this->addChildren('footer',$footer);
	}

}


?>