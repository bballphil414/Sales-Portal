<!--<script type="text/javascript">

function addSuggestion() {
	$.ajax({
  		url: "/site/admin/suggestions/add",
  		cache: false,
 		type: "POST",
  		data: "data[Suggestions][type]="+$('#suggestions_type').val()+"&data[Suggestions][suggestion]="+$('#suggestions_suggestion').val()+"",
  		success: function(html){
    			$("#suggestions_form").html(html);
		}
	});
}
</script>-->
<?
if(!isset($login)) {
?>
<div id="rightCol">


	<?
	if($session->read('Auth.User.admin') == "Yes") {
		?>
    <fieldset class="rc_module" id="fs_logs">
    <legend>Logs</legend>
     <div class="rc_buttons">
    <a class="button_or floatright" id="lib_all" href="/site/admin/logs"><span>view logs</span></a>
  </div>
</fieldset>
  <p></p>
  <? } ?>


    <!--<fieldset class="rc_module" id="fs_suggestions">
    <legend>Feedback</legend>
	<form id="suggestions_form" name="" action="" method="POST">
	<select id="suggestions_type">
		<option value="Request">Request a Feature</option>
		<option value="Problem">Report a Problem</option>
		<option value="Help">Ask for Help</option>
		<option value="Other">Other</option>
	</select>
	<textarea id="suggestions_suggestion" cols="27" rows="3" onfocus="this.innerHTML=''">Type here</textarea>
	</form>
     <div class="rc_buttons">
	<a class="button_or floatright" id="lib_all" href="javascript: addSuggestion()"><span>add suggestion</span></a>&nbsp;&nbsp;
<?
	if($session->read('Auth.User.admin') == "Yes") {
		?>
    <a class="button_gr floatright" id="lib_all" href="/site/admin/suggestions"><span>view all</span></a>
<? } ?>

  </div>
</fieldset>
  <p></p>-->
  
  
	<? if(!isset($isfiles)) { ?>
  <fieldset class="rc_module" id="fs_file_library">
  <legend>File LiBraRy</legend>
  <ul>
  	<?
	if(count($files) == 0) {
		?>
        <li>You have no files uploaded.</li>
        <?
	}
	$i = 0;
	foreach($files as $f) {
	?>
  	<li<?=($i == (count($files)-1) ? " class='last'" : "")?>><a href="/uploads/<?=$f['Files']['file']?>" title="<?=$f['Files']['file']?>"><?=$f['Files']['file']?></a></li>
  	<?
		$i++;
	}
	?>
	
  </ul>
  <div class="rc_buttons">
    <a class="button_gr floatright" id="lib_all" href="/site/file_library"><span>see all files</span></a>
  </div>
</fieldset>
  <p></p>
  
  
  <? } else { ?>
  <fieldset id="fs_file_upload" class="rc_module">
  <legend>upload file</legend>
  <form name="uploadFile" enctype="multipart/form-data" action="/site/file_library/upload" method="post">
  <input type="file" name="file" id="browse" value="" />
  <select name="data[Files][dir]" />
  <option value="" SELECTED>Select Option</option>
  				<option value="0">Root</option>
    <?
				function children2($dirs, $id, $i) {
					foreach($dirs as $d) {
						if($d['Directories']['id'] != $id && $d['Directories']['directory_id'] == $id) {
							// show
							$s = "-";
							for($i2 = 0; $i2 < $i; $i2++) {
								$s .= "-";
							}
							?><option value="<?=$d['Directories']['id']?>"><?=$s?> <?=$d['Directories']['name']?></option>
                            <?
							children2($dirs, $d['Directories']['id'], $i+1);
						}
					}
					return true;
				}
				
				foreach($dirs as $d) {
					if($d['Directories']['directory_id'] == 0) {
						// display folder
						?>
                    	<option value="<?=$d['Directories']['id']?>">- <?=$d['Directories']['name']?></option>
                    	<?
						children2($dirs, $d['Directories']['id'], 1);
					}
				}
				?>
  </select>
  </form>
  <div class="rc_buttons">
    <a class="button_or floatleft" id="upload" href="javascript:void(0);" onclick="document.uploadFile.submit()"><span>upload file</span></a>
    <a class="button_gr floatright" id="upload" href="javascript:void(0);" onclick="open_window()"><span>new folder</span></a>
  </div>
  </fieldset>
  <p></p>
  <? } ?>
  
  <?
  if(!isset($name)) { ?>
  <fieldset id="fs_contacts" class="rc_module">
  <legend>Contacts</legend>
  <ul>
  	<?
	$i = 0;
	foreach($contacts as $c) {
		?>
  	<li<?=($i == (count($contacts)-1) ? " class='last'" : "")?>>
    	<a href="mailto:<?=$c['Contacts']['email']?>" title="send email"><?=$c['Contacts']['name']?><br />
  		<?=$c['Contacts']['company_name']?><br />
        M: <?=$c['Contacts']['phone_number']?></a>
    </li>
    <?
	$i++;
	} ?>
    <!--
    <li id="last"><a href="javascript:void();" title="see more...">Short Contact Name</a></li>-->
  </ul>
  <div class="rc_buttons">
    <a class="button_or" id="con_new" href="/site/contacts/index/0"><span>new contact</span></a>
    <a class="button_gr floatright" id="con_all" href="/site/contacts"><span>all contacts</span></a>
  </div>
  </fieldset>
  <p></p>
	<? } ?>
  </div>
<? } ?>
<?
echo $javascript->link('jquery');

