<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>CMI Portal</title>
<?=$html->css('style.css')?>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>
<script type="text/javascript" src="https://github.com/douglascrockford/JSON-js/raw/master/json2.js"></script>
<script type="text/javascript" src="http://portal.comprehensive1.com/site/js/string.js"></script>
<?
if(isset($view)) { ?>
<script type="text/javascript">
var questions = "";
$(document).ready(function() {
  // Handler for .ready() called.
  questions = $("#form_questions").html();
  $("a[name*='link_']").minimize(this);
});
</script>
<? } ?>
</head>
<body>
		<?=$session->flash();
		echo $session->flash('auth');
?>
       <?php echo $content_for_layout ?>

		<? if(isset($_SESSION['Auth']['User']['id'])) {  require("right.ctp"); } ?>
</body>
</html>
