<?
echo $javascript->link('jquery');
?>


<script type="text/javascript">
<? if($step == 2) { ?>
function submitField(section) {
	var type = $("input[name=TYPE]").val();
	var os = "";
	if(type == "Dropdown") {
		for(var i = 0; i <= id; i++) {
			if(document.getElementById("option_"+i)) {
				os += "&data[Report][options]["+i+"]="+document.getElementById("option_"+i).value;
			}
		}
	}
	var text = $("input[name=TEXT]").val();
	text = "&data[Report][text]="+text;
	
$.ajax({
  url: '/site/admin/reports/new_report/5',
  type: "POST",
  data: "data[Report][form_id]=<?=$Form_ID?>&data[Report][type]="+type+"&data[Report][section]="+section+text+os+"",
  success: function(data) {
	if(data == "error") {
		alert("Sorry, there was an error.  Please try again or contact the webmaster.");
	} else {
		$('#'+section).append(data);
	}
	window_close();
  }
});
}

function delField(id, object) {
	if(confirm('Are you sure?  This will remove the field from the database.')) {
	$.ajax({
  url: '/site/admin/reports/new_report/7',
  type: "POST",
  data: "data[field_id]="+id,
  success: function(data) {
	if(data == "error") {
		alert("Sorry, there was an error.  Please try again or contact the webmaster.");
	} else {
		$(object).parents('td').parents('tr').css('display','none');
	}
	window_close();
  }
});
	}
}
<? } ?>
function changeSelectVal(id, val, string) {
	var span = document.getElementById("span_"+id);
	span.innerHTML = string;
	var input = document.getElementById("select_"+id);
	input.value=val;
}

var id = 0;
function add_recipient() {
	id++;
	$('table#more_recipients').append("<tr><td><input type=\"text\" id=\"option_"+id+"\" name=\"data[Report][option]["+id+"]\" size=\"50\" /></td></tr>");
}
<?
if($step == 4) { ?>
var id2 = 0;
function add_recipient2() {
	id2++;
	$('table#more_forms').append('<tr><td><div class="select"><span id="span_form_'+id2+'">Select a form</span><div class="options"><? foreach($forms as $f) { 
	?><a href="javascript: changeSelectVal(\'form_'+id2+'\',\'<?=$f['Forms']['id']?>\',\'<?=$f['Forms']['name']?>\')" class="option"><?=$f['Forms']['name']?></a><? 
	} ?></div><input id="select_form_'+id2+'" value="" type="hidden" name="data[Forms]['+id2+']" /></div><br style="clear: both" /></tr></td>');
}
<? } ?>
function window_close() {
	var ob = document.getElementById("new_field");
	ob.style.display = "none";
	ob.innerHTML = HTML;
}

var HTML = "";

function add_field(cat) {
	var ob = document.getElementById("new_field");
	ob.style.display = "block";
	HTML = ob.innerHTML;
	document.getElementById("cat").innerHTML = cat;
	ct = cat;
}
var ct;
function checkAdd_Field() {
	var c = document.getElementById("select_add_type");
	var area = document.getElementById("field_add_area");
	var l = document.getElementById("add_button");
	if(c.value == "checkbox") {
		// get text info
		$('#field_add_area').html('<tr><td><div class="label"><strong>Field Type:</strong> Checkbox</div></td></tr><tr><td><div class="label">Checkbox Label Text (Question Y/N):</div><input type="text" name="TEXT" size="50" /></td></tr><input type="hidden" name="TYPE" value="Checkbox" />');
	} else if(c.value == "text_question") {
		// get text info
		$('#field_add_area').html('<tr><td><div class="label"><strong>Field Type:</strong> Text Question</div></td></tr><tr><td><div class="label">Question:</div><input type="text" name="TEXT" size="50" /></td></tr><input type="hidden" name="TYPE" value="Text" />');
	} else if(c.value == "dropdown") {
		// get text info
		$('#field_add_area').html('<tr><td><div class="label"><strong>Field Type:</strong> DropDown</div></td></tr><tr><td><div class="label">DropDown Label Text (Question):</div><input type="text" name="TEXT" size="50" /></td></tr><input type="hidden" name="TYPE" value="Dropdown" /><tr><td><div class="label">Choices:</div><br style="clear: both" /><div id="first_recipient"><input id="option_0" type="text" name="data[Report][option][0]" size="50" style="float: left" /></div><ul class="floatleft form"><li><a href="javascript:add_recipient();" class="button_smgr" title="add option"><span>add choice</span></a></li></ul></td></tr>');
	}
	$('#add_button').html('<span>Add Field</span>');
	$('#add_button').attr('href', "javascript: submitField('"+ct+"')");
}

<?php
$remoteFunction = $ajax->remoteFunction(array('url' => array( 'controller' => 'reports', 'action' => 'newField', 1 ),'update' => 'temp', 'complete' => 'success_close()', )); 
?>
		
