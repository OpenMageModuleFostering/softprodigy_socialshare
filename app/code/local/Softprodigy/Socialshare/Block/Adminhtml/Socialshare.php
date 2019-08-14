<?php

class Softprodigy_Socialshare_Block_Adminhtml_Socialshare extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_socialshare';
    $this->_blockGroup = 'socialshare';
    $this->_headerText = Mage::helper('socialshare')->__("Manage Social Share Links");
    $this->_addButtonLabel = Mage::helper('socialshare')->__("Add New Link");
    
    $resource = Mage::getSingleton('core/resource');
	$readConnection = $resource->getConnection('core_read');
	$check = $readConnection->query("SELECT * from socialshare_entity ");
	$check = $check->fetch();
	if(empty($check))
	{
		$data = array(
				   'label' =>  'Create Default Share Links',
				   'onclick'   => "setLocation('".$this->getUrl('*/adminhtml_socialshare/commonlink')."')"
				   );
		Mage_Adminhtml_Block_Widget_Container::addButton('default_share_links', $data, 0, 100,  'header', 'header');           
	}
    
    parent::__construct();
  }
}
