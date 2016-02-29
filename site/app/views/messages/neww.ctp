<script type="text/javascript">
function changeSelectVal(id, val, string) {
	var span = document.getElementById("span_"+id);
	span.innerHTML = string;
	var input = document.getElementById("select_"+id);
	input.value=val;
}

var id = 0;
function add_recipient() {
	id++;
	$('#more_recipients').append("<tr><td><div class=\"label\">CC: </div><div class=\"select\"><span id=\"span_"+id+"\"></span><div class=\"options\"><? $i2 = 0; foreach ($users as $user) { $i2++; ?><a id=\"a_<?=$user['Users']['id']?>\" href=\"javascript: changeSelectVal('"+id+"','<?=$user['Users']['id']?>', '<?=$user['Users']['first_name']?> <?=$user['Users']['last_name']?>')\" class=\"option option_0\" <?=($i2 == sizeof($users) ? " style='border-bottom: none'" : "")?>><?=$user['Users']['first_name']?> <?=$user['Users']['last_name']?></a><? } ?></div><input id=\"select_"+id+"\" value=\"\" type=\"hidden\" name=\"data[Users]["+id+"]\" /></div></td></tr>");
}
</script>

<div id="content">
  <div id="top">
    <img id="logo" src="/site/img/cmi_logo_gr.png" />
      <div id="topWelcome">
      <h3>Welcome <? echo $session->read('Auth.User.first_name'); ?></h3><br />
	  <?php echo $html->link('Home', '/dashboard', array('title'=>'Home', 'class'=>'crumbs')); ?> > <?php echo $html->link('Messages', '/messages', array('title'=>'Messages', 'class'=>'crumbs')); ?> > <?php echo $html->link('New Message', '/messages/neww', array('title'=>'New Message', 'class'=>'crumbs')); ?>
      </div>
      <div id="topDate">
      <a href="/site/users/logout">Log Out</a> | <?php echo date("m\/d\/y"); ?>
      </div>
    <div class="clear"><!--IE--></div>
  </div>
 
 <!-- MAIN AREA START -->
 
  <div id="main">
  
  <fieldset id="fs_newmessage">
  <legend>edit message</legend>
  <form name="messageform" method="post" action="/site/messages/send" accept-charset="utf-8">
  <input type="hidden" name="_method" value="POST" />
  <table id="tb_newmessage">
  <tbody>
  <tr>
  	<td>
    	<div class="label">To:</div>
        <div class="select" id="first_recipient">
        	<span id="span_0"><?=(isset($reply) ? $r['Users']['first_name'] . " " . $r['Users']['last_name'] : "Select Recipient")?></span>
            <div class="options">
				<?
				$i2 = 0;
				foreach ($users as $user) {
				$i2++;
				?>
                <a id="a_<?=$user['Users']['id']?>" href="javascript: changeSelectVal('0','<?=$user['Users']['id']?>', '<?=$user['Users']['first_name']?> <?=$user['Users']['last_name']?>')" class="option option_0"<?=($i2 == sizeof($users) ? " style='border-bottom: none'" : "")?>><?=$user['Users']['first_name']?> <?=$user['Users']['last_name']?></a>
                <? 
				}
				?>
            </div>
            <input id="select_0" value="<?=(isset($reply) ? $r['Users']['id'] : '')?>" type="hidden" name="data[Users][0]" />
        </div>
        <ul class="floatleft form">
    	<li><a href="javascript:add_recipient();" class="button_smgr" title="add recipient"><span>add recipient</span></a></li>
    	</ul>
        <!--<input type="checkbox" name="data[selectc]" class="form_checkbox" />
        <div class="label label_smallpadding">Expires:</div>
        <input type="text" name="data[expires]" size="15" />-->
    </td>
  </tr>
  <tbody id="more_recipients">
  </tbody>
  <tr>
  	<td>
    	<div class="label">Subject:</div>
        <input type="text" name="data[subject]" size="45" />
        <textarea name="data[message]" cols="72" rows="7"></textarea>
    </td>
  </tr>
  </tbody>
  </table>
  
  <div class="fs_buttons">
  <a class="button_or" id="msg_send" href="javascript: void(0)" onclick="javascript: document.messageform.submit()"><span>send message</span></a>
  <a class="button_gr" id="msg_cancel" href="/site/messages"><span>cancel</span></a>
  </div>
  
  </form>
  </fieldset>
  
  
  </div>
<!-- MAIN AREA END -->
