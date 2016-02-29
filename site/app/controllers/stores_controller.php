<?php
class StoresController extends AppController {

	var $name = 'Stores';
	var $helpers = array('Html','Ajax','Javascript');
	
	function beforeFilter() {
		parent::beforeFilter();
		$this->loadModel("Files");
		$files = $this->Files->find('all', array('conditions' => "system = 'System' OR (system = 'Personal' AND user_id = ".$this->Session->read('Auth.User.id').") ORDER BY timestamp DESC LIMIT 10"));
		$this->set('files', $files);
		
		$this->loadModel("Contacts");
		$this->set('contacts', $this->Contacts->find('all', array('conditions'=>"system = 'System' OR (system = 'Personal' AND user_id = ".$this->Session->read('Auth.User.id').") ORDER BY SUBSTRING_INDEX(name, ' ', -1) ASC LIMIT 10")));
	}
	
	function admin_new() {
		if(isset($this->data)) {
			// save data
			$this->loadModel("Stores");
			$this->Stores->set(array('store_number' => $this->data['Store']['store_number'], 'city' => $this->data['Store']['city'], 'state' => $this->data['Store']['state'], 'name' => $this->data['Store']['name']));
			if($this->Stores->save()) {
				$this->Session->setFlash("Your store has been added.");
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash("Sorry, there was an error adding the store.");
			}		
		}
	}
	
	function admin_index() {
		$this->loadModel("Stores");
		$this->set('stores', $this->Stores->find('all'));
	}
	
	function admin_edit($id) {
		$this->loadModel("Stores");
		$store = $this->Stores->read(NULL, $id);
		if(isset($this->data)) {
			// save data
			$this->Stores->set(array('store_number' => $this->data['Store']['store_number'], 'city' => $this->data['Store']['city'], 'state' => $this->data['Store']['state'], 'name' => $this->data['Store']['name']));
			if($this->Stores->save()) {
				$this->Session->setFlash("Your store has been updated.");
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash("Sorry, there was an error updating the store.");
			}
		}
		if(count($store) != 0) {
			// we have store, edit
			$this->set('s', $store);
		} else {
			$this->Session->setFlash("Sorry, that store does not exist.");
			$this->redirect(array('action' => 'index'));
		}
	}
	
	function admin_delete($id) {
		$this->loadModel("Stores");
		$this->Stores->delete($id);
		$this->Session->setFlash("The store has been deleted.");
		$this->redirect(array('action' => 'index'));
	}
}