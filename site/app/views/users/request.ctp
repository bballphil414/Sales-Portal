<form id="UserRequestForm" name="UserRequestForm" method="post" action="/site/users/forgotpw" accept-charset="utf-8">
<input type="hidden" name="_method" value="POST" />
	<fieldset id="login" title="request access">
    	<img id="logo" src="../img/cmi_logo.png" /><br /><br />
        <label>Name:</label><input type="text" name="data[User][first_name]" size="30" /><br />
        <label>Email:</label><input type="text" name="data[User][username]" size="30" /><br />
        <a class="button_or" id="submit" href="javascript: void(0)" onclick="javascript: document.UserRequestForm.submit()"><span>request access</span></a>
        <span class="clear" id="tools">
		Take me back! <?php echo $html->link('User Login', '/users/login', array('title'=>'Login')); ?><br />
        Forgot Password?    <?php echo $html->link('Reset Password', '/users/forgotpw', array('title'=>'Reset Password')); ?>
        </span>
	</fieldset>
</form>