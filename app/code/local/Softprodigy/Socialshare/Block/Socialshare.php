<?php

class Softprodigy_Socialshare_Block_Socialshare extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
    public function getSocialshare()     
    { 
        if (!$this->hasData('socialshare')) {
            $this->setData('socialshare', Mage::registry('socialshare'));
        }
        return $this->getData('socialshare');
    }
}
