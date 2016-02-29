<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>CMI Portal</title>
<link href="styles.css" rel="stylesheet" type="text/css" />
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
  
  <fieldset id="fs_messages"><legend>Messages<a href="javascript:void();" class="button_smgr fieldtools"><span>test</span></a></legend>
  <div class="message highlight">
  	<ul class="floatright">
    	<li><a href="javascript:void();" class="button_smgr" title="save"><span>save</span></a></li>
        <li><a href="javascript:void();" title="delete"><img src="img/bt_del.gif" /></a></li>
    </ul>
  <strong>Message Subject</strong>
  <div class="msg_meta">08/01/10 - Message to ALL MEMBERS</div>
  Message content
  </div>
  
  <div class="message">
  	<ul class="floatright">
    	<li><a href="javascript:void();" class="button_smgr" title="reply"><span>reply</span></a></li>
    	<li><a href="javascript:void();" class="button_smgr" title="save"><span>save</span></a></li>
        <li><a href="javascript:void();" title="delete"><img src="img/bt_del.gif" /></a></li>
    </ul>
  <strong>old message</strong>
  <div class="msg_meta">08/01/10 - Message to YOU from ADMIN</div>
  Message content
  </div>
  
  <div class="fs_buttons">
  <a class="button_or" id="msg_new" href="javascript:void();"><span>new message</span></a>
  <a class="button_gr floatright" id="msg_saved" href="javascript:void();"><span>see saved messages</span></a>
  </div>
  
  </fieldset>

  <fieldset id="fs_reports"><legend>reports</legend>
  <table id="tb_reports">
  <tbody>
  <tr>
  	<th>date</th>
    <th>store name</th>
    <th>store #</th>
    <th>location</th>
    <th>status</th>
    <th>tools</th>
  </tr>
  <tr class="highlight">
  	<td>&nbsp;</td>
  	<td>&nbsp;</td>
  	<td>&nbsp;</td>
  	<td>&nbsp;</td>
  	<td>&nbsp;</td>
  	<td class="tb_tools">
        <ul>
        <li><a href="javascript:void();" title="edit"><img src="img/bt_edit.gif" /></a></li>
        <li><a href="javascript:void();" title="submit"><img src="img/bt_check.gif" /></a></li>
        <li><a href="javascript:void();" title="delete"><img src="img/bt_del.gif" /></a></li>
        </ul>
	</td>
  </tr>
  <tr class="odd">
  	<td>&nbsp;</td>
  	<td>&nbsp;</td>
  	<td>&nbsp;</td>
  	<td>&nbsp;</td>
  	<td>&nbsp;</td>
  	<td class="tb_tools">
        <ul>
        <li><img src="img/bt_edit_in.gif" /></li>
        <li><img src="img/bt_check_in.gif" /></li>
        <li><img src="img/bt_del_in.gif" /></li>
        </ul>
	</td>
  </tr>
    <tr>
  	<td>&nbsp;</td>
  	<td>&nbsp;</td>
  	<td>&nbsp;</td>
  	<td>&nbsp;</td>
  	<td>&nbsp;</td>
  	<td class="tb_tools">
        <ul>
        <li><img src="img/bt_edit_in.gif" /></li>
        <li><img src="img/bt_check_in.gif" /></li>
        <li><img src="img/bt_del_in.gif" /></li>
        </ul>
	</td>
  </tr>
  </tbody>
  </table>
  
  <div class="fs_buttons">
  <a class="button_or" id="rpt_new" href="javascript:void();"><span>new report</span></a>
  <a class="button_gr floatright" id="rpt_older" href="javascript:void();"><span>see older reports</span></a>
  </div>
  </fieldset>
  
  <fieldset id="fs_quick_export"><legend>Quick Export</legend>
  <strong>June 1, 2010 - July 31, 2010</strong><a class="bt_date" href="javascript:void();" title="edit date range"><img src="img/bt_date.gif" /></a>
  <ul class="floatright">
    <li><a class="button_or" id="ex_xls" href="javascript:void();"><span>xls</span></a></li>
    <li><a class="button_or" id="ex_pdf" href="javascript:void();"><span>pdf</span></a></li>
    <li><a class="button_gr" id="ex_adv" href="javascript:void();"><span>advanced options</span></a></li>
  </ul>
  </fieldset>
  
  <fieldset id="fs_members">
  <legend>members</legend>
  
  <table id="tb_reports">
  <tbody>
  <tr>
  	<th>Name</th>
    <th>Phone</th>
    <th>Location</th>
    <th>Category</th>
    <th>Tools</th>
  </tr>
  <tr>
  	<td>&nbsp;</td>
  	<td>&nbsp;</td>
  	<td>&nbsp;</td>
  	<td>&nbsp;</td>
  	<td class="tb_tools tb_users">
        <ul>
        <li><a href="javascript:void();" class="button_smgr" title="save"><span>edit</span></a></li>
        <li><a href="javascript:void();" title="delete"><img src="img/bt_del.gif" /></a></li>
        </ul>
	</td>
  </tr>
  <tr class="odd">
  	<td>&nbsp;</td>
  	<td>&nbsp;</td>
  	<td>&nbsp;</td>
  	<td>&nbsp;</td>
  	<td class="tb_tools tb_users">
        <ul>
        <li><a href="javascript:void();" class="button_smgr" title="save"><span>edit</span></a></li>
        <li><img src="img/bt_del_in.gif" /></li>
        </ul>
	</td>
  </tr>
    <tr>
  	<td>&nbsp;</td>
  	<td>&nbsp;</td>
  	<td>&nbsp;</td>
  	<td>&nbsp;</td>
  	<td class="tb_tools tb_users">
        <ul>
        <li><a href="javascript:void();" class="button_smgr" title="save"><span>edit</span></a></li>
        <li><img src="img/bt_del_in.gif" /></li>
        </ul>
	</td>
  </tr>
  </tbody>
  </table>
  
  
  <div class="fs_buttons">
  <a class="button_or" id="m_new" href="javascript:void();"><span>new member</span></a>
  <a class="button_gr floatright" id="m_users" href="javascript:void();"><span>see all users</span></a>
  </div>
  
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
