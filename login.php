

<div class="container-sing">
    <form method="post" class="sing-in">
        <h1>Sing In</h1>
        <div class="form-input">
            <i class="fa-solid fa-user"></i>
            <input type="text" name="username" placeholder="Username">
        </div>

        <div class="form-input">
            <i class="fa-solid fa-lock"></i>
            <input type="password" name="password" placeholder="Password" class="form-input">
        </div>

        <div class="form-input">
            <button name="login">Log in</button>
        </div>

        <div class="chyba">
            <?php echo $chyba["prihlaseni"];?>
        </div>
        <hr>
        <p>Don't have an account?<span><a href="?singUp">Register here</a></span></p>
        
        
    </form>

</div>    