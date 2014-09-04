<?php
    //include 'themes/default/header.inc.php';
    require_once "application/bootstrap.php";
    if(isset(HTTP::$POST['act_login'])){
        $user=HTTP::$POST['login'];
        $pass=HTTP::$POST['pass'];
        if($user=="" || $pass==""){
            $msg=array("Error", "Username / Password Wrong !");
        }else{
            if(!$LS->login($user, $pass)){
                $msg=array("Error", "Username / Password Wrong !");
            }
        }
    }
    if(!$LS->loggedIn){
?>
<button class="btn btn-primary btn-lg" href="#signup" data-toggle="modal" data-target=".bs-modal-sm">Sign In/Register</button>
    <?php } ?>
<!-- Modal -->
<div class="modal fade bs-modal-sm" id="myModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
        <br>
        <div class="bs-example bs-example-tabs">
            <ul id="myTab" class="nav nav-tabs">
              <li class="active"><a href="#signin" data-toggle="tab">Sign In</a></li>
              <li class=""><a href="#signup" data-toggle="tab">Register</a></li>
              <li class=""><a href="#why" data-toggle="tab">Why?</a></li>
            </ul>
        </div>
      <div class="modal-body">
        <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade in" id="why">
        <p>We need this information so that you can receive access to the site and its content. Rest assured your information will not be sold, traded, or given to anyone.</p>
        <p></p><br> Please contact <a mailto:href="JoeSixPack@Sixpacksrus.com"></a>JoeSixPack@Sixpacksrus.com</a> for any other inquiries.</p>
        </div>
        <div class="tab-pane fade active in" id="signin">
            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title"><strong>Einloggen </strong></h3></div>
                <div class="panel-body">
                    <form role="form" action="login.php" method="POST">
                        <div class="form-group">
                            <label for="login">Username oder Email</label>
                            <input type="text" class="form-control" name="login" id="login" placeholder="Username oder Email">
                        </div>
                        <div class="form-group">
                            <label for="pass">Passwort <a href="reset.php">(forgot password)</a></label>
                            <input type="password" class="form-control" name="pass" id="pass" placeholder="Passwort">
                        </div>
                        <div class="checkbox">
                            <label>
                                <input name="remember_me" type="checkbox" value="Remember Me">Eingeloggt bleiben
                            </label>
                        </div>
                        <button type="submit" name="act_login" class="btn btn-sm btn-default">Einloggen</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="signup">
            <form class="form-horizontal" action="register.php" method="POST">
            <fieldset>
            <!-- Sign Up Form -->
            <!-- Text input-->
            <div class="control-group">
              <label class="control-label" for="user_email">Email:</label>
              <div class="controls">
                <input id="Email" name="user_email" class="form-control" type="text" placeholder="JoeSixpack@sixpacksrus.com" class="input-large" required="">
              </div>
            </div>
            
            <!-- Text input-->
            <div class="control-group">
              <label class="control-label" for="user_name">Username:</label>
              <div class="controls">
                <input id="userid" name="user_name" class="form-control" type="text" placeholder="JoeSixpack" class="input-large" required="">
              </div>
            </div>
            
            <!-- Password input-->
            <div class="control-group">
              <label class="control-label" for="pass">Password:</label>
              <div class="controls">
                <input id="password" name="pass" class="form-control" type="password" placeholder="********" class="input-large" required="">
                <em>1-8 Characters</em>
              </div>
            </div>
            
            <!-- Text input-->
            <div class="control-group">
              <label class="control-label" for="pass2">Re-Enter Password:</label>
              <div class="controls">
                <input id="reenterpassword" class="form-control" name="pass2" type="password" placeholder="********" class="input-large" required="">
              </div>
            </div>
            
            <!-- Text input-->
            <div class="control-group">
              <label class="control-label" for="code">Löschcode:</label>
              <div class="controls">
                <input id="reenterpassword" class="form-control" name="code" type="text" placeholder="1234567" class="input-large" required="">
              </div>
            </div>
            
            <!-- Text input-->
            <div class="control-group">
              <label class="control-label" for="display_name">Anzeigename:</label>
              <div class="controls">
                <input id="reenterpassword" class="form-control" name="display_name" type="text" placeholder="" class="input-large" required="">
              </div>
            </div>
            
            <!-- Button -->
            <div class="control-group">
              <label class="control-label" for="submit"></label>
              <div class="controls">
                <button id="confirmsignup" name="submit" class="btn btn-success">Sign Up</button>
              </div>
            </div>
            </fieldset>
            </form>
      </div>
    </div>
      </div>
      <div class="modal-footer">
      <center>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </center>
      </div>
    </div>
  </div>
</div>
            <?php
            if(isset($msg)){
             echo $msg[0]."<br/>".$msg[1];
            }
            ?>
<?php
    include 'themes/default/footer.inc.php';
?>