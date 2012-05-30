<?php
	/*
	* Пытаемся добавить заявку
	*/

	$base_url = 'http://www.idus.su/shipping_service/api_createorder';
	$chandle = curl_init();

	curl_setopt($chandle,CURLOPT_URL,$base_url);
	curl_setopt($chandle,CURLOPT_HEADER,0);
	curl_setopt($chandle,CURLOPT_FOLLOWLOCATION,1);
	curl_setopt($chandle,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($chandle,CURLOPT_POST,1);

	/*
	* Параметры запроса
	*/
	curl_setopt($chandle,CURLOPT_POSTFIELDS,array(
		'nsp_customer' => 'Иван Иван Петрович',
		'phone_customer' => '+7 921 985 40 40',
		'email_customer' => 'example@example.com',
		'address_customer' => 'г.Санкт-Петербург ул. Такая-то д.5 кв.5',
		'address_shipping' => 'г.Санкт-Петербург кл. Такая-то д.10 кв.10',
		'investment_customer' => 'Груз такой-то, весит столько-то',
		'nsp_shipping' => 'Петров Дмитрий Иванович',
		'phone_shipping' => '+7 921 234 22 22',
		'note_customer' => '', /* Примечание */
		'price_shipping' => '21000',
		'email' => 'apstrigin@gmail.com',
		'password' => 'admin12345'
	));

	$result = curl_exec($chandle);

	$result = json_decode($result);

	if(!empty($result)){
		if(!empty($result->status)){
			switch($result->status){
				case 'success':
					/*
					* Выводим код заказа
					*/
					echo "Код заказа: {$result->result}";
					break;
				case 'error':
					/*
					* Выводим сообщения об ошибках
					*/
					echo "Ошибки валидации формы:";
					print_r($result->errors);
					break;
				case 'unexpected_server_error':
					/*
					* Заказ не добавлен, непредвиденная ошибка
					*/
					echo 'unexpected_server_error';
					break;
				case 'auth_failed':
					/*
					* Неправильный логин или пароль
					*/
					echo 'auth_failed';
					break;
			}
		}
	}
	curl_close($chandle);
?>