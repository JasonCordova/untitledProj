<?php

    include "lib/navigation.php";

?>

<!DOCTYPE html>

<html>

    <head>
        
        <link rel="stylesheet" href="index.css"/>
        <link rel="stylesheet" href="lib/navigation.css"/>
        <title>Handy Dandy Chatroom</title>

        <script src="js-functions.js"></script>

        <script>
    
            function onload(){
    
                checkAllInputs();
                showInvis();
                showChatrooms();
    
            }
    
        </script>
    
    </head>

    <body onload="onload();">

        <div class="body-container" id="body-container">

            <?php

                $chatroomLimit = 10;

                if (isset($_POST) && !empty($_POST)){

                    $roomName = se($_POST, "roomName", "", false);
                    $roomPassword = se($_POST, "roomPassword", "", false);
                    $maxUsers = se($_POST, "roomMaxUsers", "", false);

                    $stmt = $db->prepare("SELECT * FROM chatrooms");

                    try {

                        $stmt->execute([]);
                        $allChatrooms = $stmt->fetchAll(PDO::FETCH_ASSOC);


                    } catch (PDOException $e){

                        echo var_export($e);

                    }

                    if (!empty($roomName) && !empty($maxUsers) && strlen(ltrim($roomName)) > 0 && count($allChatrooms) < $chatroomLimit){


                        if (strlen($roomPassword) > 0){

                            $hashedPassword = password_hash($roomPassword, PASSWORD_BCRYPT);

                        } else {

                            $hashedPassword = "";

                        }

                        $stmt = $db->prepare("INSERT INTO chatrooms (name, password, maxUsers) VALUES (:roomName, :roomPassword, :maxUsers)");

                        try {

                            $stmt->execute([":roomName" => $roomName, ":roomPassword" => $hashedPassword, ":maxUsers" => $maxUsers]);


                        } catch (PDOException $e){

                            echo var_export($e);

                        }

                    }

                }

            ?>

            <div class="left-chatroom-search">
                
                <div class="chatroom-container-details">
            
                    <div class="basic-container-title">Chatrooms</div>

                    <div class="chatroom-container-buttons">

                        <button class="chatroom-button" id="refresh-chatrooms" onclick="showChatrooms();">

                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                
                                <path d="m92 50 14.96 15c1.76 1.88 4.85 5 4.22 7.85-.81 3.66-6.37 3.14-9.18 3.15H47c-9.17-.02-9.98-.83-10-10V10c.01-3.39-.56-9.99 5.02-8.34C45.81 2.77 58.43 16.43 62 20c4.46-5.06 12.74-8.32 19-10.8C102.26.78 115.77.74 138 1c6.86.08 16.3 1.91 23 3.63C201.49 15 234.34 45.75 248.31 85c7.13 20.04 6.79 31.41 6.69 52-.02 4.75-.22 11.12-3.31 14.96-7.84 9.73-28.64 4.13-34.99-5-2.83-4.06-2.69-8.26-2.7-12.96-.02-14.93-.72-23.84-6.45-38-13.63-33.66-46.68-54.42-82.55-54-12.08.15-21.88 4.14-33 8Zm102 186c-4.46 5.06-12.74 8.32-19 10.8-21.26 8.42-34.77 8.46-57 8.2-6.86-.08-16.3-1.91-23-3.63C54.51 241 21.66 210.25 7.69 171 .56 150.96.9 139.59 1 119c.02-4.75.22-11.12 3.31-14.96 7.84-9.73 28.64-4.13 34.99 5 2.83 4.06 2.69 8.26 2.7 12.96.02 14.93.72 23.84 6.45 38 13.63 33.66 46.68 54.42 82.55 54 12.08-.15 21.88-4.14 33-8l-14.96-15c-1.76-1.88-4.85-5-4.22-7.85.81-3.66 6.37-3.14 9.18-3.15h55c9.19.02 9.98.81 10 10v56c-.01 3.39.56 9.99-5.02 8.34-3.79-1.11-16.41-14.77-19.98-18.34Z"/>
                        
                            </svg>

                        </button>

                        <?php if (loggedIn()): ?>
                            
                            <button class="chatroom-button" id="create-room-button">

                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 128">
                                
                                <path d="M52 52V15c.07-5.61.81-9.93 6.02-13.15C64.73-2.3 73.31 1.6 75.43 9c.84 2.92.57 11.51.57 15v28h37c11.74.15 18.6 9.16 13.15 17.98-3.22 5.21-7.54 5.95-13.15 6.02H76v37c-.07 5.61-.81 9.93-6.02 13.15-6.71 4.15-15.29.25-17.41-7.15-.84-2.92-.57-11.51-.57-15V76H15c-5.61-.07-9.93-.81-13.15-6.02C-2.3 63.27 1.6 54.69 9 52.57c2.92-.84 11.51-.57 15-.57h28Z"/>
                        
                            </svg>

                            </button>

                        <?php endif; ?>

                    </div>

                </div>

                <div id="chatroom-holder">

                

                </div>

            </div>

        </div>

        <div class="fullbody-container hidden-form" id="create-room-form">

            <div class="form-holder">

                <form class="custom-form" method="POST">

                    <div class="form-title">Create new chatroom</div>
                    <div class="form-alt-title">Find new people to chat with or make one with friends.</div>

                    <div class="form-input-container">

                        <div class="basic-form-input-holder">

                            <input type="text" name="roomName" class="basic-form-input" autocomplete="false"/>
                            <span class="basic-form-span">Chatroom Name</span>

                        </div>

                        <div class="basic-form-input-holder">

                            <input type="password" name="roomPassword" class="basic-form-input" autocomplete="false"/>
                            <span class="basic-form-span">Chatroom Password</span>

                        </div>

                        <div class="basic-form-input-holder">

                            <input type="number" name="roomMaxUsers" class="basic-form-input" min="1" max="100" autocomplete="false"/>
                            <span class="basic-form-span">Max Users</span>

                        </div>

                    </div>

                    <div class="flex-row-center small-spaced-top">

                        <button class="basic-button" id="create-room-button">Continue</button>

                    </div>

                </form>

            </div>

        </div>

    </body>

    <script>

        <?php if (loggedIn()): ?>

            var creatingRoom = false;
            var createRoomButton = document.getElementById("create-room-button");
            createRoomButton.addEventListener("click", function(){

                if (creatingRoom == false){

                    creatingRoom = true;
                    console.log("Creating new room:");

                }

            });

            var createRoomButton = document.getElementById("create-room-button");
            createRoomButton.addEventListener("click", function(){

                var createRoomForm = document.getElementById("create-room-form");
                createRoomForm.classList.remove("hidden-form");
                createRoomForm.classList.add("shown-form");

            });

        <?php else: ?>

            var createRoomForm = document.getElementById("create-room-form");
            createRoomForm.remove();

        <?php endif; ?>

    </script>

</html>