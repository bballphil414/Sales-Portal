<?php
class ContactsController extends AppController {

	var $name = 'Contacts';
	var $helpers = array('Html','Ajax','Javascript');
	var $components = array('Auth', 'Email');
	
	function beforeFilter() {
		parent::beforeFilter();
		
		$this->loadModel("Files");
		$files = $this->Files->find('all', array('conditions' => "system = 'System' OR (system = 'Personal' AND user_id = ".$this->Session->read('Auth.User.id').") ORDER BY timestamp DESC LIMIT 10"));
		$this->set('files', $files);
	}
	
	function index($status = NULL, $id = NULL) {
		$this->loadModel('Contacts');
		$this->set('contacts', $this->Contacts->find('all', array('conditions'=>"system = 'System' OR (system = 'Personal' AND user_id = ".$this->Session->read('Auth.User.id').") ORDER BY SUBSTRING_INDEX(name, ' ', -1) ASC")));
		$this->set('name', 'Contacts');
		$this->set('status', $status);
		if($status == 1) {
			$contact = $this->Contacts->findById($id);
			if(sizeof($contact) != 0) {
				$this->set('data', $contact);
			} else {
				$this->setFlash("Could not find contact.  Please try again or submit a new contact.");
			}
		}
		if($status == 2) {
			// save contact
			$this->loadModel("Users");
			$user = $this->Users->findById($this->Session->read('Auth.User.id'));
			if($user['Users']['admin'] == "No") {
				$this->Contacts->set(array("system" => "Personal", "user_id" => $this->Session->read('Auth.User.id')));
			} else if($user['Users']['admin'] == "Yes") {
				$this->Contacts->set(array("system" => "System", "user_id" => $this->Session->read('Auth.User.id')));
			}
			
			$this->data['Contacts']['name'] = trim($this->data['Contacts']['name']);
			
			$this->Contacts->save($this->data);
			
			$user = $this->Users->findById($this->Session->read("Auth.User.id"));
			$this->loadModel("Logs");
			$this->Logs->set(array("user_id" => $user['Users']['id'], "timestamp" => time(), "event_description" => "Saved a contact."));
			$this->Logs->save();

			$this->Session->setFlash("Contact Saved.");
			$this->redirect(array('action' => 'index'));
		}
		
	}
	
	function delete($id) {
		$this->loadModel("Contacts");
		$this->loadModel("Users");
		$this->Contacts->delete($id);
		$user = $this->Users->findById($this->Session->read("Auth.User.id"));
		$this->loadModel("Logs");
		$this->Logs->set(array("user_id" => $user['Users']['id'], "timestamp" => time(), "event_description" => "Deleted a contact."));
		$this->Logs->save();

		$this->Session->setFlash('The contact with id: '.$id.' has been deleted.');
		$this->redirect(array('action'=>'index'));
	}
}
?>
