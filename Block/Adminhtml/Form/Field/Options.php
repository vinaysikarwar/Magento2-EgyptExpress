<?php
namespace ActiveDEMAND\ActiveDEMAND\Block\Adminhtml\Form\Field;

class Options extends \Magento\Framework\View\Element\Html\Select
{
    /**
     * Model Enabledisable
     *
     * @var \Magento\Config\Model\Config\Source\Enabledisable
     */
    protected $_enableDisable;

    /**
     * Activation constructor.
     *
     * @param \Magento\Framework\View\Element\Context $context
     * @param \Magento\Config\Model\Config\Source\Enabledisable $enableDisable $enableDisable
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Context $context,
        \ActiveDEMAND\ActiveDEMAND\Model\Config\Source\FormsToConfig $enableDisable,
		\Psr\Log\LoggerInterface $logger,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_logger = $logger;   
        $this->_enableDisable = $enableDisable;
    }

    /**
     * @param string $value
     * @return Magently\Tutorial\Block\Adminhtml\Form\Field\Activation
     */
    public function setInputName($value)
    {
        return $this->setName($value);
    }

    /**
     * Parse to html.
     *
     * @return mixed
     */
    public function _toHtml()
    {
        if (!$this->getOptions()) {
            $attributes = $this->_enableDisable->toOptionArray();
             //print_r($attributes);
			//$this->_logger->debug(json_encode($attributes));
			//$this->_logger->info(json_encode($attributes)); 
            foreach ($attributes as $key=>$value) {
			  //$this->_logger->info('key-'.$key); 
			 // $this->_logger->info('value-'.$value); 
			 
			  $this->addOption($key,$value);
            }
        }

        return parent::_toHtml();
    }
}