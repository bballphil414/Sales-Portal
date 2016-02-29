<?php
class VendorsController extends AppController {

	var $name = 'Vendors';
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
			$this->loadModel("Vendors");
			$this->Vendors->set(array('company_name' => $this->data['Vendor']['company_name']));
			if($this->Vendors->save()) {
				$this->Session->setFlash("Your vendor has been added.");
				$this->redirect(array('action' => 'new_report', 'controller' => 'reports', 1));
			} else {
				$this->Session->setFlash("Sorry, there was an error adding the vendor.");
			}			
		}
	}
	
	function admin_index() {
		$this->loadModel("Vendors");
		$this->set('vendors', $this->Vendors->find('all'));
	}
	
	function admin_edit($id) {
		$this->loadModel("Vendors");
		$vendor = $this->Vendors->read(NULL, $id);
		if(isset($this->data)) {
			// save data
			$this->Vendors->set(array('company_name' => $this->data['Vendor']['company_name']));
			if($this->Vendors->save()) {
				$this->Session->setFlash("Your vendor has been updated.");
				$this->redirect(array('action' => 'new_report', 'controller' => 'reports', 1));
			} else {
				$this->Session->setFlash("Sorry, there was a problem updating your vendor.");
			}
		}
		if(count($vendor) != 0) {
			// we have vendor, edit
			$this->set('v', $vendor);
		} else {
			$this->Session->setFlash("Sorry, that vendor does not exist.");
			$this->redirect(array('action' => 'index'));
		}
	}
	
	function admin_delete($id) {
		$this->loadModel("Vendors");
		$this->Vendors->delete($id);
		$this->Session->setFlash("The vendor has been deleted.");
		$this->redirect(array('action' => 'index'));
	}
}