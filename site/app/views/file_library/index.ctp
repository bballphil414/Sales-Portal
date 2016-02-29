<script type="text/javascript">
function toggle(o) {
	if (/MSIE (\d+\.\d+);/.test(navigator.userAgent)) { //test for MSIE x.x;
 		var ieversion=new Number(RegExp.$1) // capture x.x portion and store as a number
 		if (ieversion<8) {
			$(o).next('ul').toggle();
		} else {
			$(o).parents('li').next('ul').toggle('fast');
		}
	} else {
		$(o).parents('li').next('ul').toggle('fast');
	}
}
</script>

<div id="content">
  <div id="top">
    <img id="logo" src="img/cmi_logo_gr.png" />
      <div id="topWelcome">
      <h3>Welcome <? echo $session->read('Auth.User.first_name'); ?></h3><br />
	  <?php echo $html->link('Home', '/dashboard', array('title'=>'Home', 'class'=>'crumbs')); ?> > <?php echo $html->link('File Library', '/file_library', array('title'=>'File Library', 'class'=>'crumbs')); ?>
      </div>
      <div id="topDate">
      <a href="/site/users/logout">Log Out</a> | <?php echo date("m\/d\/y"); ?>
      </div>
    <div class="clear"><!--IE--></div>
  </div>
 
 <!-- MAIN AREA START -->
 
  <div id="main">
  
  <fieldset id="fs_filelib"><legend>file library</legend>
  <div class="file_table"> 
  <ul class="col_heads"> 
  	<li class="tb_name">name</li> 
    <li class="tb_tools">tools</li> 
    <li class="tb_size">file size</li> 
    <li class="tb_date">date added</li> 
  </ul>
  <ul>
  <?			
  				function getFileNum($id, $files, $session) {
					$num = 0;
					foreach($files as $f) {
						if($f['Files']['directory_id'] == $id) {
							$num++;
						}
					}
					return $num;
				}
				function format_size($size) {
      				$sizes = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
      				if ($size == 0) { return('n/a'); } else {
      				return (round($size/pow(1024, ($i = floor(log($size, 1024)))), $i > 1 ? 2 : 0) . $sizes[$i]); }
				}
				function file_ending($file) {
					$f = explode(".", $file);
					if($f[sizeof($f)-1] == "xls") {
						$r = "<img src='img/mime/xls.png' />";
					} else if($f[sizeof($f)-1] == "ppt") {
						$r = "<img src='img/mime/ppt.png' />";
					} else if($f[sizeof($f)-1] == "doc") {
						$r = "<img src='img/mime/doc.png' />";
					} else if($f[sizeof($f)-1] == "pdf") {
						$r = "<img src='img/mime/pdf.png' />";
					} else if($f[sizeof($f)-1] == "jpg" || $f[sizeof($f)-1] == "gif" || $f[sizeof($f)-1] == "png" || $f[sizeof($f)-1] == "jpeg" || $f[sizeof($f)-1] == "bmp") {
						$r = "<img src='img/mime/image.png' />";
					} else if($f[sizeof($f)-1] == "psd") {
						$r = "<img src='img/mime/psd.png' />";
					} else if($f[sizeof($f)-1] == "ai") {
						$r = "<img src='img/mime/ai.png' />";
					} else {
						$r = "<img src='img/mime/other.png' />";
					}
					return $r;
				}
  				function getFiles($id, $files, $session, $s) {
					
					foreach($files as $f) {
						if($f['Files']['directory_id'] == $id) {
							?>
                            <ul class="tb_file"> 
      							<li class="tb_name">
                                	<a href="/uploads/<?=$f['Files']['file']?>">
                                		<?=file_ending($f['Files']['file'])?> <?=$f['Files']['file']?>
                                    </a>
                                	<div class="clear"></div>
                                </li> 
      							<li class="tb_tools">
                                <ul>
        							
                                    	<?
                                        if($f['Files']['user_id'] == $session->read('Auth.User.id')) {
											?><li><a href="/site/file_library/delete/<?=$f['Files']['id']?>" title="delete" onclick="return confirm('Are you sure?');"><img src="img/bt_del.gif" /></a></li>
                                        <? } ?>
                                    
									
        						</ul>
                                </li> 
  	  							<li class="tb_size"><?=format_size(filesize("/home/comprehe/public_html/portal/uploads/".$f['Files']['file'])) ?></li>
  	  							<li class="tb_date"><?=date("m/d/y", $f['Files']['timestamp'])?></li> 
    						</ul> 
                            <?
						}
					}
				}
				
							
				function children3($dirs, $id, $i, $files, $session) {
					foreach($dirs as $d) {
						if($d['Directories']['id'] != $id && $d['Directories']['directory_id'] == $id) {
							// show
							$s = "";
							for($i2 = 0; $i2 < $i; $i2++) {
								$s .= "&nbsp;&nbsp;";
							}
							$num = getFileNum($d['Directories']['id'], $files, $session);
							if($num == 0) {
								$num = "";
							} else {
								$num = "(".$num.")";
							}
							?>
                            <li class="tb_folder"><a href="javascript: void(0)" onclick="toggle(this)"><img src="img/mime/folder.png" /> <?=$d['Directories']['name']?> <?=$num?></a></li> 
                            <? /* <!--<tr class="odd">
  							<td><?=$s?><a href="javascript: void(0)" onclick="$(this).parents('tr').next('table').css('display', 'block');"><img src="img/mime/folder.png" />  <?=$d['Directories']['name']?> <?=$num?></a></td>
  							<td>&nbsp;</td>
  							<td>&nbsp;</td>
  							<td class="tb_tools">
                            	<?
                                        if($d['Directories']['user_id'] == $session->read('Auth.User.id')) {
											?><li><a href="/site/file_library/directory_delete/<?=$d['Directories']['id']?>" title="delete" onclick="return confirm('Are you sure?  This will delete all files in this folder as well.');"><img src="img/bt_del.gif" /></a></li>
                                        <? } ?>
							</td>
  							</tr>-->
							*/
							?>
                            <ul style='display: none'>
                            <?
							getFiles($d['Directories']['id'], $files, $session, $s);
							children3($dirs, $d['Directories']['id'], $i+1, $files, $session);
							?>
                            </ul>
							<?
						}
					}
					return true;
				}
				getFiles(0, $files, $session, '');
				foreach($dirs as $d) {
					if($d['Directories']['directory_id'] == 0) {
						// display folder
						$num = getFileNum($d['Directories']['id'], $files, $session);
							if($num == 0) {
								$num = "";
							} else {
								$num = "(".$num.")";
							}
						?>
                        <li class="tb_folder"><a href="javascript: void(0)" onclick="toggle(this)"><img src="img/mime/folder.png" /> <?=$d['Directories']['name']?> <?=$num?></a></li> 
                    	<? /* <!--<tr class="odd">
  							<td><a href="javascript:void(0);" onclick="$(this).parents('tr').next('table').css('display','block');"><img src="img/mime/folder.png" />  <?=$d['Directories']['name']?> <?=$num?></a></td>
  							<td>&nbsp;</td>
  							<td>&nbsp;</td>
  							<td class="tb_tools">
							</td>
  							</tr>-->
							*/ ?>
                        <ul style='display: none'>
                    	<?
						getFiles($d['Directories']['id'], $files, $session, '');
						children3($dirs, $d['Directories']['id'], 1, $files, $session);
						?>
                        </ul>
						<?
					}
				}
				?>
                
	</ul>
  </div>
  </fieldset>
	<p></p>
  
  </div>
  
<!-- MAIN AREA END -->