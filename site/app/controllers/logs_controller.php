<?php
class LogsController extends AppController {

	var $name = 'Logs';
	var $helpers = array('Html','Ajax','Javascript');
	
	function beforeFilter() {
		parent::beforeFilter();
		$this->loadModel("Files");
		$files = $this->Files->find('all', array('conditions' => "system = 'System' OR (system = 'Personal' AND user_id = ".$this->Session->read('Auth.User.id').") ORDER BY timestamp DESC LIMIT 10"));
		$this->set('files', $files);
		
		$this->loadModel("Contacts");
		$contacts = $this->Contacts->find('all', array('conditions'=>"system = 'System' OR (system = 'Personal' AND user_id = ".$this->Session->read('Auth.User.id').") ORDER BY id DESC LIMIT 10"));
		
		foreach($contacts as $key=>$value) {
			$string = $value['Contacts']['name'];
			$input = explode(' ', $string);
			$result = array_reverse($input);
			$output = implode($result,' ');
			$contacts[$key]['Contacts']['name'] = $output;
		}
		
		$contacts =  Set::sort($contacts, '{n}.Contacts.name', 'asc');
		
		foreach($contacts as $key=>$value) {
			$string = $value['Contacts']['name'];
			$input = explode(' ', $string);
			$result = array_reverse($input);
			$output = implode($result,' ');
			$contacts[$key]['Contacts']['name'] = $output;
		}
		
		$this->set('contacts', $contacts);
	}
	
	function admin_index() {
		$this->loadModel("Logs");
		$this->loadModel("Users");
		$logs = $this->Logs->find('all', array('order' => 'timestamp desc', 'limit' => 10));
		foreach($logs as $l=>$k) {
			$logs[$l] = array_merge($logs[$l]['Logs'], $this->Users->findById($k['Logs']['user_id']));
		}
		$this->set('logs', $logs);
	}
	
	function admin_search() {
		$string = $this->data['string'];
		
		$return = "";
		

		$this->loadModel("Logs");
		
		$results = $this->Logs->query("SELECT DISTINCT logs.id, logs.* FROM logs, users WHERE logs.event_description LIKE '".$this->data['string']."' OR (users.first_name LIKE '".$this->data['string']."' AND logs.user_id = users.id)");
		
		$i = 0;
		
		$this->loadModel("Users");
		
  		foreach($results as $l=>$k) {
			$k['logs'] = array_merge($k['logs'], $this->Users->findById($k['logs']['user_id']));
  			$return .= "<tr style='width: 150px'";
			if($i == 1) { 
				$return .= ' class="odd">';
			} else {
				$return .= '>';
			}
  			$return .= "<td>".date('m/d/y @ g:ia', $k['logs']['timestamp'])."</td>";
  			$return .= "<td>".$k['logs']['Users']['first_name']."</td>";
  			$return .= "<td>".$k['logs']['event_description']."</td>";
  			$return .= "</tr>";
 			if($i == 0) {
	  			$i = 1;
  			} else {
	  			$i = 0;
  			}
  		}
        
		echo $return;
		exit(0);
		break;
	}
}