<!DOCTYPE html>
    <div class="headerMenu">
        <button type="button" id="sidebar_button" onclock"sidebar_toggle('sidebar_button')" value="0">SBB</button>
            <div class="logo">
                <a href="home.php" class="logo">
                    <img src="./img/logo.png" />
                </a>
            </div>
            
            <?php
                if (isset($_SESSION['u_id'])){
                    echo "<a href='logout.php' class='logout_button'>Logout</a>";
                }
                else{
                    include ( "./login.php" );
                    include ( "./register.php" );
                }
            ?>
    </div>