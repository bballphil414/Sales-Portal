<div id="content">
  <div id="top">
    <img id="logo" src="/site/img/cmi_logo_gr.png" />
      <div id="topWelcome">
      <h3>Welcome <? echo $session->read('Auth.User.first_name'); ?></h3><br />
	  <?php echo $html->link('Home', '/admin/dashboard', array('title'=>'Home', 'class'=>'crumbs')); ?> >> <?php echo $html->link('Vendors', '/admin/vendors', array('title'=>'Vendors', 'class'=>'crumbs')); ?>
      </div>
      <div id="topDate">
      <a href="/site/users/logout">Log Out</a> | <?php echo date("m\/d\/y"); ?>
      </div>
    <div class="clear"><!--IE--></div>
  </div>
 
 <!-- MAIN AREA START -->
 
  <div id="main">
  <?
  ?>
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
  </div>
  
<!-- MAIN AREA END -->