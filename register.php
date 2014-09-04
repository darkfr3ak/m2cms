<?php
    include 'themes/default/header.inc.php';
    if( isset(HTTP::$POST['reg_submit']) ){
        $user       = HTTP::$POST['user_name'];
        $email      = HTTP::$POST['user_email'];
        $pass       = HTTP::$POST['pass'];
        $pass2      = HTTP::$POST['pass2'];
        $name       = HTTP::$POST['display_name'];
        $code       = HTTP::$POST['code'];
        if( $user=="" || $email=="" || $pass=='' || $pass2=='' || $name=='' || $code=="" ){
            $reg_msg = "Some Fields were left blank. Please fill up all fields.";
            exit;
	}
        if( !$LS->validEmail($email) ){
            $reg_msg = "The E-Mail you gave is not valid";
            exit;
        }
        if( !ctype_alnum($user) ){
            $reg_msg = "The Username is not valid. Only ALPHANUMERIC characters are allowed and shouldn't exceed 10 characters.";
            exit;
        }
        if($pass != $pass2){
            $reg_msg = "The Passwords you entered didn't match";
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
            $reg_msg = "User Exists.";
        }elseif($createAccount === true){
            $reg_success = "Success. Created account. <a href='login.php'>Log In</a>";
        }
    }
?>
        <div id="signupbox" style="margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title">Sign Up</div>
                    <div style="float:right; font-size: 85%; position: relative; top:-10px"><a id="signinlink" href="login.php">Sign In</a></div>
                </div>  
                <div class="panel-body" >
                    <form id="signupform" class="form-horizontal" role="form" action="register.php" method="POST">
                        <?php
                        if(isset($reg_msg)){
                        ?>
                            <div id="signup-alert" class="alert alert-danger" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <?php
                                echo "<strong>Error</strong> ".$reg_msg[1];
                                ?>
                            </div>
                        <?php
                        }
                        ?>

                        <div class="form-group">
                            <label for="user_email" class="col-md-3 control-label">Email</label>
                            <div class="col-md-9">
                                <input type="email" class="form-control" name="user_email" placeholder="Email Address">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="user_name" class="col-md-3 control-label">Username</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="user_name" placeholder="Username">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="display_name" class="col-md-3 control-label">Display-Name</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="display_name" placeholder="Display-Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pass" class="col-md-3 control-label">Password</label>
                            <div class="col-md-9">
                                <input type="password" class="form-control" name="pass" placeholder="Password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pass2" class="col-md-3 control-label">Re-enter Password</label>
                            <div class="col-md-9">
                                <input type="password" class="form-control" name="pass2" placeholder="Password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="code" class="col-md-3 control-label">Delete Code</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="code" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <!-- Button -->                                        
                            <div class="col-md-offset-3 col-md-9">
                                <button id="submit" type="submit" class="btn btn-info" name="reg_submit"><i class="icon-hand-right"></i> &nbsp Sign Up</button>
                                <!--<span style="margin-left:8px;">or</span>-->
                            </div>
                        </div>
                        <!--
                        <div style="border-top: 1px solid #999; padding-top:20px"  class="form-group">
                            <div class="col-md-offset-3 col-md-9">
                                <button id="btn-fbsignup" type="button" class="btn btn-primary"><i class="icon-facebook"></i>   Sign Up with Facebook</button>
                            </div>                                           
                        </div>
                        -->
                    </form>
                </div>
            </div>
        </div>
<?php
    include 'themes/default/footer.inc.php';
?>