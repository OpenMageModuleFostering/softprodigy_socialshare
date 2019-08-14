<?php

class Softprodigy_Socialshare_Block_Adminhtml_Socialshare_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('socialshare_form', array('legend'=>Mage::helper('socialshare')->__("Share Link Information")));
     
      $fieldset->addField('socialshare_name', 'text', array(
          'label'     => Mage::helper('socialshare')->__('Name'),
          'required'  => true,
          'name'      => 'socialshare_name',
      ));
   
	  $fieldset->addField('socialshare_image', 'image', array(
          'label'     => Mage::helper('socialshare')->__('Image'),
          'name'      => 'socialshare_image',
      ));
       
       $fieldset->addField('socialshare_link', 'text', array(
          'label'     => Mage::helper('socialshare')->__('Link'),
          'class'     => 'validate-url',
          'required'  => true,
          'name'      => 'socialshare_link',
          'after_element_html' => '<p><small>' . 'Exp:-For Google+ - https://plus.google.com/share?url=URI    Type "URI" in place of your site url.' . '</small></p>',
      ));
       
       $fieldset->addField('socialshare_title', 'text', array(
          'label'     => Mage::helper('socialshare')->__('Title'),
          'name'      => 'socialshare_title',
      ));
      	
      	$fieldset->addField('socialshare_position', 'text', array(
          'label'     => Mage::helper('socialshare')->__('Position'),
          'class'     => 'validate-digits',
          'required'  => true,
          'name'      => 'socialshare_position',
      ));
      
      $fieldset->addField('socialshare_status', 'select', array(
          'label'     => Mage::helper('socialshare')->__('Status'),
          'name'      => 'socialshare_status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('socialshare')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('socialshare')->__('Disabled'),
              ),
          ),
      ));
      
      if ( Mage::getSingleton('adminhtml/session')->getSocialshareData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getSocialshareData());
          Mage::getSingleton('adminhtml/session')->setSocialshareData(null);
      } elseif ( Mage::registry('socialshare_data') ) {
          $form->setValues(Mage::registry('socialshare_data')->getData());
      }
      return parent::_prepareForm();
  }
}
