<?php

namespace WTC\EgyptExpress\Block\Index;


class Index extends \Magento\Framework\View\Element\Template {

    public function __construct(\Magento\Catalog\Block\Product\Context $context, array $data = []) {

        parent::__construct($context, $data);

    }


    protected function _prepareLayout()
    {
        return parent::_prepareLayout();
    }
	
	public function getCityList(){
		
		$url = "http://82.129.197.84:8080/api/shippingCities";
		$result = file_get_contents($url);
		$cities = json_decode($result, true);
		$cityList = $cities['cities'];
		return $cityList;
	}

}