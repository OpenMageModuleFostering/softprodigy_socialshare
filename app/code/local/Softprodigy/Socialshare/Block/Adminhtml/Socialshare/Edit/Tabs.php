<?php
class Softprodigy_Socialshare_Block_Adminhtml_Socialshare_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('socialshare_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('socialshare')->__("Share Link Information"));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('socialshare_form', array(
          'label'     => Mage::helper('socialshare')->__("Share Link Information"),
          'title'     => Mage::helper('socialshare')->__("Share Link Information"),
          'content'   => $this->getLayout()->createBlock('socialshare/adminhtml_socialshare_edit_tab_form')->toHtml(),
      ));     
      return parent::_beforeToHtml();
  }
}