</script>
<div id="content">
  <div id="top">
    <img id="logo" src="/site/img/cmi_logo_gr.png" />
      <div id="topWelcome">
      <h3>Welcome <? echo $session->read('Auth.User.first_name'); ?></h3><br />
	  <?php echo $html->link('Home', '/admin/dashboard', array('title'=>'Home', 'class'=>'crumbs')); ?> > <?php echo $html->link('Reports', '/admin/reports', array('title'=>'Reports', 'class'=>'crumbs')); ?> > <?php echo $html->link('Report Builder', '/admin/reports/new_report', array('title'=>'Report Builder', 'class'=>'crumbs')); ?>
      </div>
      <div id="topDate">
      <a href="/site/users/logout">Log Out</a> | <?php echo date("m\/d\/y"); ?>
      </div>
    <div class="clear"><!--IE--></div>
  </div>
 
 <!-- MAIN AREA START -->
 
  <div id="main">
  
  <fieldset id="fs_messages"><legend>Reports</legend>
  
  <? 
  if($step == 0) {
	?>
    <form id="ReportAdd" name="ReportAdd" method="post" action="/site/admin/reports/new_report/1" accept-charset="utf-8">
	<input type="hidden" name="_method" value="POST" />
  <table>
  <tr>
  	<td>
	   <div class="label">What do you wish to do?:</div>
        <div class="select" id="">
        	<span id="span_form_option">Select Option</span>
            <div class="options">
				<a href="javascript: changeSelectVal('form_option','new','Create New Report')" class="option">Create New Report</a>
                <a href="javascript: changeSelectVal('form_option','form_modifycreate','Create a Form')" class="option">Create a Form</a>
                <a href="javascript: changeSelectVal('form_option','form','View all Forms')" class='option'>View all Forms</a>
                <a href="javascript: changeSelectVal('form_option','vendor','Add/Modify a Vendor')" class="option">Add/Modify a Vendor</a>
            </div>
            <input id="select_form_option" value="new" type="hidden" name="data[Report][type]" />
        </div>
    </td>
  </tr>
  </table> 
  
  <div class="fs_buttons">
  <a class="button_or floatright" id="report_next" href="javascript: document.ReportAdd.submit()"><span>Next Step</span></a>
  </div>
    <?
  }
  
  if($step == 1) {
	  ?>
  <form id="ReportAdd" name="ReportAdd" method="post" action="/site/admin/reports/new_report/2" accept-charset="utf-8">
	<input type="hidden" name="_method" value="POST" />
  <table>
  <tr>
  	<td>
      <div class="label" style="width: 100px">Form&nbsp;Title:</div>
      <input type="text" name="data[Report][name]" class="floatleft" />
    </td>
  </tr>
  <tr>
    <td>
	  <div class="label">Choose Form Vendor (Optional):</div>
        <div class="select" id="">
        	<span id="span_form3">Select Vendor</span>
            <div class="options">
            	<? 
				foreach($vendors as $f) {
				?>
				<a href="javascript: changeSelectVal('form3','<?=$f['Vendors']['id']?>','<?=$f['Vendors']['company_name']?>')" class="option"><?=$f['Vendors']['company_name']?></a>
                <? } ?>
            </div>
            <input id="select_form3" value="" type="hidden" name="data[Report][vendor_id]" />
        </div>
	</td>
  </tr>
  
  </table> 
  <input type="hidden" name="data[Report][step]" value="2" />
  </form>
  <div class="fs_buttons">
  <a class="button_or floatright" id="report_next" href="javascript: document.ReportAdd.submit()"><span>Next Step</span></a>
  </div>
  
  </fieldset>
  <br />
  <fieldset id="fs_messages">
  <legend>vendors</legend>
  <table id="tb_messages">
  <tbody>
  <tr>
  	<th>id</th>
    <th>company name</th>
    <th>options</th>
  </tr>
  <?
  if(count($vendors) == 0) {
	  ?>
  <tr><td>No vendors exist in the database.</td></tr>
  <? 
  } else {
  $i = 0;
  foreach($vendors as $v) { ?>
  <tr<?=($i == 1 ? " class='odd'" : "")?>>
  	<td><?=$v['Vendors']['id']?></td>
  	<td><?=$v['Vendors']['company_name']?></td>
  	<td class="tb_tools">
        <ul>
        <li><a href="/site/admin/vendors/edit/<?=$v['Vendors']['id']?>" title="edit"><img src="/site/img/bt_edit.gif" /></a></li>
        <li><a href="/site/admin/vendors/delete/<?=$v['Vendors']['id']?>" title="delete" onclick="return confirm('Are you sure?');"><img src="/site/img/bt_del.gif" /></a></li>
        </ul>
	</td>
  </tr>
  <? if($i == 0) {
	  $i++;
  } else {
	  $i = 0;
  } 
  } 
  }?>
  </tbody>
  </table>
  
  <div class="fs_buttons">
  <a class="button_or" href="/site/admin/vendors/new"><span>new vendor</span></a>
  </div>
  
  </fieldset>
  
  <? }
 	if($step == 2) {
		
		// This is where we will allow the user to add fields along with already displaying previous fields.
		
	?>
  <table>
  
  <tr>
  	<td>
      <div class="label">Form&nbsp;Name:  "<strong><?=$form['Forms']['name']?>"</div>
    </td>
  </tr>
  <?
  if(!isset($vendor)) { ?>
  <tr>
  	<td>
      <div class="label">General Questions Form</div>
		<ul class="floatright form">
    	<li><a href="javascript:add_field('General');" class="button_smgr" title="add field"><span>add field</span></a></li>
    	</ul>
    </td>
  </tr>
  <tbody id="General">
  <?
  echo $reader['General'];
  ?>
  </tbody>
  <?
  }
  if(isset($vendor)) {
	?>
  <tr>
    <td>
      <div class="label">Vendor [<strong><?=$vendor['Vendors']['company_name']?></strong>] Questions Form</div>
      <ul class="floatright form">
    	<li><a href="javascript:add_field('Vendor');" class="button_smgr" title="add field"><span>add field</span></a></li>
    	</ul>
    </td>
  </tr>
  <tbody id="Vendor">
  <?
  echo $reader['Vendor'];
  ?>
  </tbody>
  <? } ?>
  </table> 
  
  <div class="fs_buttons">
  <a class="button_or floatright" href="/site/admin/forms"><span>save form</span></a>
  </div>
    
    <? } 
	
	if($step == 3) {
		
		// new report
		// 3. choose store
		// 4. vendors listed (add/remove) using forms, optional to add/remove more/less forms.
		// 5. report is created, move to 'send_report' 
		
		?>
        
        <form id="ReportAdd" name="ReportAdd" method="post" action="/site/admin/reports/new_report/4" accept-charset="utf-8">
	<input type="hidden" name="_method" value="POST" />
  <table>
  <tr>
  	<td>
    	<div class="label">Choose Store for Report:</div>
		 <div class="select" id="">
        	<span id="span_store">Select Store</span>
            <div class="options">
            	<? 
				foreach($stores as $s) {
				?>
				<a href="javascript: changeSelectVal('store','<?=$s['Stores']['id']?>','<?=$s['Stores']['name']?>')" class="option"><?=$s['Stores']['store_number']?> - <?=$s['Stores']['name']?></a>
                <? } ?>
            </div>
            <input id="select_store" value="" type="hidden" name="data[Report][store_id]" />
        </div>
    </td>
  </tr>
  </table>
  </form>
   <div class="fs_buttons">
  <a class="button_or floatright" id="report_next" href="javascript: document.ReportAdd.submit()"><span>Next</span></a>
  </div>
  
        <?
	} else if($step == 4) {
		// vendor listings
		?>
        <form id="ReportAdd" name="ReportAdd" method="post" action="/site/admin/reports/new_report/6" accept-charset="utf-8">
	<input type="hidden" name="_method" value="POST" />
    <? // <input type="hidden" name="data[Report][store_id]" value="<?=$store_id" /> ?>
  <table>
  <tr>
  	<td>
    	<div class="label">Report Name:</div>
        <input type="text" name="data[Report][name]" value="" />
    </td>
  </tr>
  <tr>
  	<td>
      <div class="label">Customer:</div>
      <input type="text" name="data[Report][customer]" class="floatleft" />
    </td>
  </tr>
  <?
?>
  <tr>
    <td>
	  <div class="label">Report Form:</div><br style="clear: both" />
        <div class="select" id="first_recipient">
        	<span id="span_form_0">Select a form</span>
            <div class="options">
            	<? 
				foreach($forms as $f) {
				?>
				<a href="javascript: changeSelectVal('form_0','<?=$f['Forms']['id']?>','<?=$f['Forms']['name']?>')" class="option"><?=$f['Forms']['name']?></a>
                <? } ?>
            </div>
            <input id="select_form_0" value="" type="hidden" name="data[Forms][0]" />
        </div>
        
        <ul class="floatleft form">
    	<li><a href="javascript:add_recipient2();" class="button_smgr" title="add another form"><span>add another form</span></a></li>
    	</ul>
	</td>
  </tr>
  </table>
  <table id="more_forms">
  </table>
   <div class="fs_buttons">
  <a class="button_or floatright" id="report_next" href="javascript: document.ReportAdd.submit()"><span>Save & Next</span></a>
  </div>
        
        <? } ?>
  
  </fieldset>
  
  </div>
  
  <div id="temp"></div>
  
<!-- MAIN AREA END -->
