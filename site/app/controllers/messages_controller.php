<?php
class MessagesController extends AppController {

	var $name = 'Messages';
	var $helpers = array('Html','Ajax','Javascript');
	
	function beforeFilter() {
		parent::beforeFilter();
		$this->loadModel("Files");
		$files = $this->Files->find('all', array('conditions' => "system = 'System' OR (system = 'Personal' AND user_id = ".$this->Session->read('Auth.User.id').") ORDER BY timestamp DESC LIMIT 10"));
		$this->set('files', $files);
		$this->loadModel("Contacts");
		$this->set('contacts', $this->Contacts->find('all', array('conditions'=>"system = 'System' OR (system = 'Personal' AND user_id = ".$this->Session->read('Auth.User.id').") ORDER BY SUBSTRING_INDEX(name, ' ', -1) ASC LIMIT 10")));
	}
	
	function admin_new($reply = NULL, $message = NULL) {
		
		$this->loadModel('Users');
		// if this is a reply, then we're going to have to find who we are replying to.
		if($reply != NULL  && $message != NULL) {
			$r = array();
			$r = $this->Users->findById($reply);
			$r .= $this->Messages->findById($message);
		}
		
		$this->set('users', $this->Users->find('all'));
	}
	
	function neww($reply = NULL, $message = NULL) {
		$this->loadModel('Users');
		// if this is a reply, then we're going to have to find who we are replying to.
		if($reply != NULL  && $message != NULL) {
			$r = array();
			$r = $this->Users->findById($reply);
			$r .= $this->Messages->findById($message);
		}
		
		$this->set('users', $this->Users->find('all'));
	}
	
	function admin_index() {
		$this->loadModel("Messages");
		$this->loadModel("Users");
		
		
		// get "FROM" messages
		
		$from_messages = $this->Messages->find('all', array('conditions' => 'to_user_id = '.$this->Session->read('Auth.User.id').' AND visibility_to = "Show"'));
		$i = 0;
		foreach($from_messages as $f) {
			$from_messages[$i]['User'] = $this->Users->findById($f['Messages']['from_user_id']);
			$i++;
		}
		$this->set('from_messages', $from_messages);
		
		// get "TO" messages
		
		$to_messages = $this->Messages->find('all', array('conditions' => 'from_user_id = '.$this->Session->read('Auth.User.id').' AND visibility_from = "Show"'));
		$i = 0;
		foreach($to_messages as $f) {
			$to_messages[$i]['User'] = $this->Users->findById($f['Messages']['to_user_id']);
			$i++;
		}
		$this->set('to_messages', $to_messages);
	}
	
	function index() { 
		$this->loadModel("Messages");
		$this->loadModel("Users");
		
		
		// get "FROM" messages
		
		$from_messages = $this->Messages->find('all', array('conditions' => 'to_user_id = '.$this->Session->read('Auth.User.id').' AND visibility_to = "Show"'));
		$i = 0;
		foreach($from_messages as $f) {
			$from_messages[$i]['User'] = $this->Users->findById($f['Messages']['from_user_id']);
			$i++;
		}
		$this->set('from_messages', $from_messages);
		
		// get "TO" messages
		
		$to_messages = $this->Messages->find('all', array('conditions' => 'from_user_id = '.$this->Session->read('Auth.User.id').' AND visibility_from = "Show"'));
		$i = 0;
		foreach($to_messages as $f) {
			$to_messages[$i]['User'] = $this->Users->findById($f['Messages']['to_user_id']);
			$i++;
		}
		$this->set('to_messages', $to_messages);
	}
	
	function admin_send() {
		if (!empty($this->data)) {
			$this->loadModel("Users");
			$this->loadModel("Messages");
			
			$this->data['timestamp'] = time();
			$this->data['from_user_id'] = $this->Session->read('Auth.User.id');
			if($this->data['Users'][0] == "all") {
				$this->data['all_select'] = "Yes";
				$users = $this->Users->find('all', array('conditions' => 'id <> '.$this->Session->read('Auth.User.id')));
				foreach($users as $u) {
					$this->Messages->set(array('timestamp' => $this->data['timestamp'], 'from_user_id' => $this->Session->read('Auth.User.id'), 'to_user_id' => $u['Users']['id'], 'subject' => $this->data['subject'], 'message' => $this->data['message']));
					$this->Messages->save();
					$this->Messages->id = NULL;
				}
			} else {
				foreach($this->data['Users'] as $key=>$value) {
					$u = $this->Users->findById($value);
					$this->Messages->set(array('timestamp' => $this->data['timestamp'], 'from_user_id' => $this->Session->read('Auth.User.id'), 'to_user_id' => $u['Users']['id'], 'subject' => $this->data['subject'], 'message' => $this->data['message']));
					$this->Messages->save();
					$this->Messages->id = NULL;
				}
			}
			
			$user = $this->Users->findById($this->Session->read("Auth.User.id"));
			$this->loadModel("Logs");
			$this->Logs->set(array("user_id" => $user['Users']['id'], "timestamp" => time(), "event_description" => "Sent a message."));
			$this->Logs->save();
			
			$this->Session->setFlash('The message has been sent.');
			$this->redirect(array('action' => 'index', 'admin' => 1));
		} else {
			$this->Session->setFlash('There was an error sending your message.');
			$this->redirect(array('action' => 'new', 'admin' => 1));
		}			
	}
	
