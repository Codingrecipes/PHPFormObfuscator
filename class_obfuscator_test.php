<?php
	
	require_once 'class_obfuscator.php';
	
	$form_fields = array('username', 'password', 'email');
	$obfuscator  = new Form_Obfuscator($form_fields);
	$obfuscator	-> set_secret_key('My Secret Key - KJFOIRET8439FSKJ');
	
	if( empty($_POST) ) {
		$fields 	 = $obfuscator	-> obfuscate();
		$enc_form = $obfuscator	-> encode_form();
		?>
<form action="" method="post">
	Name:<br /><input type="text" name="<?php echo $fields['username']; ?>" /><br /><br />
   Password:<br /><input type="password" name="<?php echo $fields['password']; ?>" /><br /><br />
   Email:<br /><input type="email" name="<?php echo $fields['email']; ?>" /><br /><br />
   <input type="submit" />
   <input type="hidden" name="__A" value="<?php echo $enc_form; ?>" />
</form>
      <?php
	} else {
		foreach($_POST as $key => $value) $_POST[ $key ] = trim(strip_tags($value)); /* Filter input */
		$form = $obfuscator -> decode_form($_POST['__A'], $_POST);
		
		foreach($form as $key => $value) $form[ $key ] = htmlentities($value, ENT_QUOTES, 'utf-8'); /* Escape output */
		echo "Username: {$form['username']}<br />
				Password: {$form['password']}<br />
				Email: {$form['email']}";
	}
	
?>