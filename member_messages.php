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
      <h3>Welcome Membername</h3><br />
      <a class="crumbs" href="javascript:void();" title="Home">Home</a>
      </div>
      <div id="topDate">
      <?php echo date("m\/d\/y"); ?>
      </div>
    <div class="clear"><!--IE--></div>
  </div>
 
 <!-- MAIN AREA START -->
 
  <div id="main">
  
  <fieldset id="fs_messages"><legend>Messages</legend>
  <div class="message">
  	<ul class="floatright">
    	<li><a href="javascript:void();" class="button_smgr" title="reply"><span>reply</span></a></li>
    	<li><a href="javascript:void();" class="button_smgr" title="save"><span>save</span></a></li>
        <li><a href="javascript:void();" title="delete"><img src="img/bt_del.gif" /></a></li>
    </ul>
  <strong>July 1st report?</strong>
  <div class="msg_meta">07/05/10 - Message to YOU from ADMIN</div>
  Billy, can you submit your last report? It’s currently in draft mode and needs to be submited before we can accurately compile the information. See, this awesome new tool is only as good
as the people who use it and we need to make sure our internal processes are up to speed.<br /><br />Thanks for your understanding<br />Teh Admin
  </div>  

  <legend>saved messages</legend>
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
  
  <legend>new message</legend>
  <form>
  <table id="tb_newmessage">
  <tbody>
  <tr>
  	<td>
    	<div class="label">To:</div>
        <div class="select">
        	<span id="span_s">Select a Recipient</span>
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
    </td>
  </tr>
  <tr class="odd">
  	<td>
    	<div class="label">CC:</div>
        <div class="select">
        	<span id="span_c">...custom email address...</span>
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
        <input type="text" name="email" size="30" class="form_input" />
        <input type="checkbox" name="bcc" class="form_checkbox" />
        <span class="bcc">BCC</span>
         <ul class="floatright form del">
        <li><img src="img/bt_del_in.gif" /></li>
        </ul>
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
