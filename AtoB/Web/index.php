<?php
    // Henter header information fra "header.php"
    require("header.php");
?>

<main>
    <!-- Bootstrap container -->
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-sm-6">
                <?php

                // Tjekker forskellige statusbeskeder fra redirection. Udskriver en besked til brugeren alt efter status.
                if (isset($_GET['error'])){
                    if ($_GET['error'] == "emptyfields"){
                        echo "<br><p class='text-center border rounded border-danger'>One or more fields were empty. Make sure you enter both username and password!</p>";
                    }
                    else if ($_GET['error'] == "sqlerror"){
                        echo "<br><p class='text-center border rounded border-danger'>An error occured when trying to establish a connection with the server, please try again later.</p>";
                    }
                    else if ($_GET['error'] == "wrongpwd" || $_GET['error'] == "nouser"){
                        echo "<br><p class='text-center border rounded border-danger'>Password or username is wrong!</p>";
                    }
                }
                else if (isset($_GET['login'])){
                    if (isset($_GET['login']) == "success"){
                        echo "<br><p class='text-center border rounded border-success'>Logged in!</p>";
                    }
                }
                else{
                    // Hvis der ikke er en statusbesked informerer siden blot hvorvidt du er logget ind eller ej
                    if (isset($_SESSION['username'])){
                        echo "<br><p class='text-center'>You are logged in!</p>";
                    }
                    else{
                        echo "<br><p class='text-center'>Please log in to use the site!</p>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
</main>

<?php
    // Henter footer information fra "footer.php"
    require("footer.php");
?>