<div class="header">
    <h2> OJC ADMIN HOME </h2>
    <?php
    if (isset($_SESSION["username"]))
    {?>
        <a class="logOut" href="./auth/admin_auth_handler.php?id=logOut">Log Out</a>
    <?php
    }?>
</div>