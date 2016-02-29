<div id="content">
  <div id="top">
    <img id="logo" src="/site/img/cmi_logo_gr.png" />
      <div id="topWelcome">
      <h3>Welcome <? echo $session->read('Auth.User.first_name'); ?></h3><br />
	  <?php echo $html->link('Home', '/dashboard', array('title'=>'Home', 'class'=>'crumbs')); ?>
      </div>
      <div id="topDate">
      <a href="/site/users/logout">Log Out</a> | <?php echo date("m\/d\/y"); ?>
      </div>
    <div class="clear"><!--IE--></div>
  </div>
 
 <!-- MAIN AREA START -->
 
  <div id="main">
  
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
  	<td><a href="/site/messages/view/<?=$m['Messages']['id']?>"><?=$m['Messages']['subject']?></a></td>
  	<td><?=$m['User']['Users']['first_name']?> <?=$m['User']['Users']['last_name']?></td>
  	<td class="tb_tools">
        <ul>
        <li><a href="/site/messages/delete/<?=$m['Messages']['id']?>" title="delete" onclick="return confirm('Are you sure?');"><img src="/site/img/bt_del.gif" /></a></li>
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
  <a class="button_or" href="/site/messages/neww"><span>new message</span></a>
  <a class="button_gr floatright" href="/site/messages"><span>see all messages</span></a>
  </div>
  </fieldset><p></p>

  <fieldset id="fs_reports"><legend>reports</legend>
  <table id="tb_reports">
  <tbody>
  <tr>
  	<th>date</th>
    <th>customer</th>
    <th>last updated</th>
    <th>tools</th>
  </tr>
  <?
  if(count($reports) == 0) { ?>
  <tr><td>You have no reports.</td></tr>
  <? } ?>
  <?
  $i = 0;
  foreach($reports as $r) {
  ?>
  <tr <?=($i == 1 ? 'class="odd"': '')?>>
  <?
  ?>
  	<td><?=date("m/d/y", $r['ReportsRecipients']['timestamp'])?></td>
  	<td><?=$r['Reports']['customer']?></td>
  	<td><? if(strlen($r['ReportsRecipients']['last_updated_timestamp'] == 0)) {
		echo "Never"; } else { echo date("m/d/y g:ia", $r['ReportsRecipients']['last_updated_timestamp']); } ?></td>
  	<td class="tb_tools">
        <ul>
        <li><? echo $html->link('<span>edit</span>', array('controller' => 'reports', 'action' => 'view', $r['ReportsRecipients']['id']), array('title'=>'complete', 'escape'=>false, 'class'=>'button_smgr')) ?></li>
        </ul>
	</td>
  </tr>
  <? if($i == 1) {
	  $i = 0;
  } else {
	  $i = 1;
  }
  } ?>
  </tbody>
  </table>
  
  <div class="fs_buttons">
  <a class="button_gr floatright" id="rpt_older" href="/site/reports/"><span>see all my reports</span></a>
  </div>
  </fieldset><p></p>

  </div>
  
<!-- MAIN AREA END -->