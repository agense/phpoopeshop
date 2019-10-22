<?php

class UserSessions extends Model{
	public $id, $user_id, $user_session, $user_agent;

	public function __construct(){
		$table = 'user_sessions';
		parent::__construct($table);
	}

	// RETURN USER FROM REMEMBER ME COOKIE
	// Used for remember me functionality, i.e. automatic login
	public static function getUserFromCookie(){
	    $uSession = new self();	
	    if(Cookie::exists(REMEMBER_ME_COOKIE_NAME)){
		$userSession = $uSession->findfirst([
			'conditions' => "user_agent = ? AND user_session = ?",
			'bind' => [Session::uagent_no_version(), Cookie::get(REMEMBER_ME_COOKIE_NAME)]
        ]);
	    }
	    if(!$userSession) return false;
	    return $userSession;
    }
}