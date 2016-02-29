<?php
class SuggestionsController extends AppController {

	var $name = 'Suggestions';
	var $helpers = array('Html','Ajax','Javascript');
	
	function beforeFilter() {
		parent::beforeFilter();
	}

	function add() {
		// add suggestion
		echo "Thank you for your feedback.";
		exit();
	}

	function admin_index() {
		// show all suggestions
		$this->loadModel("Suggestions");
		$this->set('suggestions', $this->Suggestions->find('all'));
	}
}