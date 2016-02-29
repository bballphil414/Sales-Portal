<?php

class ReportsController extends AppController {



	var $name = 'Reports';

	var $helpers = array('Html','Ajax','Javascript');

	

	function beforeFilter() {

		parent::beforeFilter();

		

		$this->loadModel("Files");

		$files = $this->Files->find('all', array('conditions' => "system = 'System' OR (system = 'Personal' AND user_id = ".$this->Session->read('Auth.User.id').") ORDER BY timestamp DESC LIMIT 10"));

		$this->set('files', $files);

		$this->loadModel("Contacts");
		$this->set('contacts', $this->Contacts->find('all', array('conditions'=>"system = 'System' OR (system = 'Personal' AND user_id = ".$this->Session->read('Auth.User.id').") ORDER BY SUBSTRING_INDEX(name, ' ', -1) ASC LIMIT 10")));
		/* $contacts = $this->Contacts->find('all', array('conditions'=>"system = 'System' OR (system = 'Personal' AND user_id = ".$this->Session->read('Auth.User.id').") ORDER BY id DESC LIMIT 10"));
		
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
		*/

	}

	function index() {

		$this->loadModel('Reports');

		

		// sent reports

			$this->loadModel("ReportsRecipients");

			$reports = $this->ReportsRecipients->find('all', array('conditions' => 'user_id = '.$this->Session->read('Auth.User.id'), 'order' => 'last_updated_timestamp ASC'));

			$i = 0;

			foreach($reports as $r) {

				$report_data = $this->Reports->findById($r['ReportsRecipients']['report_id']);

				$reports[$i]['Reports']['customer'] = $report_data['Reports']['customer'];

				$i++;

			}

		

			$this->set('reports',$reports);
	}

	

	function admin_index() {

		$this->loadModel('Reports');

		$this->loadModel("Users");

		// sent reports

			$this->loadModel("ReportsRecipients");

			$reports = $this->ReportsRecipients->find('all', array('order' => 'timestamp DESC', 'conditions' => "visibility = 'Show'"));

			$i = 0;

			foreach($reports as $r) {

				$report_data = $this->Reports->findById($r['ReportsRecipients']['report_id']);

				$reports[$i]['Reports']['customer'] = $report_data['Reports']['customer'];

				$reports[$i]['Users'] = $this->Users->findById($r['ReportsRecipients']['user_id']);

				$i++;

			}

		

			$this->set('reports',$reports);

		

		// draft reports

		$r2 = $this->Reports->find('all', array('conditions' => "visibility = 'Show'"));

		$i = 0;

			foreach($r2 as $r) {

				$r2[$i]['Reports']['customer'] = $r['Reports']['customer'];

				$i++;

			}

		$this->set('r2', $r2);

	}

	

