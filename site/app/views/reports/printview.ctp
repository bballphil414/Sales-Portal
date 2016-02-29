 <?
 	$i = 0;
	foreach($reader as $r) {
		if($type == "blank" && $i >= 1) {
			break;
		}
		// separated by store
			// we have no stores added, must add a store
			?>
            <table>
            <tr class="titles">
            <th>Store Name</th>
            <th>Number</th>
            <th>City</th>
            <th>State</th>
            <th>Date Visited</th>
            <!--<th class="tb_tools"><ul class="floatright"><li><a class="button_smgr" href="javascript: void(0)" onclick="minimize(this)"><span><strong>-</strong></span></a></li></ul></th>-->
            </tr>
            <tr>
            	<?
				if($type == "blank") { ?>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <? } else { ?>
            	<td><?=stripslashes($r['Stores']['ReportsStores']['store_name'])?></td>
                <td><?=$r['Stores']['ReportsStores']['store_number']?></td>
                <td><?=$r['Stores']['ReportsStores']['city']?></td>
                <td><?=$r['Stores']['ReportsStores']['state']?></td>
                <td><? if(isset($r['Stores']['ReportsStores']['date_visited']) && strlen($r['Stores']['ReportsStores']['date_visited']) != 0) { echo date("m/d/y", $r['Stores']['ReportsStores']['date_visited']); } ?></td>
                <? } ?>
           		<!--<td></td>-->
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
    <td class="vendor_title">
      <div class="label"><?=$r2['Vendors']['company_name']?> Questions</div>
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