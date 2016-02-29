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

  <fieldset id="fs_aemember">
  <legend>New Member</legend>
  
  <table>
  <tr>
  	<td>
      <div class="label label_newmember">Name:</div>
      <input type="text" name="name" class="floatleft" />
    </td>
  </tr>
  <tr>
    <td>
      <div class="label label_newmember">Email:</div>
      <input type="text" name="email" class="floatleft" />
      <div class="label"><- Member Username</div>
    </td>
  </tr>
  <tr>
  	<td>
      <input type="checkbox" class="form_checkbox3" />
      <div class="label">Send Welcome Email</div>
    </td>
  </tr>
  </table> 
  
  <legend>Member Permissions</legend>
  
  <table>
  <tr>
    <td>
      <input type="checkbox" class="form_checkbox3" />
      <div class="label">Reports</div>
    </td>
  </tr>
  <tr>
    <td>
      <input type="checkbox" class="form_checkbox3" />
      <div class="label">File Library</div>
      <ul class="floatleft form">
        <li><a href="javascript:void();" class="button_smgr" title="save"><span>select folders</span></a></li>
      </ul>
    </td>
  </tr>
  <tr>
    <td>
      <input type="checkbox" class="form_checkbox3" />
      <div class="label">Messages</div>
    </td>
  </tr>
  </table>
  
  <div class="fs_buttons">
  <a class="button_or" id="u_save" href="javascript:void();"><span>save</span></a>
  <a class="button_gr" id="u_cancel" href="javascript:void();"><span>cancel</span></a>
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
