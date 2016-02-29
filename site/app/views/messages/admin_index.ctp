<div id="content">
  <div id="top">
    <img id="logo" src="/site/img/cmi_logo_gr.png" />
      <div id="topWelcome">
      <h3>Welcome <? echo $session->read('Auth.User.first_name'); ?></h3><br />
	  <?php echo $html->link('Home', '/admin/dashboard', array('title'=>'Home', 'class'=>'crumbs')); ?> > <?php echo $html->link('Messages', '/admin/messages', array('title'=>'Messages', 'class'=>'crumbs')); ?>
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
  <legend>received messages</legend>
  <table id="tb_messages">
  <tbody>
  <tr>
  	<th>date</th>
    <th>subject</th>
    <th>sent by</th>
    <th>delete</th>
  </tr>
  <?
  if(count($from_messages) == 0) {
	  ?>
  <tr><td>You have no received messages.</td></tr>
  <? 
  } else {
  $i = 0;
  foreach($from_messages as $m) { ?>
  <tr<?=($i == 1 ? " class='odd'" : "")?>>
  	<td><?=date("m/d/y", $m['Messages']['timestamp'])?></td>
  	<td><a href="/site/admin/messages/view/<?=$m['Messages']['id']?>"><?=$m['Messages']['subject']?></a></td>
  	<td><?=$m['User']['Users']['first_name']?> <?=$m['User']['Users']['last_name']?></td>
  	<td class="tb_tools">
        <ul>
        <li><a href="/site/admin/messages/delete/<?=$m['Messages']['id']?>" title="delete" onclick="return confirm('Are you sure?');"><img src="/site/img/bt_del.gif" /></a></li>
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
  </fieldset>
  
  <fieldset id="fs_messages">
  <legend>sent messages</legend>
  <table id="tb_messages">
  <tbody>
  <tr>
  	<th>date</th>
    <th>subject</th>
    <th>sent to</th>
    <th>delete</th>
  </tr>
  <?
  if(count($to_messages) == 0) {
	  ?>
      
  <tr><td>You have not sent any messages.</td></tr>
  <? } else {
  $i = 0;
  foreach($to_messages as $m) { ?>
  <tr<?=($i == 1 ? " class='odd'" : "")?>>
  	<td><?=date("m/d/y", $m['Messages']['timestamp'])?></td>
  	<td><a href="/site/admin/messages/view/<?=$m['Messages']['id']?>"><?=$m['Messages']['subject']?></a></td>
  	<td><?=$m['User']['Users']['first_name']?> <?=$m['User']['Users']['last_name']?></td>
  	<td class="tb_tools">
        <ul>
        <li><a href="/site/admin/messages/delete/<?=$m['Messages']['id']?>" title="delete"><img src="/site/img/bt_del.gif" /></a></li>
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
  <a class="button_or" href="/site/admin/messages/new"><span>new message</span></a>
  </div>
  </fieldset>
  </div>
  
<!-- MAIN AREA END -->