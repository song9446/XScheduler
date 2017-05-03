<!DOCTYPE html>
<meta charset="utf-8" />
    <button type="button" id="login_button" onclick="login_toggle('login_button', 'login_headerMenu_toggle')" value="0">Login</button>

    <div id="login_headerMenu_toggle">
        <form action="login_ok.php" method="POST">
            <input type="text" name="user_id_login" size"25" placeholder="User ID"/>
            <input type="password" name="password_login" size="25" placeholder="Password" />
            <input type="submit" name="login" value="Login" />
        </form>
    </div>
