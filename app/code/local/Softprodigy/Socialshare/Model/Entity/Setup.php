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
 
class Softprodigy_Socialshare_Model_Entity_Setup extends Mage_Eav_Model_Entity_Setup
{
    public function getDefaultEntities()
    {
        return array(
        	'socialshare_product' => array(
                'entity_model'      => 'socialshare/product',
                'table'=>'socialshare/entity',
                'attributes' => array(
               		'socialshare_entity_id'         => array('type'=>'static'),
               		'socialshare_name'    => array('type'=>'varchar'),
               		'socialshare_image'    => array('type'=>'varchar'),
               		'socialshare_link'    => array('type'=>'varchar'),
               		'socialshare_title'    => array('type'=>'text'),
               		'socialshare_position'    => array('type'=>'varchar'),
               		'socialshare_status'    => array('type'=>'int'),
                    'socialshare_created_at'        => array('type'=>'datetime')
              )
            )
        );
    }
}
