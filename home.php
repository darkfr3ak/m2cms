<?php
    include 'themes/default/header.inc.php';
    if( isset(HTTP::$POST['newName']) ){
	HTTP::$POST['newName'] = HTTP::$POST['newName']=="" ? "Dude" : HTTP::$POST['newName'];
	$LS->updateUser(array(
            "display_name" => HTTP::$POST['newName']
	));
    }
    $details = $LS->getUser();
?>
            <p>
                You registered on this website <strong><?php echo $LS->timeSinceJoin(); ?></strong> ago.
            </p>
            <p>
                Here is the full data the database stores on this user :
            </p>
            <pre><?php
                print_r($details);
                
                if($details['mAuthority'] == "IMPLEMENTOR"){
                    echo "Oberaffe vom Dienst";
                }
            ?></pre> 
            <p>
                Change the name of your account :
            </p>
            <form action="home.php" method="POST">
                <input name="newName" placeholder="New name" />
                <button class="btn btn-primary">Change Name</button>
            </form>
<?php
    include 'themes/default/footer.inc.php';
?>