<script type="text/javascript">
function press(e) { 
	if(e.keyCode == 13) {
		document.UserLoginForm.submit();
	}
}
</script>
<form id="UserLoginForm" name="UserLoginForm" method="post" action="/site/users/login/" accept-charset="utf-8">
<input type="hidden" name="_method" value="POST" />
	<fieldset id="login" title="login">
	<div style="width:215px;margin:0 auto;">
    	<img id="logo" src="../img/cmi_logo.png" /><br /><br />
        <label for="UserUsername">Username:</label><input id="UserUsername" type="text" name="data[User][username]" size="30" onkeypress="javascript: press(event)" /><br />
        <label for="UserPassword">Password:</label><input id="UserPassword" type="password" name="data[User][password]" size="30" onkeypress="javascript: press(event)" /><br />
        <a class="button_or" id="submit" href="javascript: void(0)" onclick="javascript: document.UserLoginForm.submit()"><span>login</span></a>
        <br style="clear: both" /><br />
		<a href="/site/users/forgotpw" title="Password reset">Forgot Password?</a><br />
        New user? <a href="mailto://bscruggs@comprehensive1.com" title="Request access">Request access here.</a>
	</div>
	</fieldset>
</form>