<?php

//show negative messages
if ($login->errors) {
    foreach ($login->errors as $error) {
        echo $error;    
    }
}

// show positive messages
if ($login->messages) {
    foreach ($login->messages as $message) {
        echo $message;
    }
}

?> 


<form name="loginform" action="index.php" method="post">
    <input name="user_name" placeholder="Username" id="user" type="text" autofocus required>
    <br>
    <input name="user_password" placeholder="Password" id="pass" type="password" autocomplete="off" required>
    <br><br>
    <div id="button-wrapper">
        <input id="submit" name="login" value="Sign in" type="submit">
    </div>
    <a class="misc-link" href="register.php">Register</a>
    <br>
    <a class="misc-link" href="javascript:alert('Too bad!');">Forgot passcode</a>
</form>
        