	function admin_new_report($step = 0, $referrer = NULL, $formID = NULL) {

		// make a new report.

		$this->set('step', $step);

		$this->set('referrer', $referrer);

		switch($step) {

			case 0:

				// see if creating new form or just want to send report to another person.

				break;

			case 1: 

				// check to see if we are sending report to another person

				if($this->data['Report']['type'] == "send") {

					$this->redirect(array('controller' => 'reports', 'admin'=>1, 'action' => 'new_report', 3, "true"));

					return;

				} else if($this->data['Report']['type'] == "vendor") {

					$this->redirect(array('controller' => 'vendors', 'admin'=>1, 'action' => 'index'));

					return;

				//} else if($this->data['Report']['type'] == "store") {

				//	$this->redirect(array('controller' => 'stores', 'admin' => 1, 'action' => 'index'));

				//	return;

				} else if($this->data['Report']['type'] == "form") {

					$this->redirect(array('controller' => 'forms', 'admin' => 1, 'action' => 'index'));

					return;

				} else if($this->data['Report']['type'] == "new") {

					$this->redirect(array('controller' => 'reports', 'admin' => 1, 'action' => 'new_report', 4, "true"));

					return;

				//} else if($this->data['Report']['type'] == "storevendor") {

				//	$this->redirect(array('controller' => 'storesvendors', 'admin' => 1, 'action' => 'index'));

				//	return;

				}

				

				// if using form, get this data for the user

				$this->loadModel('Forms');

				$this->set('forms', $this->Forms->find('all'));

				

				// set up vendors in so we know if this form will be a Vendor or General form.

				$this->loadModel("Vendors");

				$this->set('vendors', $this->Vendors->find('all'));

				

				break;

			case 2:

				// #1 - create new form using the NAME

				$this->loadModel('Forms');

				// check to see if the form has already been created / name is taken

				if(isset($formID)) {

					// load the form instead of saving a new one

					$form = $this->Forms->findById($formID);

					if($form['Forms']['type'] == "Vendor") {

						$this->loadModel("Vendors");

						$this->set('vendor', $this->Vendors->findById($form['Forms']['vendor_id']));

					}

				} else {

					if(count($this->Forms->find('all',array('conditions'=>'name = "'.$this->data['Report']['name'].'"'))) != 0) {

						$this->Session->setFlash('That form name has already been taken.  Please choose another, or if you wish to edit that specific form please go to the <a href="/site/admin/forms/">Forms</a> section and select that form to edit.');

						$this->redirect(array('controller' => 'reports', 'admin'=>1, 'action' => 'new_report', 1));

					}

					if(!isset($this->data['Report']['vendor_id']) || strlen($this->data['Report']['vendor_id']) == 0) {

						$this->Forms->set(array('type' => 'General'));

					} else {

						$this->Forms->set(array('type' => 'Vendor', 'vendor_id' => $this->data['Report']['vendor_id']));

						$this->loadModel("Vendors");

						$this->set('vendor', $this->Vendors->findById($this->data['Report']['vendor_id']));

					}

					$this->Forms->set(array('name' => $this->data['Report']['name']));

					$this->Forms->save();

					$this->Forms->find('all',array('conditions'=>'name = "'.$this->data['Report']['name'].'"'));

					$form = $this->Forms->read();

					$formID = $form['Forms']['id'];

				}

				

				$this->set('form',$form);

				$this->loadModel('Fields');

				$this->loadModel('FieldCheckboxLabels');

				$this->loadModel('FieldDropdownLabels');

				$this->loadModel('FieldDropdownOptions');

				$this->loadModel('FieldTextQuestions');

				

				// #2 - are we loading a saved form ?

				// also load fields and insert them into the admin view

				$return = "";

				$reader = array();

				$reader['General'] = array();

				$reader['Vendor'] = array();

				

				if(isset($this->data['Report']['form_id']) && strlen($this->data['Report']['form_id']) > 0) {

					// #3 - if yes, then load the saved form and insert all fields into DB for this form

					

					$fields = $this->Fields->find('all',array('conditions'=>'form_id = '.$this->data['Report']['form_id'].' ORDER BY position'));

					foreach($fields as $f) {

						$this->Fields->set(array('field_type'=>$f['Fields']['field_type'], 'rel_type'=>$f['Fields']['rel_type'], 'form_id'=>$form['Forms']['id']));

						$this->Fields->save();

						

						$cf = $this->Fields->read();

						

						// have to go and copy all the values from separate field types too

						if($f['Fields']['field_type'] == "Checkbox") {

							$tf = $this->FieldCheckboxLabels->find('all',array('conditions'=>'fields_id = '.$f['Fields']['id']));

							$this->FieldCheckboxLabels->set(array('fields_id'=>$cf['Fields']['id'], 'text'=>$tf[0]['FieldCheckboxLabels']['text']));

							$this->FieldCheckboxLabels->save();							

						} else if($f['Fields']['field_type'] == "Dropdown") {

							$label = $this->FieldDropdownLabels->find('all',array('conditions'=>'fields_id = '.$f['Fields']['id']));

							$this->FieldDropdownLabels->set(array('fields_id'=>$cf['Fields']['id'],'text'=>$label[0]['FieldDropdownLabels']['text']));

							$this->FieldDropdownLabels->save();

							

							$options = $this->FieldDropdownOptions->find('all',array('conditions'=>'fields_id = '.$f['Fields']['id']));

							foreach($options as $o) {

								$this->FieldDropdownOptions->set(array('fields_id'=>$cf['Fields']['id'],'text'=>$o['FieldDropdownOptions']['text']));

								$this->FieldDropdownOptions->save();

							}

						} else if($f['Fields']['field_type'] == "Text") {

							$tf = $this->FieldTextQuestions->find('all',array('conditions'=>'fields_id = '.$f['Fields']['id']));

							$this->FieldTextQuestions->set(array('fields_id'=>$cf['Fields']['id'],'text'=>$tf[0]['FieldTextQuestions']['text']));

							$this->FieldTextQuestions->save();							

						}

					}

				}

				

				// Add fields into reader

				

				$fields = $this->Fields->find('all',array('conditions' => 'form_id = '.$formID));

				foreach($fields as $f) {

					if($f['Fields']['field_type'] == "Checkbox") {

						$tf = $this->FieldCheckboxLabels->find('all',array('conditions'=>'fields_id = '.$f['Fields']['id']));

						if($f['Fields']['rel_type'] == "General") {

							$reader['General'][sizeof($reader['General'])] = array('Checkbox', $tf[0]['FieldCheckboxLabels']['text'], $f['Fields']['id']);

						} else if($f['Fields']['rel_type'] == "Vendor") {

							$reader['Vendor'][sizeof($reader['Vendor'])] = array('Checkbox',$tf[0]['FieldCheckboxLabels']['text'], $f['Fields']['id']);

						}

					} else if($f['Fields']['field_type'] == "Dropdown") {

						$label = $this->FieldDropdownLabels->find('all',array('conditions'=>'fields_id = '.$f['Fields']['id']));

						$options = $this->FieldDropdownOptions->find('all',array('conditions'=>'fields_id = '.$f['Fields']['id']));

						if($f['Fields']['rel_type'] == "General") {

							$reader['General'][sizeof($reader['General'])] = array('Dropdown', $label[0]['FieldDropdownLabels']['text'], $options, $f['Fields']['id']);

						} else if($f['Fields']['rel_type'] == "Vendor") {

							$reader['Vendor'][sizeof($reader['Vendor'])] = array('Dropdown', $label[0]['FieldDropdownLabels']['text'], $options, $f['Fields']['id']);

						}

					} else if($f['Fields']['field_type'] == "Text") {

						$tf = $this->FieldTextQuestions->find('all',array('conditions'=>'fields_id = '.$f['Fields']['id']));

						if($f['Fields']['rel_type'] == "General") {

							$reader['General'][sizeof($reader['General'])] = array('Text', $tf[0]['FieldTextQuestions']['text'], $f['Fields']['id']);

						} else if($f['Fields']['rel_type'] == "Vendor") {

							$reader['Vendor'][sizeof($reader['Vendor'])] = array('Text',$tf[0]['FieldTextQuestions']['text'], $f['Fields']['id']);

						}	

					}

				}

				// Process the array for the current fields

				$returnText = array();

				foreach($reader as $r=>$value) {

					$returnText[$r] = "";

					foreach($reader[$r] as $i) {

						if($i[0] == "Checkbox") {

							$returnText[$r] .= '<tr><td><input type="checkbox" class="form_checkbox3" /><div class="label">'.$i[1].'</div><a href=javascript: void(0)" onclick="delField('.$i[2].', this)" title="delete"><img src="/site/img/bt_del.gif" /></a></td></tr>';

						} else if($i[0] == "Text") {

							$returnText[$r] .= '<tr><td><div class="label">'.$i[1].'</div><textarea cols="50" rows="6" class="floatleft"></textarea><a href=javascript: void(0)" onclick="delField('.$i[2].', this)" title="delete"><img src="/site/img/bt_del.gif" /></a></td></tr>';

						} else if($i[0] == "Dropdown") {

							$returnText[$r] .= '<tr><td><div class="label">'.$i[1].'</div><select>';

							foreach($i[2] as $o) {

								$returnText[$r] .= '<option>'.$o['FieldDropdownOptions']['text'].'</option>';

							}

							$returnText[$r] .= '</select><a href=javascript: void(0)" onclick="delField('.$i[3].', this)" title="delete"><img src="/site/img/bt_del.gif" /></a></td></tr>';

						}

					}

				}

				if(count($returnText) == 0) {

					$returnText = "";

				}

				$this->set('reader', $returnText);

				

				// get all fields for this new form and show them, allow user to create new fields

				$this->set('fields',$this->Fields->find('all',array('conditions'=>'form_id = '.$form['Forms']['id']) ) );

				$this->set('Form_ID', $form['Forms']['id']);

				break;

				

			/*case 3:

				$this->loadModel('Stores');

				

				if($referrer == 'false') {

					// edit: just go back to reports index... we have added the form.

					$this->Session->setFlash("Your form has been saved.  You may now use it in reports.  To view all forms, go to: <a href='/site/admin/forms/'>Forms</a>");

					$this->redirect(array('action' => 'index'));

				} else {

				// get all possible users and allow admin to send the form (create new report that hasn't been filled out yet)			

					$this->set('stores',$this->Stores->find('all',array()));

				}

				

				break;

			*/

			case 4: 

				// we have the store, now we just need the vendors

				//$this->loadModel("StoresVendors");

				//$vendors = $this->StoresVendors->find('all', array('conditions' => 'store_id = '.$this->data['Report']['store_id']));

				$this->loadModel('Vendors');

				$this->loadModel('Forms');

				$vendors = $this->Vendors->find('all');

				$i = 0;

				foreach($vendors as $v) {

					//$vendors[$i]['Vendors'] = $this->Vendors->findById($v['StoresVendors']['vendor_id']);

					$form = $this->Forms->find('all', array('conditions' => 'vendor_id = '.$v['Vendors']['id']));

					if(count($form) != 0) {

						$vendors[$i]['Forms'] = $form[0]['Forms'];

						$i++;

					}

				}

				$this->set('vendors', $vendors);

				$this->set('forms', $this->Forms->find('all'));

				//$this->set('store_id', $this->data['Report']['store_id']);

				

				break;

			case 5:

				// save form field

				$this->loadModel('Fields');

				$this->Fields->set(array('form_id' => $this->data['Report']['form_id'], 'rel_type' => $this->data['Report']['section'], 'field_type' => $this->data['Report']['type']));

				$this->Fields->save();

				

				$id = $this->Fields->read();

				$return = "";

				if($this->data['Report']['type'] == "Checkbox") {

					$this->loadModel('FieldCheckboxLabels');

					$this->FieldCheckboxLabels->set(array('fields_id'=>$id['Fields']['id'], 'text'=>$this->data['Report']['text']));

					$this->FieldCheckboxLabels->save();

					

					

					// set new field string

					$return = '<tr><td><input type="checkbox" class="form_checkbox3" /><div class="label">'.$this->data['Report']['text'].'</div><a href=javascript: void(0)" onclick="delField('.$id['Fields']['id'].', this)" title="delete"><img src="/site/img/bt_del.gif" /></a></td></tr>';

					

				} else if($this->data['Report']['type'] == "Text") {

					$this->loadModel('FieldTextQuestions');

					$this->FieldTextQuestions->set(array('fields_id'=>$id['Fields']['id'], 'text'=>$this->data['Report']['text']));

					$this->FieldTextQuestions->save();

					

					

					// set new field string

					$return = '<tr><td><div class="label">'.$this->data['Report']['text'].'</div><textarea cols="50" rows="6" class="floatleft"></textarea><a href=javascript: void(0)" onclick="delField('.$id['Fields']['id'].', this)" title="delete"><img src="/site/img/bt_del.gif" /></a></td></tr>';

					

				} else if($this->data['Report']['type'] == "Dropdown") {

					$this->loadModel('FieldDropdownLabels');

					$this->loadModel('FieldDropdownOptions');

					$this->FieldDropdownLabels->set(array('fields_id' => $id['Fields']['id'], 'text' => $this->data['Report']['text']));

					$this->FieldDropdownLabels->save();

					$return = '<tr><td><div class="label">'.$this->data['Report']['text'].'</div>';

					

					$options = "";

					foreach($this->data['Report']['options'] as $o) {

						$this->FieldDropdownOptions->id = NULL;

						$this->FieldDropdownOptions->set(array('fields_id' => $id['Fields']['id'], 'text' => $o));

						$this->FieldDropdownOptions->save();

						//$options .= "<a href=\"javascript: changeSelectVal('select_".$id['Fields']['id']."','NULL','".$o."')\" class=\"option\">".$o."</a>";

						$options .= "<option>".$o."</option>";

					}

					

					$return .= "<select>";

					$return .= $options;

					$return .= '</select><a href="javascript: void(0)" onclick="delField('.$id['Fields']['id'].', this)" title="delete"><img src="/site/img/bt_del.gif" /></a><input id="select_'.$id['Fields']['id'].'" value="" type="hidden" name="" /></div>';

				}

				

				if(strlen($return) == 0) {

					$return = "error";

				}

				

				echo $return;

				exit();

				break;

			case 7:

				// delete form field

				$this->loadModel("Fields");

				$this->Fields->delete($this->data['field_id']);

				exit();

				break;

			case 6:

				// save report

				// we need to make the report

				$this->loadModel("Reports");

				//$this->Reports->set(array('name' => $this->data['Report']['name'], 'from_user_id' => $this->Session->read('Auth.User.id'), 'store_id' => $this->data['Report']['store_id']));

				$this->Reports->set(array('name' => $this->data['Report']['name'], 'from_user_id' => $this->Session->read('Auth.User.id'), 'customer' => $this->data['Report']['customer']));

				$this->Reports->save();

				$r = $this->Reports->read();

				

				$this->loadModel("ReportsForms");

				foreach($this->data['Forms'] as $key=>$value) {

					$this->ReportsForms->id = NULL;

					$this->ReportsForms->set(array('form_id' => $value, 'report_id' => $r['Reports']['id']));

					$this->ReportsForms->save();

				}

				

				$this->Session->setFlash("The Report has been created and will now be listed under Report Drafts.");

				$this->redirect(array('action' => 'send_report', $r['Reports']['id']));				

		}

	}

	

