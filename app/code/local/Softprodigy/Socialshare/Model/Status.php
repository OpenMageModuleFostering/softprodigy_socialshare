<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   Softprodigy
 * @package    Softprodigy_Socialshare
 * @copyright  Copyright (c) 2014 SoftProdigy <magento@softprodigy.com>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
 
class Softprodigy_Socialshare_Model_Status extends Varien_Object
{
    const STATUS_ENABLED	= 1;
    const STATUS_DISABLED	= 2;

    static public function getOptionArray()
    {
        return array(
            self::STATUS_ENABLED    => Mage::helper('socialshare')->__('Enabled'),
            self::STATUS_DISABLED   => Mage::helper('socialshare')->__('Disabled')
        );
    }
}
