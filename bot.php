<?php
require __DIR__.'/config/config.php';
require __DIR__.'/core/apiVK.php';
$v = new vk();
$confirmation_token = $config['confirmation_token'];
//Ключ доступа сообщества
$token = $config['token'];

if (!isset($_REQUEST)) {
  return;
}

//Получаем и декодируем уведомление
$data = $v->get();

//Проверяем, что находится в поле "type"
switch ($data->type) {
  //Если это уведомление для подтверждения адреса сервера...
  case 'confirmation':
    //...отправляем строку для подтверждения адреса
    echo $confirmation_token;
    break;

//Если это уведомление о новом сообщении...
  case 'message_new':
    //...получаем id его автора
    $uid = $data->object->user_id;
	$user_msg = $data->object->body;
	
    //затем с помощью users.get получаем данные об авторе
    $user_info = $v->usersGet($uid);

//и извлекаем из ответа его имя
	$info = array_shift(json_decode($user_info)->response);
	$uname = $info->first_name;

	//С помощью messages.send и токена сообщества отправляем ответное сообщение
	if($user_msg == '/time'){
		$v->msgSend("Время:".date('h:i:s'), $uid, $token);
	}else{
		$v->msgSend("Привет, $uname", $uid, $token);
	}
//Возвращаем "ok" серверу Callback API
    echo('ok');
die;
break;
}
?> 