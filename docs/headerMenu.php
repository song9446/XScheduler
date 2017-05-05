<!DOCTYPE html>
    <div class="headerMenu">
        <!-- <button type="button" id="sidebar_button" onclick="sidebar_toggle('sidebar_button')" value="0">SBB</button> -->
        <div class="logo">
            <a href="home.php" class="logo">
                <img src="./img/logo.png" width="42" height="42"/>
            </a>
        </div>
        <nav id="topMenu">
          <ul>
              <li>
                <a class="menuLink" href="#">Personal schedule</a>
              </li>
              <li>
                <a class="menuLink" href="#">Group schedule</a>
              </li>
          </ul>
        </nav>
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