	function admin_send_report($id = NULL) {

		if(!isset($this->data)) {

			$this->loadModel("Reports");

		

			$report = $this->Reports->findById($id);

			$this->set('report', $report);

		

			// Reports Forms connection

			$this->loadModel("Forms");

			$this->loadModel("Vendors");

			$this->loadModel("Fields");

			$this->loadModel("ReportsForms");

			$this->loadModel("FieldCheckboxLabels");

			$this->loadModel("FieldTextQuestions");

			$this->loadModel("FieldDropdownLabels");

			$this->loadModel("FieldDropdownOptions");

		

			$rf = $this->ReportsForms->find('all',array('conditions' => 'report_id ='.$report['Reports']['id']));

			// for each customer we find the reportsforms connection

			$i2 = 0;

			$totalText = array();

			

			foreach($rf as $r_f) {

				$reader = array();

				$reader['General'] = array();

				$reader['Vendor'] = array();

				

				$f = $this->Forms->findById($r_f['ReportsForms']['form_id']);

				if($f['Forms']['vendor_id'] != 0) {

					$vendor = $this->Vendors->findById($f['Forms']['vendor_id']);
				}

				// for each report form we find the form

				$formID = $f['Forms']['id'];

				if(is_numeric($formID)) {

				$fields = $this->Fields->find('all',array('conditions' => 'form_id = '.$formID));

				foreach($fields as $f) {

					

					if($f['Fields']['field_type'] == "Checkbox") {

						$tf = $this->FieldCheckboxLabels->find('all',array('conditions'=>'fields_id = '.$f['Fields']['id']));

						if($f['Fields']['rel_type'] == "General") {

							$reader['General'][sizeof($reader['General'])] = array('Checkbox', $tf[0]['FieldCheckboxLabels']['text'], $f['Fields']['id']);

						} else if($f['Fields']['rel_type'] == "Vendor") {

							$reader['Vendor'][sizeof($reader['Vendor'])] = array('Checkbox',$tf[0]['FieldCheckboxLabels']['text'], $f['Fields']['id']);

						}

					} else if($f['Fields']['field_type'] == "Dropdown") {

						$label = $this->FieldDropdownLabels->find('all',array('conditions'=>'fields_id = '.$f['Fields']['id']));

						$options = $this->FieldDropdownOptions->find('all',array('conditions'=>'fields_id = '.$f['Fields']['id']));

						if($f['Fields']['rel_type'] == "General") {

							$reader['General'][sizeof($reader['General'])] = array('Dropdown', $label[0]['FieldDropdownLabels']['text'], $options, $f['Fields']['id']);

						} else if($f['Fields']['rel_type'] == "Vendor") {

							$reader['Vendor'][sizeof($reader['Vendor'])] = array('Dropdown', $label[0]['FieldDropdownLabels']['text'], $options, $f['Fields']['id']);

						}

					} else if($f['Fields']['field_type'] == "Text") {

					$tf = $this->FieldTextQuestions->find('all',array('conditions'=>'fields_id = '.$f['Fields']['id']));

					if($f['Fields']['rel_type'] == "General") {

							$reader['General'][sizeof($reader['General'])] = array('Text', $tf[0]['FieldTextQuestions']['text'], $f['Fields']['id']);

						} else if($f['Fields']['rel_type'] == "Vendor") {

							$reader['Vendor'][sizeof($reader['Vendor'])] = array('Text',$tf[0]['FieldTextQuestions']['text'], $f['Fields']['id']);

						}	

					}	

				}

				// Process the array for the current fields

				$returnText = array();

				foreach($reader as $r=>$val) {

					$returnText[$r] = "";

					foreach($reader[$r] as $n) {

						if($n[0] == "Checkbox") {

							$returnText[$r] .= '<tr><td><input type="checkbox" class="form_checkbox3" /><div class="label">'.$n[1].'</div></a></td></tr>';

						} else if($n[0] == "Text") {

							$returnText[$r] .= '<tr><td><div class="label">'.$n[1].'</div><textarea cols="50" rows="6" class="floatleft"></textarea></td></tr>';

						} else if($n[0] == "Dropdown") {

							$returnText[$r] .= '<tr><td><div class="label">'.$n[1].'</div><select>';

							foreach($n[2] as $o) {

								$returnText[$r] .= '<option value="'.$o['FieldDropdownOptions']['text'].'">'.$o['FieldDropdownOptions']['text'].'</option>';

							}

							$returnText[$r] .= '</select></a></td></tr>';

						}

					}

				}

				if(count($returnText) == 0) {

					$returnText = "";

				}

				$totalText[$i2]['text'] = $returnText;
				if(isset($vendor)) {
				$totalText[$i2] = array_merge($totalText[$i2], $f, $vendor);
				} else {
				$totalText[$i2] = array_merge($totalText[$i2], $f);
				}

				// we have the text for the form info + vendor info

				$i2++;

				}

			}

		

			$this->set('reader', $totalText);

		}

		

		

		if(isset($this->data)) {

			$this->loadModel("ReportsRecipients");

			// send report

			foreach($this->data['Report']['User'] as $key=>$value) {

				$this->ReportsRecipients->id = NULL;

				$this->ReportsRecipients->set(array('user_id' => $value, 'report_id' => $this->data['Report']['id'], 'timestamp' => time()));

				$this->ReportsRecipients->save();

			}

			$this->Session->setFlash("The report has been sent to the selected users.");

			$this->redirect(array('action' => 'index'));

		} else {

			$this->loadModel("Reports");

			$this->loadModel("Users");

			$this->set('users', $this->Users->find('all'));

			if(isset($id)) {

				$this->set('report', $this->Reports->findById($id));

			} else {

				$this->set('reports', $this->Reports->find('all', array('conditions' => "visibility = 'Show'")));

			}

		}

	}

	

	function admin_delete_rr($id) {

		$this->loadModel("ReportsRecipients");

		$report = $this->ReportsRecipients->findById($id);


		$this->ReportsRecipients->delete($id);

		$this->Session->setFlash('The sent report with id: '.$id.' has been deleted.');

		$this->redirect(array('action'=>'index'));

	}

	

	function admin_delete($id) {

		$this->loadModel("Reports");

		$this->Reports->id = $id;

		$this->Reports->set(array('visibility' => 'Hide'));

		$this->Reports->save();

		$this->Session->setFlash('The draft report with the id: '.$id.' has been removed.');

		$this->redirect(array('action' => 'index'));

	}

	

