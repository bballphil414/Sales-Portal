<?
class UsersController extends AppController {
	var $name = 'Users';
	var $components = array('Auth', 'Email');
	var $helpers = array('Html','Ajax','Javascript');
	
	function beforeFilter() {
		$this->Auth->allow('*');
		if($this->Session->read('Auth.User.id')) {
			$user = $this->User->findById($this->Session->read("Auth.User.id"));
			$this->loadModel("Logs");
			$this->Logs->set(array("user_id" => $user['User']['id'], "timestamp" => time(), "event_description" => "Logged in."));
			$this->Logs->save();
		}
		$this->set('session_status', 1);
		
		$this->loadModel("Files");
		$files = array();
		
		$this->loadModel("Contacts");
		$contacts = array();
		
		parent::beforeFilter();
	}
	
	function index() {
		$this->redirect(array('action' => 'login'));
	}
	
	function login() {
		if($this->Session->read('Auth.User.id')){
			$this->set('login', true);
			$user = $this->User->findById($this->Session->read('Auth.User.id'));
			if($user['User']['admin'] == "Yes") {
				$this->Session->write("admin", "Yes");
			} else {
				$this->Session->write("admin", "No");
			}
		if($this->Session->read('admin') == "Yes") {
			$this->redirect(array('controller' => 'dashboard', 'admin'=>1, 'action' => 'index'));
		} else {
			$this->redirect(array('controller' => 'dashboard', 'admin'=>0, 'action' => 'index'));
		}
		
		}
			// Session access variables
			
			// Log this action
			//$this->loadModel("Logs");
			//$this->Logs->set(array("user_id" => $user['User']['id'], "timestamp" => time(), "event_description" => "Logged in."));
			//$this->Logs->save();
			 
		
	}
	function logout() {
		$this->loadModel("Logs");
		$this->loadModel("Users");
		$user = $this->Users->findById($this->Session->read("Auth.User.id"));
		$this->Logs->set(array("user_id" => $user['Users']['id'], "timestamp" => time(), "event_description" => "Logged out."));
		$this->Logs->save();
		
		$this->Session->write("admin", "No");
		
		$this->redirect($this->Auth->logout());
	}
	
	function admin_index() {
		$this->loadModel("Files");
		$files = $this->Files->find('all', array('conditions' => "system = 'System' OR (system = 'Personal' AND user_id = ".$this->Session->read('Auth.User.id').") ORDER BY timestamp DESC LIMIT 10"));
		$this->set('files', $files);
		$this->loadModel("Contacts");
		$this->set('contacts', $this->Contacts->find('all', array('conditions'=>"system = 'System' OR (system = 'Personal' AND user_id = ".$this->Session->read('Auth.User.id').") ORDER BY SUBSTRING_INDEX(name, ' ', -1) ASC LIMIT 10")));
		$this->set('users', $this->User->find('all', array('order' => 'SUBSTRING_INDEX(first_name, " ", -1) ASC')));
	}
	
	function forgotpw() {
		if(isset($this->data['User']['username'])) {
			// we have username, check to see if its in database
			$user = $this->User->find('all', array('conditions' => 'username = "'.$this->data['User']['username'].'"'));
			if(count($user) != 0) {
					// email the user the new password.
					$new_password = rand(0, 100) * 999999;
					$new_password_encrypt = $new_password; //encrypt
					$this->User->id = $user[0]['User']['id'];
					$this->User->save(array("password" => $this->Auth->password($new_password_encrypt)));
					
					// send email to user, notifying of password update
					$this->Email->from = 'CMI Portal No-Reply <system_noreply@portal.comprehensive1.com>';
					$this->Email->to = ''.$user[0]['User']['first_name'].' <'.$user[0]['User']['username'].'>';
					$this->Email->subject = 'CMI Online Portal - Password Reset';
					$this->Email->send("Hello, ".$user[0]['User']['first_name']."\n\nYour password to the CMI Online Portal has been reset.  It is now '".$new_password."' (without quotes).\nIf this is a problem, please notify the administrator.");
					$this->Session->setFlash("Reset password has been emailed to the user's email.  Please check your email, and if there are problems notify the site administrator.");
					$this->redirect(array('action' => 'login', 'admin' => 0));
			} else {
				$this->Session->setFlash("Sorry, that username/email was not found.  Please try again, or contact the administrator if you are having problems.");
			}
		}
	}
	
