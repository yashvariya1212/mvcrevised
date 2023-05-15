<?php 



class Model_Category extends Model_Core_TableCopy
{
	protected $resourceClass = 'Model_Category_Resource';

	public function getPathName($path=NULL)
	{
		if ($path) {
			$categoryId = explode('=',$path);
		}else {
			$categoryId = explode('=', $this->path);
		}
		
		$final = [];
		foreach ($categoryId as $id) {
			if ($id > 1) {
				$sql = "SELECT `name` FROM `categories` WHERE `category_id` = '{$id}'";
				$model = Ccc::getModel('Category');
				$model->fetchRow($sql);
				$final[] = $model->getData('name');
			}
		}
		if (!$final) {
			return "ROOT";
		}
		return implode('=>', $final);
	}

	public function updatePath()
	{
		if(!$this->getId())
		{
			return false;
		}

		$parent = Ccc::getModel('Category')->load($this->parent_id);
		$oldPath = $this->path;
		if (!$parent) {
			$this->path = $this->getId();
		} else {
			$this->path = $parent->path."=".$this->getId();
		}

		unset($this->updated_at);
		$this->save();
		$sql = "UPDATE `categories`
		SET `path` = REPLACE(`path`,'{$oldPath}=','{$this->path}=')  // 14=27(find), =(replace), 14=27(string)
		WHERE `path` LIKE '{$oldPath}=%';";
		$this->getResource()->getAdapter()->update($sql);
		return $this;
	}

	public function deleteChild()
	{
		if (!$this->getId()) {
			return false;
		}
		$query = "DELETE FROM `categories` WHERE `path` LIKE '{$this->path}=%'";
		$this->getResource()->getAdapter()->delete($query);
		return $this;
	}
}

?>