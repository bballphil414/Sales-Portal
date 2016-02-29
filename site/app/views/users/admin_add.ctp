<div id="content">
  <div id="top">
    <img id="logo" src="/site/img/cmi_logo_gr.png" />
      <div id="topWelcome">
      <h3>Welcome <? echo $session->read('Auth.User.first_name'); ?></h3><br />
	  <?php echo $html->link('Home', '/admin/dashboard', array('title'=>'Home', 'class'=>'crumbs')); ?> >> <?php echo $html->link('Manage Users', '/admin/users', array('title'=>'Manage Users', 'class'=>'crumbs')); ?> >> <?php echo $html->link('New User', '/admin/users/add', array('title'=>'New User', 'class'=>'crumbs')); ?>
      </div>
      <div id="topDate">
      <?php echo date("m\/d\/y"); ?>
      </div>
    <div class="clear"><!--IE--></div>
  </div>
 
 <!-- MAIN AREA START -->
 
  <div id="main">
  
  <fieldset id="fs_aemember">
	
  <legend>New Member</legend>
  
  <form id="UserAdd" name="UserAdd" method="post" action="/site/admin/users/add" accept-charset="utf-8">
	<input type="hidden" name="_method" value="POST" />
  <table>
  <tr>
  	<td>
      <div class="label label_newmember">Name:</div>
      <input type="text" name="data[User][first_name]" class="floatleft" />
    </td>
  </tr>
  <tr>
  	<td>
    	<div class="label label_newmember">Password:</div>
        <input type="text" name="data[User][password_2]" class="floatleft" />
    </td>
  </tr>
  <tr>
    <td>
      <div class="label label_newmember">Email:</div>
      <input type="text" name="data[User][username]" class="floatleft" />
      <div class="label"><- Member Username</div>
    </td>
  </tr>
  <tr>
  	<td>
      <input name="data[Other][send_email]" type="checkbox" value="Yes" class="form_checkbox3" />
      <div class="label">Send Welcome Email</div>
    </td>
  </tr>
  </table> 
  
  <!--<legend>Member Permissions</legend>
  
  <table>
  <tr>
    <td>
      <input type="checkbox" name="data[User][checkbox_reports]" class="form_checkbox3" value="Yes" />
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
      <input type="checkbox" name="data[User][checkbox_messages]" class="form_checkbox3" value="Yes" />
      <div class="label">Messages</div>
    </td>
  </tr>
  </table>
  -->
  
  <div class="fs_buttons">
  <a class="button_or" id="u_save" href="javascript: document.UserAdd.submit()"><span>save</span></a>
  <a class="button_gr" id="u_cancel" href="/site/admin/users"><span>cancel</span></a>
  </div>
  
  </form>
  </fieldset>
</div>