<div class="container-sing">
    <form method="post"  class="register">
        <h1>Register</h1>
        <div class="form-input">
            <i class="fa-solid fa-user"></i>
            <input type="text" name="username" placeholder="Username">
        </div>

        <div class="chyba">
            <?php echo $chyba["uzivatel"];?>
        </div>

        <div class="form-input">
            <i class="fa-solid fa-lock"></i>
            <input type="password" name="password" placeholder="Password" class="form-input">
        </div>

        <div class="chyba">
            <?php echo $chyba["register"];?>
        </div>

        <div class="form-input">
            <button name="register">Sing Up</button>
        </div>
        
    </form>
</div>