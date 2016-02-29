<script type="text/javascript">
function save(submit_type) {
	//$("input[name*='data[fields]']").each(function() { alert($(this).val()); });
	var i2 = 1;
	for(var i = 0; i <= storeIds; i++) {
		if($('[name="data[stores]['+i+'][store_number]"]').length) {
			var value = $('[name="data[stores]['+i+'][store_number]"]').val();
			if(value.length == 0) {
				alert("You must enter a store number for Store " + i2);
				return;
			}
			i2++;
		}
	}
	// process
	if(submit_type == 'true') {
		document.getElementById('submit_value').value='true';
	}
	$('#ReportAdd').submit();
}
			
var storesNum = <?=count($reader)?>;
var storeIds = <?=count($reader)?>-1;

function addStore() {
	storeIds++;
	var html = "<table>";
	html += '<tr>';
    html += '<th>Store Name:</th>';
    html += '<th>Number:</th>';
    html += '<th>City</th>';
    html += '<th>State</th>';
	html += '<th>Date Visited</th>';
    html += '<th class="tb_tools"><ul class="floatright"><li><a class="button_smgr" href="javascript: void(0)" onclick="minimize(this)"><span><strong>-</strong></span></a></li><li><a href="javascript: void(0)" onclick="removeStore(this)" title="delete"><img src="/site/img/bt_del.gif" /></a></li></ul></th>';
    html += '</tr>';
    html += '<tr>';
    html += '<td><input type="text" name="data[stores]['+storeIds+'][store_name]" /></td>';
    html += '<td><input type="text" style="width: 90px" name="data[stores]['+storeIds+'][store_number]" /></td>';
    html += '<td><input type="text" style="width: 70px" name="data[stores]['+storeIds+'][city]" /></td>';
    html += '<td><input type="text" style="width: 30px" name="data[stores]['+storeIds+'][state]" /></td>';
	html += '<td><select name="data[stores]['+storeIds+'][month]"><? $m = date("m", time()); for($i = 1; $i <= 12; $i++) { ?><option <? if($m == $i) { ?>SELECTED <? } ?>value="<?=$i?>"><?=$i?></option><? } ?></select>&nbsp;';
	html += '<select name="data[stores]['+storeIds+'][day]"><? $d = date("d", time()); for($i = 1; $i <= 31; $i++) { ?><option <? if($i == $d) { ?>SELECTED <? } ?>value="<?=$i?>"><?=$i?></option><? } ?></select>&nbsp;';
	html += '<select name="data[stores]['+storeIds+'][year]"><? $y = date("Y", time()); for($z = $y; $z <= $y+1; $z++) { ?><option value="<?=$z?>"><?=$z?></option><? } ?></select></td>';
    html += '<td></td>';
    html += '</tr>';
    html += '</table>';
	var questions2 = '<?
foreach($empty as $r) {
   if(!$r['Vendor']) { ?><tr><td><div class="label">General Questions</div></td></tr><tbody id="General"><?
   echo addslashes($r['General']);
  ?></tbody><?
  	} else {
	?><tr><td><div class="label">Vendor [<strong><?=$r['Vendors']['company_name']?></strong>] Questions</div></td></tr><tbody id="Vendor"><?
  echo addslashes($r['Vendor']);
  ?></tbody><?
	}
} ?>';
	html += '<table>' + questions2 + '</table>';
	$("#more_stores").append(html);

	// process field names so they don't duplicate and are lined up with the stores...
	var i = 0;
	var num = $('input[name*="data[fieldsTwo]"], textarea[name*="data[fieldsTwo]"], select[name*="data[fieldsTwo]"]').length;
	$('input[name*="data[fieldsTwo]"], textarea[name*="data[fieldsTwo]"], select[name*="data[fieldsTwo]"]').each(function() {
		i++;
		var name = $(this).attr("name");
		var re1='.*?';	// Non-greedy match on filler
      	var re2='(\\d+)';	// Integer Number 1

      	var p = new RegExp(re1+re2,["i"]);
     	 var m = p.exec(name);
     	 if (m != null)
      	{
          var int1=m[1];
		  $(this).attr('name', 'data[fields]['+m[1]+']['+storeIds+']');
      	}
		if(i == num) {
			return false;
		}
	});
	storesNum++;
	
}

function minimize(object) {
	if($(object).html() == '<span>+</span>') {
		$(object).html('<span>-</span>');
	} else {
		$(object).html('<span>+</span>');
	}
	$(object).parents('li').parents('ul').parents('th').parents('tr').parents('table').next('table').toggle();
}
function removeStore(object) {
	if(storesNum == 1) {
		return;
	} else {
		storesNum--;
	}
	$(object).parents('li').parents('ul').parents('th').parents('tr').parents('table').next('table').html('');
	$(object).parents('li').parents('ul').parents('th').parents('tr').parents('table').html('');
}