if(isset($isfiles)) {
?>

<script type="text/javascript">
function addFolder() {
	var text = "";
	text = $("input[name=PARENT_FOLDER]").val();
	var name = $("input[name=FOLDER_NAME]").val();
$.ajax({
  url: '/site/file_library/new_folder',
  type: "POST",
  data: "data[Directories][directory_id]="+text+"&data[Directories][name]="+name+"",
  success: function(data) {
	if(data == "error") {
		alert("Sorry, there was an error.  Please try again or contact the webmaster.");
	} else {
		location.reload(true);
	}
	close();
  }
});
}

function open_window() {
	var ob = document.getElementById("new_folder");
	ob.style.display = "block";
	HTML = ob.innerHTML;
}

function close() {
	var ob = document.getElementById("new_folder")
	ob.style.display = "none";
	ob.innerHTML = HTML;
}

var HTML = "";

function changeSelectVal(id, val, string) {
	var span = document.getElementById("span_"+id);
	span.innerHTML = string;
	var input = document.getElementById("select_"+id);
	input.value=val;
}

</script>

<div id="new_folder" style="display: none; position: absolute; z-index: 99; top: 150px; left: 400px; border: 1px #010101 solid; opacity: 0.95; background-color: #FFF; padding: 5px">
  	<fieldset id="fs_messages">
    <legend>Add Folder<a href="javascript:close();" class="button_smgr fieldtools" title="close"><span>close</span></a></legend>
    <table>
    <tbody id="field_add_area">
    <tr>
    <td>
	  <div class="label"><strong>Select Parent Folder:</strong></div>
        <div class="select" id="">
        	<span id="span_add_type">Select Folder</span>
            <div class="options">
            	<a href="javascript: changeSelectVal('add_type', '0', 'Root')" class="option">Root</a>
            	<?
				function children($dirs, $id, $i) {
					foreach($dirs as $d) {
						if($d['Directories']['id'] != $id && $d['Directories']['directory_id'] == $id) {
							// show
							$s = "-";
							for($i2 = 0; $i2 < $i; $i2++) {
								$s .= "-";
							}
							?><a href="javascript: changeSelectVal('add_type','<?=$d['Directories']['id']?>','<?=$d['Directories']['name']?>')" class="option"><?=$s?> <?=$d['Directories']['name']?></a>
                            <?
							children($dirs, $d['Directories']['id'], $i+1);
						}
					}
					return true;
				}
				
				foreach($dirs as $d) {
					if($d['Directories']['directory_id'] == 0) {
						// display folder
						?>
                    	<a href="javascript: changeSelectVal('add_type','<?=$d['Directories']['id']?>','<?=$d['Directories']['name']?>')" class="option">- <?=$d['Directories']['name']?></a>
                    	<?
						children($dirs, $d['Directories']['id'], 1);
					}
				}
				?>
            </div>
            <form>
            
            <input id="select_add_type" value="" type="hidden" name="PARENT_FOLDER" />
            
        </div>
	</td>
    <td>
    	<div class="label"><strong>Folder Name:</strong></div>
        <input type="text" name="FOLDER_NAME" />
     </td>
  </tr>
  </tbody>
    </table>
    <div class="rc_buttons floatright">
        	<a class="button_or" style="margin-right: 10px" id="add_button" href="javascript: addFolder();"><span>Add</span></a>
        </div>
    </fieldset>
	<p></p>
  </div>
  <? } ?>
  
  <?
  if(isset($step)) {
	  ?>
	  <div id="new_field" style="display: none; position: absolute; left: 200px; z-index: 99; top: 150px; opacity: 0.95; background-color: #FFF; padding: 5px">
  	<fieldset id="fs_messages"><legend>Add Field<a href="javascript: window_close();" class="button_smgr fieldtools" title="close"><span>close</span></a></legend>
    <table>
  	<tr>
  		<td style="text-align: center; font-style: italic">You are adding a field to the <span id="cat">General</span> category on this form.</td>
    </tr>
    </table>
    <table id="field_add_area">
    <tr>
    <td>
	  <div class="label"><strong>Field Type:</strong></div>
        <div class="select" id="">
        	<span id="span_add_type">Select Type</span>
            <div class="options">
				<a href="javascript: changeSelectVal('add_type','checkbox','Checkbox')" class="option">Checkbox</a>
                <a href="javascript: changeSelectVal('add_type','dropdown', 'DropDown')" class="option">DropDown</a>
                <a href="javascript: changeSelectVal('add_type','text_question', 'Text Question')" class="option">Text Question</a>
            </div>
            <form>
            
            <input id="select_add_type" value="" type="hidden" name="data[Report][field_type]" />
            
            </form>
        </div>
	</td>
  </tr>
  </table>
  <table id="more_recipients">
  </table>
    <div id="field_link" class="fs_buttons">
        	<a class="button_or floatright" style="margin-right: 10px" id="add_button" href="javascript: checkAdd_Field();"><span>Next</span></a>
        </div>
    </fieldset>
  </div>
  <? } ?>