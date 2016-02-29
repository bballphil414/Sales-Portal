  <div id="content">
  <div id="top">
    <img id="logo" src="/site/img/cmi_logo_gr.png" />
      <div id="topWelcome">
      <h3>Welcome <? echo $session->read('Auth.User.first_name'); ?></h3><br />
	  <?php echo $html->link('Home', '/admin/dashboard', array('title'=>'Home', 'class'=>'crumbs')); ?> >> <?php echo $html->link('Vendors', '/admin/vendors', array('title'=>'Vendor', 'class'=>'crumbs')); ?> >> <?php echo $html->link('New Vendor', '/admin/vendors/new', array('title'=>'New Vendor', 'class'=>'crumbs')); ?>
      </div>
      <div id="topDate">
      <a href="/site/users/logout">Log Out</a> | <?php echo date("m\/d\/y"); ?>
      </div>
    <div class="clear"><!--IE--></div>
  </div>
 
 <!-- MAIN AREA START -->
 
  <div id="main">
  
  <fieldset id="fs_messages">
  <legend>Vendors - Add Vendor</legend>
  <form id="ReportAdd" name="ReportAdd" method="post" action="/site/admin/vendors/new" accept-charset="utf-8">
	<input type="hidden" name="_method" value="POST" />
  <table>
  <tr>
  	<td>
      <div class="label" style="width: 100px">Company Name</div>
      <input type="text" name="data[Vendor][company_name]" class="floatleft" />
    </td>
  </tr>
  </table> 
  </form>
  <div class="fs_buttons">
  <a class="button_gr floatleft" href="/site/admin/vendors"><span>Cancel</span></a>
  <a class="button_or floatright" href="javascript: document.ReportAdd.submit()"><span>Save</span></a>
  </div>
  </fieldset>
  </div>
  