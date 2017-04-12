<!DOCTYPE html>
<meta charset="utf-8" />
    <button type="button" id="register_button" onclick="login_toggle('register_button', 'register_headerMenu_toggle')", value="0">Register</button>

    <div id="register_headerMenu_toggle">
        <form action="register_ok.php" method="POST">
            <input type="text" name="u_id_register" placeholder="User ID" />
            <input type="text" name="password_register" placeholder="Password" />
        
            <input type="submit" name"reg" value="Sign Up!" />

        </form>
    </div>
