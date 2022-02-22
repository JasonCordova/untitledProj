<?php

    include_once("db.inc.php");
    include("functions.php");
    session_start();

?>

<div class="global-navigation">

    <div class="nav-bar">

        <div class="main-nav-flex">

            <a href="home.php" class="nav-logo">
                
                <span class="small-nav-text">UNTITLED</span>
                <span class="big-nav-text">PROJECT</span>
        
            </a>

        </div>

        <div class="alt-nav-flex">

            <?php if (loggedIn()): ?>
        
                <div class="nav-profile-bubble">

                    <span class="abb-username"><?php echo getUsername()[0]; ?></span>
                    <div class="user-online-status <?php echo getStatus();?>-status" onclick="toggleStatus(this)"></div>

                    <script>

                        function toggleStatus(e){

                            var status = "";

                            if (e.classList.contains("online-status")){

                                e.classList.remove("online-status");
                                e.classList.add("away-status");
                                status = "away";

                            } else if (e.classList.contains("away-status")){

                                e.classList.remove("away-status");
                                e.classList.add("offline-status");
                                status = "offline";

                            } else if (e.classList.contains("offline-status")){

                                e.classList.remove("offline-status");
                                e.classList.add("online-status");
                                status = "online";

                            }

                        }

                        function printStatus(){

                            console.log("<?php echo getStatus();?>");

                        }

                    </script>

                    <div class="nav-user-dropdown-holder">

                        <div class="nav-user-dropdown">

                            <div class="nav-user-details">

                                <div class="nav-user-text">Signed in as:</div>
                                <div class="nav-username"><?php echo getUsername();?></div>
                        
                            </div>

                            <a href="logout.php" class="nav-user-anchor">
                                
                                <span>Friends</span>
                        
                            </a>

                            <a href="logout.php" class="nav-user-anchor">
                                
                                <span>Settings</span>
                        
                            </a>

                            <a href="logout.php" class="nav-user-anchor">
                                
                                <span>Logout</span>
                        
                            </a>

                        </div>

                    </div>

                </div>

            <?php else: ?>

                <a href="login.php" class="nav-anchor">Login</a>

            <?php endif; ?>

        </div>

    </div>

</div>