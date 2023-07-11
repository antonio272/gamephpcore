<?php
    require("config.php");

    if( isset($_SESSION["user_id"]) ) {
        header("Location: game.php");
        exit;
    }

    if(isset($_POST["send"])) {
        foreach($_POST as $key => $value) {
            $_POST[$key] = trim(strip_tags($value));
        }
        
        if(
            filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) &&
            mb_strlen($_POST["password"]) >= 8 &&
            mb_strlen($_POST["password"]) <= 1000
        ) {
            
            $query = $db->prepare("
                SELECT user_id, password
                FROM users
                WHERE email = ?
            ");

            $query->execute([ $_POST["email"] ]);

            $user = $query->fetch( PDO::FETCH_ASSOC );
            
            if(
                !empty($user) &&
                password_verify($_POST["password"], $user["password"])
            ) {
                $_SESSION["user_id"] = $user["user_id"];
                header("Location: game.php");
            }
            else {
                $message = "Email ou password incorrectos.  Tente de novo.";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <!-- BOOTSTRAP CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
            integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <!-- FONT AWESOME -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css"
            integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />
            
        <link rel="stylesheet" href="../css/styles.css">
    </head>
    <body>
          
<?php
    include("header.php");
?>
    <section id="formulariologin">
                <div class="col-md-12 text-center mt-5 mb-5">
                            <h1>Login</h1>
<?php
    if(isset($message)) {
        echo '<p role="alert">' .$message. '</p>';
    }
?>
        
       <!-- <p>If you don't have an account yet,<a href="register.php"> create one here</a>.</p>-->
        <form method="post" action="index.php">
        
        <div class="wrap">
            
            <div>
                <label>
                    Email
                    <input type="email" name="email" required autofocus>
                </label>
            </div>
            <div>
                <label>
                    Password
                    <input type="password" name="password" minlength="8" maxlength="255" required>
                </label>
            </div>
            
            <div>
                <button type="submit" name="send">Login</button>
                <a href="index.php">Cancel</a>
            </div>
        </form>
        </div>
                            

                </div>
                            
            </section> 
            <?php
    include("footer.php");
?>
    <!-- JQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 

    <!-- Script -->
    <script src="../scripts/app.js"></script>
    <script src="/scripts/ckeditorscript.js"></script>

    </body>
</html>