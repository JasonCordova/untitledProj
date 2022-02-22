<!DOCTYPE html>

<html>

    <head>
        
        <link rel="stylesheet" href="index.css"/>
        <link rel="stylesheet" href="lib/navigation.css"/>
        <title>Register</title>

        <script src="js-functions.js"></script>

        <script>
    
            function onload(){
    
                checkAllInputs();
                showInvis();
    
            }
    
        </script>

    </head>

    <body onload="onload()">

        <div class="fullbody-container">

            <?php

                include "lib/navigation.php";

                if (loggedIn()){

                    header("Location: home.php");

                }

                function checkRegister($email, $username, $password, $confirm){

                    $sanitizedEmail = filter_var($email, FILTER_SANITIZE_EMAIL);

                    // Check to see if all fields are not empty.

                    if (empty($sanitizedEmail) || empty($username) || empty($password) || empty($confirm)){

                        return false;

                    }

                    // Check to see if the sanitized email is validated.

                    if (!filter_var($sanitizedEmail, FILTER_VALIDATE_EMAIL)){

                        return false;

                    }

                    // Check to see if the username is not already in the SQL table.

                    if (strlen($password) < 8){

                        return false;

                    }

                    // Check to see if the password equals the confirm password;

                    if (strlen($password) > 0 && $password !== $confirm){

                        return false;

                    }

                    return true;

                }

                if (isset($_POST) && !empty($_POST)){

                    $email = se($_POST, "email", "", false);
                    $username = se($_POST, "username", "", false);
                    $password = se($_POST, "password", "", false);
                    $confirm = se($_POST, "confirm-password", "", false);
                    $registerAbility = checkRegister($email, $username, $password, $confirm);

                    if ($registerAbility) {

                        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                        $stmt = $db->prepare("INSERT INTO Users (email, username, password) VALUES (:email, :username, :password)");

                        try {

                            $stmt->execute([":email" => $email, ":username" => $username, ":password" => $hashedPassword]);
                            header("Location: login.php");


                        } catch (PDOException $e){

                            echo var_export($e);

                        }

                    }

                    

                    // if Username is not in the Users table.
                    // if Email is valid after sanitzation.
                    // if Email is not in the Users table.
                    // CHECK LATER FOR PASSWORD.
                    // if confirm password matches with password.

                    // IF MEETS ALL CRITERIA, THEN INSERT INTO USERS!!!

                }

            ?>

            <div class="form-holder">

                <form class="custom-form" method="POST">

                    <div class="form-title">Sign Up</div>
                    <div class="form-alt-title">Already have an account? <a href="login.php">Log in</a></div>

                    <div class="form-input-container">

                        <div class="basic-form-input-holder">

                            <input type="text" name="email" class="basic-form-input"/>
                            <span class="basic-form-span">Email address</span>

                        </div>

                        <div class="basic-form-input-holder">

                            <input type="text" name="username" class="basic-form-input"/>
                            <span class="basic-form-span">Username</span>

                        </div>

                        <div class="basic-form-input-holder">

                            <input type="password" name="password" class="basic-form-input"/>
                            <span class="basic-form-span">Password</span>

                        </div>

                        <div class="basic-form-input-holder">

                            <input type="password" name="confirm-password" class="basic-form-input"/>
                            <span class="basic-form-span">Confirm</span>

                        </div>

                    </div>

                    <div class="flex-row-center small-spaced-top">

                        <button class="basic-button">Continue</button>

                    </div>

                </form>

            </div>

        </div>

    </body>

</html>