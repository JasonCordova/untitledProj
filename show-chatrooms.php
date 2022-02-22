<?php

    include_once("lib/db.inc.php");
    include("lib/functions.php");
    session_start();
    $stmt = $db->prepare("SELECT * FROM chatrooms WHERE 1=1 ORDER BY currentUsers DESC");

    try {

        $stmt->execute([]);
        $allChatrooms = $stmt->fetchAll(PDO::FETCH_ASSOC);


    } catch (PDOException $e){

        echo var_export($e);

    }

?>

<?php if (count($allChatrooms) > 0): ?>

    <?php foreach ($allChatrooms as $chatroom): ?>

        <?php

            $chatroomID = se($chatroom, "id", "", false);
            $chatroomName = se($chatroom, "name", "", false);
            $chatroomPassword = se($chatroom, "password", "", false);
            $chatroomUsers = se($chatroom, "currentUsers", "", false);
            $chatroomMaxUsers = se($chatroom, "maxUsers", "", false);

        ?>

        <a href="room.php?id=<?php echo $chatroomID;?>" class="chatroom">

            <div class="chatroom-content">

                <div class="chatroom-details">

                    <div class="chatroom-status">

                        <?php if (empty($chatroomPassword)): ?>

                            <svg xmlns="http://www.w3.org/2000/svg" class="chatroom-status-img" viewBox="0 0 256 256">
                                
                                <path d="M48 114V79c.04-24.21 11.78-47.82 31-62.5C121.49-15.94 185.95 1.34 203.33 53c2.19 6.5 4.36 15.15 4.63 22 .78 20.05-18.04 25.41-28.92 17.35-7.62-5.64-7.01-15.1-9.2-23.35-2.27-8.59-7.88-16.98-14.84-22.48-7.44-5.89-17.36-10.18-27-10.18-16.84 0-33.97 12.23-40.24 27.66C82.45 77.08 84 99.5 84 114h120c4.07.01 7.04-.05 11 1.22 12.76 4.08 16.98 14.44 17 26.78v86c-.03 18.01-9.99 27.97-28 28H50c-17.5-.21-25.97-11.29-26-28v-86c.02-15.85 7.39-26.6 24-28Z"/>
                            
                            </svg>

                        <?php else: ?>

                            <svg xmlns="http://www.w3.org/2000/svg" class="chatroom-status-img" viewBox="0 0 256 256">
                                
                                <path d="M48 114c0-24.33-2.79-49.83 9.31-72C84.92-8.59 156.34-15.05 191.5 31c20.21 26.48 16.5 51.98 16.5 83 16.61 1.4 23.98 12.15 24 28v86c-.03 18.01-9.99 27.97-28 28H50c-17.5-.21-25.97-11.29-26-28v-86c.02-15.85 7.39-26.6 24-28Zm124 0c0-14.83 1.79-40.07-4.66-53-15.79-31.67-58.46-32.86-76.97-3C81.7 71.99 84 97.55 84 114h88Z"/>
                        
                            </svg>

                        <?php endif; ?>

                    </div>
                    <div class="chatroom-name"><?php echo $chatroomName;?></div>
                    <div class="chatroom-usercount"><?php echo $chatroomUsers;?>/<?php echo $chatroomMaxUsers;?></div>

                </div>

            </div>

        </a>

    <?php endforeach; ?>

<?php else: ?>

    <div class="no-chatrooms">
        
        <?php

            $errorMessages = array (

                array("Aw shucks,", "There are no chatrooms available."),
                array("Gee whiz,", "There are no chatrooms available."),
                array("Whoopsies,", "There are no chatrooms available."),

            );

            $select = $errorMessages[rand(0, count($errorMessages) - 1)];

        ?>

        <span class="span1"><?php echo $select[0];?></span>
        <span><?php echo $select[1];?></span>

    </div>

<?php endif; ?>