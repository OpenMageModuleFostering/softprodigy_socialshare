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
class Softprodigy_Socialshare_Adminhtml_SocialshareController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('sociallinks/managesocialshare')
			->_addBreadcrumb(Mage::helper('adminhtml')->__("Links Manager"), Mage::helper('adminhtml')->__("Links Manager"));
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()->renderLayout();
	}
	
	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('socialshare/socialshare_product')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('socialshare_data', $model);

			$this->loadLayout();
			if(empty($id))
			{
				$this->getLayout()->getBlock('head')->setTitle($this->__("New Link / Manage SocialLinks / SocialLinks / Magento Admin"));
			}
			else
			{
				$this->getLayout()->getBlock('head')->setTitle($this->__($model->getSocialshareName()." / Manage SocialLinks / SocialLinks / Magento Admin"));
			}
			$this->_setActiveMenu('sociallinks/managesocialshare');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__("SocialLinks Manager"), Mage::helper('adminhtml')->__("SocialLinks Manager"));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('socialshare/adminhtml_socialshare_edit'))
				->_addLeft($this->getLayout()->createBlock('socialshare/adminhtml_socialshare_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('socialshare')->__('Link does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	public function newAction() {
		$this->_forward('edit');
	}
 
	public function saveAction() {
		
		$socialshareCollection = Mage::getModel('socialshare/socialshare_product')->getCollection();
		if (!is_dir(Mage::getBaseDir().'/media/socialshare/')) {
				mkdir(Mage::getBaseDir().'/media/socialshare/', 0777);
		} 
		$path = Mage::getBaseDir('media') ."/socialshare/" ;
		$supported_extensions = array('jpg', 'png', 'gif', 'jpeg', 'bmp');
		
		
		if ($data = $this->getRequest()->getPost()) 
		{
			
			$resource = Mage::getSingleton('core/resource');
			$readConnection = $resource->getConnection('core_read');
			$writeConnection = $resource->getConnection('core_write');
		
			$error = 0;
			$replace = 0; 
			$id = $this->getRequest()->getParam('id');
			
			//------Start ---Checking position if already exist--
			$pos_attri_id = $readConnection->query("SELECT `attribute_id` FROM `eav_attribute` WHERE `attribute_code` = 'socialshare_position'");
			$pos_attri_id = $pos_attri_id->fetch();
			$pos_attri_id = $pos_attri_id['attribute_id'];
			
			if($id)
			{	
				$value = $data['socialshare_position'];	
				$linkdata = $readConnection->query("SELECT * FROM socialshare_entity_varchar where attribute_id = $pos_attri_id and value = $value and entity_id != $id ;");
				$linkdata = $linkdata->fetch();
				if(!empty($linkdata))
				{
					Mage::getSingleton('adminhtml/session')->addError(Mage::helper('socialshare')->__("Position value conflict with exist link position. Please try with new 'position value'."));
					$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
					return;
				}	
			}
			else
			{
				$value = $data['socialshare_position'];	
				$linkdata = $readConnection->query("SELECT * FROM socialshare_entity_varchar where attribute_id = $pos_attri_id and value = $value ;");
				$linkdata = $linkdata->fetch();
				if(!empty($linkdata))
				{
					Mage::getSingleton('adminhtml/session')->addError(Mage::helper('socialshare')->__("Position value conflict with exist link position. Please try with new 'position value'."));
					$this->_redirect('*/*/edit');
					return;
				}		
			}
			//----End ---checking position------
			
				$model = Mage::getModel('socialshare/socialshare_product')->load($id);
				foreach($_FILES as $field1 => $val1)
				{
					if(!empty($val1['name']))
					{
						if($val1['error'] == 0)
						{
							$slider_extension = end(explode('.', $val1['name']));
							if(in_array($slider_extension,$supported_extensions)) {
								$time = time();
								$removeunderscore1 = str_replace('_', ' ', $field1);
								$ucwordss1 = ucwords($removeunderscore1);
								$imgname = str_replace(' ', '_', $ucwordss1);
								$imgname = $time.$imgname;
								$func1 = str_replace(' ', '', $ucwordss1);
								$fname1 = "set".$func1;
								if(isset($val1['name']) && $val1['name'] != '') {
									$sliderimage = str_replace(' ', '_', $imgname);
									$slider_uploader = new Varien_File_Uploader($field1);
									$slider_uploader->setAllowedExtensions($supported_extensions);
									$slider_uploader->setAllowRenameFiles(true);
									$slider_uploader->setFilesDispersion(false);
									$slider_uploader->save($path, $sliderimage.".".$slider_extension );
									$dbval = "socialshare/".$sliderimage.".".$slider_extension;
									$model->$fname1($dbval);
									unset($slider_uploader);
									
									if($data['socialshare_image']['value'])
									{
										//unlink(Mage::getBaseDir('media').'/'.$data['socialshare_image']['value']);
										$replace = 1; 	
									}
								}
							} else {
								$error = 1;
							}
						} else {
							$error = 1;
						}
					}
				}
				foreach($_POST as $field => $val)
				{
					if($replace == 1 && $field == 'socialshare_image')
						continue; 	
						
					$value = $val;
					$removeunderscore = str_replace('_', ' ', $field);
					$ucwordss = ucwords($removeunderscore);
					$func = str_replace(' ', '', $ucwordss);
					$fname = "set".$func;
					if(is_array($value))
					{
						if($value['delete'] == 1)
						{
							//unlink(Mage::getBaseDir('media').'/'.$data['socialshare_image']['value']);
							$value = '';
						}	
					}
					$model->$fname($value);
				}
				
				try {
					if ($model->getSocialshareCreatedAt == NULL) {
						$model->setSocialshareCreatedAt(now());
					}
					if($error == 1) {
						Mage::getSingleton('adminhtml/session')->setFormData($data);
						Mage::getSingleton('adminhtml/session')->addError(Mage::helper('socialshare')->__('Invalid Link image format'));
						$this->_redirect('*/*/');
					} else {
						$model->save();
						Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('socialshare')->__('Link was successfully saved'));
						Mage::getSingleton('adminhtml/session')->setFormData(false);
					}
					if ($this->getRequest()->getParam('back')) {
						$this->_redirect('*/*/edit', array('id' => $model->getId()));
						return;
					}
					$this->_redirect('*/*/');
					return;
				} catch (Exception $e) {
					Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
					Mage::getSingleton('adminhtml/session')->setFormData($data);
					$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
					return;
				}
		}
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('socialshare')->__('Unable to find link to save'));
		$this->_redirect('*/*/');
	}
 
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('socialshare/socialshare_product');
				$model->setId($this->getRequest()->getParam('id'))
					->delete();
					 
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Link was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

    public function massDeleteAction() {
        $webIds = $this->getRequest()->getParam('socialshare');
        if(!is_array($webIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select Share link(s)'));
        } else {
            try {
                foreach ($webIds as $webId) {
                    $web = Mage::getModel('socialshare/socialshare_product')->load($webId);
                    //unlink(Mage::getBaseDir('media').'/'.$web->getSocialshareImage());
                    $web->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($webIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	
    public function massStatusAction()
    {
        $webIds = $this->getRequest()->getParam('socialshare');
        $read = Mage::getSingleton('core/resource')->getConnection('core_read');
        $attr_query = $read->fetchall("select * from `eav_attribute` where `attribute_code`='socialshare_status'");
        $attr_id = $attr_query[0]['attribute_id'];
		if(!is_array($webIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select slide(s)'));
        } else {
            try {
                foreach ($webIds as $webId) {
					if($webId!="")
					{
						$write = Mage::getSingleton('core/resource')->getConnection('core_write');
						$query = "delete from `socialshare_entity_int` where `entity_id`='".$webId."' and `attribute_id`='".$attr_id."'";
						$write->query($query);
					}
					$web = Mage::getModel('socialshare/socialshare_product')->load($webId);
					$web->setSocialshareStatus($this->getRequest()->getParam('socialshare_status'));
					$web->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($webIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
    
    /*------Create default share links ---------*/
    public function commonlinkAction()
    {
		try
		{
			$resource = Mage::getSingleton('core/resource');
			$readConnection = $resource->getConnection('core_read');
			$writeConnection = $resource->getConnection('core_write');
			
			/*---Getting all socialshare's attribute_id and attribute_set_id  */
			$data = $readConnection->query("SELECT `attribute_id` , `entity_type_id` , `attribute_code` FROM `eav_attribute` WHERE `attribute_code` LIKE 'socialshare%' ORDER BY `attribute_id`");
			$data = $data->fetchAll();
			
			/*---seprate array for each attribute-----*/
			foreach($data as $key => $index)
			{
				$att[$index['attribute_code']]['a_id'] = $index['attribute_id'];
				$att[$index['attribute_code']]['e_id'] = $index['entity_type_id'];
			}
			$attSetId  =  $att['socialshare_name']['e_id']; /*---Attribute set id is common for all socialshare's attributes-------*/

			$writeConnection->query("INSERT INTO `socialshare_entity` VALUES
			(1, $attSetId, 0, NULL, '', 0, '', 0, 0, now(), now(), 1),
			(2, $attSetId, 0, NULL, '', 0, '', 0, 0, now(), now(), 1),
			(3, $attSetId, 0, NULL, '', 0, '', 0, 0, now(), now(), 1),
			(4, $attSetId, 0, NULL, '', 0, '', 0, 0, now(), now(), 1),
			(5, $attSetId, 0, NULL, '', 0, '', 0, 0, now(), now(), 1);
			");
			$create = $att['socialshare_created_at']['a_id'];
			$writeConnection->query("INSERT INTO `socialshare_entity_datetime` VALUES
			('', $attSetId, $create, 1, now()),
			('', $attSetId, $create, 2, now()),
			('', $attSetId, $create, 3, now()),
			('', $attSetId, $create, 4, now()),
			('', $attSetId, $create, 5, now());");
			
			$status = $att['socialshare_status']['a_id'];
			$writeConnection->query("INSERT INTO `socialshare_entity_int` VALUES
			('', $attSetId, $status, 1, 1),
			('', $attSetId, $status, 2, 1),
			('', $attSetId, $status, 3, 1),
			('', $attSetId, $status, 4, 1),
			('', $attSetId, $status, 5, 1);");

			$title = $att['socialshare_title']['a_id'];
			$writeConnection->query("INSERT INTO `socialshare_entity_text` VALUES
			('', $attSetId, $title, 1, 'Share On FB'),
			('', $attSetId, $title, 2, 'Share On G+'),
			('', $attSetId, $title, 3, 'Share On Twitter'),
			('', $attSetId, $title, 4, 'Share On Linkedin'),
			('', $attSetId, $title, 5, 'Share On PIN');");

			$image = $att['socialshare_image']['a_id'];
			$name = $att['socialshare_name']['a_id'];
			$link = $att['socialshare_link']['a_id'];
			$pos = $att['socialshare_position']['a_id'];
			
			$writeConnection->query( "INSERT INTO `socialshare_entity_varchar` VALUES
			('', $attSetId, $image, 1, 'socialshare/1401346942Socialshare_Image.png'),
			('', $attSetId, $name, 1, 'Facebook'),
			('', $attSetId, $link, 1, 'https://www.facebook.com/sharer/sharer.php?u=URI'),
			('', $attSetId, $pos, 1, '1'),
			('', $attSetId, $image, 2, 'socialshare/1401346970Socialshare_Image.png'),
			('', $attSetId, $name, 2, 'Google Plus'),
			('', $attSetId, $link, 2, 'https://plus.google.com/share?url=URI'),
			('', $attSetId, $pos, 2, '2'),
			('', $attSetId, $image, 3, 'socialshare/1401347001Socialshare_Image.png'),
			('', $attSetId, $name, 3, 'Twitter'),
			('', $attSetId, $link, 3, 'https://twitter.com/share?url=URI'),
			('', $attSetId, $pos, 3, '3'),
			('', $attSetId, $image, 4, 'socialshare/1401347065Socialshare_Image.png'),
			('', $attSetId, $name, 4, 'Linked in'),
			('', $attSetId, $link, 4, 'https://www.linkedin.com/shareArticle?url=URI'),
			('', $attSetId, $pos, 4, '4'),
			('', $attSetId, $image, 5, 'socialshare/1401347109Socialshare_Image.png'),
			('', $attSetId, $name, 5, 'Pinterest'),
			('', $attSetId, $link, 5, 'https://pinterest.com/pin/create/button/?url=URI'),
			('', $attSetId, $pos, 5, '5');");
		
			Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('socialshare')->__('Links was successfully created.'));
		}
		catch(Exception $e)
		{
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('socialshare')->__('Please delete all links then try again.'));
		}
		$this->_redirect('*/*/index');
	}
}
