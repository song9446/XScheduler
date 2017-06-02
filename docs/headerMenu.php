<!DOCTYPE html>
    <div class="headerMenu">
        <!-- <button type="button" id="sidebar_button" onclick="sidebar_toggle('sidebar_button')" value="0">SBB</button> -->
        <div class="logo">
            <a href="http://52.78.81.68/home.php" class="logo">
                <img src="http://52.78.81.68/img/logo.png" width="42" height="42"/>
            </a>
        </div>
        <nav id="topMenu">
          <ul>
              <li>
                <a class="menuLink" href="http://52.78.81.68/scheduler/index.php">Personal schedule</a>
              </li>
              <li>
                <a class="menuLink" href="http://52.78.81.68/group/index.php">Group schedule</a>
              </li>
              <li>
                <a class="menuLink" href="http://52.78.81.68/friends/index.php">Friends</a>
              </li>
          </ul>
        </nav>
            <?php
                if (isset($_SESSION['u_id'])){
                    echo "<a href='http://52.78.81.68/logout.php' class='logout_button'>Logout</a>";
                }
                else{
                    include ( "./login.php" );
                    include ( "./register.php" );
                }
            ?>
    </div>

    <script src="./js/script1.js"></script>