</script>
<div id="content">
<div id="top">
      <img id="logo" src="/site/img/cmi_logo_gr.png" />
      <div id="topWelcome">
      <h3>Welcome <? echo $session->read('Auth.User.first_name'); ?></h3><br />
	  <?php echo $html->link('Home', '/dashboard', array('title'=>'Home', 'class'=>'crumbs')); ?> > <?php echo $html->link('Reports', '/reports', array('title'=>'Reports', 'class'=>'crumbs')); ?> > <?php echo $html->link('View/Complete Report', '/reports/view/'.$report['ReportsRecipients']['id'], array('title'=>'View/Complete Report', 'class'=>'crumbs')); ?>
      </div>
      <div id="topDate">
      <a href="/site/users/logout">Log Out</a> | <?php echo date("m\/d\/y"); ?>
      </div>
    <div class="clear"><!--IE--></div>
  </div>
  
  <div id="main">
  <fieldset>

  <legend>complete report</legend>
  <table><tr><td><div class="label"><strong>Report Name:</strong> <?=$report['Reports']['name']?> | <strong>Customer:</strong> <?=$report['Reports']['customer']?></div></td></tr></table>
  <br />
	<form id="ReportAdd" name="ReportAdd" method="post" action="/site/reports/view/<?=$report['ReportsRecipients']['id']?>" accept-charset="utf-8">
	<? // <input type="hidden" name="_method" value="POST" /> 
	
	$i = 0;
	foreach($reader as $r) {
		// separated by store
		
			// we have no stores added, must add a store
			?>
            <table>
            <tr>
            <th>Store Name</th>
            <th>Number</th>
            <th>City</th>
            <th>State</th>
            <th>Date&nbsp;Visited</th>
            <th class="tb_tools" style="width: 60px" ><ul class="floatright"><li><a id="link_<?=$i?>" class="button_smgr" href="javascript: void(0)" onclick="minimize(this)"><span><strong>-</strong></span></a></li><li><a href="javascript: void(0)" onclick="removeStore(this)" title="delete"><img src="/site/img/bt_del.gif" /></a></li></ul></th>
            </tr>
            <tr>
            <?            
			if($r['Stores'] == -1) {
				?>
            	<td><input type="text" name="data[stores][0][store_name]" /></td>
                <td><input type="text" style="width: 80px" name="data[stores][0][store_number]" /></td>
                <td><input type="text" style="width: 70px" name="data[stores][0][city]" /></td>
                <td><input type="text" style="width: 30px" name="data[stores][0][state]" /></td>
                <td><select name="data[stores][0][month]" /><? $m = date("m", time()); for($i = 1; $i <= 12; $i++) { ?><option <? if($m == $i) { ?>SELECTED <? } ?>value="<?=$i?>"><?=$i?></option><? } ?></select>
					<select name="data[stores][0][day]" /><? $d = date("d", time()); for($i = 1; $i <= 31; $i++) { ?><option <? if($i == $d) { ?>SELECTED <? } ?>value="<?=$i?>"><?=$i?></option><? } ?></select>
					<select name="data[stores][0][year]" /><? $y = date("Y", time()); for($z = $y; $z <= $y+1; $z++) { ?><option value="<?=$z?>"><?=$z?></option><? } ?></select>
                </td>
           		<td></td>
                <? } else {
					?>
                <td><input type="text" name="data[stores][<?=$i?>][store_name]" value="<?=stripslashes($r['Stores']['ReportsStores']['store_name'])?>" /></td>
                <td><input type="text" style="width: 90px" name="data[stores][<?=$i?>][store_number]" value="<?=$r['Stores']['ReportsStores']['store_number']?>" /></td>
                <td><input type="text" style="width: 70px" name="data[stores][<?=$i?>][city]" value="<?=$r['Stores']['ReportsStores']['city']?>" /></td>
                <td><input type="text" style="width: 30px" name="data[stores][<?=$i?>][state]" value="<?=$r['Stores']['ReportsStores']['state']?>" /></td>
                <td><select name="data[stores][<?=$i?>][month]" style="float: left"><? for($z = 1; $z <= 12; $z++) { ?><option <? if(isset($r['Stores']['ReportsStores']['date_visited'])) { if(date("m", $r['Stores']['ReportsStores']['date_visited']) == $z) { ?>SELECTED <? } } ?>value="<?=$z?>"><?=$z?></option><? } ?></select>
					<select name="data[stores][<?=$i?>][day]" style="float: left"><? for($z = 1; $z <= 31; $z++) { ?><option <? if(isset($r['Stores']['ReportsStores']['date_visited'])) { if(date("d", $r['Stores']['ReportsStores']['date_visited']) == $z) { ?>SELECTED <? } } ?>value="<?=$z?>"><?=$z?></option><? } ?></select>
					<select name="data[stores][<?=$i?>][year]" style="float: left"><? $y = date("Y", time()); for($z = $y; $z <= $y+1; $z++) { ?><option <? if(isset($r['Stores']['ReportsStores']['date_visited'])) { if(date("Y", $r['Stores']['ReportsStores']['date_visited']) == $z) { ?>SELECTED <? } } ?>value="<?=$z?>"><?=$z?></option><? } ?></select>
                </td>
                <td></td>
                <? } ?>
            </tr>
			
            </table>
			 
            <table id="form_questions">
        <?     
           foreach($r as $key=>$r2) {
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
      <div class="label">Vendor [<strong><?=$r2['Vendors']['company_name']?></strong>] Questions</div>
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
		$i++;
	} 
	?>
    </table>
    <div id="more_stores"></div>
    <input type="hidden" name="data[submit]" id="submit_value" value="false" />
  </form>
    
  <div class="fs_buttons">
  <a class="button_gr floatleft" href="javascript: addStore()"><span>Add Store</span></a>
  <a target="_blank" class="button_gr floatleft" href="/site/reports/printview/<?=$report['ReportsRecipients']['id']?>"><span>Print Full Report</span><a>
<a target="_blank" class="button_gr floatleft" href="/site/reports/printview/<?=$report['ReportsRecipients']['id']?>/blank"><span>Print Blank Report</span><a>

  <a class="button_or floatright" href="javascript: void(0)" onclick="save('true')"><span>Save Report</span></a>
  </div>
    </table>
  </fieldset>
  </div>
