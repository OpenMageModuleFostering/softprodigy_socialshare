<?php

class Softprodigy_Socialshare_Block_Adminhtml_Socialshare_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('socialshareGrid');
      $this->setDefaultSort('id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getResourceModel('socialshare/socialshare_product_collection')->addAttributeToSelect('*');
      
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('entity_id', array(
          'header'    => Mage::helper('socialshare')->__('ID'),
          'width' => '50px',
          'type'  => 'number',
          'index'     => 'entity_id',
      ));

      $this->addColumn('socialshare_name', array(
          'header'    => Mage::helper('socialshare')->__('Name'),
          'align'     =>'left',
          'index'     => 'socialshare_name',
      ));
     
     $this->addColumn('socialshare_title', array(
          'header'    => Mage::helper('socialshare')->__('Title'),
          'align'     =>'left',
          'index'     => 'socialshare_title',
      ));
	 
	 $this->addColumn('socialshare_image', array(
          'header'    => Mage::helper('socialshare')->__('Image'),
          'align'     =>'left',
          'type' 	  => 'image',
          'index'     => 'socialshare_image',
          'renderer' => 'socialshare/adminhtml_socialshare_renderer_image', //get the image HTML code
		  'style' => 'text-align:center',
		  'filter'    => false,
          'sortable'  => false,
      ));
      
	 $this->addColumn('socialshare_position', array(
          'header'    => Mage::helper('socialshare')->__('Position'),
          'align'     =>'left',
          'index'     => 'socialshare_position',
      ));
      
	$this->addColumn('action',
            array(
                'header'    =>  Mage::helper('socialshare')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('socialshare')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
        
	  
      
      $this->addColumn('socialshare_status', array(
          'header'    => Mage::helper('socialshare')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'socialshare_status',
          'type'      => 'options',
          'options'   => array(
              1 => 'Enabled',
              2 => 'Disabled',
          ),
      ));
	  
        
		
		//$this->addExportType('*/*/exportCsv', Mage::helper('csv')->__('CSV'));
		//$this->addExportType('*/*/exportXml', Mage::helper('csv')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('socialshare');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('socialshare')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('socialshare')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('socialshare/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('socialshare')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'socialshare_status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('socialshare')->__('Status'),
                         'values' => $statuses
                     )
             )
        ));
        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}
