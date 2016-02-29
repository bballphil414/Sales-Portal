<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>CMI Portal</title>
<link href="styles.css" rel="stylesheet" type="text/css" />
</head>
<body>

<div id="content">
  <div id="top">
    <img id="logo" src="img/cmi_logo_gr.png" />
      <div id="topWelcome">
      <h3>Welcome Membername</h3><br />
      <a class="crumbs" href="javascript:void();" title="Home">Home</a>
      </div>
      <div id="topDate">
      <?php echo date("m\/d\/y"); ?>
      </div>
    <div class="clear"><!--IE--></div>
  </div>
 
 <!-- MAIN AREA START -->
 
  <div id="main">

  <fieldset id="fs_reports"><legend>reports - page 2 of 3</legend>
  <table id="tb_reports">
  <tbody>
  <tr>
  	<th>date</th>
    <th>store name</th>
    <th>store #</th>
    <th>location</th>
    <th>status</th>
    <th>tools</th>
  </tr>
  <tr>
  	<td>&nbsp;</td>
  	<td>&nbsp;</td>
  	<td>&nbsp;</td>
  	<td>&nbsp;</td>
  	<td>&nbsp;</td>
  	<td class="tb_tools">
        <ul>
        <li><a href="javascript:void();" title="edit"><img src="img/bt_edit.gif" /></a></li>
        <li><a href="javascript:void();" title="submit"><img src="img/bt_check.gif" /></a></li>
        <li><a href="javascript:void();" title="delete"><img src="img/bt_del.gif" /></a></li>
        </ul>
	</td>
  </tr>
  <tr class="odd">
  	<td>&nbsp;</td>
  	<td>&nbsp;</td>
  	<td>&nbsp;</td>
  	<td>&nbsp;</td>
  	<td>&nbsp;</td>
  	<td class="tb_tools">
        <ul>
        <li><img src="img/bt_edit_in.gif" /></li>
        <li><img src="img/bt_check_in.gif" /></li>
        <li><img src="img/bt_del_in.gif" /></li>
        </ul>
	</td>
  </tr>
    <tr>
  	<td>&nbsp;</td>
  	<td>&nbsp;</td>
  	<td>&nbsp;</td>
  	<td>&nbsp;</td>
  	<td>&nbsp;</td>
  	<td class="tb_tools">
        <ul>
        <li><img src="img/bt_edit_in.gif" /></li>
        <li><img src="img/bt_check_in.gif" /></li>
        <li><img src="img/bt_del_in.gif" /></li>
        </ul>
	</td>
  </tr>
  </tbody>
  </table>
  
  <div class="fs_buttons">
  <a class="button_or" id="rpt_new" href="javascript:void();"><span>new report</span></a>
  </div>
  </fieldset>
  
  <fieldset id="fs_quick_export"><legend>report export</legend>
  <table>
  	<tr>
  		<td>
        	<input type="checkbox" name="selectc" class="form_checkbox2" />
  			<div class="td_padded">
            	Date Range: June 1, 2010 - July 31, 2010<a class="bt_date" href="javascript:void();" title="edit date range"><img src="img/bt_date.gif" /></a>
            </div>
        </td>
    </tr>
    <tr class="odd">
    	<td>
        	<input type="checkbox" name="selectc" class="form_checkbox2" />
        	<div class="select">
        	<span id="span_c">Store #</span>
            <div class="options">
            <a href="javascript: changeSelectVal('s','something')" class="option">Something</a>
                <a href="#" class="option">Something Else</a>
                <a href="#" class="option last">Something last</a>
            </div>
            <select id="select_s" name="">
            	<option value="1"></option>
                <option value="2"></option>
            </select>
        	</div>
        </td>
    </tr>
    <tr>
    	<td>
        	<input type="checkbox" name="selectc" class="form_checkbox2" />
        	<div class="select">
        	<span id="span_c">Location</span>
            <div class="options">
            <a href="javascript: changeSelectVal('s','something')" class="option">Something</a>
                <a href="#" class="option">Something Else</a>
                <a href="#" class="option last">Something last</a>
            </div>
            <select id="select_s" name="">
            	<option value="1"></option>
                <option value="2"></option>
            </select>
        	</div>
        </td>
    </tr>
  </table>
  <div class="fs_buttons">
  <a class="button_or" id="xls" href="javascript:void();"><span>xls</span></a>
  <a class="button_or" id="pdf" href="javascript:void();"><span>pdf</span></a>
  </div>
  </fieldset>

  </div>
  
<!-- MAIN AREA END -->
<!-- RIGHT COL START -->

  <div id="rightCol">

  <fieldset id="fs_file_library" class="rc_module">
  <legend>File LiBraRy</legend>
  <ul>
  	<li><a href="javascript:void();" title="Filename">Filename</a></li>
  	<li><a href="javascript:void();" title="Filename">Filename</a></li>
  	<li><a href="javascript:void();" title="Filename">Filename</a></li>
  	<li><a href="javascript:void();" title="Filename">Filename</a></li>
  	<li><a href="javascript:void();" title="Filename">Filename</a></li>
  	<li id="last"><a href="javascript:void();" title="Filename">Filename</a></li>
  </ul>  
    <a class="button_gr floatright" id="lib_all" href="javascript:void();"><span>see all files</span></a>
  </fieldset>
  
  <fieldset id="fs_contacts" class="rc_module">
  <legend>Contacts</legend>
  <ul>
  	<li>
    	<a href="javascript:void();" title="see more...">Contact Name<br />
  		Company Name<br />
        M: 888-888-8888</a>
    </li>
    <li id="last"><a href="javascript:void();" title="see more...">Short Contact Name</a></li>
  </ul>
  <a class="button_or" id="con_new" href="javascript:void();"><span>new contact</span></a>
  <a class="button_gr floatright" id="con_all" href="javascript:void();"><span>all contacts</span></a>

  </fieldset>

  </div>
</div>
</body>
</html>
