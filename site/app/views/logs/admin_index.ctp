<div id="content">
  <div id="top">
    <img id="logo" src="/site/img/cmi_logo_gr.png" />
      <div id="topWelcome">
      <h3>Welcome <? echo $session->read('Auth.User.first_name'); ?></h3><br />
	  <?php echo $html->link('Home', '/admin/dashboard', array('title'=>'Home', 'class'=>'crumbs')); ?> > <?php echo $html->link('Logs', '/admin/logs', array('title'=>'Logs', 'class'=>'crumbs')); ?>
      </div>
      <div id="topDate">
      <a href="/site/users/logout">Log Out</a> | <?php echo date("m\/d\/y"); ?>
      </div>
    <div class="clear"><!--IE--></div>
  </div>

<script type="text/javascript">
function s(event) {
	var k;
	if(event.which) {
		k = event.which;
	} else {
		k = event.keyCode;
	}
	if(k == 13) {
	$.ajax({
  		url: "/site/admin/logs/search",
  		cache: false,
 		type: "POST",
  		data: "data[string]="+$('#search_string').html()+"",
  		success: function(html){
    			$("#search_results").html(html);
		}
	});
	}
}

 </script>
 <!-- MAIN AREA START -->
 
  <div id="main">
  <?
  ?>
  <fieldset id="fs_logs_search">
  <legend>search</legend>
  <table>
  <tbody>
  <tr class="odd"><td>
  <input type="text" id="search_string" onkeyup="s(event)" name="string" style="width: 200px; float:left;height: 20px; margin-left: 200px; text-align: center; font-family: Tahoma; font-size: 11px; font-weight: bold" value="Enter a Search Phrase" onfocus="this.value=''; this.style.fontWeight='normal'; $('#reset_search').fadeIn('fast');"  />
  <a href="#" onclick="$('#search_results').html(''); $('#search_string').val(''); $(this).fadeOut('fast');" id="reset_search" title="reset" style="margin-top: 3px;display:none;float:left;margin-left:5px"><img src="/site/img/bt_del.gif" /></a>
  <br style="clear: both" />
  </td></tr>
  </tbody>
  </table>
  </fieldset>
  
  <fieldset id="fs_messages">
  <legend>recent activity</legend>
  <table id="tb_messages">
  <tbody>
  <tr>
  	<th>timestamp</th>
    <th>user</th>
    <th>event description</th>
  </tr>
  </tbody>
  </table>
  <table id="search_results">
  <tbody>
  <?
  $i = 0;
  foreach($logs as $l=>$k) { ?>
  <tr<? if($i == 1) { ?> class="odd"<? } ?>>
  	<td><?=date('m/d/y @ g:ia', $k['timestamp'])?></td>
  	<td><?=$k['Users']['first_name']?></td>
  	<td><?=$k['event_description']?></td>
  </tr>
  <?
  if($i == 0) {
	  $i = 1;
  } else {
	  $i = 0;
  }
  } ?>
  </tbody>
  </table>
  </fieldset>
  </div>
  
<!-- MAIN AREA END -->