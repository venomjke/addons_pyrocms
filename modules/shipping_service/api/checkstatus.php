<?php
	/*
	* Пытаемся проверить статус объявления
	*/	

	$base_url = 'http://idus.su/shipping_service/api_checkorder/#####';

	$chandle = curl_init();

	curl_setopt($chandle,CURLOPT_URL,$base_url);
	curl_setopt($chandle,CURLOPT_HEADER,0);
	curl_setopt($chandle,CURLOPT_FOLLOWLOCATION,1);
	curl_setopt($chandle,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($chandle,CURLOPT_POST,1);

	curl_setopt($chandle,CURLOPT_POSTFIELDS,array(

	));

	$result = curl_exec($chandle);

	$result = json_decode($result);

	if(!empty($result)){
		if(!empty($result->status)){
			switch($result->status){
				case 'success':
					/*
					* Можем посмотреть статус
					*/
					echo "Статус заказа ".$result->result;
					break;
				case 'order_not_found':
					/*
					* Объект, с указанным id не был найден
					*/
					echo "order_not_found";
					break;
				case 'error':
					/*
					* Id заказа не задан, либо это не число
					*/
					print_r($result->errors);
					break;
			}
		}
	}
?>