	function admin_export($refer = 'false') {

		// If data is set, then export the file and send back to admin dashboard

		if(isset($this->data)) {

			// Export

			// We will need:

			/*

				EXPORT SEPARATED BY USER 

				THEN BY REPORT/STORE

				DATA INCLUDES: FORM(S) [ VENDOR ] -> Fields -> FieldsResponses

			*/

			

			$this->loadModel("Reports");

			$this->loadModel("Forms");

			$this->loadModel("ReportsRecipients");

			$this->loadModel("ReportsForms");

			$this->loadModel("ReportsStores");

			$this->loadModel("Stores");

			$this->loadModel("Fields");

			$this->loadModel("FieldCheckboxLabels");

			$this->loadModel("FieldTextQuestions");

			$this->loadModel("FieldDropdownLabels");

			$this->loadModel("FieldResponses");

			$this->loadModel("Vendors");

			$this->loadModel("Users");

			

			// Time constraints

			$start_date = strtotime($this->data['Export']['month_start']." ".$this->data['Export']['day_start'].", ".$this->data['Export']['year_start']);

			$end_date = strtotime($this->data['Export']['month_end']." ".$this->data['Export']['day_end'].", ".$this->data['Export']['year_end']);

			

			if($end_date == $start_date || $start_date > $end_date) {

				$this->Session->setFlash("Please set a valid date range for export.");

				$this->redirect(array('action' => 'export'));

			}

			$t = $this->ReportsRecipients->find('all', array('conditions' => 'timestamp >= '.$start_date.' AND timestamp <= '.$end_date));

			if(count($t) == 0) {

				$this->Session->setFlash("Sorry, there were no Reports for the specified date range.");

				$this->redirect(array('action' => 'export'));

			}

			// If store is set but not vendor, we load the report connected to the store.

			if(isset($this->data['Export']['customer_selected']) && isset($this->data['Export']['Customer'])) {

				$report = $this->Reports->find('all', array('conditions' => 'customer = "'.$this->data['Export']['Customer'].'"'));

				if(count($report) == 0) {

					$this->Session->setFlash("Sorry, there were no Reports for the specified customer.");

					$this->redirect(array('action' => 'export'));

				}

			} else if(isset($this->data['Export']['vendor_selected']) && isset($this->data['Export']['Vendor'])) {

				// If vendor is set in any case, we load vendor questions only and export those

				$form = $this->Forms->find('all', array('conditions' => "type = 'Vendor' AND vendor_id = ".$this->data['Export']['Vendor']));

				if(count($form) == 0) {

					$this->Session->setFlash("Sorry, there were no Reports for the specified vendor.");

					$this->redirect(array('action' => 'export'));

				}

			} 

			

			if(isset($this->data['Export']['user_selected']) && isset($this->data['Export']['User'])) {

				$rr = $this->ReportsRecipients->find('all', array('conditions' => 'user_id = '.$this->data['Export']['User'].' AND timestamp >= '.$start_date.' AND timestamp <= '.$end_date));

				if(count($rr) == 0) {

					$this->Session->setFlash("Sorry, there were no Reports for the specified user.");

					$this->redirect(array('action' => 'export'));

				}

			}

			

			// 1.  If $report (by Store) is set AND $form (by Vendor) is NOT set AND $rr (by User) is set, we narrow to reports that were submitted by the user for that specific Store.

			// 2.  If $report (by Store) is set AND $form (by Vendor) is NOT set AND $rr (by User) is NOT set, then we load all reports submitted for that specific Store.

			// 3.  If $form (by Vendor) is set AND $rr (by User) is set, we narrow to FORMS that were submitted by the user for that specific Vendor.

			// 4.  If $form (by Vendor) is set AND $rr (by User) is NOT set, then we load all reports submitted for that specific Vendor.

			// 5.  If $rr (by User) is set AND $form (by Vendor) is NOT set AND $report (by Store/Report) is NOT set, we narrow to that specific User.

			// 6.  Select all reports, forms, users with no constraints on which ones to select, only connect them up.

			

			if(isset($report) && isset($rr) && !isset($form)) {

				$u = $rr[0];

				$i = 0;

				foreach($report as $re) {

					$stores = $this->ReportsStores->find('all', array('conditions' => 'reportsrecipients_id = '.$u['ReportsRecipients']['id']));

					$i2 = 0;

					foreach($stores as $c) {

					$rf = $this->ReportsForms->find('all', array('conditions' => 'report_id = '.$u['ReportsRecipients']['report_id']));

					foreach($rf as $rz) {

							$ff = $this->Forms->findById($rz['ReportsForms']['form_id']);
							if(is_numeric($ff['Forms']['id'])) {
								
							$fields = $this->Fields->find('all', array('conditions' => 'form_id = '.$ff['Forms']['id']));

							// we have all fields, now we need all labels and responses 

							$i3 = 0;

							foreach($fields as $f) {

								$label = $this->FieldCheckboxLabels->find('all', array('conditions' => 'fields_id = '.$f['Fields']['id']));

								if(count($label) == 0) {

									$label = array_merge($label, $this->FieldTextQuestions->find('all', array('conditions' => 'fields_id = '.$f['Fields']['id'])));

								}

								if(count($label) == 0) {

									$label = array_merge($label, $this->FieldDropdownLabels->find('all', array('conditions' => 'fields_id = '.$f['Fields']['id'])));

								}

					

								$response = $this->FieldResponses->find('all', array('conditions' => 'fields_id = '.$f['Fields']['id'].' AND user_id = '.$u['ReportsRecipients']['user_id'].' AND store_number = "'.$c['ReportsStores']['store_number'] . '" AND reportsrecipients_id = '.$u['ReportsRecipients']['id']));

								if(count($response) == 0) {

									$response = array(0 => array("FieldResponses" => array("text" => "") ) );

								}

								// FORMS

								$r[$i] = $ff;

								// REPORT FORM CONNECTION

								$r[$i] = array_merge($r[$i], $rz);

								// REPORT STORE

								$r[$i] = array_merge($r[$i], $c);

								// REPORT USER 

								$r[$i] = array_merge($r[$i],$this->Users->findById($u['ReportsRecipients']['user_id']));

								// REPORT INFORMATION + CONNECTION TO USER

								$r[$i] = array_merge($r[$i], $u);

								// FIELD (FOR INFORMATION)

								$r[$i] = array_merge($r[$i], $f);

								// FIELD LABEL

								$r[$i] = array_merge($r[$i], $label);

								// FIELD RESPONSE

								$r[$i] = array_merge($r[$i], $response);

								$i++;

								

							}
							}

						}

					}

				}

			} else if(isset($report) && !isset($rr) && !isset($form)) {

				$i = 0;

				foreach($report as $re) {

				$rr = $this->ReportsRecipients->find('all', array('conditions' => 'report_id = '.$re['Reports']['id'].' AND timestamp >= '.$start_date.' AND timestamp <= '.$end_date));

				

				foreach($rr as $u) {

					$stores = $this->ReportsStores->find('all', array('conditions' => 'reportsrecipients_id = '.$u['ReportsRecipients']['id']));

					$i2 = 0;

					foreach($stores as $c) {

					$rf = $this->ReportsForms->find('all', array('conditions' => 'report_id = '.$u['ReportsRecipients']['report_id']));

					foreach($rf as $rz) {

							$ff = $this->Forms->findById($rz['ReportsForms']['form_id']);
							if(is_numeric($ff['Forms']['id'])) {
							$fields = $this->Fields->find('all', array('conditions' => 'form_id = '.$ff['Forms']['id']));

							// we have all fields, now we need all labels and responses 

							$i2 = 0;

							foreach($fields as $f) {

								$label = $this->FieldCheckboxLabels->find('all', array('conditions' => 'fields_id = '.$f['Fields']['id']));

								if(count($label) == 0) {

									$label = array_merge($label, $this->FieldTextQuestions->find('all', array('conditions' => 'fields_id = '.$f['Fields']['id'])));

								}

								if(count($label) == 0) {

									$label = array_merge($label, $this->FieldDropdownLabels->find('all', array('conditions' => 'fields_id = '.$f['Fields']['id'])));

								}

					

								$response = $this->FieldResponses->find('all', array('conditions' => 'fields_id = '.$f['Fields']['id'].' AND user_id = '.$u['ReportsRecipients']['user_id'].' AND store_number = "'.$c['ReportsStores']['store_number'] . '" AND reportsrecipients_id = '.$u['ReportsRecipients']['id']));

								if(count($response) == 0) {

									$response = array(0 => array("FieldResponses" => array("text" => "") ) );

								}

								// FORMS

								$r[$i] = $ff;

								// REPORT FORM CONNECTION

								$r[$i] = array_merge($r[$i], $rz);

								// REPORT STORE

								$r[$i] = array_merge($r[$i], $c);

								// REPORT USER 

								$r[$i] = array_merge($r[$i],$this->Users->findById($u['ReportsRecipients']['user_id']));

								// REPORT INFORMATION + CONNECTION TO USER

								$r[$i] = array_merge($r[$i], $u);

								// FIELD (FOR INFORMATION)

								$r[$i] = array_merge($r[$i], $f);

								// FIELD LABEL

								$r[$i] = array_merge($r[$i], $label);

								// FIELD RESPONSE

								$r[$i] = array_merge($r[$i], $response);

									

								$i++;

							}
							}

						}

					}

					}

				}
			
			} else if(isset($report) && !isset($rr) && isset($form)) {
				echo "";
				die();
				$i = 0;

				foreach($report as $re) {

				$rr = $this->ReportsRecipients->find('all', array('conditions' => 'report_id = '.$re['Reports']['id'].' AND timestamp >= '.$start_date.' AND timestamp <= '.$end_date));

				

				foreach($rr as $u) {

					$stores = $this->ReportsStores->find('all', array('conditions' => 'reportsrecipients_id = '.$u['ReportsRecipients']['id']));

					$i2 = 0;

					foreach($stores as $c) {
					foreach($form as $ff) {

							$rz =  $this->ReportsForms->find('all', array('conditions' => 'form_id = '.$ff['Forms']['id'].' AND report_id = '.$u['ReportsRecipients']['report_id']));
							if(count($rz) != 0) {

								$rz = $rz[0];
							} else {
								die();
							}
								

							$fields = $this->Fields->find('all', array('conditions' => 'form_id = '.$ff['Forms']['id']));
							$ff = $this->Forms->findById($rz['ReportsForms']['form_id']);
							if(is_numeric($ff['Forms']['id'])) {
							$fields = $this->Fields->find('all', array('conditions' => 'form_id = '.$ff['Forms']['id']));

							// we have all fields, now we need all labels and responses 

							$i2 = 0;

							foreach($fields as $f) {

								$label = $this->FieldCheckboxLabels->find('all', array('conditions' => 'fields_id = '.$f['Fields']['id']));

								if(count($label) == 0) {

									$label = array_merge($label, $this->FieldTextQuestions->find('all', array('conditions' => 'fields_id = '.$f['Fields']['id'])));

								}

								if(count($label) == 0) {

									$label = array_merge($label, $this->FieldDropdownLabels->find('all', array('conditions' => 'fields_id = '.$f['Fields']['id'])));

								}

					

								$response = $this->FieldResponses->find('all', array('conditions' => 'fields_id = '.$f['Fields']['id'].' AND user_id = '.$u['ReportsRecipients']['user_id'].' AND store_number = "'.$c['ReportsStores']['store_number'] . '" AND reportsrecipients_id = '.$u['ReportsRecipients']['id']));

								if(count($response) == 0) {

									$response = array(0 => array("FieldResponses" => array("text" => "") ) );

								}

								// FORMS

								$r[$i] = $ff;

								// REPORT FORM CONNECTION

								$r[$i] = array_merge($r[$i], $rz);

								// REPORT STORE

								$r[$i] = array_merge($r[$i], $c);

								// REPORT USER 

								$r[$i] = array_merge($r[$i],$this->Users->findById($u['ReportsRecipients']['user_id']));

								// REPORT INFORMATION + CONNECTION TO USER

								$r[$i] = array_merge($r[$i], $u);

								// FIELD (FOR INFORMATION)

								$r[$i] = array_merge($r[$i], $f);

								// FIELD LABEL

								$r[$i] = array_merge($r[$i], $label);

								// FIELD RESPONSE

								$r[$i] = array_merge($r[$i], $response);

									

								$i++;

							}
							}
					}
					}
						}

					}


				
			} else if(isset($form) && isset($rr)) {

				$i = 0;

				foreach($rr as $u) {

					$stores = $this->ReportsStores->find('all', array('conditions' => 'reportsrecipients_id = '.$u['ReportsRecipients']['id']));

					$i2 = 0;

					foreach($stores as $c) {

					foreach($form as $ff) {

						$rz =  $this->ReportsForms->find('all', array('conditions' => 'form_id = '.$ff['Forms']['id'].' AND report_id = '.$u['ReportsRecipients']['report_id']));

						if(count($rz) != 0) {

						$rz = $rz[0];

							$fields = $this->Fields->find('all', array('conditions' => 'form_id = '.$ff['Forms']['id']));

							// we have all fields, now we need all labels and responses 

							$i2 = 0;

							foreach($fields as $f) {

								$label = $this->FieldCheckboxLabels->find('all', array('conditions' => 'fields_id = '.$f['Fields']['id']));

								if(count($label) == 0) {

									$label = array_merge($label, $this->FieldTextQuestions->find('all', array('conditions' => 'fields_id = '.$f['Fields']['id'])));

								}

								if(count($label) == 0) {

									$label = array_merge($label, $this->FieldDropdownLabels->find('all', array('conditions' => 'fields_id = '.$f['Fields']['id'])));

								}

					

								$response = $this->FieldResponses->find('all', array('conditions' => 'fields_id = '.$f['Fields']['id'].' AND user_id = '.$u['ReportsRecipients']['user_id'].' AND store_number = "'.$c['ReportsStores']['store_number'] . '" AND reportsrecipients_id = '.$u['ReportsRecipients']['id']));

								if(count($response) == 0) {

									$response = array(0 => array("FieldResponses" => array("text" => "") ) );

								}

								// FORMS

								$r[$i] = $ff;

								// REPORT FORM CONNECTION

								$r[$i] = array_merge($r[$i], $rz);

								// REPORT STORE

								$r[$i] = array_merge($r[$i], $c);

								// REPORT USER 

								$r[$i] = array_merge($r[$i],$this->Users->findById($u['ReportsRecipients']['user_id']));

								// REPORT INFORMATION + CONNECTION TO USER

								$r[$i] = array_merge($r[$i], $u);

								// FIELD (FOR INFORMATION)

								$r[$i] = array_merge($r[$i], $f);

								// FIELD LABEL

								$r[$i] = array_merge($r[$i], $label);

								// FIELD RESPONSE

								$r[$i] = array_merge($r[$i], $response);

									

								$i++;

							}

						}

						}

					}

					}

				

			} else if(isset($form)) {

				$i = 0;

				$rr = $this->ReportsRecipients->find('all', array('conditions' => 'timestamp >= '.$start_date.' AND timestamp <= '.$end_date));

				if(count($rr) == 0) {

					$this->Session->setFlash("Sorry, there were no Reports in the specified date range.");

					$this->redirect(array('action' => 'export'));

				}

				foreach($rr as $u) {

					$stores = $this->ReportsStores->find('all', array('conditions' => 'reportsrecipients_id = '.$u['ReportsRecipients']['id']));

					$i2 = 0;

					foreach($stores as $c) {

					foreach($form as $ff) {

						$rz =  $this->ReportsForms->find('all', array('conditions' => 'form_id = '.$ff['Forms']['id'].' AND report_id = '.$u['ReportsRecipients']['report_id']));

						if(count($rz) != 0) {

						$rz = $rz[0];

							$fields = $this->Fields->find('all', array('conditions' => 'form_id = '.$ff['Forms']['id']));

							// we have all fields, now we need all labels and responses 

							$i2 = 0;

							foreach($fields as $f) {

								$label = $this->FieldCheckboxLabels->find('all', array('conditions' => 'fields_id = '.$f['Fields']['id']));

								if(count($label) == 0) {

									$label = array_merge($label, $this->FieldTextQuestions->find('all', array('conditions' => 'fields_id = '.$f['Fields']['id'])));

								}

								if(count($label) == 0) {

									$label = array_merge($label, $this->FieldDropdownLabels->find('all', array('conditions' => 'fields_id = '.$f['Fields']['id'])));

								}

					

								$response = $this->FieldResponses->find('all', array('conditions' => 'fields_id = '.$f['Fields']['id'].' AND user_id = '.$u['ReportsRecipients']['user_id'].' AND store_number = "'.$c['ReportsStores']['store_number'] . '" AND reportsrecipients_id = '.$u['ReportsRecipients']['id']));

								if(count($response) == 0) {

									$response = array(0 => array("FieldResponses" => array("text" => "") ) );

								}

								// FORMS

								$r[$i] = $ff;

								// REPORT FORM CONNECTION

								$r[$i] = array_merge($r[$i], $rz);

								// REPORT STORE

								$r[$i] = array_merge($r[$i], $c);

								// REPORT USER 

								$r[$i] = array_merge($r[$i],$this->Users->findById($u['ReportsRecipients']['user_id']));

								// REPORT INFORMATION + CONNECTION TO USER

								$r[$i] = array_merge($r[$i], $u);

								// FIELD (FOR INFORMATION)

								$r[$i] = array_merge($r[$i], $f);

								// FIELD LABEL

								$r[$i] = array_merge($r[$i], $label);

								// FIELD RESPONSE

								$r[$i] = array_merge($r[$i], $response);

									

								$i++;

							}

						}

					}

					}

					}

			} else if(isset($rr)) {

				$i = 0;

				$report = $this->Reports->find('all');

				foreach($rr as $u) {

					$stores = $this->ReportsStores->find('all', array('conditions' => 'reportsrecipients_id = '.$u['ReportsRecipients']['id']));

					$i2 = 0;

					foreach($stores as $c) {

					$rf = $this->ReportsForms->find('all', array('conditions' => 'report_id = '.$u['ReportsRecipients']['report_id']));

					foreach($rf as $rz) {

							$ff = $this->Forms->findById($rz['ReportsForms']['form_id']);
							if(is_numeric($ff['Forms']['id'])) {

							$fields = $this->Fields->find('all', array('conditions' => 'form_id = '.$ff['Forms']['id']));

							// we have all fields, now we need all labels and responses 

							$i2 = 0;

							foreach($fields as $f) {

								$label = $this->FieldCheckboxLabels->find('all', array('conditions' => 'fields_id = '.$f['Fields']['id']));

								if(count($label) == 0) {

									$label = array_merge($label, $this->FieldTextQuestions->find('all', array('conditions' => 'fields_id = '.$f['Fields']['id'])));

								}

								if(count($label) == 0) {

									$label = array_merge($label, $this->FieldDropdownLabels->find('all', array('conditions' => 'fields_id = '.$f['Fields']['id'])));

								}

					

								$response = $this->FieldResponses->find('all', array('conditions' => 'fields_id = '.$f['Fields']['id'].' AND user_id = '.$u['ReportsRecipients']['user_id'].' AND store_number = "'.$c['ReportsStores']['store_number'] . '" AND reportsrecipients_id = '.$u['ReportsRecipients']['id']));

								if(count($response) == 0) {

									$response = array(0 => array("FieldResponses" => array("text" => "") ) );

								}

								// FORMS

								$r[$i] = $ff;

								// REPORT FORM CONNECTION

								$r[$i] = array_merge($r[$i], $rz);

								// REPORT STORE

								$r[$i] = array_merge($r[$i], $c);

								// REPORT USER 

								$r[$i] = array_merge($r[$i],$this->Users->findById($u['ReportsRecipients']['user_id']));

								// REPORT INFORMATION + CONNECTION TO USER

								$r[$i] = array_merge($r[$i], $u);

								// FIELD (FOR INFORMATION)

								$r[$i] = array_merge($r[$i], $f);

								// FIELD LABEL

								$r[$i] = array_merge($r[$i], $label);

								// FIELD RESPONSE

								$r[$i] = array_merge($r[$i], $response);

									

								$i++;

							}
							}

						}

					}

					}

			} else {

				$i = 0;

				$rr = $this->ReportsRecipients->find('all', array('conditions' => 'timestamp >= '.$start_date.' AND timestamp <= '.$end_date));
				
				if(count($rr) == 0) {

					$this->Session->setFlash("Sorry, there were no Reports in the specified date range.");

					if($refer == 'true') {

						$this->redirect(array('action' => 'index', 'admin' => 1, 'controller' => 'dashboard'));

					} else {

						$this->redirect(array('action' => 'export'));

					}

				}
				

				$report = $this->Reports->find('all');

				foreach($rr as $u) {
				
					$stores = $this->ReportsStores->find('all', array('conditions' => 'reportsrecipients_id = '.$u['ReportsRecipients']['id']));

					$i2 = 0;

					foreach($stores as $c) {

					$rf = $this->ReportsForms->find('all', array('conditions' => 'report_id = '.$u['ReportsRecipients']['report_id']));

					foreach($rf as $rz) {

							$ff = $this->Forms->findById($rz['ReportsForms']['form_id']);
							if(is_numeric($ff['Forms']['id'])) {
							$fields = $this->Fields->find('all', array('conditions' => 'form_id = '.$ff['Forms']['id']));

							// we have all fields, now we need all labels and responses 

							$i2 = 0;

							foreach($fields as $f) {

								

								$label = $this->FieldCheckboxLabels->find('all', array('conditions' => 'fields_id = '.$f['Fields']['id']));

								if(count($label) == 0) {

									$label = array_merge($label, $this->FieldTextQuestions->find('all', array('conditions' => 'fields_id = '.$f['Fields']['id'])));

								}

								if(count($label) == 0) {

									$label = array_merge($label, $this->FieldDropdownLabels->find('all', array('conditions' => 'fields_id = '.$f['Fields']['id'])));

								}

					

								$response = $this->FieldResponses->find('all', array('conditions' => 'fields_id = '.$f['Fields']['id'].' AND user_id = '.$u['ReportsRecipients']['user_id'].' AND store_number = "'.$c['ReportsStores']['store_number'] . '" AND reportsrecipients_id = '.$u['ReportsRecipients']['id']));

								if(count($response) == 0) {

									$response = array(0 => array("FieldResponses" => array("text" => "") ) );

								}

								// FORMS

								$r[$i] = $ff;

								// REPORT FORM CONNECTION

								$r[$i] = array_merge($r[$i], $rz);

								// REPORT STORE

								$r[$i] = array_merge($r[$i], $c);

								// REPORT USER 
								$user = $this->Users->findById($u['ReportsRecipients']['user_id']);
								$r[$i] = array_merge($r[$i],$user);
								
								// REPORT INFORMATION + CONNECTION TO USER

								$r[$i] = array_merge($r[$i], $u);

								// FIELD (FOR INFORMATION)

								$r[$i] = array_merge($r[$i], $f);

								// FIELD LABEL

								$r[$i] = array_merge($r[$i], $label);

								// FIELD RESPONSE

								$r[$i] = array_merge($r[$i], $response);
								
									

								$i++;

							}
							}

						}

					}

					}

			}

			

			// Now that we have a collection of Forms, ReportsForms, and ReportsRecipients all in one connected to eachother by FORM, process	

			
			if(!isset($r)) {
				$this->Session->setFlash("Sorry, there were no Reports found with those specifications.");
				$this->redirect(array('action' => 'export', 'controller' => 'reports', 'admin' => 1));
			}
			
			if($this->data['Export']['filetype'] == "xls") { 

				// CSV for EXCEL

				header("Content-type: application/csv"); 

				header("Content-Disposition: attachment; filename=REPORTS.csv");

				header("Pragma: no-cache");

				header("Expires: 0");

				

				echo "Report Title, Date, User, Customer, Store Name, Number, City, State, Question Type, Vendor, Question, Response\n";

				$last_report_id = NULL;

				$last_user_id = NULL;
				
				
				foreach($r as $row) {
					if(isset($row['Fields']['field_type']) && strlen($row['Fields']['field_type']) != 0) {
					if(($last_report_id != $row['ReportsRecipients']['id'] || $last_user_id != $row['Users']['id']) && $last_report_id != NULL) {

						echo "\n\n";

					}

					$last_user_id = $row['Users']['id'];

					$report = $this->Reports->findById($row['ReportsForms']['report_id']);

					$last_report_id = $row['ReportsRecipients']['id'];

					$store = $this->ReportsStores->find('all', array('conditions' => 'store_number = "'.$row['ReportsStores']['store_number'].'"'));

					$store = $store[0];

					$vendor = $this->Vendors->findById($row['Forms']['vendor_id']);

					echo $report['Reports']['name'];

					echo "," . date("m/d/y @ g:i:s a T", $row['ReportsRecipients']['timestamp']);

					echo "," . $row['Users']['first_name'] . " " . $row['Users']['last_name'];

					echo "," . $report['Reports']['customer'];

					echo ", ". stripslashes($store['ReportsStores']['store_name']).", ".$store['ReportsStores']['store_number'].", ".$store['ReportsStores']['city'].", ".$store['ReportsStores']['state'];

					echo "," . $row['Forms']['type'];

					echo "," . $vendor['Vendors']['company_name'];

					if($row['Fields']['field_type'] == "Checkbox") {

						echo "," . $row[0]['FieldCheckboxLabels']['text'];

					} else if($row['Fields']['field_type'] == "Text") {

						echo "," . $row[0]['FieldTextQuestions']['text'];

					} else if($row['Fields']['field_type'] == "Dropdown") {
						
						echo "," . $row[0]['FieldDropdownLabels']['text'];

					}
					
					if(isset($row[1])) {
					echo "," . stripslashes($row[1]['FieldResponses']['text']);

															

					echo "\n";
					}
					}

				}

				exit(0);

			} else {

				// PDF

				define('FPDF_FONTPATH','/home/comprehe/public_html/portal/font/');

				require('/home/comprehe/public_html/portal/fpdf.php');



				$pdf=new FPDF();

				$pdf->AddPage();

				

				// Title Row

				$pdf->SetFont('Arial','B',6);

				$pdf->Cell(15,5,'Date',1);
				
				$pdf->Cell(100,5,'Report Title',1,1);

				$pdf->Cell(30,5,'User',1);

				$pdf->Cell(15,5,'Customer',1);

				$pdf->Cell(15,5,'Store Name',1);

				$pdf->Cell(15,5,'Number',1);

				$pdf->Cell(15,5,'City',1);

				$pdf->Cell(15,5,'State',1);

				$pdf->Cell(18,5,'Question Type',1);

				$pdf->Cell(15,5,'Vendor',1,1);

				$pdf->Ln(2.0);

				

				$pdf->SetFont('Arial','',5);

				$last_report_id = NULL;

				$last_user_id = NULL;

				foreach($r as $row) {
					
					if(isset($row['Fields']['field_type']) && strlen($row['Fields']['field_type']) != 0) {
					if(($last_report_id != $row['ReportsRecipients']['id'] || $last_user_id != $row['Users']['id']) && $last_report_id != NULL) {

						$pdf->Ln(1.0);

						$pdf->Cell(15,10,'-----------------------------------------------',0,1);

						$pdf->Ln(1.0);

					}

					$last_user_id = $row['Users']['id'];

					$report = $this->Reports->findById($row['ReportsForms']['report_id']);

					$last_report_id = $row['ReportsRecipients']['id'];

					$store = $this->ReportsStores->find('all', array('conditions' => 'store_number = "'.$row['ReportsStores']['store_number'].'"'));

					$store = $store[0];

					$vendor = $this->Vendors->findById($row['Forms']['vendor_id']);
					
					$pdf->Cell(15,5,date("m/d/y", $row['ReportsRecipients']['timestamp']), 1);
					$pdf->Cell(100,5,$report['Reports']['name'],1,1);


					$pdf->Cell(30,5,$row['Users']['first_name'] . " " . $row['Users']['last_name'],1);

					$pdf->Cell(15,5,$report['Reports']['customer'],1);

					$pdf->Cell(15,5,stripslashes($store['ReportsStores']['store_name']),1);

					$pdf->Cell(15,5,$store['ReportsStores']['store_number'],1);

					$pdf->Cell(15,5,$store['ReportsStores']['city'],1);

					$pdf->Cell(15,5,$store['ReportsStores']['state'],1);

					$pdf->Cell(18,5,$row['Forms']['type'],1);

					$pdf->Cell(15,5,$vendor['Vendors']['company_name'],1,1);

					$pdf->SetFont('Arial','B',6);

					$pdf->Cell(30,5,'Question',1);

					$pdf->SetFont('Arial','',6);

					if($row['Fields']['field_type'] == "Checkbox") {

						$pdf->Cell(100,5,$row[0]['FieldCheckboxLabels']['text'],1,1);

					} else if($row['Fields']['field_type'] == "Text") {

						$pdf->Cell(100,5,$row[0]['FieldTextQuestions']['text'],1,1);

					} else if($row['Fields']['field_type'] == "Dropdown") {

						$pdf->Cell(100,5,$row[0]['FieldDropdownLabels']['text'],1,1);
				
					}
					
					if(isset($row[1])) {

					$pdf->SetFont('Arial','B',6);

					$pdf->Cell(30,5,'Response',1);

					$pdf->SetFont('Arial','',6);

					$pdf->Cell(100,5,stripslashes($row[1]['FieldResponses']['text']),1,1);

					$pdf->Ln(1.0);
					}
					}
									

				}



				$pdf->Output();

				

				exit(0);

			}

			

		} else {

			$this->loadModel("Reports");

			$this->set('customers', $this->Reports->query("SELECT DISTINCT customer FROM reports"));

			$this->loadModel("Vendors");

			$this->set('vendors', $this->Vendors->find('all'));

			$this->loadModel("Users");

			$this->set('users', $this->Users->find('all'));

		}

	}

	

