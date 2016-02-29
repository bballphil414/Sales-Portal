<?php
class StoresVendorsController extends AppController {

	var $name = 'StoresVendors';
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
		$this->loadModel("Stores");
		$this->loadModel("Vendors");
		
		if(isset($this->data)) {
			// save store vendor pair
			$this->loadModel("StoresVendors");
			$this->StoresVendors->set(array('store_id' => $this->data['Store']['id'], 'vendor_id' => $this->data['Vendor']['id']));
			$this->StoresVendors->save();
			$this->Session->setFlash("Your Store Vendor Pair has been created.");
			$this->redirect(array('action' => 'index'));
		}
		
		$this->set('stores', $this->Stores->find('all'));
		$this->set('vendors', $this->Vendors->find('all'));
	}
	
	function admin_delete($id) {
		$this->loadModel("StoresVendors");
		$this->StoresVendors->delete($id);
		$this->Session->setFlash("Your Store Vendor Pair has been deleted.");
		$this->redirect(array('action' => 'index'));
	}
	
	function admin_index() {
		$this->loadModel("StoresVendors");
		$this->loadModel("Stores");
		$this->loadModel("Vendors");
		$storesvendors = $this->StoresVendors->find('all');
		$i = 0;
		foreach($storesvendors as $sv) {
			$storesvendors[$i]['StoresVendors']['Stores'] = $this->Stores->findById($sv['StoresVendors']['store_id']);
			$storesvendors[$i]['StoresVendors']['Vendors'] = $this->Vendors->findById($sv['StoresVendors']['vendor_id']);
			$i++;
		}
		$this->set('storesvendors', $storesvendors);
	}
}