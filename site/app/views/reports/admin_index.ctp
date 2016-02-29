<div id="content">
  <div id="top">
    <img id="logo" src="/site/img/cmi_logo_gr.png" />
      <div id="topWelcome">
      <h3>Welcome <? echo $session->read('Auth.User.first_name'); ?></h3><br />
	  <?php echo $html->link('Home', '/admin/dashboard', array('title'=>'Home', 'class'=>'crumbs')); ?> >> <?php echo $html->link('Reports', '/admin/reports', array('title'=>'Reports', 'class'=>'crumbs')); ?>
      </div>
      <div id="topDate">
      <a href="/site/users/logout">Log Out</a> | <?php echo date("m\/d\/y"); ?>
      </div>
    <div class="clear"><!--IE--></div>
  </div>
 
 <!-- MAIN AREA START -->
 
  <div id="main">

  <fieldset id="fs_reports"><legend>sent reports</legend>
  <table id="tb_reports">
  <tbody>
  <tr>
  	<th>date</th>
    <th>customer</th>
    <th>recipient</th>
    <th>last updated</th>
    <th>tools</th>
  </tr>
  <?
  if(count($reports) == 0) {
	  ?>
  <tr><td>You have no sent reports listed in the database.</td></tr>
  <? } 
  $i = 0;
  foreach($reports as $r) {
	  ?>
	<tr <?=($i == 1 ? 'class="odd"': '')?>>
  <?
  ?>
  	<td><?=date("m/d/y", $r['ReportsRecipients']['timestamp'])?></td>
  	<td><?=$r['Reports']['customer']?></td>
    <td><?=$r['Users']['Users']['first_name'] . " " . $r['Users']['Users']['last_name']?></td>
  	<td><? if(strlen($r['ReportsRecipients']['last_updated_timestamp'] == 0)) {
		echo "Never"; } else { echo date("m/d/y g:ia", $r['ReportsRecipients']['last_updated_timestamp']); } ?></td>
  	<td class="tb_tools">
        <ul>
            <li><? echo $html->link('<span>view</span>', array('controller' => 'reports', 'action' => 'view', $r['ReportsRecipients']['id']), array('title'=>'view', 'escape'=>false, 'class'=>'button_smgr')) ?></li>
        <!--<li><a href="javascript:void();" title="edit"><img src="../img/bt_edit.gif" /></a></li>-->
        <li class="floatright"><a href="/site/admin/reports/delete_rr/<?=$r['ReportsRecipients']['id']?>" onclick="return confirm('Are you sure?  This will delete sent report.');" title="delete"><img src="/site/img/bt_del.gif" /></a></li>
        </ul>
	</td>
  </tr>
  <?
  if($i == 0) {
	  $i = 1;
  } else {
	  $i = 0;
  }
  }
  ?>
  </tbody>
  </table>
  
  
  <legend>report drafts</legend>
  <table id="tb_reports">
  <tbody>
  <tr>
  	<th>name</th>
    <th>customer</th>
    <th>tools</th>
  </tr>
  <?
  if(count($r2) == 0) {
	  ?>
  <tr><td>You have no reports listed in the database.</td></tr>
  <? } 
  $i = 0;
  foreach($r2 as $r) {
	  ?>
	<tr <?=($i == 1 ? 'class="odd"': '')?>>
  <?
  ?>
  	<td><?=$r['Reports']['name']?></td>
  	<td><?=$r['Reports']['customer']?></td>
  	<td class="tb_tools">
        <ul>
        <!--<li><a href="javascript:void();" title="edit"><img src="../img/bt_edit.gif" /></a></li>-->
        <li><? echo $html->link('<span>send</span>', array('controller' => 'reports', 'action' => 'send_report', $r['Reports']['id']), array('title'=>'send', 'escape'=>false, 'class'=>'button_smgr')) ?></li>
        <li><a href="/site/admin/reports/delete/<?=$r['Reports']['id']?>" onclick="return confirm('Are you sure?  This will delete report draft and make it unusable for future entries.');" title="delete"><img src="/site/img/bt_del.gif" /></a></li>
        </ul>
	</td>
  </tr>
  <?
  if($i == 0) {
	  $i = 1;
  } else {
	  $i = 0;
  }
  }
  ?>
  </tbody>
  </table>
  
  <div class="fs_buttons">
  <a class="button_or" id="rpt_new" href="/site/admin/reports/new_report"><span>new report</span></a>
  </div>
  </fieldset>
  

  </div>
  
<!-- MAIN AREA END -->