  <div id="content">
  <div id="top">
    <img id="logo" src="/site/img/cmi_logo_gr.png" />
      <div id="topWelcome">
      <h3>Welcome <? echo $session->read('Auth.User.first_name'); ?></h3><br />
	  <?php echo $html->link('Home', '/admin/dashboard', array('title'=>'Home', 'class'=>'crumbs')); ?> >> <?php echo $html->link('Stores', '/admin/stores', array('title'=>'Stores', 'class'=>'crumbs')); ?> >> <?php echo $html->link('New Store', '/admin/stores/edit/'.$s['Stores']['id'], array('title'=>'Edit Store', 'class'=>'crumbs')); ?>
      </div>
      <div id="topDate">
      <a href="/site/users/logout">Log Out</a> | <?php echo date("m\/d\/y"); ?>
      </div>
    <div class="clear"><!--IE--></div>
  </div>
 
 <!-- MAIN AREA START -->
  <div id="main">
  
  <fieldset id="fs_messages">
  <legend>Stores - Edit Store</legend>
  <form id="ReportAdd" name="ReportAdd" method="post" action="/site/admin/stores/edit/<?=$s['Stores']['id']?>" accept-charset="utf-8">
	<input type="hidden" name="_method" value="POST" />
  <table>
  <tr>
  	<td>
      <div class="label" style="width: 100px">Store #</div>
      <input type="text" name="data[Store][store_number]" class="floatleft" value="<?=$s['Stores']['store_number']?>" />
    </td>
  </tr>
    <tr>
  	<td>
      <div class="label" style="width: 100px">Store Name</div>
      <input type="text" name="data[Store][name]" class="floatleft" value="<?=$s['Stores']['name']?>"/>
    </td>
  </tr>
  <tr>
  	<td>
    	<div class="label" style="width: 100px">City</div>
        <input type="text" name="data[Store][city]" class="floatleft" value="<?=$s['Stores']['city']?>" />
    </td>
  </tr>
  <tr>
  	<td>
    	<div class="label" style="width: 100px">State</div>
        <input type="text" name="data[Store][state]" class="floatleft" value="<?=$s['Stores']['state']?>" />
    </td>
  </tr>
  </table> 
  </form>
  <div class="fs_buttons">
  <a class="button_gr floatleft" href="/site/admin/stores"><span>Cancel</span></a>
  <a class="button_or floatright" href="javascript: document.ReportAdd.submit()"><span>Save</span></a>
  </div>
  </fieldset>
  
  </div>