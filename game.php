<?php
    require("config.php");
    
    // Function to sanitize user input
    function sanitize($value) {
        return trim(strip_tags($value));
    }

    $query = $db->prepare("
        SELECT *           
        FROM games  
        ORDER BY created_at DESC
    ");

    $query->execute();

    $games = $query->fetchAll( PDO::FETCH_ASSOC );

    if( empty($games) ) {
        header("HTTP/1.1 404 Not Found");
        die("Não encontrado");
    }
    /*
    1) validar toda a informação
    2) sanitizar
    3) inserir na base de dados
    */
    $finish_at = date('Y-m-d H:i:s'); 
    // User play submission
    if (isset($_SESSION["user_id"])) {
        if (isset($_POST["game"])) {
            $userPlayed = [
                "game" => sanitize($_POST["game"]),
                "game_time" => $_POST["game_time"]
            ];

            if (
                !empty($userPlayed["game"]) &&
                mb_strlen($userPlayed["game"]) <= 10 &&
                filter_var($userPlayed["game"], FILTER_VALIDATE_INT)
            ) {
                $finish_at = date('Y-m-d H:i:s'); 

            try {
                $query = $db->prepare("
                    INSERT INTO user_play
                    (user_id, game_id, finish_at, game_time)
                    VALUES(?, ?, ?, ?)
                ");
    
                $query->execute([
                    $_SESSION["user_id"],
                    $userPlayed["game"],                  
                    $finish_at,
                    $userPlayed["game_time"],
                ]);
            } catch (PDOException $e) {
                // Handle the exception and display the error message
                die("Error: " . $e->getMessage());
            }
    
            header("Location: game.php");
            exit;
                
            }
        }
    }

    //var_dump($_SESSION);
?>


<!DOCTYPE html>
<html lang="pt">

         <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Play Games</title>
        <!-- BOOTSTRAP CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
            integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <!-- FONT AWESOME -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css"
            integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <!-- GOOGLE FONTS -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Candal&family=Lora&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;600&display=swap" rel="stylesheet">
     
        <link rel="stylesheet" href="../css/styles.css">
        <link rel="stylesheet" href="../css/stylesgames.css">


<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
     integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI="
     crossorigin=""/>

     <script src="../scripts/app.js"></script>
     
     <!-- Make sure you put this AFTER Leaflet's CSS -->
 <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
 integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM="
 crossorigin=""></script>

 <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

</head>
<body>
<?php
    include("header.php");
?> 
    

<div class="board">
     <!-- Script game -->

<?php
    include( "gamescore/". $games[0]["name"] . "script.php" );
?>


<div class="gameinfo">
        <h1><?php echo $games[0]["name"]; ?></h1>
        <div>
            <div class="gameimage">    
            <?php echo '<img src="images/'.$games[0]["image"].'">'; ?>
            </div> 
            <div class="description">
                <?php echo $games[0]["description"]; ?>
                
            </div>  
            <div class="createdat">
                <label for="">created at
                <?php echo $games[0]["created_at"]; ?>
                </label>
            </div>  
              
        </div>
</div>
</div>

    <!--</ul>-->
<?php
    include("footer.php");
?>
    <!-- JQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 



</body>
</html>