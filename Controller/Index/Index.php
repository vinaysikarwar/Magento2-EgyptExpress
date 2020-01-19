<?php
namespace WTC\EgyptExpress\Controller\Index;
//ini_set('display_errors',1);

class Index extends \Magento\Framework\App\Action\Action
{
	/* const $apiUrl = "http://82.129.197.84:8080//api/cities";
	
	public function __construct(
		\Magento\Catalog\Block\Product\Context $context,
		array $data = []
		)
	{
		$this->apiUrl = $apiUrl;
        parent::__construct($context, $data);	
    } */
	
    public function execute()
    {


		/* $ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "http://82.129.197.84:8080/api/shippingCalculator");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, true);

			$shipdata = array(
				'source' => "10th of Ramadan",//$originCity,
				'destination' => "Qalioub",//$destinationCity,
				'weight_unit' => 1,//$qty,
				'weight' => 2,//$weight
			);
			
			curl_setopt($ch, CURLOPT_POSTFIELDS, $shipdata);
			$output = curl_exec($ch);
			$info = curl_getinfo($ch);
			curl_close($ch); 
				$res = json_decode($output);
			
		echo '<pre>';print_r($res);
			
			die('test'); */
		//$url = $this->apiUrl. "/api/shippingCalculator/";
		/* $form ='<h1>Calculator</h1>
				<form action="http://82.129.197.84:8080/api/shippingCalculator" method="post">
					<label>Source</label>
					<input type="text" name="source" id="" >
					<br><label>Destination</label>
					<input type="text" name="destination" id="" >
					<br><label>Width</label>
					<input type="text" name="width" id="" >
					<br><label>Height</label>
					<input type="text" name="height" id="" >
					<br><label>Length</label>
					<input type="text" name="length" id="" >
					<br><label>Unit</label>
					<input type="text" name="weight_unit" id="" >
					<br><label>Weight</label>
					<input type="text" name="weight" id="" >
					<input type="submit" value="submit">
				</form>';
		echo $form;
		die('test');
		//$url = "/api/cities";
		$result = file_get_contents($url);
		// Will dump a beauty json :3
		echo '<pre>';print_r(json_decode($result, true));die; */

        $this->_view->loadLayout();
        $this->_view->getLayout()->initMessages();
        $this->_view->renderLayout();
    }
}