<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Print Report</title>
<?=$html->css('print.css')?>
</head>
<body>
		<?=$session->flash();
		echo $session->flash('auth');
?>
       <?php echo $content_for_layout ?>
</body>
</html>
