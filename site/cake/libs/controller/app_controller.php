<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * This is a placeholder class.
 * Create the same file in app/app_controller.php
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.cake.libs.controller
 * @link http://book.cakephp.org/view/957/The-App-Controller
 */
class AppController extends Controller {
	
	function beforeFilter() {
		if (!$this->Session->read('Auth.User.id') && $this->params['controller'] != 'users') {  
        	// set flash message and redirect  
       		$this->redirect(array('controller' => 'users', 'action' => 'login', 'admin' => 0)); 
		}

		//if($this->Session->read('Auth.User.admin') == 'No' && $this->params['admin'] == 1) {
			//print_r($this->params);
			//$this->redirect(array('controller' => 'dashboard', 'action' => 'index', 'admin' => 1));
		//}
	}			
}