	function view($id, $submit = false) {

		$this->set('view', true);

		if(!isset($id)) {

			$this->Session->setFlash("Invalid Report ID");

			$this->redirect(array('controller' => 'reports', 'action' => 'index'));

		}

		

		$this->loadModel("Reports");

		$this->loadModel("ReportsRecipients");

		

		$report_conn = $this->ReportsRecipients->findById($id);

		$report = $this->Reports->findById($report_conn['ReportsRecipients']['report_id']);

		$report = array_merge($report, $report_conn);

		$this->set('report', $report);

		

		// Reports Forms connection

		$this->loadModel("Forms");

		$this->loadModel("Vendors");

		$this->loadModel("Fields");

		$this->loadModel("ReportsForms");

		$this->loadModel("ReportsStores");

		$this->loadModel("FieldCheckboxLabels");

		$this->loadModel("FieldTextQuestions");

		$this->loadModel("FieldDropdownLabels");

		$this->loadModel("FieldDropdownOptions");

		$this->loadModel("FieldResponses");

		

		$rc = $this->ReportsStores->find('all', array('conditions' => 'reportsrecipients_id = '.$report['ReportsRecipients']['id'], 'order' => 'id ASC'));

		$i = 0;

		if(count($rc) ==0) {

			$rc = array(0 => -1);

		}

		$totalText = array();

		foreach($rc as $c) {

			$rf = $this->ReportsForms->find('all',array('conditions' => 'report_id ='.$report['Reports']['id']));

			// for each customer we find the reportsforms connection

			$i2 = 0;
			$emptyText = array();
			foreach($rf as $r_f) {

				$reader = array();

				$reader['General'] = array();

				$reader['Vendor'] = array();

				$f = $this->Forms->findById($r_f['ReportsForms']['form_id']);

				if(isset($f['Forms']['vendor_id'])) {

					$vendor = $this->Vendors->findById($f['Forms']['vendor_id']);

				}

				// for each report form we find the form

				$formID = $f['Forms']['id'];

				if(isset($formID)) {

				$fields = $this->Fields->find('all',array('conditions' => 'form_id = '.$formID));
				
				
				foreach($fields as $f) {

					if(isset($c) && $c != -1) {

						$response = $this->FieldResponses->find('all', array('conditions' => 'reportsrecipients_id = '.$report['ReportsRecipients']['id'].' AND fields_id = '.$f['Fields']['id'].' AND store_number = "'.$c['ReportsStores']['store_number'].'"'));

						if(count($response) != 0) {

							$response = $response[0];
							$response = array("FieldResponses" => array("text" => stripslashes($response['FieldResponses']['text'])));

						} else {

							$response = array("FieldResponses" => array("text" => ""));

						}

					} else {

						$response = array("FieldResponses" => array("text" => ""));

					}

					

					

					if($f['Fields']['field_type'] == "Checkbox") {

						$tf = $this->FieldCheckboxLabels->find('all',array('conditions'=>'fields_id = '.$f['Fields']['id']));

						if($f['Fields']['rel_type'] == "General") {

							$reader['General'][sizeof($reader['General'])] = array('Checkbox', $tf[0]['FieldCheckboxLabels']['text'], $f['Fields']['id'], $i, $response);

						} else if($f['Fields']['rel_type'] == "Vendor") {

							$reader['Vendor'][sizeof($reader['Vendor'])] = array('Checkbox',$tf[0]['FieldCheckboxLabels']['text'], $f['Fields']['id'], $i, $response);

						}

					} else if($f['Fields']['field_type'] == "Dropdown") {

						$label = $this->FieldDropdownLabels->find('all',array('conditions'=>'fields_id = '.$f['Fields']['id']));

						$options = $this->FieldDropdownOptions->find('all',array('conditions'=>'fields_id = '.$f['Fields']['id']));

						if($f['Fields']['rel_type'] == "General") {

							$reader['General'][sizeof($reader['General'])] = array('Dropdown', $label[0]['FieldDropdownLabels']['text'], $options, $f['Fields']['id'],$i, $response);

						} else if($f['Fields']['rel_type'] == "Vendor") {

							$reader['Vendor'][sizeof($reader['Vendor'])] = array('Dropdown', $label[0]['FieldDropdownLabels']['text'], $options, $f['Fields']['id'], $i, $response);

						}

					} else if($f['Fields']['field_type'] == "Text") {

						$tf = $this->FieldTextQuestions->find('all',array('conditions'=>'fields_id = '.$f['Fields']['id']));

						if($f['Fields']['rel_type'] == "General") {

							$reader['General'][sizeof($reader['General'])] = array('Text', $tf[0]['FieldTextQuestions']['text'], $f['Fields']['id'], $i, $response);

						} else if($f['Fields']['rel_type'] == "Vendor") {

							$reader['Vendor'][sizeof($reader['Vendor'])] = array('Text',$tf[0]['FieldTextQuestions']['text'], $f['Fields']['id'], $i, $response);

						}	

					}

				}

				// Process the array for the current fields

				$returnText = array();

				foreach($reader as $r=>$value) {

					$returnText[$r] = "";

					foreach($reader[$r] as $n) {

						if($n[0] == "Checkbox") {

							$returnText[$r] .= '<tr><td><input type="checkbox" value="'.$n[4]['FieldResponses']['text'].'" onclick="if($(this).is(\':checked\')) { $(this).next(\'input\').val(\'Yes\'); } else { $(this).next(\'input\').val(\'No\'); }" class="form_checkbox3" '.($n[4]['FieldResponses']['text'] == "Yes" ? 'checked="Yes" ' : '' ).'/><input type="hidden" name="data[fields]['.$n[2].']['.$n[3].']" value="'.$n[4]['FieldResponses']['text'].'" /><div class="label">'.$n[1].'</div></a></td></tr>';

						} else if($n[0] == "Text") {

							$returnText[$r] .= '<tr><td><div class="label">'.$n[1].'</div><textarea name="data[fields]['.$n[2].']['.$n[3].']" cols="50" rows="6" class="floatleft">'.stripslashes($n[4]['FieldResponses']['text']).'</textarea></td></tr>';

						} else if($n[0] == "Dropdown") {

							$returnText[$r] .= '<tr><td><div class="label">'.$n[1].'</div><select name="data[fields]['.$n[3].']['.$n[4].']">';

							foreach($n[2] as $o) {

								$returnText[$r] .= '<option '.($o['FieldDropdownOptions']['text'] == stripslashes($n[5]['FieldResponses']['text']) ? 'SELECTED ' : '').'value="'.$o['FieldDropdownOptions']['text'].'">'.$o['FieldDropdownOptions']['text'].'</option>';

							}

							$returnText[$r] .= '</select></a></td></tr>';

						}


					}

				}
				
				$emptyText[$i2] = array();
				foreach($reader as $r=>$value) {
					$emptyText[$i2][$r] = "";
					foreach($reader[$r] as $n) {
						if($n[0] == "Checkbox") {

						$emptyText[$i2][$r] .= '<tr><td><input type="checkbox" value="" onclick="if($(this).is(\':checked\')) { $(this).next(\'input\').val(\'Yes\'); } else { $(this).next(\'input\').val(\'No\'); }" class="form_checkbox3" /><input type="hidden" name="data[fieldsTwo]['.$n[2].'][-1]" value="" /><div class="label">'.$n[1].'</div></a></td></tr>';

						} else if($n[0] == "Text") {

							$emptyText[$i2][$r] .= '<tr><td><div class="label">'.$n[1].'</div><textarea name="data[fieldsTwo]['.$n[2].'][-1]" cols="50" rows="6" class="floatleft"></textarea></td></tr>';

						} else if($n[0] == "Dropdown") {

							$emptyText[$i2][$r] .= '<tr><td><div class="label">'.$n[1].'</div><select name="data[fieldsTwo]['.$n[3].'][-1]">';

							foreach($n[2] as $o) {

								$emptyText[$i2][$r] .= '<option value="'.$o['FieldDropdownOptions']['text'].'">'.$o['FieldDropdownOptions']['text'].'</option>';

							}

							$emptyText[$i2][$r] .= '</select></a></td></tr>';

						}
					}
				}
				if(is_array($vendor)){
				$emptyText[$i2] = array_merge($emptyText[$i2], $vendor);
				}

				if(count($returnText) == 0) {

					$returnText = "";

				}

				$totalText[$i][$i2]['text'] = $returnText;
				
				if(is_array($vendor)) {
				$totalText[$i][$i2] = array_merge($totalText[$i][$i2], $f, $vendor);
				} else {
				$totalText[$i][$i2] = array_merge($totalText[$i][$i2], $f);
				}
				// we have the text for the form info + vendor info

				$i2++;

				}

			}

			if(count($totalText) != 0) {

			$totalText[$i] = array_merge($totalText[$i], array('Stores' => $c));

			$i++;

			}

			// we have customer + text for that customer

		}
		

		// now that we have the entire triple-array of report information separated by customer [which the user inputs], let's share it with the page

		

		/* Structure:

		$totalText[0]['ReportsStores'] = array('store_name', 'store_number', 'city', 'state')

		$totalText[0][0] = array('text', Forms -array-, Vendor -array-)

		$totalText[0][0]['text'] = FORM TEXT FIELDS ENUMERATED BY ID AND STORE NUMBER TO SEPARATE

		$totalText[0][0]['Vendors'] = array()

		$totalText[0][0]['Forms'] = array()

		*/

		
		$this->set('empty', $emptyText);
		$this->set('reader', $totalText);

		

		if(isset($this->data)) {

			// save draft
			
			

			$this->loadModel("FieldResponses");

			$this->loadModel("ReportsStores");

			$i = 0;

			$findstore = $this->ReportsStores->find('all', array('conditions' => 'reportsrecipients_id = '.$report['ReportsRecipients']['id']));

			foreach($findstore as $f) {

				$this->ReportsStores->delete($f['ReportsStores']['id']);

			}
		
			foreach($this->data['stores'] as $store) {

				if(!(!isset($store['store_number']) || strlen($store['store_number']) == 0)) {
				$timestamp = mktime(0,0,0,$store['month'],$store['day'],$store['year']);

				$this->ReportsStores->query("INSERT INTO reports_stores (`store_name`,`store_number`,`city`,`state`,`reportsrecipients_id`, `date_visited`) VALUES('".addslashes($store['store_name'])."', '".$store['store_number']."', '".$store['city']."', '".$store['state']."', '".$report['ReportsRecipients']['id']."', '".$timestamp."')");

				$rs = $this->ReportsStores->findById($this->ReportsStores->getLastInsertId());

				
				foreach($this->data['fields'] as $key=>$f) {

					// key is the field ID

					foreach($f as $key2=>$f2) {

						// key2 is the i, so we read this i and if it equals the field i then we save the field with that store number.  

							// FINISH HERE

						if($key2 == $i) {

							$fields = $this->FieldResponses->find('all', array('conditions' => 'fields_id = '.$key.' AND reportsrecipients_id = '.$report['ReportsRecipients']['id'].' AND store_number = "'.$rs['ReportsStores']['store_number'].'"'));
							if(count($fields) != 0) {

								// update the field

								$this->FieldResponses->id = $fields[0]['FieldResponses']['id'];

								$this->FieldResponses->set(array('text' => addslashes($f2)));

							} else {

								$this->FieldResponses->id = NULL;

								$this->FieldResponses->set(array('text' => addslashes($f2), 'reportsrecipients_id' => $report['ReportsRecipients']['id'], 'store_number' => $rs['ReportsStores']['store_number'], 'fields_id' => $key, 'user_id' => $this->Session->read('Auth.User.id')));

							}

							$this->FieldResponses->save();

							$this->FieldResponses->id = NULL;

						}

					}

				}

				}

				$i++;

			}		

				// submit report

				$this->ReportsRecipients->id = $id;

				$this->ReportsRecipients->set(array('last_updated_timestamp' => time()));

				$this->ReportsRecipients->save();

				$this->loadModel("Logs");
				
				$this->Logs->set(array("user_id" => $this->Session->read('Auth.User.id'), "timestamp" => time(), "event_description" => "<span style='text-decoration: underline'>Updated Report</span><br /><strong>Name:</strong> <a href='/site/admin/reports/view/".$report['ReportsRecipients']['id']."'>".$report['Reports']['name']."</a><br /><strong>Customer:</strong> ".$report['Reports']['customer']));
				
				$this->Logs->save();
				

				$this->Session->setFlash("Report Saved.");

			$this->redirect(array('action' => 'view', $id));

		}

	}

	

