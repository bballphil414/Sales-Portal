<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>CMI Portal</title>
<link href="styles.css" rel="stylesheet" type="text/css" />
<script type="text/havascript">
function changeSelectVal(id, val) {
	var sel = document.getElementById("select_"+id);
	var span = document.getElementById("span_"+id);
	span.innerHTML = val;
}
</script>
	
</head>
<body>

<div id="content">
  <div id="top">
    <img id="logo" src="img/cmi_logo_gr.png" />
      <div id="topWelcome">
      <h3>Welcome, Admin</h3><br />
      <a class="crumbs" href="javascript:void();" title="Home">Home</a>
      </div>
      <div id="topDate">
      <?php echo date("m\/d\/y"); ?>
      </div>
    <div class="clear"><!--IE--></div>
  </div>
 
 <!-- MAIN AREA START -->
 
  <div id="main">
  
  <fieldset id="fs_newmessage">
  <legend>edit message</legend>
  <form>
  <table id="tb_newmessage">
  <tbody>
  <tr>
  	<td>
    	<div class="label">To:</div>
        <div class="select">
        	<span id="span_s">All Members</span>
            <div class="options">
            	<a href="javascript: changeSelectVal('s','something')" class="option">Something</a>
                <a href="#" class="option">Something Else</a>
                <a href="#" class="option last">Something last</a>
            </div>
            <select id="select_s" name="">
            	<option value="1"></option>
                <option value="2"></option>
            </select>
        </div>
        <ul class="floatleft form">
    	<li><a href="javascript:void();" class="button_smgr" title="add recipient"><span>add recipient</span></a></li>
    	</ul>
        <input type="checkbox" name="selectc" class="form_checkbox" />
        <div class="label label_smallpadding">Expires:</div>
        <input type="text" name="subject" size="15" />
    </td>
  </tr>
  <tr>
  	<td>
    	<div class="label">Subject:</div>
        <input type="text" name="subject" size="45" />
        <textarea name="message" cols="75" rows="7"></textarea>
    </td>
  </tr>
  </tbody>
  </table>
  
  <div class="fs_buttons">
  <a class="button_or" id="msg_send" href="javascript:void();"><span>send message</span></a>
  <a class="button_gr" id="msg_save" href="javascript:void();"><span>save draft</span></a>
  <a class="button_gr" id="msg_cancel" href="javascript:void();"><span>cancel</span></a>
  </div>
  
  </form>
  </fieldset>
  
  <fieldset id="fs_messages">
  <legend>saved messages - page 1 of 2<a class="button_gr floatright" style="margin-top: 2px" id="ex_adv" href="javascript:void();"><span>see sent messages</span></a></legend>
  <table id="tb_messages">
  <tbody>
  <tr>
  	<th>date</th>
    <th>subject</th>
    <th>sent by</th>
    <th>delete</th>
  </tr>
  <tr>
  	<td>08/12/09</td>
  	<td><a href="#">June 1st report?</a></td>
  	<td>Billy</td>
  	<td class="tb_tools">
        <ul>
        <li><a href="javascript:void();" title="delete"><img src="img/bt_del.gif" /></a></li>
        </ul>
	</td>
  </tr>
  <tr class="odd">
  	<td>&nbsp;</td>
  	<td>&nbsp;</td>
  	<td>&nbsp;</td>
  	<td class="tb_tools">
        <ul>
        <li><img src="img/bt_del_in.gif" /></li>
        </ul>
	</td>
  </tr>
    <tr>
  	<td>&nbsp;</td>
  	<td>&nbsp;</td>
  	<td>&nbsp;</td>
  	<td class="tb_tools">
        <ul>
        <li><img src="img/bt_del_in.gif" /></li>
        </ul>
	</td>
  </tr>
  </tbody>
  </table>
  
  </fieldset>
  
  
  </div>
  
<!-- MAIN AREA END -->
<!-- RIGHT COL START -->

  <div id="rightCol">

  <fieldset id="fs_file_library" class="rc_module">
  <legend>File LiBraRy</legend>
  <ul>
  	<li><a href="javascript:void();" title="Filename">Filename</a></li>
  	<li><a href="javascript:void();" title="Filename">Filename</a></li>
  	<li><a href="javascript:void();" title="Filename">Filename</a></li>
  	<li><a href="javascript:void();" title="Filename">Filename</a></li>
  	<li><a href="javascript:void();" title="Filename">Filename</a></li>
  	<li id="last"><a href="javascript:void();" title="Filename">Filename</a></li>
  </ul>  
    <a class="button_gr floatright" id="lib_all" href="javascript:void();"><span>see all files</span></a>
  </fieldset>
  
  <fieldset id="fs_contacts" class="rc_module">
  <legend>Contacts</legend>
  <ul>
  	<li>
    	<a href="javascript:void();" title="see more...">Contact Name<br />
  		Company Name<br />
        M: 888-888-8888</a>
    </li>
    <li id="last"><a href="javascript:void();" title="see more...">Short Contact Name</a></li>
  </ul>
  <a class="button_or" id="con_new" href="javascript:void();"><span>new contact</span></a>
  <a class="button_gr floatright" id="con_all" href="javascript:void();"><span>all contacts</span></a>

  </fieldset>

  </div>
</div>
</body>
</html>
