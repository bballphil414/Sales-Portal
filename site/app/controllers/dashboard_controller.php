<?php
class DashboardController extends AppController {

	var $name = 'Dashboard';
	var $components = array('Auth');
	var $helpers = array('Html','Ajax','Javascript');
	
	function beforeFilter() {
		parent::beforeFilter();
		$this->loadModel("Files");
		$files = $this->Files->find('all', array('conditions' => "system = 'System' OR (system = 'Personal' AND user_id = ".$this->Session->read('Auth.User.id').") ORDER BY timestamp DESC LIMIT 10"));
		$this->set('files', $files);
		
		$this->loadModel("Contacts");
		$this->set('contacts', $this->Contacts->find('all', array('conditions'=>"system = 'System' OR (system = 'Personal' AND user_id = ".$this->Session->read('Auth.User.id').") ORDER BY SUBSTRING_INDEX(name, ' ', -1) ASC LIMIT 10")));
		
		
		$this->loadModel("Users");
		$user = $this->Users->findById($this->Session->read('Auth.User.id'));
	}
	
	function index($new = NULL) {
		if($this->Session->read("Auth.User.admin") == "Yes") { 
			$this->redirect(array("controller" => "dashboard", "admin" => 1));
		}
		if($new == 1) {
			$user = $this->User->findById($this->Session->read("Auth.User.id"));
			$this->loadModel("Logs");
			$this->Logs->set(array("user_id" => $user['User']['id'], "timestamp" => time(), "event_description" => "Logged in."));
			$this->Logs->save();
		}
		// Check to see if the user has admin access or not.
		
		
		// Necessary for displaying the Messages box
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
		
		
		
		// Necessary for displaying the Reports box
			$this->loadModel('Reports');
			$this->loadModel("ReportsRecipients");
			$reports = $this->ReportsRecipients->find('all', array('conditions' => 'user_id ='.$this->Session->read('Auth.User.id'), 'order' => 'timestamp DESC'));
			$this->loadModel('Stores');
			$i = 0;
			foreach($reports as $r) {
				$report_data = $this->Reports->findById($r['ReportsRecipients']['report_id']);
				$reports[$i]['Stores'] = $this->Stores->findById($report_data['Reports']['store_id']);
				$reports[$i]['Reports']['customer'] = $report_data['Reports']['customer'];
				$i++;
			}
		
			$this->set('reports',$reports);
	}
	
	function admin_index($new = NULL) {
		//print_r($this->Session->read("Auth.User.admin"));
		if($this->Session->read("Auth.User.admin") == "No") {
			$this->redirect(array("controller" => "dashboard", "action" => "index", "admin" => 0));
		}
		// Check to see if the user has admin access or not.
		if($new == 1) {
			$user = $this->User->findById($this->Session->read("Auth.User.id"));
			$this->loadModel("Logs");
			$this->Logs->set(array("user_id" => $user['User']['id'], "timestamp" => time(), "event_description" => "Logged in."));
			$this->Logs->save();
		}
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
		
		
		
		// Necessary for displaying the Reports box
		
			$this->loadModel("ReportsRecipients");
			$this->loadModel("Reports");
			$reports = $this->ReportsRecipients->find('all', array('order' => 'timestamp DESC', 'conditions' => "visibility = 'Show'"));
			$this->loadModel('Stores');
			$i = 0;
			foreach($reports as $r) {
				$report_data = $this->Reports->findById($r['ReportsRecipients']['report_id']);
				$reports[$i]['Stores'] = $this->Stores->findById($report_data['Reports']['store_id']);
				$reports[$i]['Users'] = $this->Users->findById($r['ReportsRecipients']['user_id']);
				$reports[$i]['Reports']['customer'] = $report_data['Reports']['customer'];
				$i++;
			}
		
			$this->set('reports',$reports);
			
		// for the User management system
		$this->set('users', $this->Users->find('all', array('order' => 'SUBSTRING_INDEX(first_name, " ", -1) ASC LIMIT 15')));
	}
}
?>
