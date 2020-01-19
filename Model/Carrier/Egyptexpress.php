<?php

namespace WTC\EgyptExpress\Model\Carrier;
 
use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Shipping\Model\Rate\Result;
 
class Egyptexpress extends \Magento\Shipping\Model\Carrier\AbstractCarrier implements
    \Magento\Shipping\Model\Carrier\CarrierInterface
{
    /**
     * @var string
     */
    protected $_code = 'egyptexpress';
 
    /**
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Shipping\Model\Rate\ResultFactory $rateResultFactory
     * @param \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Shipping\Model\Rate\ResultFactory $rateResultFactory,
        \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory,
		\Magento\Checkout\Model\Cart $cartModel,
		\Magento\Checkout\Model\Session $checkoutSession,
        array $data = []
    ) {
        $this->_rateResultFactory = $rateResultFactory;
		$this->_cart = $cartModel;
		$this->_checkoutSession = $checkoutSession;
        $this->_rateMethodFactory = $rateMethodFactory;
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);
    }
 
    /**
     * @return array
     */
    public function getAllowedMethods()
    {
        return ['egyptexpress' => $this->getConfigData('name')];
    }
 
    /**
     * @param RateRequest $request
     * @return bool|Result
     */
    public function collectRates(RateRequest $request)
    {
        if (!$this->getConfigFlag('active')) {
            return false;
        }
	
		$data = $this->getFormData();
		$weight = $data['weight'];
		$originCity = $this->getConfigData('origincity');
		$destinationCity = $this->_checkoutSession->getQuote()->getShippingAddress()->getCity();
		$price = 0;
		if($destinationCity){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "http://82.129.197.84:8080/api/shippingCalculator");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, true);
			
			$dcityId = $this->getCityIdByName($destinationCity);
			$shipdata = array(
				'source' => $originCity,
				'destination' => $dcityId,
				'weight_unit' => 2,
				'weight' => $weight
			);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $shipdata);
			$output = curl_exec($ch);
			$info = curl_getinfo($ch);
			curl_close($ch); 
			$response = json_decode($output);
			
			if($response->response_code == 200){
				$price = $response->total_price;
			}
		}else{
			$price = 0;
		}		
		
			
			$result = $this->_rateResultFactory->create();
	 
			$method = $this->_rateMethodFactory->create();
	 
			$method->setCarrier('egyptexpress');
			$method->setCarrierTitle($this->getConfigData('title'));
	 
			$method->setMethod('egyptexpress');
			$method->setMethodTitle($this->getConfigData('name'));
	 
		
			//$amount = $this->getConfigData('price');
	 
			$method->setPrice($price);
			$method->setCost($price);
	 
			$result->append($method);
	 
			return $result;
		 
    }
	
	public function getFormData()
	{
		$items = $this->_cart->getQuote()->getAllItems();

		$weight = 0;
		$qty = 0;
		foreach($items as $item) {
			$weight += ($item->getWeight() * $item->getQty()) ;     
			$qty += $item->getQty();
		}
		
		$data['weight'] = $weight;
		$data['qty'] = $qty;
		
		return $data;
	}
	
	public function getCityIdByName($cityName){
		
		$url = "http://82.129.197.84:8080/api/shippingCities";
		$result = file_get_contents($url);
		$cities = json_decode($result, true);
		$cityList = $cities['cities'];
		$citiesArray = array();
		foreach($cityList as $city){
			
			$name = $city['city_en'];
			if($name == $cityName){
				return $city['id'];
			}
		}
	}
	public function getConfigDataSystem($name){
		return $this->getConfigData($name);
	}
}