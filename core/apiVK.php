<?php


/**
 * Source code of the first version of the bot Kuzma.
 * @author GROM <botx68@gmail.com>
 * @license https://github.com/KuzmaBot/VKbotKuzmaForPHP/blob/master/LICENSE
 */


class vk {
	const API_VERSION = '5.24';
	const METHOD_URL = 'https://api.vk.com/method/';

	public function get(){
		return json_decode(file_get_contents('php://input'));
	}

    /**
     * Get User Info.
     * @param   string $uid
     * @return  string
     */
	public function usersGet($uid){	
		return file_get_contents(self::METHOD_URL."users.get?user_ids={$uid}&v=".self::API_VERSION);
	}

    /**
     * Check user is a member of the community.
     * @param   string $gid
     * @param   string $uid
     * @return  string
     */
	public function groupsIsMember($gid, $uid){
		$res = json_decode(file_get_contents(self::METHOD_URL."groups.isMember?group_id={$gid}&user_id={$uid}&v=".self::API_VERSION));
	    return $res->response; 
	}

    /**
     * Send messages.
     * @param   string $msg
     * @param   string $uid
     * @param   string $token
     * @return
     */
    public function msgSend($msg, $uid, $token){	
		$request_params = array(
		  'message' => $msg,
		  'user_id' => $uid,
		  'access_token' => $token,
		  'v' => self::API_VERSION
		);
		$get_params = http_build_query($request_params);
		file_get_contents(self::METHOD_URL."messages.send?".$get_params);
	}

    /**
     * Magic.
     * @return string
     */
	public function okCallbackApi(){
		ob_start();
		echo 'ok';
		$length = ob_get_length();
		// magic
		header('Connection: close');
		header("Content-Length: " . $length);
		header("Content-Encoding: none");
		header("Accept-Ranges: bytes");
		ob_end_flush();
		ob_flush();
		flush();
	}

}

?>
