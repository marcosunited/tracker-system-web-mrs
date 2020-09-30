<h1>Login</h1>

<form role="form" action="<?=URL?>/login/action/" method="post">
    <input name="user_name" type="text" class="form-control" placeholder="Username" required autofocus><br>
    <input name="user_password" type="password" class="form-control" placeholder="Password" required><br>
    <button class="button-primary" type="submit">Sign in</button>
</form>
