<div id="content">
  <div id="top">
    <img id="logo" src="/site/img/cmi_logo_gr.png" />
      <div id="topWelcome">
      <h3>Welcome <? echo $session->read('Auth.User.first_name'); ?></h3><br />
	  <?php echo $html->link('Home', '/admin/dashboard', array('title'=>'Home', 'class'=>'crumbs')); ?> >> <?php echo $html->link('Stores', '/admin/stores', array('title'=>'Stores', 'class'=>'crumbs')); ?>
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
  <legend>stores</legend>
  <table id="tb_messages">
  <tbody>
  <tr>
    <th>store #</th>
    <th>name</th>
    <th>city</th>
    <th>state</th>
    <th>options</th>
  </tr>
  <?
  if(count($stores) == 0) {
	  ?>
  <tr><td>No stores exist in the database.</td></tr>
  <? 
  } else {
  $i = 0;
  foreach($stores as $s) { ?>
  <tr<?=($i == 1 ? " class='odd'" : "")?>>
  	<td><?=$s['Stores']['store_number']?></td>
    <td><?=$s['Stores']['name']?></td>
  	<td><?=$s['Stores']['city']?></td>
    <td><?=$s['Stores']['state']?></td>
  	<td class="tb_tools">
        <ul>
        <li><a href="/site/admin/stores/edit/<?=$s['Stores']['id']?>" title="edit"><img src="/site/img/bt_edit.gif" /></a></li>
        <li><a href="/site/admin/stores/delete/<?=$s['Stores']['id']?>" title="delete" onclick="return confirm('Are you sure?  This will remove all vendor connections as well.');"><img src="/site/img/bt_del.gif" /></a></li>
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
  <a class="button_or" href="/site/admin/stores/new"><span>new store</span></a>
  </div>
  
  </fieldset>
  </div>
  
<!-- MAIN AREA END -->