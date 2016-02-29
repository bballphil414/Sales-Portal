  <div id="content">
  <div id="top">
    <img id="logo" src="/site/img/cmi_logo_gr.png" />
      <div id="topWelcome">
      <h3>Welcome <? echo $session->read('Auth.User.first_name'); ?></h3><br />
	  <?php echo $html->link('Home', '/admin/dashboard', array('title'=>'Home', 'class'=>'crumbs')); ?> >> <?php echo $html->link('Store Vendor Pairs', '/admin/storesvendors', array('title'=>'Store Vendor Pairs', 'class'=>'crumbs')); ?> >> <?php echo $html->link('New Store Vendor Pair', '/admin/storesvendors/new', array('title'=>'New Store Vendor Pair', 'class'=>'crumbs')); ?>
      </div>
      <div id="topDate">
      <a href="/site/users/logout">Log Out</a> | <?php echo date("m\/d\/y"); ?>
      </div>
    <div class="clear"><!--IE--></div>
  </div>
 
 <!-- MAIN AREA START -->
 
  <div id="main">
  
  <fieldset id="fs_messages">
  <legend>Store Vendors - Add Pair</legend>
  <form id="ReportAdd" name="ReportAdd" method="post" action="/site/admin/storesvendors/new" accept-charset="utf-8">
	<input type="hidden" name="_method" value="POST" />
  <table>
  <tr>
    <td>
	  <div class="label">Choose Store:</div>
        <div class="select" id="">
        	<span id="span_store">Select Store</span>
            <div class="options">
            	<? 
				foreach($stores as $s) {
				?>
				<a href="javascript: changeSelectVal('store','<?=$s['Stores']['id']?>','<?=$s['Stores']['name']?>')" class="option"><?=$s['Stores']['name']?></a>
                <? } ?>
            </div>
            <input id="select_store" value="" type="hidden" name="data[Store][id]" />
        </div>
	</td>
    <tr>
    <td>
	  <div class="label">Choose Vendor:</div>
        <div class="select" id="">
        	<span id="span_vendor">Select Vendor</span>
            <div class="options">
            	<? 
				foreach($vendors as $v) {
				?>
				<a href="javascript: changeSelectVal('vendor','<?=$v['Vendors']['id']?>','<?=$v['Vendors']['company_name']?>')" class="option"><?=$v['Vendors']['company_name']?></a>
                <? } ?>
            </div>
            <input id="select_vendor" value="" type="hidden" name="data[Vendor][id]" />
        </div>
	</td>
  </tr>
  </tr>
  </table> 
  </form>
  <div class="fs_buttons">
  <a class="button_gr floatleft" href="/site/admin/storesvendors"><span>Cancel</span></a>
  <a class="button_or floatright" href="javascript: document.ReportAdd.submit()"><span>Save</span></a>
  </div>
  </fieldset>
  </div>
  