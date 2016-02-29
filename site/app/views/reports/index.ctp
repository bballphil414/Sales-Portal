<div id="content">
  <div id="top">
    <img id="logo" src="/site/img/cmi_logo_gr.png" />
      <div id="topWelcome">
      <h3>Welcome <? echo $session->read('Auth.User.first_name'); ?></h3><br />
	  <?php echo $html->link('Home', '/dashboard', array('title'=>'Home', 'class'=>'crumbs')); ?> >> <?php echo $html->link('Reports', '/reports', array('title'=>'Reports', 'class'=>'crumbs')); ?>
      </div>
      <div id="topDate">
      <a href="/site/users/logout">Log Out</a> | <?php echo date("m\/d\/y"); ?>
      </div>
    <div class="clear"><!--IE--></div>
  </div>
 
 <!-- MAIN AREA START -->
 
  <div id="main">

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
  if(count($reports) == 0) {
	  ?>
  <tr><td>You have no reports listed.</td></tr>
  <? } 
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
        <li><? echo $html->link('<span>view</span>', array('controller' => 'reports', 'action' => 'view', $r['ReportsRecipients']['id']), array('title'=>'view', 'escape'=>false, 'class'=>'button_smgr')) ?></li>
        <!--<li><a href="javascript:void();" title="edit"><img src="../img/bt_edit.gif" /></a></li>-->
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
  </fieldset>

  </div>
  
<!-- MAIN AREA END -->