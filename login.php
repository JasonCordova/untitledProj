<!DOCTYPE html>

<html>

    <head>
        
        <link rel="stylesheet" href="index.css"/>
        <link rel="stylesheet" href="lib/navigation.css"/>
        <title>Login</title>

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

                function checkLogin($user, $pass){

                    if (empty($user) || empty($pass)){

                        return false;

                    }

                    if (strlen($pass) < 8){

                        return false;

                    }

                    return true;

                }

                if (isset($_POST) && !empty($_POST)){

                    $username = se($_POST, "username", "", false);
                    $password = se($_POST, "password", "", false);

                    $loginAbility = checkLogin($username, $password);

                    if ($loginAbility) {

                        $stmt = $db->prepare("SELECT * FROM Users WHERE username = :username");

                        try {

                            $stmt->execute([":username" => $username]);
                            $user = $stmt->fetch(PDO::FETCH_ASSOC);

                            if ($user) {

                                if (password_verify($password, se($user, "password", "", false))){

                                    $_SESSION["user"] = $user;
                                    if (loggedIn()){

                                        header("Location: home.php");

                                    }

                                } else {

                                    // Invalid password.

                                }

                            } else {

                                // User doesn't exist.

                            }


                        } catch (PDOException $e){

                            echo var_export($e);

                        }

                    }

                }

            ?>

            <div class="form-holder">

                <form class="custom-form" method="POST">

                    <div class="form-title">Login</div>
                    <div class="form-alt-title">Don't have an account? <a href="signup.php">Sign up</a></div>

                    <div class="form-input-container">

                        <div class="basic-form-input-holder">

                            <input type="text" name="username" class="basic-form-input"/>
                            <span class="basic-form-span">Username</span>

                        </div>

                        <div class="basic-form-input-holder">

                            <input type="password" name="password" class="basic-form-input"/>
                            <span class="basic-form-span">Password</span>

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