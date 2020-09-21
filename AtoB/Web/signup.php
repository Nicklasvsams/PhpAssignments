<?php
    // Henter header information fra "header.php"
    require("header.php");
?>

<main>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-sm-6">
                <h1>
                    Sign up
                </h1>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-sm-6">
                <?php
                // Tjekker hvorvidt der er parametre i URL. Dette forekommer først hvis der er en brugerfejl under bruger oprettelse
                if (isset($_GET['error'])) {
                    if ($_GET['error'] == "emptyfields"){
                        echo '<p class="text-center border rounded border-danger">All fields must be filled!</p>';
                    }
                    else if ($_GET['error'] == "passwordcheck"){
                        echo '<p class="text-center border rounded border-danger">Passwords must match!</p>';
                    }
                    else if ($_GET['error'] == "usertaken"){
                        echo '<p class="text-center border rounded border-danger">Username already exists. Please choose another username!</p>';
                    }
                    else if ($_GET['error'] == "sqlerror"){
                        echo '<p class="text-center border rounded border-danger">An error occured when trying to establish a connection with the server, please try again later.</p>';
                    }
                    else if ($_GET['error'] == "invaliduser"){
                        echo '<p class="text-center border rounded border-danger">One or more characters in the username were invalid. Please only use letters a-z and numbers 0-9</p>';
                    }
                }

                if (isset($_GET['signup'])){
                    if (isset($_GET['signup']) == "success"){
                        echo '<p class="text-center border rounded border-success">User succesfully created!</p>';
                    }
                }
                ?>
            </div>
        </div>
        <!-- HTML med Bootstrap CSS til at oprette en bruger -->
        <div class="row d-flex justify-content-center">
            <div class="col-sm-6">
                <form method="post" action="includes/signup.inc.php">
                    <div class="form-group">
                        <input type="text" class="form-control" name="username" placeholder="Username..." value="<?php if(isset($_GET['username'])){echo $_GET['username'];} ?>">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="Password...">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password-repeat" placeholder="Repeat password...">
                    </div>
                    <button type="submit" class="btn btn-success" name="submit-signup">Register</button>
                </form>
            </div>
        </div>
    </div>
</main>

<?php
    // Henter footer information fra "footer.php"
    require("footer.php");
?>