	function admin_view($id) {

		if(!isset($id)) {

			$this->Session->setFlash("Invalid Report ID");

			$this->redirect(array('controller' => 'reports', 'action' => 'index', 'admin' => 1));

		}

		

		$this->loadModel("Reports");

		$this->loadModel("ReportsRecipients");

		

		$report_conn = $this->ReportsRecipients->findById($id);

		

		$report = $this->Reports->findById($report_conn['ReportsRecipients']['report_id']);

		$report = array_merge($report, $report_conn);

		$this->set('report', $report);

		

		// Reports Forms connection

		$this->loadModel("Forms");

		$this->loadModel("Vendors");

		$this->loadModel("Fields");

		$this->loadModel("ReportsForms");

		$this->loadModel("ReportsStores");

		$this->loadModel("FieldCheckboxLabels");

		$this->loadModel("FieldTextQuestions");

		$this->loadModel("FieldDropdownLabels");

		$this->loadModel("FieldDropdownOptions");

		$this->loadModel("FieldResponses");

		

		$rc = $this->ReportsStores->find('all', array('conditions' => 'reportsrecipients_id = '.$report['ReportsRecipients']['id'], 'order' => 'id ASC'));

		$i = 0;

		if(count($rc) ==0) {

			$rc = array(0 => -1);

		}

		foreach($rc as $c) {

			$rf = $this->ReportsForms->find('all',array('conditions' => 'report_id ='.$report['Reports']['id']));

			// for each customer we find the reportsforms connection

			$i2 = 0;

			

			foreach($rf as $r_f) {

				$reader = array();

				$reader['General'] = array();

				$reader['Vendor'] = array();

				$f = $this->Forms->findById($r_f['ReportsForms']['form_id']);

				if(isset($f['Forms']['vendor_id'])) {

					$vendor = $this->Vendors->findById($f['Forms']['vendor_id']);

				} else {

					$vendor = array("Vendors" => -1);

				}

				// for each report form we find the form

				$formID = $f['Forms']['id'];

				if(isset($formID)) {

				$fields = $this->Fields->find('all',array('conditions' => 'form_id = '.$formID));

				foreach($fields as $f) {

					if(isset($c) && $c != -1) {

						$response = $this->FieldResponses->find('all', array('conditions' => 'fields_id = '.$f['Fields']['id'].' AND store_number = "'.$c['ReportsStores']['store_number'].'"'));

						if(count($response) != 0) {

							$response = $response[0];

						} else {

							$response = array("FieldResponses" => array("text" => ""));

						}

					} else {

						$response = array("FieldResponses" => array("text" => ""));

					}

					

					

					if($f['Fields']['field_type'] == "Checkbox") {

						$tf = $this->FieldCheckboxLabels->find('all',array('conditions'=>'fields_id = '.$f['Fields']['id']));

						if($f['Fields']['rel_type'] == "General") {

							$reader['General'][sizeof($reader['General'])] = array('Checkbox', $tf[0]['FieldCheckboxLabels']['text'], $f['Fields']['id'], $i, $response);

						} else if($f['Fields']['rel_type'] == "Vendor") {

							$reader['Vendor'][sizeof($reader['Vendor'])] = array('Checkbox',$tf[0]['FieldCheckboxLabels']['text'], $f['Fields']['id'], $i, $response);

						}

					} else if($f['Fields']['field_type'] == "Dropdown") {

						$label = $this->FieldDropdownLabels->find('all',array('conditions'=>'fields_id = '.$f['Fields']['id']));

						$options = $this->FieldDropdownOptions->find('all',array('conditions'=>'fields_id = '.$f['Fields']['id']));

						if($f['Fields']['rel_type'] == "General") {

							$reader['General'][sizeof($reader['General'])] = array('Dropdown', $label[0]['FieldDropdownLabels']['text'], $options, $f['Fields']['id'],$i, $response);

						} else if($f['Fields']['rel_type'] == "Vendor") {

							$reader['Vendor'][sizeof($reader['Vendor'])] = array('Dropdown', $label[0]['FieldDropdownLabels']['text'], $options, $f['Fields']['id'], $i, $response);

						}

					} else if($f['Fields']['field_type'] == "Text") {

						$tf = $this->FieldTextQuestions->find('all',array('conditions'=>'fields_id = '.$f['Fields']['id']));

						if($f['Fields']['rel_type'] == "General") {

							$reader['General'][sizeof($reader['General'])] = array('Text', $tf[0]['FieldTextQuestions']['text'], $f['Fields']['id'], $i, $response);

						} else if($f['Fields']['rel_type'] == "Vendor") {

							$reader['Vendor'][sizeof($reader['Vendor'])] = array('Text',$tf[0]['FieldTextQuestions']['text'], $f['Fields']['id'], $i, $response);

						}	

					}

				}

				// Process the array for the current fields

				$returnText = array();

				foreach($reader as $r=>$value) {

					$returnText[$r] = "";

					foreach($reader[$r] as $n) {

						if($n[0] == "Dropdown") {

							$text = stripslashes($n[5]['FieldResponses']['text']);

						} else {

							$text = stripslashes($n[4]['FieldResponses']['text']);

						}

						$returnText[$r] .= '<tr><td><div class="label">'.$n[1].': </div>'.$text.'</td></tr>';

					}

				}

				if(count($returnText) == 0) {

					$returnText = "";

				}

				$totalText[$i][$i2]['text'] = $returnText;
				
				if(is_array($vendor)) {
				$totalText[$i][$i2] = array_merge($totalText[$i][$i2], $f, $vendor);
				} else {
					$totalText[$i][$i2] = array_merge($totalText[$i][$i2], $f);
				}
				// we have the text for the form info + vendor info

				$i2++;

				}

			}

			$totalText[$i] = array_merge($totalText[$i], array('Stores' => $c));

			$i++;

			// we have customer + text for that customer

		}

		// now that we have the entire triple-array of report information separated by customer [which the user inputs], let's share it with the page

		

		/* Structure:

		$totalText[0]['ReportsStores'] = array('store_name', 'store_number', 'city', 'state')

		$totalText[0][0] = array('text', Forms -array-, Vendor -array-)

		$totalText[0][0]['text'] = FORM TEXT FIELDS ENUMERATED BY ID AND STORE NUMBER TO SEPARATE

		$totalText[0][0]['Vendors'] = array()

		$totalText[0][0]['Forms'] = array()

		*/

		

		$this->set('reader', $totalText);

	}

	

