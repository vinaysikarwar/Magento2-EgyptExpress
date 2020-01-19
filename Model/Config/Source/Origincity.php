<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace WTC\EgyptExpress\Model\Config\Source;

class Origincity implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
		//echo $this->getCityList();
        return [
            ['value' => 0, 'label' => __('All Allowed Countries')],
            ['value' => 1, 'label' => __('Specific Countries')]
        ];
    }
	
	public function getCityList(){
		$result = file_get_contents($url);
		//echo '<pre>';print_r(json_decode($result, true));die;
		
	}
}