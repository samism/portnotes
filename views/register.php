<!-- errors & messages --->
<?php

// show negative messages
if ($registration->errors) {
    foreach ($registration->errors as $error) {
        echo $error . '<br>';    
    }
}

// show positive messages
if ($registration->messages) {
    foreach ($registration->messages as $message) {
        echo $message . '<br>';
    }
}

?>   

<!-- register form -->
<form method="post" action="register.php" name="registerform" id="reg-form">   
    <input placeholder="Username (only letters and numbers)" id="login_input_username" class="login_input" type="text" pattern="[a-zA-Z0-9]{2,64}" name="user_name" required>
    <input placeholder="Email" id="login_input_email" class="login_input" type="email" pattern="(.*){3,64}" name="user_email" required>        
    <input placeholder="Password" id="login_input_password_new" class="login_input" type="password" name="user_password_new" required autocomplete="off">  
    <input placeholder="Repeat Password" id="login_input_password_repeat" class="login_input" type="password" name="user_password_repeat" required autocomplete="off">        
    <input id="submit" type="submit" name="register" value="Register">
</form>