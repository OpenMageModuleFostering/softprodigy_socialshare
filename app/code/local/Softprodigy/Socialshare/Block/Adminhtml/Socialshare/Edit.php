<?php

class Softprodigy_Socialshare_Block_Adminhtml_Socialshare_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'socialshare';
        $this->_controller = 'adminhtml_socialshare';
        
        $this->_updateButton('save', 'label', Mage::helper('socialshare')->__("Save Link"));
        $this->_updateButton('delete', 'label', Mage::helper('socialshare')->__("Delete Link"));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('web_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'web_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'web_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('socialshare_data') && Mage::registry('socialshare_data')->getId() ) {
            return Mage::helper('socialshare')->__("Edit Share Link '%s'", $this->htmlEscape(Mage::registry('socialshare_data')->getSocialshareName()));
        } else {
            return Mage::helper('socialshare')->__("Add New Share Link");
        }
    }
}
