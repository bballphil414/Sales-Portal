<script type="text/javascript">
function minimize(object) {
	if($(object).html() == '<span>+</span>') {
		$(object).html('<span>-</span>');
	} else {
		$(object).html('<span>+</span>');
	}
	$(object).parents('li').parents('ul').parents('th').parents('tr').parents('table').next('table').toggle();
}
</script>
<div id="content">
<div id="top">
      <img id="logo" src="/site/img/cmi_logo_gr.png" />
      <div id="topWelcome">
      <h3>Welcome <? echo $session->read('Auth.User.first_name'); ?></h3><br />
	  <?php echo $html->link('Home', '/admin/dashboard', array('title'=>'Home', 'class'=>'crumbs')); ?> > <?php echo $html->link('Reports', '/admin/reports', array('title'=>'Reports', 'class'=>'crumbs')); ?> > <?php echo $html->link('View Report', '/reports/admin/view/'.$report['ReportsRecipients']['id'], array('title'=>'View Report', 'class'=>'crumbs')); ?>
      </div>
      <div id="topDate">
      <a href="/site/users/logout">Log Out</a> | <?php echo date("m\/d\/y"); ?>
      </div>
    <div class="clear"><!--IE--></div>
  </div>
  
  <div id="main">
  <fieldset>

  <legend>view report</legend>
  <?
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
            <th>Date Visited</th>
            <th class="tb_tools"><ul class="floatright"><li><a class="button_smgr" href="javascript: void(0)" onclick="minimize(this)"><span><strong>-</strong></span></a></li></ul></th>
            </tr>
            <tr>
            	<td><?=stripslashes($r['Stores']['ReportsStores']['store_name'])?></td>
                <td><?=$r['Stores']['ReportsStores']['store_number']?></td>
                <td><?=$r['Stores']['ReportsStores']['city']?></td>
                <td><?=$r['Stores']['ReportsStores']['state']?></td>
                <td><?=date("m/d/y", $r['Stores']['ReportsStores']['date_visited'])?></td>
           		<td></td>
            </tr>
            </table>
            <table class="form_questions">
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
	} 
	?>
    </table>
  <div class="fs_buttons">
  	<a target="_blank" class="button_gr floatleft" href="/site/reports/printview/<?=$report['ReportsRecipients']['id']?>"><span>Print Full Report</span><a>
	<a target="_blank" class="button_gr floatleft" href="/site/reports/printview/<?=$report['ReportsRecipients']['id']?>/blank"><span>Print Blank Report</span><a>
  	<a class="button_gr floatright" href="/site/admin/reports/"><span>View All Reports</span></a>
  </div>
  </fieldset>
  </div>
