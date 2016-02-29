<div id="content">
  <div id="top">
    <img id="logo" src="/site/img/cmi_logo_gr.png" />
      <div id="topWelcome">
      <h3>Welcome <? echo $session->read('Auth.User.first_name'); ?></h3><br />
      <?
	  if($session->read('admin') == "Yes") {
	  echo $html->link('Home', '/admin/dashboard', array('title'=>'Home', 'class'=>'crumbs'));
      } else { 
	  echo $html->link('Home', '/dashboard', array('title' => 'Home', 'class'=>'crumbs')); 
	  } ?> 
      > <?php echo $html->link('Contacts', '/contacts', array('title'=>'Contacts', 'class'=>'crumbs')); ?>
      </div>
      <div id="topDate">
      <a href="/site/users/logout">Log Out</a> | <?php echo date("m\/d\/y"); ?>
      </div>
    <div class="clear"><!--IE--></div>
  </div>
 <div id="main">
 <!-- MAIN AREA START -->
 
   <fieldset id="fs_contacts"><legend>Contacts<? if(isset($status)) { if($status == 0) { ?> - New Contact<? } else if($status == 1) { ?> - Edit Contact<? } } ?></legend>
  <table id="tb_contacts">
  
  <tbody>
     <?
   if(!isset($status)) { ?>
  <tr>
  	<th>name</th>
    <th>company</th>
    <th>tools</th>
  </tr>
  	<?
	$i = 0;
	foreach($contacts as $c) {
		?>
  <tr<?=($i == 1 ? " class='odd'" : "")?>>
  	<td><h3><?=$c['Contacts']['name']?></h3><?=$c['Contacts']['title']?><br /><a href="mailto:<?=$c['Contacts']['email']?>"><?=$c['Contacts']['email']?></a><br /><?=$c['Contacts']['phone_number']?></td>
  	<td><?=$c['Contacts']['company_name']?><br /><?=$c['Contacts']['address']?><br />Notes: <?=$c['Contacts']['notes']?></td>
  	<td class="tb_tools">
        <ul>
        <!--<li><a href="javascript:void();" title="email"><img src="img/bt_email.png" /></a></li>-->
        <?
		if($c['Contacts']['user_id'] == $session->read('Auth.User.id')) { ?>
        <li><a href="/site/contacts/index/1/<?=$c['Contacts']['id']?>" class="edit" title="edit"><img src="img/bt_edit.gif" /></a></li>
        <li><a href="/site/contacts/delete/<?=$c['Contacts']['id']?>" title="delete" onclick="return confirm('Are you sure?')"><img src="img/bt_del.gif" /></a></li>
        <? } ?>
        </ul>
	</td>
  </tr>
  <? if($i == 0) {
	  $i = 1;
  } else {
	  $i = 0;
  }
  } ?>
  <?
  if(sizeof($contacts) == 0) {
	  ?>
  <tr>
  	<td>Sorry, you have no contacts.  Please click "New Contact" to add a contact.</td>
  </tr>
  <? }
   }?>
  <tr>
  	<td>
<!-- NEW/EDIT CONTACT -->   
<?
if(isset($status)) { 
	if($status == 1) { ?>
    <form method="post" name="new_contact" action="/site/contacts/index/2">
    <label for="name">Name</label>
    <input type="text" name="data[Contacts][name]" value="<?=$data['Contacts']['name']?>" /><br />
    <label for="title">Title</label>
    <input type="text" name="data[Contacts][title]" value="<?=$data['Contacts']['title']?>" /><br />
    <label for="email">Email</label>
    <input type="text" name="data[Contacts][email]" value="<?=$data['Contacts']['email']?>" /><br />
    <label for="phone">Phone</label>
    <input type="text" name="data[Contacts][phone_number]" value="<?=$data['Contacts']['phone_number']?>" /><br />
    <label for="website">Website</label>
    <input type="text" name="data[Contacts][website]" value="<?=$data['Contacts']['website']?>" /><br />
    <label for="company">Company</label>
    <input type="text" name="data[Contacts][company_name]" value="<?=$data['Contacts']['company_name']?>" /><br />
    <label for="address">Address</label>
    <textarea name="data[Contacts][address]" cols="25" rows="4">
<?=$data['Contacts']['address']?>
</textarea><br />
    <label for="notes">Notes</label>
    <textarea name="data[Contacts][notes]" cols="25" rows="4"><?=$data['Contacts']['notes']?></textarea><br />
    <input type="hidden" name="data[Contacts][id]" value="<?=$data['Contacts']['id']?>" />
   </form>
<? } else {
	?>
    <form method="post" name="new_contact" action="/site/contacts/index/2">
    <label for="name">Name</label>
    <input type="text" name="data[Contacts][name]" value="" /><br />
    <label for="title">Title</label>
    <input type="text" name="data[Contacts][title]" value="" /><br />
    <label for="email">Email</label>
    <input type="text" name="data[Contacts][email]" value="" /><br />
    <label for="phone">Phone</label>
    <input type="text" name="data[Contacts][phone_number]" value="" /><br />
    <label for="website">Website</label>
    <input type="text" name="data[Contacts][website]" value="" /><br />
    <label for="company">Company</label>
    <input type="text" name="data[Contacts][company_name]" value="" /><br />
    <label for="address">Address</label>
    <textarea name="data[Contacts][address]" cols="25" rows="4"></textarea><br />
    <label for="notes">Notes</label>
    <textarea name="data[Contacts][notes]" cols="25" rows="4"></textarea><br />
    </form>
<!-- //NEW/EDIT CONTACT -->
<? }
} ?>
	</td>
  </tr>
  </tbody>
  </table>
  
  <div class="fs_buttons">
  <? 
  if(!isset($status)) { ?>
  <a class="button_or" id="con_new" href="/site/contacts/index/0"><span>new contact</span></a>
  <? } ?>
  <?
  if(isset($status)) { ?>
  <a class="button_gr" id="con_save" href="javascript: void(0)" onclick="document.new_contact.submit()"><span>save contact</span></a>
	<? } ?>
  </div>

  
  </fieldset>
  
  </div>