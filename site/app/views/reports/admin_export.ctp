<script type="text/javascript">
function changeSelectVal(id, val, string) {
	var span = document.getElementById("span_"+id);
	span.innerHTML = string;
	var input = document.getElementById("select_"+id);
	input.value=val;
}

function check(object) {
	var ob1 = document.getElementById(object);
	/*if(object == "customer_selected") {
		var ob2 = document.getElementById("vendor_selected");
		if(ob1.checked == true) {
			ob2.checked = false;
		}
	} else {
		var ob2 = document.getElementById("customer_selected");
		if(ob1.checked == true) {
			ob2.checked = false;
		}
	}*/
}
</script>

<div id="content">
  <div id="top">
    <img id="logo" src="/site/img/cmi_logo_gr.png" />
      <div id="topWelcome">
      <h3>Welcome <? echo $session->read('Auth.User.first_name'); ?></h3><br />
	  <?php echo $html->link('Home', '/dashboard', array('title'=>'Home', 'class'=>'crumbs')); ?> > <?php echo $html->link('Reports', '/reports', array('title'=>'Reports', 'class'=>'crumbs')); ?>
      </div>
      <div id="topDate">
      <a href="/site/users/logout">Log Out</a> | <?php echo date("m\/d\/y"); ?>
      </div>
    <div class="clear"><!--IE--></div>
  </div>
 
 <!-- MAIN AREA START -->
 
  <div id="main">
  
  <fieldset id="fs_export">
  <legend>export</legend>
  
  <form action="/site/admin/reports/export" method="post" name="QuickExport">
  <table>
  <tr>
    <td>
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
      <!--<a class="bt_date" href="javascript:void();" title="edit date range"><img src="/site/img/bt_date.gif" /></a>-->
      </span>
    </td>
  </tr>
  </table>
  
  <legend>advanced options</legend>
  
  <div class="rc_module">
  <ul class="m">
  	<li>
    	<input id="customer_selected" onclick="check('customer_selected')" type="checkbox" class="form_checkbox2" value="Yes" name="data[Export][customer_selected]" />
        <!--<div class="label">Choose Store:</div><br style="clear: both" />-->
        <div class="select select_ul">
        	<span id="span_customer">Select Customer</span>
            <div class="options">
            	<? 
				foreach($customers as $c) {
				?>
				<a href="javascript: changeSelectVal('customer','<?=$c['reports']['customer']?>','<?=$c['reports']['customer']?>')" class="option"><?=$c['reports']['customer']?></a>
                <? } ?>
            </div>
            <input id="select_customer" value="" type="hidden" name="data[Export][Customer]" />
        </div>
        <br style="clear: both;" />
    </li>
  	<li>
    	<input id="vendor_selected" onclick="check('vendor_selected')" type="checkbox" class="form_checkbox2" value="Yes" name="data[Export][vendor_selected]" />
        <!--<div class="label">Choose Vendor:</div><br style="clear: both" />-->
        <div class="select select_ul">
        	<span id="span_vendor">Select Vendor</span>
            <div class="options">
            	<? 
				foreach($vendors as $v) {
				?>
				<a href="javascript: changeSelectVal('vendor','<?=$v['Vendors']['id']?>','<?=$v['Vendors']['company_name']?>')" class="option"><?=$v['Vendors']['company_name']?></a>
                <? } ?>
            </div>
            <input id="select_vendor" value="" type="hidden" name="data[Export][Vendor]" />
        </div>
        <br style="clear: both" />
    </li>
  	<li id="last">
    	<input id="user_selected" type="checkbox" class="form_checkbox2" value="Yes" name="data[Export][user_selected]" />
        <!--<div class="label">Choose User:</div><br style="clear: both" />-->
        <div class="select select_ul">
        	<span id="span_user">Select User</span>
            <div class="options">
            	<? 
				foreach($users as $u) {
				?>
				<a href="javascript: changeSelectVal('user','<?=$u['Users']['id']?>','<?=$u['Users']['first_name'] . " " . $u['Users']['last_name']?>')" class="option"><?=$u['Users']['first_name'] . " " . $u['Users']['last_name']?></a>
                <? } ?>
            </div>
            <input id="select_user" value="" type="hidden" name="data[Export][User]" />
        </div>
    </li>
	<li><div class="clear"></div></li>
  </ul>
  </div>
  <input id="filetype" type="hidden" name="data[Export][filetype]" />
  </form>
  
  <div class="fs_buttons">
  <a class="button_or" id="ex_xls" href="javascript: void(0)" onclick="document.getElementById('filetype').value='xls'; document.QuickExport.submit()"><span>xls</span></a>
  <a class="button_or" id="ex_pdf" href="javascript: void(0)" onclick="document.getElementById('filetype').value='pdf'; document.QuickExport.submit()"><span>pdf</span></a>
  </div>
  
  </fieldset>
  </div>
  
<!-- MAIN AREA END -->