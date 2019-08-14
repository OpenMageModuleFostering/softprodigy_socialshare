<?php
/**
 * Softprodigy Inc.
 *
 *
 * @package    Softprodigy_Socialshare
 */ 

class Softprodigy_Socialshare_Model_Placeoption
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => 1, 'label'=>Mage::helper('adminhtml')->__('Left')),
            array('value' => 2, 'label'=>Mage::helper('adminhtml')->__('Right')),
        );
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return array(
            array('value' => 1, 'label'=>Mage::helper('adminhtml')->__('Left')),
            array('value' => 2, 'label'=>Mage::helper('adminhtml')->__('Right')),
        );
    }

}
