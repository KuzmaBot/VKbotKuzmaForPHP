<?php

/***************************************
* Class VK
* author: https://github.com/retro3f
***************************************/


class VK {
	
  const API_VERSION = '5.24';
  const CALLBACK_BLANK = 'https://oauth.vk.com/blank.html';
  const AUTHORIZE_URL = 'https://oauth.vk.com/authorize?client_id={client_id}&scope={scope}&redirect_uri={redirect_uri}&display={display}&v=5.24&response_type={response_type}';
  const GET_TOKEN_URL = 'https://oauth.vk.com/access_token?client_id={client_id}&client_secret={client_secret}&code={code}&redirect_uri={redirect_uri}';
  const METHOD_URL = 'https://api.vk.com/method/';
  public $secret_key = null;
  public $scope = array();
  public $client_id = null;
  public $access_token = null;
  public $owner_id = 0;
  /**
  * Это Конструктор (Кэп.)
  * Передаются параметры настроек
  * @param array $options
  */
  function __construct($options = array()){
    $this->scope[]='offline';
    if(count($options) > 0){
      foreach($options as $key => $value){
        if($key == 'scope' && is_string($value)){
          $_scope = explode(',', $value);
          $this->scope = array_merge($this->scope, $_scope);
        } else {
          $this->$key = $value;
        }
      }
    }
  }
  /**
  * Выполнение вызова Api метода
  * @param string $method - метод, http://vk.com/dev/methods
  * @param array $vars - параметры метода
  * @return array - выводит массив данных или ошибку (но тоже в массиве)
  */
  function api($method = '', $vars = array()){
    $vars['v'] = self::API_VERSION;
    $params = http_build_query($vars);
    $url = $this->http_build_query($method, $params);
    return (array)$this->call($url);
  }
  /**
  * Построение конечного URI для выхова
  * @param $method
  * @param string $params
  * @return string
  */
  private function http_build_query($method, $params = ''){
    return  self::METHOD_URL . $method . '?' . $params.'&access_token=' . $this->access_token;
  }
  /**
  * Получить ссылка на запрос прав доступа
  *
  * @param string $type тип ответа (code - одноразовый код авторизации , token - готовый access token)
  * @return mixed
  */
  public function get_code_token($type="code"){
    $url = self::AUTHORIZE_URL;
    $scope = implode(',', $this->scope);
    $url = str_replace('{client_id}', $this->client_id, $url);
    $url = str_replace('{scope}', $scope, $url);
    $url = str_replace('{redirect_uri}', self::CALLBACK_BLANK, $url);
    $url = str_replace('{display}', 'page', $url);
    $url = str_replace('{response_type}', $type, $url);
    return $url;
  }
  public function get_token($code){
    $url = self::GET_TOKEN_URL;
    $url = str_replace('{code}', $code, $url);
    $url = str_replace('{client_id}', $this->client_id, $url);
    $url = str_replace('{client_secret}', $this->secret_key, $url);
    $url = str_replace('{redirect_uri}', self::CALLBACK_BLANK, $url);
    return $this->call($url);
  }  
}

?>