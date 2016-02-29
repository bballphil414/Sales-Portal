<div id="content">
  <div id="top">
    <img id="logo" src="/site/img/cmi_logo_gr.png" />
      <div id="topWelcome">
      <h3>Welcome <? echo $session->read('Auth.User.first_name'); ?></h3><br />
	  <?php echo $html->link('Home', '/admin/dashboard', array('title'=>'Home', 'class'=>'crumbs')); ?>
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
  <div class="fs_buttons">
  <a class="button_or" href="/site/admin/messages/new"><span>new message</span></a>
  <a class="button_gr floatright" href="/site/admin/messages"><span>see all messages</span></a>
  </div>
  </fieldset><p></p>

  <fieldset id="fs_reports"><legend>reports</legend>
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
  
  if(count($reports) == 0) { ?>
  <tr><td>You have no reports in the database.</td></tr>
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
    <td><?=$r['Users']['Users']['first_name'] . " " . $r['Users']['Users']['last_name']?></td>
  	<td><? if(strlen($r['ReportsRecipients']['last_updated_timestamp'] == 0)) {
		echo "Never"; } else { echo date("m/d/y g:ia", $r['ReportsRecipients']['last_updated_timestamp']); } ?></td>
  	<td class="tb_tools">
        <ul>
        <!--<li><a href="javascript:void();" title="edit"><img src="../img/bt_edit.gif" /></a></li>-->
        <li><li><? echo $html->link('<span>view</span>', array('controller' => 'reports', 'action' => 'view', $r['ReportsRecipients']['id']), array('title'=>'view', 'escape'=>false, 'class'=>'button_smgr')) ?></li></li>
        <li class="floatright"><a href="/site/admin/reports/delete_rr/<?=$r['ReportsRecipients']['id']?>" onclick="return confirm('Are you sure?  This will delete sent report.');" title="delete"><img src="../img/bt_del.gif" /></a></li>
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
  <a class="button_or" id="rpt_new" href="/site/admin/reports/new_report"><span>new report</span></a>
  <a class="button_gr floatright" id="rpt_older" href="/site/admin/reports/"><span>see all reports</span></a>
  </div>
  </fieldset><p></p>
  
  <fieldset id="fs_quick_export"><legend>Quick Export</legend>
  <form name="QuickExport" action="/site/admin/reports/export/true" method="post">
  <span class="label">Date Range: 
  		<select name="data[Export][month_start]">
        <option value="January">January</option>
        <option value="February">February</option>
        <option value="March">March</option>
        <option value="April">April</option>
        <option value="May">May</option>
      	<option value="June">June</option>
        <option value="July">July</option>
        <option value="August">August</option>
        <option value="September">September</option>
        <option value="October">October</option>
        <option value="November">November</option>
        <option value="December">December</option>
      </select> 
      <select name="data[Export][day_start]">
      	<?
		for($i = 1; $i < 31; $i++) { ?>
      	<option value="<?=$i?>"><?=$i?></option>
        <? } ?>
      </select>, 
      <select name="data[Export][year_start]">
      	<option value="2010">2010</option>
        <option value="2011">2011</option>
        <option value="2012">2012</option>
      </select> - 
      <select name="data[Export][month_end]">
      	<?
		$months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
		$mo = date("F", time());
		foreach($months as $m) { 
		?>
        <option <? if($mo == $m) { ?>SELECTED <? } ?>value="<?=$m?>"><?=$m?></option>
        <? } ?>
      </select>
      <select name="data[Export][day_end]">
      	<?
		$d = date("d", time());
		for($i = 1; $i <= 31; $i++) { 
			?>
      	<option <? if($d == $i) { ?>SELECTED <? } ?>value="<?=$i?>"><?=$i?></option>
        <? } ?>
      </select>, 
      <select name="data[Export][year_end]">
      	<?
		$y = date("Y", time());
		for($i = $y; $i <= $y+1; $i++) { ?>
      	<option value="<?=$i?>"><?=$i?></option>
        <? } ?>
      </select>
  </span>
   <input id="filetype" type="hidden" name="data[Export][filetype]" />
  </form>
  <div class="fs_buttons">
  	<a class="button_or" id="ex_xls" href="javascript: void(0)" onclick="document.getElementById('filetype').value='xls'; document.QuickExport.submit()"><span>xls</span></a>
  	<a class="button_or" id="ex_pdf" href="javascript: void(0)" onclick="document.getElementById('filetype').value='pdf'; document.QuickExport.submit()"><span>pdf</span></a>
    <a class="button_gr floatright" id="ex_adv" href="/site/admin/reports/export"><span>advanced options</span></a></li>
   </div>
 </fieldset><p></p>
  
  <fieldset id="fs_members">
  <legend>members</legend>
  
  <table id="tb_reports">
  <tbody>
  <tr>
  	<th>Name</th>
    <th>Phone</th>
    <th>Location</th>
    <th>Category</th>
    <th>Tools</th>
  </tr>
  <?
  $i = 0;
  $i2 = 0;
  foreach ($users as $user) { 
  	$i2++; ?>
  <tr<?=($i == 1 ? " class='odd'" : "")?>>
  	<td><?php echo $user['Users']['first_name'] . " " . $user['Users']['last_name'] ?></td>
  	<td>&nbsp;</td>
  	<td>&nbsp;</td>
  	<td><?=$user['Users']['account']?></td>
  	<td class="tb_tools tb_users">
        <ul>
        <li><? echo $html->link('<span>edit</span>', array('controller' => 'users', 'action' => 'edit', $user['Users']['id']), array('title'=>'edit', 'escape'=>false, 'class'=>'button_smgr')) ?></li>
		<?
		$image = $html->image('/img/bt_del.gif',null);
		?>
        <li><?php echo $html->link($image, array('controller' => 'users', 'action' => 'delete', $user['Users']['id']), array('title'=>'delete', 'escape'=>false), 'Are you sure?' )?></li>
        </ul>
	</td>
  </tr>
  <? $i++;
  if($i == 2) { $i = 0; }
  } ?>
  </tbody>
  </table>
  
  
  <div class="fs_buttons">
  <a class="button_or" id="m_new" href="/site/admin/users/add"><span>new member</span></a>
  <a class="button_gr floatright" id="m_users" href="/site/admin/users"><span>see all users</span></a>
  </div>
  
  </fieldset><p></p>

  </div>
  
<!-- MAIN AREA END -->