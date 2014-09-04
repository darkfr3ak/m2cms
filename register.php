<?php
    include 'themes/default/header.inc.php';
?>
            <div class="container">
                <?php
	   	if( isset(HTTP::$POST['submit']) ){
	    		$user	 = HTTP::$POST['user_name'];
	    		$email = HTTP::$POST['user_email'];
	    		$pass	 = HTTP::$POST['pass'];
	    		$pass2 = HTTP::$POST['pass2'];
	    		$name	 = HTTP::$POST['display_name'];
	    		$code	 = HTTP::$POST['code'];
	    		if( $user=="" || $email=="" || $pass=='' || $pass2=='' || $name=='' || $code=="" ){
	     			echo "Fields Left Blank","Some Fields were left blank. Please fill up all fields.";
	     			exit;
	    		}
	    		if( !$LS->validEmail($email) ){
	     			echo "E-Mail Is Not Valid", "The E-Mail you gave is not valid";
	     			exit;
	    		}
	    		if( !ctype_alnum($user) ){
	     			echo "Invalid Username", "The Username is not valid. Only ALPHANUMERIC characters are allowed and shouldn't exceed 10 characters.";
	     			exit;
	    		}
	    		if($pass != $pass2){
		     		echo "Passwords Don't Match","The Passwords you entered didn't match";
	     			exit;
	    		}
   	 		$createAccount = $LS->register($user, $pass, $code,
	    			array(
	    				"user_email" 	 => $email,
	    				"display_name" 	 => $name,
	    				"created" => date("Y-m-d H:i:s") // Just for testing
	    			)
	    		);
	    		if($createAccount === "exists"){
	     			echo "User Exists.";
	    		}elseif($createAccount === true){
	     			echo "Success. Created account. <a href='login.php'>Log In</a>";
	    		}
	   	}
	   	?>
 		</div>
<?php
    include 'themes/default/footer.inc.php';
?>