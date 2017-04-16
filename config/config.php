<?php

/**
 * Source code of the first version of the bot Kuzma.
 * @author GROM <botx68@gmail.com>
 * @license https://github.com/KuzmaBot/VKbotKuzmaForPHP/blob/master/LICENSE
 */

ini_set('display_errors', 1);
error_reporting(0);

//Строка для подтверждения адреса сервера из настроек Callback API
$config['confirmation_token'] = ''; // [ https://vk.com/{id_group}?act=api ]
$config['token'] = ''; // [ https://vk.com/{id_group}?act=tokens ];
$config['gid'] = ''; // идентификатор или короткое имя сообщества.

// Конфиг событий. 
$config['group_join']  = 'Спасибо за подписку'; // Сообщение при выходе пользователя.
$config['group_leave'] = 'Жаль за отписку...';  // Сообщение при выходе пользователя.
$config['gismember']   = 'Чтобы мною пользоваться, нужно на меня подписаться: vk.com/bot_kuzma'; // Сообщение для тех кто не состоит в группе/паблике.

?>