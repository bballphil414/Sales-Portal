<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<style type="text/css" media="all">
<!--
@import url("images/style.css");
-->
</style>
</head>

<body>
<div id="dropdown"  onclick="show_dropdown()" >
<input id="dd_text" name="dd_text" type="text" value="SE"  size="10"  readonly=""  />
<div id="dd_list" onmousemove="show_dropdown()" onmouseout="hide_list()" >
	<div id="ul">
		<div id="li"><a onclick="setText('sekar 1');">Sekar 1</a></div>
		<div id="li"><a onclick="setText('sekar 2');">Sekar 2</a></div>
		<div id="li"><a onclick="setText('sekar 3');">Sekar 3</a></div>
		<div id="li"><a onclick="setText('sekar 4');"  >Sekar 4</a></div>
	</div>
</div>
</div>
<script>
	var hide= false;
    function show_dropdown(){
		if(!hide) document.getElementById("dd_list").style.visibility="visible";
		hide= false;
		//document.getElementById("dd_text").value=121;
	}
	function downkey(){
	
	}
	
	function setText(val){
		hide=true;
		hide_list();
		document.getElementById("dd_text").value=val;
		
	}
	function hide_list(){
		document.getElementById("dd_list").style.visibility="hidden";
	}
</script>
	
	

</body>
</html>
