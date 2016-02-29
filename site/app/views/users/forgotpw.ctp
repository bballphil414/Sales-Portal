<form id="UserForgotPWForm" name="UserForgotPWForm" method="post" action="/site/users/forgotpw" accept-charset="utf-8">
<input type="hidden" name="_method" value="POST" />
	<fieldset id="login" title="forgot password">
    	<img id="logo" src="../img/cmi_logo.png" /><br /><br />
        <label for="UserUsername">Username:</label><input id="UserUsername" type="text" name="data[User][username]" size="30" /><br />
        <a class="button_or" id="submit" href="javascript: void(0)" onclick="javascript: document.UserForgotPWForm.submit()"><span>reset password</span></a>
        <span class="clear" id="tools">
		Take me back! <?php echo $html->link('User Login', '/users/login', array('title'=>'Login')); ?><br />
        New user?    <?php echo $html->link('Request access here.', '/users/request', array('title'=>'Request access')); ?>
        </span>
	</fieldset>
</form>