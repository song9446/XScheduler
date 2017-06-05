<!DOCTYPE html>
<html>
    <head>
        <title>UniScheduler</title>
        
            <link rel="stylesheet" type="text/css" href="/css/headerMenu.css" />
        
    </head>

    <body>
        <div class="headerMenu">
            <div class="logo">
                <a href="/home.php" class="logo">
                    <img src="/img/logo.png" width="42" height="42"/>
                </a>
            </div>
            <nav id="topMenu">
                <ul>
                    <li>
                        <a class="menuLink" href="/scheduler/index.php">Personal schedule</a>
                    </li>
                    <li>
                        <a class="menuLink" href="/group/index.php">Groups</a>
                    </li>
                    <li>
                        <a class="menuLink" href="/friends/index.php">Friends</a>
                    </li>
                 </ul>
            </nav>
            <?php
                if (isset($_SESSION['u_id'])){
                    echo "<a href='/logout.php' class='logout_button'>Logout</a>";
                }
                else{
                    include ( "./login.php" );
                    include ( "./register.php" );
                }
            ?>
        </div>
    </body>

    <script src="./js/script1.js"></script>
</html>
