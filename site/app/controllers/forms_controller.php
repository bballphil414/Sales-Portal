<?php
class FormsController extends AppController {

	var $name = 'Forms';
	var $helpers = array('Html','Ajax','Javascript');
	
	function beforeFilter() {
		parent::beforeFilter();
		
		$this->loadModel("Files");
		$files = $this->Files->find('all', array('conditions' => "system = 'System' OR (system = 'Personal' AND user_id = ".$this->Session->read('Auth.User.id').") ORDER BY timestamp DESC LIMIT 10"));
		$this->set('files', $files);
		$this->loadModel("Contacts");
		$this->set('contacts', $this->Contacts->find('all', array('conditions'=>"system = 'System' OR (system = 'Personal' AND user_id = ".$this->Session->read('Auth.User.id').") ORDER BY SUBSTRING_INDEX(name, ' ', -1) ASC LIMIT 10")));
	}
	
	function admin_index() {
		$this->loadModel("Forms");
		$this->loadModel("Fields");
		$this->loadModel("Vendors");
		
		$forms = $this->Forms->find('all');
		$i = 0;
		foreach($forms as $f) {
			if($f['Forms']['type'] == "Vendor") {
				$vendor = $this->Vendors->findById($f['Forms']['vendor_id']);
				$forms[$i]['Forms']['vendor'] = $vendor['Vendors']['company_name'];
			} else {
				$forms[$i]['Forms']['vendor'] = '';
			}
			
			$fields = $this->Fields->find('all', array('conditions' => 'form_id = '.$f['Forms']['id']));
			if(count($fields) == 0) {
				$forms[$i]['Forms']['field_count'] = 0;
			} else {
				$forms[$i]['Forms']['field_count'] = count($fields);
			}
			$i++;
		}
		$this->set('forms', $forms);
	}
	
	function admin_delete($id) {
		$this->loadModel("Forms");
		$this->Forms->delete($id);
		$this->Session->setFlash('The form with id: '.$id.' has been deleted.');
		$this->redirect(array('action'=>'index'));
	}
}