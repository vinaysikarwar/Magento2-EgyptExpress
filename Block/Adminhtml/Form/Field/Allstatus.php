<?php
namespace ActiveDEMAND\ActiveDEMAND\Block\Adminhtml\Form\Field;

class Allstatus extends \Magento\Framework\View\Element\Html\Select
{
    /**
     * Model Enabledisable
     *
     * @var \Magento\Config\Model\Config\Source\Enabledisable
     */
	 protected $options = null;
    protected $_OrderStatus;
 protected $statusCollectionFactory;
    /**
     * Activation constructor.
     *
     * @param \Magento\Framework\View\Element\Context $context
     * @param \Magento\Config\Model\Config\Source\Enabledisable $enableDisable $enableDisable
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Context $context,
        \ActiveDEMAND\ActiveDEMAND\Model\Config\Source\MultiselectOrderStatus $OrderStatus,
		\Psr\Log\LoggerInterface $logger,
		\Magento\Sales\Model\ResourceModel\Order\Status\CollectionFactory $statusCollectionFactory,
        array $data = []
    ){
        parent::__construct($context, $data);
        $this->_logger = $logger;   
        $this->_OrderStatus = $OrderStatus;
		$this->statusCollectionFactory = $statusCollectionFactory;
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
	 
	 
	public function toOptionArray()
    {
        if ($this->options === null) {
            $status = $this->statusCollectionFactory->create();
            foreach ($status as $stat) {
              $this->options[$stat->getStatus()] = $stat->getLabel() ;
            }
        }
        return $this->options;
    } 
	 
	 
    public function _toHtml()
    {
        if (!$this->getOptions()){
          // $attributes = $this->_OrderStatus->toOptionArray();
		   $options = $this->toOptionArray();
             //print_r($attributes);
			
			//$this->_logger->info(json_encode($options)); 
            foreach ($options as $key=>$value){
			  //$this->_logger->info('key-'.$key); 
			 // $this->_logger->info('value-'.$value); 
			 //$this->_logger->debug(json_encode($option));
			  $this->addOption($key,$value);
            }
        }

        return parent::_toHtml();
    }
}