	function printview($id, $type = NULL) {

		$this->pageTitle = 'Print Report';

		$this->layout = 'print';

		$this->set('type', $type);
		

		if(!isset($id)) {

			$this->Session->setFlash("Invalid Report ID");

			$this->redirect(array('controller' => 'reports', 'action' => 'index', 'admin' => 1));

		}

		

		$this->loadModel("Reports");

		$this->loadModel("ReportsRecipients");

		

		$report_conn = $this->ReportsRecipients->findById($id);

		

		$report = $this->Reports->findById($report_conn['ReportsRecipients']['report_id']);

		$report = array_merge($report, $report_conn);

		$this->set('report', $report);

		

		// Reports Forms connection

		$this->loadModel("Forms");

		$this->loadModel("Vendors");

		$this->loadModel("Fields");

		$this->loadModel("ReportsForms");

		$this->loadModel("ReportsStores");

		$this->loadModel("FieldCheckboxLabels");

		$this->loadModel("FieldTextQuestions");

		$this->loadModel("FieldDropdownLabels");

		$this->loadModel("FieldDropdownOptions");

		$this->loadModel("FieldResponses");

		

		$rc = $this->ReportsStores->find('all', array('conditions' => 'reportsrecipients_id = '.$report['ReportsRecipients']['id'], 'order' => 'id ASC'));

		$i = 0;

		if(count($rc) ==0) {

			$rc = array(0 => -1);

		}

		foreach($rc as $c) {

			$rf = $this->ReportsForms->find('all',array('conditions' => 'report_id ='.$report['Reports']['id']));

			// for each customer we find the reportsforms connection

			$i2 = 0;

			

			foreach($rf as $r_f) {

				

				$reader = array();

				$reader['General'] = array();

				$reader['Vendor'] = array();

				

				$f = $this->Forms->findById($r_f['ReportsForms']['form_id']);

				if(isset($f['Forms']['vendor_id'])) {

					$vendor = $this->Vendors->findById($f['Forms']['vendor_id']);

				} else {

					$vendor = array("Vendors" => -1);

				}

				// for each report form we find the form

				$formID = $f['Forms']['id'];

				if(isset($formID)) {

				$fields = $this->Fields->find('all',array('conditions' => 'form_id = '.$formID));

				foreach($fields as $f) {

					if(isset($c) && $c != -1) {

						$response = $this->FieldResponses->find('all', array('conditions' => 'fields_id = '.$f['Fields']['id'].' AND store_number = "'.$c['ReportsStores']['store_number'].'"'));

						if(count($response) != 0 && $type == NULL) {

							$response = $response[0];

						} else {

							$response = array("FieldResponses" => array("text" => ""));

						}

					} else {

						$response = array("FieldResponses" => array("text" => ""));

					}

					

					

					if($f['Fields']['field_type'] == "Checkbox") {

						$tf = $this->FieldCheckboxLabels->find('all',array('conditions'=>'fields_id = '.$f['Fields']['id']));

						if($f['Fields']['rel_type'] == "General") {

							$reader['General'][sizeof($reader['General'])] = array('Checkbox', $tf[0]['FieldCheckboxLabels']['text'], $f['Fields']['id'], $i, $response);

						} else if($f['Fields']['rel_type'] == "Vendor") {

							$reader['Vendor'][sizeof($reader['Vendor'])] = array('Checkbox',$tf[0]['FieldCheckboxLabels']['text'], $f['Fields']['id'], $i, $response);

						}

					} else if($f['Fields']['field_type'] == "Dropdown") {

						$label = $this->FieldDropdownLabels->find('all',array('conditions'=>'fields_id = '.$f['Fields']['id']));

						$options = $this->FieldDropdownOptions->find('all',array('conditions'=>'fields_id = '.$f['Fields']['id']));

						if($f['Fields']['rel_type'] == "General") {

							$reader['General'][sizeof($reader['General'])] = array('Dropdown', $label[0]['FieldDropdownLabels']['text'], $options, $f['Fields']['id'],$i, $response);

						} else if($f['Fields']['rel_type'] == "Vendor") {

							$reader['Vendor'][sizeof($reader['Vendor'])] = array('Dropdown', $label[0]['FieldDropdownLabels']['text'], $options, $f['Fields']['id'], $i, $response);

						}

					} else if($f['Fields']['field_type'] == "Text") {

						$tf = $this->FieldTextQuestions->find('all',array('conditions'=>'fields_id = '.$f['Fields']['id']));

						if($f['Fields']['rel_type'] == "General") {

							$reader['General'][sizeof($reader['General'])] = array('Text', $tf[0]['FieldTextQuestions']['text'], $f['Fields']['id'], $i, $response);

						} else if($f['Fields']['rel_type'] == "Vendor") {

							$reader['Vendor'][sizeof($reader['Vendor'])] = array('Text',$tf[0]['FieldTextQuestions']['text'], $f['Fields']['id'], $i, $response);

						}	

					}

				}

				// Process the array for the current fields

				$returnText = array();

				foreach($reader as $r=>$value) {

					$returnText[$r] = "";

					foreach($reader[$r] as $n) {

						if($n[0] == "Dropdown") {

							$text = stripslashes($n[5]['FieldResponses']['text']);

						} else {

							$text = stripslashes($n[4]['FieldResponses']['text']);

						}

						$returnText[$r] .= '<tr><td><div class="label">'.$n[1].': </div>'.$text.'</td></tr>';

					}

				}

				if(count($returnText) == 0) {

					$returnText = "";

				}

				$totalText[$i][$i2]['text'] = $returnText;

				if(is_array($vendor)) {
				$totalText[$i][$i2] = array_merge($totalText[$i][$i2], $f, $vendor);
				} else {
					$totalText[$i][$i2] = array_merge($totalText[$i][$i2], $f);
				}

				// we have the text for the form info + vendor info

				$i2++;

				}

			}

			$totalText[$i] = array_merge($totalText[$i], array('Stores' => $c));

			$i++;

			// we have customer + text for that customer

		}

		// now that we have the entire triple-array of report information separated by customer [which the user inputs], let's share it with the page

		

		/* Structure:

		$totalText[0]['ReportsStores'] = array('store_name', 'store_number', 'city', 'state')

		$totalText[0][0] = array('text', Forms -array-, Vendor -array-)

		$totalText[0][0]['text'] = FORM TEXT FIELDS ENUMERATED BY ID AND STORE NUMBER TO SEPARATE

		$totalText[0][0]['Vendors'] = array()

		$totalText[0][0]['Forms'] = array()

		*/

		

		$this->set('reader', $totalText);

		

	}

			

}

?>