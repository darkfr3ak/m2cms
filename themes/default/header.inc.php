<?php
    require "application/bootstrap.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="themes/<?php echo THEME ?>/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="themes/<?php echo THEME ?>/css/font-awesome.min.css" rel="stylesheet" media="screen">
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,700' rel='stylesheet' type='text/css'>
        <style type="text/css">
        body {
          padding-top: 65px;
          padding-bottom: 40px;
          background-color: #E5E5E5;
        }

        .form-signin {
           border: 1px solid #D8D8D8;
           border-bottom-width: 2px;
           border-top-width: 0;
           background-color: #FFF;
           max-width: 350px;
          padding: 19px 29px 29px;
          margin: 0 auto 20px;
          background-color: #fff;
          border: 1px solid #F5F5F5;
          -webkit-border-radius: 3px;
             -moz-border-radius: 3px;
                  border-radius: 3px;
        }
        .form-signin .form-signin-heading {
           font-size: 24px;
           font-weight: 300;
        }

        .form-signin .form-signin-heading,
        .form-signin .checkbox {
          margin-bottom: 10px;
        }
        .form-signin input[type="text"],
        .form-signin input[type="password"] {
          font-size: 16px;
          height: auto;
          margin-bottom: 15px;
          padding: 7px 9px;
        }

        </style>
    </head>
    <body>
        <!-- Main Menu Top -->
        <?php
        $main = new Menu;

        $main->add('<span class="glyphicon glyphicon-home"></span>', 'index.php');
        $about = $main->add('about', 'about.php');
        //$about->add('Who we are?', 'who-we-are?');
        //$about->add('What we do?', 'what-we-do?');
        //$main->add('Services', 'services');

        // menu #2
        $user = new Menu;
        $profile = $user->add('Profile', '');
        $profile->add('Account', 'profile.php')->link->prepend('<span class="glyphicon glyphicon-user"></span> ');

        $profile->add('Settings', 'settings')->link->prepend('<span class="glyphicon glyphicon-cog"></span> ');
        $user->add('Logout', 'logout.php');
        
        function bootstrapItems($items) {
	
            // Starting from items at root level
            if( !is_array($items) ) {
                $items = $items->roots();
            }

            foreach( $items as $item ) {
            ?>
                <li<?php if($item->hasChildren()): ?> class="dropdown"<?php endif ?>>
                    <a href="<?php echo $item->link->get_url() ?>" <?php if($item->hasChildren()): ?> class="dropdown-toggle" data-toggle="dropdown" <?php endif ?>>
                    <?php echo $item->link->get_text() ?> <?php if($item->hasChildren()): ?> <b class="caret"></b> <?php endif ?></a>
                    <?php if($item->hasChildren()): ?>
                    <ul class="dropdown-menu">
                        <?php bootstrapItems( $item->children() ) ?>
                    </ul> 
                    <?php endif ?>
                </li>
                <?php
            }
        }
        ?>
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php"><?php echo $LS->company; ?></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <?php echo bootstrapItems($main); ?>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <?php 
        if($LS->loggedIn){
            echo bootstrapItems($user);
            ?>
            <p class="navbar-text navbar-right">Signed in as <a href="profile.php" class="navbar-link"><?php echo $LS->getUser("user_name"); ?></a></p>
        <?php
        }else{
            ?>
            <p class="navbar-text navbar-right"><a href="login.php" class="navbar-link">Einloggen / Anmelden</a></p>
        <?php
        }
        ?>
          
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container -->
</nav>
        <div class="container">
            
            