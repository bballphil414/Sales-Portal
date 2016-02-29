  <div id="content">
  <div id="top">
    <img id="logo" src="/site/img/cmi_logo_gr.png" />
      <div id="topWelcome">
      <h3>Welcome <? echo $session->read('Auth.User.first_name'); ?></h3><br />
	  <?php echo $html->link('Home', '/admin/dashboard', array('title'=>'Home', 'class'=>'crumbs')); ?> >> <?php echo $html->link('Vendors', '/admin/vendors', array('title'=>'Vendor', 'class'=>'crumbs')); ?> >> <?php echo $html->link('Edit Vendor', '/admin/vendors/edit'.$v['Vendors']['id'], array('title'=>'Edit Vendor', 'class'=>'crumbs')); ?>
      </div>
      <div id="topDate">
      <a href="/site/users/logout">Log Out</a> | <?php echo date("m\/d\/y"); ?>
      </div>
    <div class="clear"><!--IE--></div>
  </div>
 
 <!-- MAIN AREA START -->
 
  <div id="main">
  
  <fieldset id="fs_messages">
  <legend>Vendors - Edit Vendor</legend>
  <form id="ReportAdd" name="ReportAdd" method="post" action="/site/admin/vendors/edit/<?=$v['Vendors']['id']?>" accept-charset="utf-8">
	<input type="hidden" name="_method" value="POST" />
  <table>
  <tr>
  	<td>
      <div class="label" style="width: 100px">Company Name</div>
      <input type="text" name="data[Vendor][company_name]" class="floatleft" value="<?=$v['Vendors']['company_name']?>" />
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
  