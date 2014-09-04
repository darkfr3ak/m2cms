<?php
    include 'themes/default/header.inc.php';
    ?>
        <div id="signupbox" style="margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title">Reset Password</div>
                    <div style="float:right; font-size: 85%; position: relative; top:-10px"><a id="signinlink" href="login.php">Sign In</a></div>
                </div>  
                <div class="panel-body" >
                    <?php
                    $LS->forgotPassword();
                    ?>
                </div>
            </div>
        </div>
<?php
    include 'themes/default/footer.inc.php';
?>