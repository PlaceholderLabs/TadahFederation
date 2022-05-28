<?php
// Tadah Federation API example file.
include './tadah_federation.php';


// Detect if any POST data was received, if so log in to Tadah.
if(isset($_POST)){
    if(isset($_POST['email']) && isset($_POST['password'])){
        $email = $_POST['email'];
        $password = $_POST['password'];
        $login = new tadah_federation();
        $login_result = $login->Login($email, $password);
        echo "LOGIN RESULT: ".$login_result."\n";
    }
}

// Detect if any GET data was received, if so log in to Tadah.
if(isset($_GET)){
    if(isset($_GET['email']) && isset($_GET['password'])){
        $email = $_GET['email'];
        $password = $_GET['password'];
        $login = new tadah_federation();
        $login_result = $login->Login($email, $password);
        echo "LOGIN RESULT: ".$login_result."\n";
    }
}

// Below is an example Form for logging into a Tadah account and returns User info.
?>
<h1>Tadah Federation API Example - Login</h1>
<form action="" method="post">
    <input type="text" name="email" placeholder="Tadah Email">
    <input type="password" name="password" placeholder="Password">
    <input type="submit" value="Login">
</form>
