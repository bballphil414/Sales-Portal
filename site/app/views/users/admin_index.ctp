<div id="content">
  <div id="top">
    <img id="logo" src="/site/img/cmi_logo_gr.png" />
      <div id="topWelcome">
      <h3>Welcome <? echo $session->read('Auth.User.first_name'); ?></h3><br />
	  <?php echo $html->link('Home', '/admin/dashboard', array('title'=>'Home', 'class'=>'crumbs')); ?> > <?php echo $html->link('Manage Users', '/admin/users', array('title'=>'Manage Users', 'class'=>'crumbs')); ?>
      </div>
      <div id="topDate">
      <?php echo date("m\/d\/y"); ?>
      </div>
    <div class="clear"><!--IE--></div>
  </div>
 
 <!-- MAIN AREA START -->
 
  <div id="main">
  
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
  foreach ($users as $user) { ?>
  <tr<?=($i == 1 ? " class='odd'" : "")?>>
  	<td><?php echo $user['User']['first_name'] . " " . $user['User']['last_name'] ?></td>
  	<td>&nbsp;</td>
  	<td>&nbsp;</td>
  	<td><?=$user['User']['account']?></td>
  	<td class="tb_tools tb_users">
        <ul>
        <li><? echo $html->link('<span>edit</span>', array('action' => 'edit', $user['User']['id']), array('title'=>'edit', 'escape'=>false, 'class'=>'button_smgr')) ?></li>
		<?
		$image = $html->image('/img/bt_del.gif',null);
		?>
        <li><?php echo $html->link($image, array('action' => 'delete', $user['User']['id']), array('title'=>'delete', 'escape'=>false), 'Are you sure?' )?></li>
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
  </div>
  
  </fieldset>
  </div>
  
<!-- MAIN AREA END -->