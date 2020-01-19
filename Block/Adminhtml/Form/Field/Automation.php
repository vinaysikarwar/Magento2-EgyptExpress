<?php
/**
 * @author Wtc Team
 * @copyright Copyright (c) 2018
 * @package
 */

namespace ActiveDEMAND\ActiveDEMAND\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

/**
 * Class Automation
 */
class Automation extends AbstractFieldArray
{
	
	protected $_itemRendererYesNo;
    /**
     * {@inheritdoc}
     */
	   protected $_activation;
	   protected $_allstatus;
	 
	protected function _getActivationRenderer()
    {
        if (!$this->_activation) {
            $this->_activation = $this->getLayout()->createBlock(
                '\ActiveDEMAND\ActiveDEMAND\Block\Adminhtml\Form\Field\Options',
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }

        return $this->_activation;
    } 
	
    protected function _getStatusRenderer()
    {
        if (!$this->_allstatus) {
            $this->_allstatus = $this->getLayout()->createBlock(
                '\ActiveDEMAND\ActiveDEMAND\Block\Adminhtml\Form\Field\Allstatus',
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }

        return $this->_allstatus;
    }	
	 
    protected function _prepareToRender()
    {
		$this->addColumn('orderstatus',['label' => __('Order Status'),'renderer' => $this->_getStatusRenderer(),'class' => 'required-entry']);
		$this->addColumn('posttoform',['label' => __('Post to form'),'renderer' => $this->_getActivationRenderer(),'class' => 'required-entry']);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');
    }
	
	
	
	protected function _prepareArrayRow(\Magento\Framework\DataObject $row)
    {
        $options = [];
		
		$customAttribute = $row->getData('orderstatus');
        $key = 'option_' . $this->_getStatusRenderer()->calcOptionHash($customAttribute);
        $options[$key] = 'selected="selected"';
		
		$customAttributetwo = $row->getData('posttoform');
        $keytwo = 'option_' . $this->_getActivationRenderer()->calcOptionHash($customAttributetwo);
        $options[$keytwo] = 'selected="selected"';
		
        $row->setData('option_extra_attrs', $options);
    }
	
	
}