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
	$('#more_recipients').append('<tr><td><div class="select"><span id="span_user_'+id+'">Select User</span><div class="options"><? 
				foreach($users as $u) {
				?><a href="javascript: changeSelectVal(\'user_'+id+'\',\'<?=$u['Users']['id']?>\',\'<?=$u['Users']['first_name']?> <?=$u['Users']['last_name']?>\')" class="option"><?=$u['Users']['first_name']?> <?=$u['Users']['last_name']?></a><? 
				} ?></div><input id="select_user_'+id+'" value="" type="hidden" name="data[Report][User]['+id+']" /></div></td></tr>');
}
</script>
<div id="content">
<div id="top">
    <img id="logo" src="/site/img/cmi_logo_gr.png" />
      <div id="topWelcome">
      <h3>Welcome <? echo $session->read('Auth.User.first_name'); ?></h3><br />
	  <?php echo $html->link('Home', '/admin/dashboard', array('title'=>'Home', 'class'=>'crumbs')); ?> > <?php echo $html->link('Reports', '/admin/reports', array('title'=>'Reports', 'class'=>'crumbs')); ?> > <?php echo $html->link('New Report', '/admin/reports/new_report', array('title'=>'New Report', 'class'=>'crumbs')); ?>
      </div>
      <div id="topDate">
      <a href="/site/users/logout">Log Out</a> | <?php echo date("m\/d\/y"); ?>
      </div>
    <div class="clear"><!--IE--></div>
  </div>
  
  <div id="main">
  <fieldset><legend>send report</legend>
	<form id="ReportAdd" name="ReportAdd" method="post" action="/site/admin/reports/send_report/1" accept-charset="utf-8">
	<input type="hidden" name="_method" value="POST" />
  <table>	`
  <tr>
    <td>
    <?
	if(isset($report)) {
		?>
      <div class="label">Send Report: &quot;<strong><?=$report['Reports']['name']?></strong>&quot;</div>
      <input id="select_report" value="<?=$report['Reports']['id']?>" type="hidden" name="data[Report][id]" />
     
    <? } else { ?>
	  <div class="label">Choose Report to send:</div>
        <div class="select" id="">
        	<span id="span_report">Select Report</span>
            <div class="options">
            	<? 
				foreach($reports as $r) {
				?>
				<a href="javascript: changeSelectVal('report','<?=$r['Reports']['id']?>','<?=$r['Reports']['name']?>')" class="option"><?=$r['Reports']['name']?></a>
                <? } ?>
            </div>
            <input id="select_report" value="" type="hidden" name="data[Report][id]" />
        </div>
        <? } ?>
	</td>
  </tr>
  <tr>
    <td>
	  <div class="label">Choose User(s) to send report to:</div><br style="clear: both" />
        <div class="select">
        	<span id="span_user_0">Select User</span>
            <div class="options">
            	<? 
				foreach($users as $u) {
				?>
				<a href="javascript: changeSelectVal('user_0','<?=$u['Users']['id']?>','<?=$u['Users']['first_name']?> <?=$u['Users']['last_name']?>')" class="option"><?=$u['Users']['first_name']?> <?=$u['Users']['last_name']?></a>
                <? } ?>
            </div>
            <input id="select_user_0" value="" type="hidden" name="data[Report][User][0]" />
        </div>
        
        <ul class="floatleft form">
    	<li><a href="javascript:add_recipient();" class="button_smgr" title="add recipient"><span>add recipient</span></a></li>
    	</ul>
	</td>
  </tr>
  <tbody id="more_recipients">
  </tbody>
  </table>
  </form>
  
  <div class="fs_buttons">
  <a class="button_or floatright" id="report_next" href="javascript: document.ReportAdd.submit()"><span>Send Report</span></a>
  </div>
  </fieldset>
  
  <fieldset><legend>report preview</legend>
  <table>
           <tr>
            <th>Store Name</th>
            <th>Number</th>
            <th>City</th>
            <th>State</th>
            <th class="tb_tools"><ul class="floatright"><li><a class="button_smgr" href="javascript: void(0)" onclick="minimize(this)"><span><strong>-</strong></span></a></li></ul></th>
            </tr>
            <tr>
            	<td></td>
                <td></td>
                <td></td>
                <td></td>
           		<td></td>
            </tr>
            </table>
            <table class="form_questions">
     	<?
        
           foreach($reader as $key=>$r2) {
			   if(is_numeric($key)) {
         	if(!$r2['text']['Vendor']) { ?>
  <tr>
  	<td>
      <div class="label">General Questions</div>
    </td>
  </tr>
  <tbody id="General">
  <?
  echo $r2['text']['General'];
  ?>
  </tbody>
  <?
  }
  if($r2['text']['Vendor']) {
	?>
  <tr>
    <td>
      <div class="label"><strong><?=$r2['Vendors']['company_name']?> Questions</strong></div>
    </td>
  </tr>
  <tbody id="Vendor">
  <?
  echo $r2['text']['Vendor'];
  ?>
  </tbody>
  <?
			}
			   }?>
            <?
		}
	
	?>
    </table>
    <div class="fs_buttons"></div>
    </fieldset><p></p>
  </div>