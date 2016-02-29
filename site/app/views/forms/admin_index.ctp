<div id="content">
  <div id="top">
    <img id="logo" src="/site/img/cmi_logo_gr.png" />
      <div id="topWelcome">
      <h3>Welcome <? echo $session->read('Auth.User.first_name'); ?></h3><br />
	  <?php echo $html->link('Home', '/admin/dashboard', array('title'=>'Home', 'class'=>'crumbs')); ?> >> <?php echo $html->link('Forms', '/admin/forms', array('title'=>'Stores', 'class'=>'crumbs')); ?>
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
  <legend>forms</legend>
  <table id="tb_messages">
  <tbody>
  <tr>
    <th>title</th>
    <th>vendor</th>
    <th># of fields</th>
    <th>options</th>
  </tr>
  <?
  if(count($forms) == 0) {
	  ?>
  <tr><td>No forms exist in the database.</td></tr>
  <? 
  } else {
  $i = 0;
  foreach($forms as $f) { ?>
  <tr<?=($i == 1 ? " class='odd'" : "")?>>
  	<td><?=$f['Forms']['name']?></td>
    <td><? if(strlen($f['Forms']['vendor']) != 0) { echo $f['Forms']['vendor']; } else { echo "General"; } ?></td>
    <td><?=$f['Forms']['field_count']?></td>
  	<td class="tb_tools">
        <ul>
        <li><a href="/site/admin/reports/new_report/2/null/<?=$f['Forms']['id']?>" title="edit"><img src="/site/img/bt_edit.gif" /></a></li>
        <li><a href="/site/admin/forms/delete/<?=$f['Forms']['id']?>" title="delete" onclick="return confirm('Are you sure?  This will completely remove the form from the database.');"><img src="/site/img/bt_del.gif" /></a></li>
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
  <a class="button_or" href="/site/admin/reports/new_report/1"><span>new form</span></a>
  </div>
  
  </fieldset>
  </div>
  
<!-- MAIN AREA END -->