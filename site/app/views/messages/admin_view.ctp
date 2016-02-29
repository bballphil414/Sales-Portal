<div id="content">
  <div id="top">
    <img id="logo" src="/site/img/cmi_logo_gr.png" />
      <div id="topWelcome">
      <h3>Welcome <? echo $session->read('Auth.User.first_name'); ?></h3><br />
	  <?php echo $html->link('Home', '/admin/dashboard', array('title'=>'Home', 'class'=>'crumbs')); ?> >> <?php echo $html->link('Messages', '/admin/messages', array('title'=>'Messages', 'class'=>'crumbs')); ?> >> <?php echo $html->link('View Message', '/admin/messages/view/'.$message['Messages']['id'], array('title'=>'View Message', 'class'=>'crumbs')); ?>
      </div>
      <div id="topDate">
      <a href="/site/users/logout">Log Out</a> | <?php echo date("m\/d\/y"); ?>
      </div>
    <div class="clear"><!--IE--></div>
  </div>
 
 <!-- MAIN AREA START -->
 
  <div id="main">
  <fieldset id="fs_messages"><legend>View Message</legend>
  <div class="message">
  	<ul class="floatright">
        <li><a href="/site/admin/messages/delete/<?=$message['Messages']['id']?>" title="delete"><img src="/site/img/bt_del.gif" /></a></li>
    </ul>
  <strong><?=$message['Messages']['subject']?></strong>
  <?
  if($message['Messages']['from_user_id'] == $session->read('Auth.User.id')) { ?>
  <div class="msg_meta"><?=date("m/d/y", $message['Messages']['timestamp'])?> - Message to <?=$message['User']['Users']['first_name']?> <?=$message['User']['Users']['last_name']?></div>
  <? } else { ?>
  <div class="msg_meta"><?=date("m/d/y", $message['Messages']['timestamp'])?> - Message from <?=$message['User']['Users']['first_name']?> <?=$message['User']['Users']['last_name']?></div>
  <? } ?>
  <?=$message['Messages']['message']?>
  </div>
  <div class="fs_buttons">
  <a class="button_or" id="" href="/site/admin/messages/new"><span>new message</span></a>
  <a class="button_gr floatright" id="" href="/site/admin/messages"><span>see older messages</span></a>
  </div>
  
  </fieldset>
   </div>
<!-- MAIN AREA END -->
