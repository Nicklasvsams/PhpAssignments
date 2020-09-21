<?php
    // Sørger for at vores session altid bliver bibeholdt
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Links til stylingsheets. Bootstrap bruger CDN. -->
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title></title>
</head>
<body>

<!-- Bootstrap navigationsbar -->
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">
            <img id="logo" src="img/logo.png" alt="logo">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Home<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="kontaktform.php">Contact</a>
                </li>
                <?php
                    // Tjekker om der er en bruger logget ind
                    if (isset($_SESSION['username'])){
                        // Hvis der er en bruger, og brugeren er Admin tilføjes "Forms" knappen, som kun Admin har adgang til
                        if ($_SESSION['username'] == "Admin"){
                            echo    '<li class="nav-item">
                            <a class="nav-link" href="adminkontakt.php">Forms</a>
                        </li>';
                        }
                    }
                ?>
            </ul>

            <?php
                // Hvis en bruger er logget ind bliver logud knappen vist
                if (isset($_SESSION['username'])){
                    $user = $_SESSION['username'];
                    echo "<h3 class='username'>$user</h3>";
                    echo "<form action='includes/logout.inc.php' method='post'>";
                    echo "<button class='btn btn-danger' type='submit' name='logout-submit'>Log out</button>";
                    echo "</form>"; 
                }
                // Hvis en bruger ikke er logget ind vises en login formular og en "Sign up" knap
                else{
                    echo "<form action='includes/login.inc.php' method='post' class='form-inline my-2 my-lg-0'>";
                    echo "<input class='form-control mr-sm-2' type='text' name='username' placeholder='Username...''>";
                    echo "<input class='form-control mr-sm-2' type='password' name='password' placeholder='Password...''>";
                    echo "<button class='btn btn-outline-success my-2 my-sm-0' name='submit-login' type='submit'>Login</button>";
                    echo "</form>";
                
                    echo "<a href='signup.php'>";
                    echo "<button class='btn btn-success signup-button' type='submit' name='signup-submit'>Sign up</button>";
                    echo "</a>";
                }
            ?>
        </div>
    </nav>
</header>
<!-- HTML til header --> 
