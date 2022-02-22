<?php

    include "lib/navigation.php";
    $roomID = se($_GET, "id", "", false);

    $stmt = $db->prepare("SELECT * FROM chatrooms WHERE id = :roomID");

    try {

        $stmt->execute([":roomID" => $roomID]);
        $room = $stmt->fetch(PDO::FETCH_ASSOC);


    } catch (PDOException $e){

        echo var_export($e);

    }

    $roomName = se($room, "name", "", false);
    $roomPassword = se($room, "password", "", false);
    $roomUsers = se($room, "currentUsers", "", false);
    $roomMax = se($room, "maxUsers", "", false);
    $roomHost = se($room, "host", "", false);

?>

<!DOCTYPE html>

<html>

    <head>
        
        <link rel="stylesheet" href="index.css"/>
        <link rel="stylesheet" href="lib/navigation.css"/>
        <title><?php echo $roomName;?></title>

        <script src="js-functions.js"></script>

        <script>
    
            function onload(){
    
                checkAllInputs();
                showInvis();
    
            }
    
        </script>

    </head>

    <body onload="onload();">

        <?php

            $userEnter = false;

            if (isset($_POST) && !empty($_POST) && !empty($roomPassword)){

                $userInput = se($_POST, "roomPassword", "", false);
                if (password_verify($userInput, $roomPassword)) {

                    $userEnter = true;

                }

            }

        ?>

        <?php if (!empty($roomPassword) && !($userEnter)): ?>

            <div class="fullbody-container">

                <div class="form-holder">

                    <form class="custom-form" method="POST">

                        <div class="custom-form-back">

                            <a href="home.php" class="redirect-back">

                                <!--<svg class="back-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 104 172">
                                    
                                    <path d="M82 2.53C98.81-.19 105.89 15.48 99.91 26 97.79 29.74 89.45 37.55 86 41L58 69 47.01 80c-1.42 1.48-3.97 3.8-3.97 6 0 3.18 10.36 12.4 12.96 15l28 28c3.32 3.32 13.18 12.8 15.3 16 5.76 8.7 1.84 21.02-8.3 24.2-11.4 3.57-17.86-5.06-25-12.2l-47-47c-5.16-5.16-15.68-13.85-16.79-21C.43 77.56 9.78 71.22 17 64l43-43c6.07-6.07 13.9-15.87 22-18.47Z"/>
                            
                                </svg>

                                <span>Chatrooms</span>-->

                                <svg class="back-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 172 172">
                                    
                                    <path d="M15 2.53C25.91.85 29.9 6.9 37 14l33 33c2.7 2.7 12.79 13.96 16 13.96 3.21 0 13.3-11.26 16-13.96l34-34c5.51-5.51 10.38-11.65 19-10.8 9.11.9 15.73 8.6 14.8 17.8-.76 7.55-7.73 12.93-12.8 18l-33 33c-2.42 2.42-12.13 11.43-12.8 14-.66 2.49 1.31 4.33 2.84 6L126 103l32 32c4.85 4.85 11.07 9.69 11.8 17 1.03 10.26-7.54 18.83-17.8 17.8-7.55-.76-12.93-7.73-18-12.8l-33-33c-2.42-2.42-11.43-12.13-14-12.8-2.49-.66-4.33 1.31-6 2.84L69 126l-33 33c-5.51 5.51-10.38 11.65-19 10.8-9.11-.9-15.73-8.6-14.8-17.8.7-6.98 6.15-11.35 10.8-16l17-17 22-22c1.94-1.94 8.19-7.69 8.8-10 .66-2.49-1.31-4.33-2.84-6L47 70 19 42C15.8 38.8 6.78 30.14 4.7 27-1.93 16.99 4.14 5.77 15 2.53Z"/>
                                
                                </svg>

                            </a> 

                        </div>

                        <div class="form-title">
                            
                            <?php echo $roomName;?>
                            
                    
                        </div>

                        <div class="form-alt-title">This chatroom requires a password.</div>

                        <div class="form-input-container">

                            <div class="basic-form-input-holder">

                                <input type="password" name="roomPassword" class="basic-form-input"/>
                                <span class="basic-form-span">Enter password</span>

                            </div>

                        </div>

                        <div class="flex-row-center small-spaced-top">

                            <button class="basic-button" id="create-room-button">Continue</button>

                        </div>

                    </form>

                </div>

            </div>

        <?php elseif ($roomUsers < $roomMax): ?>

            <?php

                $stmt = $db->prepare("UPDATE chatrooms SET currentUsers = currentUsers + 1 WHERE id = :roomID");

                try {

                    $stmt->execute([":roomID" => $roomID]);


                } catch (PDOException $e){

                    echo var_export($e);

                }

            ?>

            <div class="body-container">

                <div class="chatroom-viewer">

                    <div class="chatroom-viewer-details">

                        <?php if (loggedIn() && (getUserID() == $roomHost)): ?>

                            <input type="text" class="chatroom-viewer-name" value="<?php echo $roomName;?>" onsubmit="console.log(this.value);" spellcheck="false"/>

                        <?php else: ?>

                            <div class="chatroom-viewer-name"><?php echo $roomName;?></div>

                        <?php endif; ?>

                    </div>

                    <div class="chatroom-messages">


                    </div>

                    <div class="chatroom-input-holder">

                        <textarea class="chatroom-input" placeholder="Write your message here." spellcheck="false" resize="false" oninput="console.log(this.scrollHeight); this.style.height = (this.scrollHeight + 2) + 'px';"></textarea>
                        <div class="send-text-button">

                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 126 162">
                                
                            <path d="M47 57 33 70.98c-4.03 3.91-8.15 7.33-14 7.8C8.18 79.64.62 70.51 2.21 60 3.34 52.54 9.94 47.06 15 42l27-27C49.86 7.14 54 .84 66 2.11c5.98.63 9.94 4.88 14 8.89l21 21 11 11c6.75 6.76 13.43 12.48 11.79 23-1.58 10.15-12.67 15.24-21.79 11.52C95.53 74.88 84.41 62.41 79 57v87c-.12 9.96-5.14 17.92-16 17.92S47.12 153.96 47 144V57Z"/>
                        
                        </svg>
                        
                        </div>

                    </div>

                </div>

            </div>

        <?php else: ?>

            <div class="body-container">

                <div>THE ROOM IS FULL</div>

            </div>

        <?php endif; ?>

    </body>

</html>