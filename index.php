<?php

/**
 * Source code of the first version of the bot Kuzma.
 * @author GROM <botx68@gmail.com>
 * @license https://github.com/KuzmaBot/VKbotKuzmaForPHP/blob/master/LICENSE
 */

require __DIR__.'/config/config.php';
require __DIR__.'/core/apiVK.php';

// Init class vk.
$v = new vk();

// Load config.
$ctoken = $config['confirmation_token'];
$token  = $config['token'];
$gid    = $config['gid'];
$gjoin  = $config['group_join'];
$gleave = $config['group_leave'];
$gismember = $config['gismember'];

if (!isset($_REQUEST)) {
  return;
}

//Получаем и декодируем уведомление
    $data = $v->get();
//...получаем id его автора
    $uid = $data->object->user_id;
    $user_msg = $data->object->body;

//Проверяем, что находится в поле "type"
switch ($data->type) {
  //Если это уведомление для подтверждения адреса сервера...
  case 'confirmation':
    //...отправляем строку для подтверждения адреса
    echo $ctoken;
    break;
//Если это уведомление о новом сообщении...
  case 'message_new':
  $v->okCallbackApi();
//затем с помощью users.get получаем данные об авторе
    $user_info = $v->usersGet($uid);

//и извлекаем из ответа его имя
  $info = array_shift(json_decode($user_info)->response);
  $uname = $info->first_name;
  
// Проверим есть ли пользователь в группе, если есть, то продолжим общение, а если нет, то выводим сообщение что он должен для начала вступить в группу/паблик.
  $chk_uid = $v->groupsIsMember($gid, $uid);
    if($chk_uid != true){
    $v->msgSend($gismember, $uid, $token);
  }else{
  
    if(true){
      // Логика ответа.
      $smsg = 'Привет, я бот Кузя :)';
    $v->msgSend($smsg, $uid, $token);
  }
}
break;

// Если пользователь вступил в группу/паблик. 
case 'group_join':
    $v->okCallbackApi();
    $v->msgSend($gjoin, $uid, '', $token);
  break;

// Если пользователь покинул группу/паблик.
case 'group_leave':
    $v->okCallbackApi();
    $v->msgSend($gleave, $uid, $token);
  break;
}
?> 