	function admin_add() {
		$this->loadModel("Files");
		$files = $this->Files->find('all', array('conditions' => "system = 'System' OR (system = 'Personal' AND user_id = ".$this->Session->read('Auth.User.id').") ORDER BY timestamp DESC LIMIT 10"));
		$this->set('files', $files);
		$this->loadModel("Contacts");
		$this->set('contacts', $this->Contacts->find('all', array('conditions'=>"system = 'System' OR (system = 'Personal' AND user_id = ".$this->Session->read('Auth.User.id').") ORDER BY SUBSTRING_INDEX(name, ' ', -1) ASC LIMIT 10")));
		if (!empty($this->data)) {
			if(!isset($this->data['User']['first_name']) || !isset($this->data['User']['password_2']) || !isset($this->data['User']['username'])) {
				$this->Session->setFlash("Sorry, you did not enter all the necessary data.  Please go back and add the missing field.");
				$this->redirect(array('action' => 'add', 'admin' => 1));
			}
			
			if(isset($this->data['Other']['send_email']) && $this->data['Other']['send_email'] == "Yes") {
				
				// send welcome email
				$this->Email->from    = 'CMI Portal No-Reply <system_noreply@portal.comprehensive1.com>';
				$this->Email->to      = ''.$this->data['User']['first_name'].' <'.$this->data['User']['username'].'>';
				$this->Email->subject = 'Welcome to the CMI Online Portal';
				$this->Email->send("Hello, ".$this->data['User']['first_name']."\n\nYou may now log into CMI Portal at http://portal.comprehensive1.com/\nUsername: ".$this->data['User']['username']."\nPassword: ".$this->data['User']['password_2']."\n\nIf you have any issues, please contact the site administrator.");
			}
			
			$this->User->set(array("password" => $this->Auth->password($this->data['User']['password_2']), "first_name" => $this->data['User']['first_name'], "username" => $this->data['User']['username']));
			
			if ($this->User->save()) {
				$this->Session->setFlash('The user has been saved.');
				$this->redirect(array('action' => 'index'));
			}
		}
	}
	
	function admin_delete($id) {
		$this->User->delete($id);
		$this->Session->setFlash('The user with id: '.$id.' has been deleted.');
		$this->redirect(array('action'=>'index'));
	}
	
	function admin_edit($id = null) {
		$this->loadModel("Files");
		$files = $this->Files->find('all', array('conditions' => "system = 'System' OR (system = 'Personal' AND user_id = ".$this->Session->read('Auth.User.id').") ORDER BY timestamp DESC LIMIT 10"));
		$this->set('files', $files);
		$this->loadModel("Contacts");
		$this->set('contacts', $this->Contacts->find('all', array('conditions'=>"system = 'System' OR (system = 'Personal' AND user_id = ".$this->Session->read('Auth.User.id').") ORDER BY SUBSTRING_INDEX(name, ' ', -1) ASC LIMIT 10")));
		$this->User->id = $id;
		if (empty($this->data)) {
			$this->data = $this->User->read();
			$this->set('user', $this->User->read());
		} else {
			if(isset($this->data['User']['password']) && strlen($this->data['User']['password']) != 0) {
				$this->User->set(array("password" => $this->Auth->password($this->data['User']['password'])));
			}
			if ($this->User->save($this->data)) {
				$this->Session->setFlash('The user has been updated.');
				$this->redirect(array('action' => 'index'));
			}
		}
	}
	
	function request() {
	}
}
?>