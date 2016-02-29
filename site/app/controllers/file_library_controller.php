<?

class FileLibraryController extends AppController {

	var $name = 'FileLibrary';
	var $helpers = array('Html','Ajax','Javascript');
	
	function index() {
		$this->loadModel("Files");
		$this->loadModel("Contacts");
		$this->set('contacts', $this->Contacts->find('all', array('conditions'=>"system = 'System' OR (system = 'Personal' AND user_id = ".$this->Session->read('Auth.User.id').") ORDER BY SUBSTRING_INDEX(name, ' ', -1) ASC LIMIT 10")));
		
		$this->set('isfiles', true);
		
		$this->loadModel("Directories");
		$dirs = $this->Directories->find('all', array('conditions' => "system = 'System' OR (system = 'Personal' AND user_id= ".$this->Session->read('Auth.User.id').") ORDER BY name"));
		$this->set('dirs', $dirs);
		$files = $this->Files->find('all', array('conditions' => "system = 'System' OR (system = 'Personal' AND user_id = ".$this->Session->read('Auth.User.id').") ORDER BY file"));
		$this->set('files', $files);
	}
	
	function new_folder() {
		// we have the PARENT FOLDER and the FOLDER
		$this->loadModel("Directories");
		$this->loadModel("Users");
		$user = $this->Users->findById($this->Session->read('Auth.User.id'));
		if($user['Users']['account'] == "Admin") {
			$this->Directories->set(array('system' => "System"));
		} else {
			$this->Directories->set(array('system','Personal'));
		}
		$this->Directories->set(array('user_id' => $this->Session->read('Auth.User.id')));
		
		if($this->Directories->save($this->data)) {
			echo "True";
			$user = $this->Users->findById($this->Session->read("Auth.User.id"));
			$this->loadModel("Logs");
			$this->Logs->set(array("user_id" => $user['Users']['id'], "timestamp" => time(), "event_description" => "Created a file folder."));
			$this->Logs->save();
		} else {
			echo "False";
		}
		exit();		
	}
	
	function upload() {
		$this->loadModel("Files");
		$this->loadModel("Users");
		$target_path = "/home/comprehe/public_html/portal/uploads/";
		$target_path = $target_path . basename($_FILES['file']['name']);
		
		if(move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
    		$this->Session->setFlash("The file ".  basename($_FILES['file']['name']). " has been uploaded");
		} else{
    		$this->Session->setFlash("There was an error uploading the file, please try again!");
			$this->redirect(array('action' => 'index'));
		}
		if($this->Session->read('Auth.User.admin') == "Yes") {
			$this->Files->set(array("system" => "System"));
		} else {
			$this->Files->set(array("system" => "Personal"));
		}
		
		$this->Files->set(array("file" => basename($_FILES['file']['name']), "user_id" => $this->Session->read("Auth.User.id"), "directory_id" => $this->data['Files']['dir'], "timestamp" => time()));
		$this->Files->save();
		$user = $this->Users->findById($this->Session->read("Auth.User.id"));
		$this->loadModel("Logs");
		$this->Logs->set(array("user_id" => $user['Users']['id'], "timestamp" => time(), "event_description" => "Uploaded a file."));
		$this->Logs->save();
		$this->redirect(array('action' => 'index'));
	}
	function delete($id) {
		$this->loadModel("Files");
		$this->loadModel("Users");
		$user = $this->Users->findById($this->Session->read("Auth.User.id"));
		$this->loadModel("Logs");
		$this->Logs->set(array("user_id" => $user['Users']['id'], "timestamp" => time(), "event_description" => "Deleted a file."));
		$this->Logs->save();
		$this->Files->delete($id);
		$this->Session->setFlash('The file with id: '.$id.' has been deleted.');
		$this->redirect(array('action'=>'index'));
	}
	function directory_delete($id) {
		$this->loadModel("Files");
		$this->loadModel("Directories");
		$this->loadModel("Users");
		$this->Directories->delete($id);
		$user = $this->Users->findById($this->Session->read("Auth.User.id"));
		$this->loadModel("Logs");
		$this->Logs->set(array("user_id" => $user['Users']['id'], "timestamp" => time(), "event_description" => "Deleted a file folder."));
		$this->Logs->save();
		$this->Files->deleteAll("directory_id = ".$id, false, false);
		$this->Session->setFlash('The directory and all its files have been deleted.');
		$this->redirect(array('action'=>'index'));
	}
	
}