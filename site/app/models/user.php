<?php
class User extends AppModel {
    var $name = 'User';
	
	 function validateLogin($data) 
    { 
        $user = $this->find(array('username' => $data['username'], 'password' => sha1($data['password']))); 
        if(empty($user) == false) 
            return $user['User']; 
        return false; 
    } 
}

?>