	function send() {
		if (!empty($this->data)) {
			$this->loadModel("Users");
			$this->loadModel("Messages");
			
			$this->data['timestamp'] = time();
			$this->data['from_user_id'] = $this->Session->read('Auth.User.id');
			foreach($this->data['Users'] as $key=>$value) {
				$u = $this->Users->findById($value);
				$this->Messages->set(array('timestamp' => $this->data['timestamp'], 'from_user_id' => $this->Session->read('Auth.User.id'), 'to_user_id' => $u['Users']['id'], 'subject' => $this->data['subject'], 'message' => $this->data['message']));
				$this->Messages->save();
				$this->Messages->id = NULL;
			}

			$user = $this->Users->findById($this->Session->read("Auth.User.id"));
			$this->loadModel("Logs");
			$this->Logs->set(array("user_id" => $user['Users']['id'], "timestamp" => time(), "event_description" => "Sent a message."));
			$this->Logs->save();
			
			$this->Session->setFlash('The message has been sent.');
			$this->redirect(array('action' => 'index'));
		} else {
			$this->Session->setFlash('There was an error sending your message.');
			$this->redirect(array('action' => 'neww'));
		}		
	}
	
	function admin_view($id) {
		$this->loadModel('Users');
		$this->loadModel('Messages');
		
		if(!isset($id)) {
			$this->Session->setFlash("Invalid Message ID.");
			$this->redirect(array('action' => 'index', 'admin' => 1));
		}
		
		$message = $this->Messages->findById($id);
		if($message['Messages']['to_user_id'] == $this->Session->read('Auth.User.id')) {
			$id = $message['Messages']['from_user_id'];
		} else {
			$id = $message['Messages']['to_user_id'];
		}
		
		$message['User'] = $this->Users->findById($id);
		$this->set('message', $message);
	}
	
	function view($id) { 
		$this->loadModel('Users');
		$this->loadModel('Messages');
		
		if(!isset($id)) {
			$this->Session->setFlash("Invalid Message ID.");
			$this->redirect(array('action' => 'admin_index'));
		}
		
		$message = $this->Messages->findById($id);
		if($message['Messages']['to_user_id'] == $this->Session->read('Auth.User.id')) {
			$id = $message['Messages']['from_user_id'];
		} else {
			$id = $message['Messages']['to_user_id'];
		}
		
		$message['User'] = $this->Users->findById($id);
		$this->set('message', $message);
	}
	
	function admin_delete($id) {
		$this->loadModel("Messages");
		$this->loadModel("Users");
		$this->Messages->read(NULL, $id);
		$m = $this->Messages->findById($id);
		if($m['Messages']['to_user_id'] == $this->Session->read('Auth.User.id')) {
			$this->Messages->set(array('visibility_to' => 'Hide'));
		}
		if($m['Messages']['from_user_id'] == $this->Session->read('Auth.User.id')) {
			$this->Messages->set(array('visibility_from' => 'Hide'));
		}
		$this->Messages->save();

		$user = $this->Users->findById($this->Session->read("Auth.User.id"));
		$this->loadModel("Logs");
		$this->Logs->set(array("user_id" => $user['Users']['id'], "timestamp" => time(), "event_description" => "Deleted a message."));
		$this->Logs->save();

		$this->Session->setFlash('Message removed.');
		$this->redirect(array('action'=>'index', 'admin' => 1));
	}
	
	function delete($id) {
		$this->loadModel("Messages");
		$this->loadModel("Users");
		$this->Messages->read(NULL, $id);
		$m = $this->Messages->findById($id);
		if($m['Messages']['to_user_id'] == $this->Session->read('Auth.User.id')) {
			$this->Messages->set(array('visibility_to' => 'Hide'));
		}
		if($m['Messages']['from_user_id'] == $this->Session->read('Auth.User.id')) {
			$this->Messages->set(array('visibility_from' => 'Hide'));
		}
		$this->Messages->save();
		$user = $this->Users->findById($this->Session->read("Auth.User.id"));
		$this->loadModel("Logs");
		$this->Logs->set(array("user_id" => $user['Users']['id'], "timestamp" => time(), "event_description" => "Deleted a message."));
		$this->Logs->save();
		$this->Session->setFlash('Message removed.');
		$this->redirect(array('action'=>'index', 'admin' => 0));
	}
}
?>
