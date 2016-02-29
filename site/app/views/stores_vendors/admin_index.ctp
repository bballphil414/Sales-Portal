<div id="content">
  <div id="top">
    <img id="logo" src="/site/img/cmi_logo_gr.png" />
      <div id="topWelcome">
      <h3>Welcome <? echo $session->read('Auth.User.first_name'); ?></h3><br />
	  <?php echo $html->link('Home', '/admin/dashboard', array('title'=>'Home', 'class'=>'crumbs')); ?> >> <?php echo $html->link('Stores Vendor Pairs', '/admin/storesvendors', array('title'=>'Store Vendor Pairs', 'class'=>'crumbs')); ?>
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
  <legend>store vendor pairs</legend>
  <table id="tb_messages">
  <tbody>
  <tr>
    <th>Store #</th>
    <th>Store Name</th>
    <th>Vendor Name</th>
    <th>options</th>
  </tr>
  <?
  if(count($storesvendors) == 0) {
	  ?>
  <tr><td>No stores vendor pairs exist in the database.</td></tr>
  <? 
  } else {
  $i = 0;
  foreach($storesvendors as $sv) { ?>
  <tr<?=($i == 1 ? " class='odd'" : "")?>>
  	<td><?=$sv['StoresVendors']['Stores']['Stores']['store_number']?></td>
  	<td><?=$sv['StoresVendors']['Stores']['Stores']['name']?></td>
    <td><?=$sv['StoresVendors']['Vendors']['Vendors']['company_name']?></td>
  	<td class="tb_tools">
        <ul>
        <li><a href="/site/admin/storesvendors/delete/<?=$sv['StoresVendors']['id']?>" title="delete" onclick="return confirm('Are you sure?);"><img src="/site/img/bt_del.gif" /></a></li>
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
  <a class="button_or" href="/site/admin/storesvendors/new"><span>new store vendor pair</span></a>
  </div>
  
  </fieldset>
  </div>
  
<!-- MAIN AREA END -->