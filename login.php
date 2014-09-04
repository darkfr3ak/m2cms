<?php
    include 'themes/default/header.inc.php';
    if(isset(HTTP::$POST['act_login'])){
        $user=HTTP::$POST['login'];
        $pass=HTTP::$POST['pass'];
        if($user==""){
            $login_msg = array("Error", "Please enter your Username !");
        }elseif($pass==""){
            $login_msg = array("Error", "Please enter your Password!");
        }else{
            if(!$LS->login($user, $pass)){
                $login_msg = array("Error", "Username or Password wrong !");
            }else{
                $LS->redirect("home.php");
            }
        }
    }
    ?>

        <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
            <div class="panel panel-info" >
                <div class="panel-heading">
                    <div class="panel-title">Sign In</div>
                    <div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="reset.php">Forgot password?</a></div>
                </div>     

                <div style="padding-top:30px" class="panel-body" >
                    <?php
                    if(isset($msg)){
                        ?>
                        <div id="login-alert" class="alert alert-danger" role="alert">
                            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <?php
                        echo "<strong>".$login_msg[0]."</strong> ".$login_msg[1];
                        ?>
                        </div>
                        <?php
                    }
                    ?>
                    <form id="loginform" class="form-horizontal" role="form" action="login.php" method="POST">
                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input id="login-username" type="text" class="form-control" name="login" value="" placeholder="username or email">                                        
                        </div>
                                
                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input id="login-password" type="password" class="form-control" name="pass" placeholder="password">
                        </div>
                        <div class="input-group">
                            <div class="checkbox">
                                <label>
                                    <input id="login-remember" type="checkbox" name="remember_me" value="1"> Remember me
                                </label>
                            </div>
                        </div>
                        <div style="margin-top:10px" class="form-group">
                            <!-- Button -->
                            <div class="col-sm-12 controls">
                                <button type="submit" name="act_login" class="btn btn-success">Login  </button>
                                <!--<a id="btn-fblogin" href="#" class="btn btn-primary">Login with Facebook</a>-->
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 control">
                                <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
                                    Don't have an account? 
                                    <a href="register.php">
                                        Sign Up Here
                                    </a>
                                </div>
                            </div>
                        </div>    
                    </form>     
                </div>                     
            </div>  
        </div>
        
        <div style="display: none; margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2" id="forgot-pass">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title">Forgot your password?</div>
                    <div style="float:right; font-size: 85%; position: relative; top:-10px"><a id="signinlink" href="#" onclick="$('#signupbox').hide(); $('#loginbox').show()">Sign In</a></div>
                </div>  
                <div class="panel-body" >
                    <?php $LS->forgotPassword(); ?>
                    <form accept-charset="UTF-8" role="form" id="login-recordar" method="post">
                        <fieldset>
                            <span class="help-block">
                                Email address you use to log in to your account
                                <br>
                                We'll send you an email with instructions to choose a new password.
                            </span>
                            <div class="form-group input-group">
                                <span class="input-group-addon">
                                    @
                                </span>
                                <input class="form-control" placeholder="Email" name="email" type="email" required="">
                            </div>
                            <button type="submit" class="btn btn-primary btn-block" id="btn-olvidado">
                                Continue
                            </button>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
            
<?php
    include 'themes/default/footer.inc.php';
?>