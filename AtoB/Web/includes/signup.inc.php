<?php
// Tjekker hvorvidt at der er blevet sendt en "POST" forespørgsel
if (isset($_POST['submit-signup'])){
    // Sørger for at der kan oprettes forbindelse til databasen
    require_once('../../mysql_connect.php');
    
    // Gemmer brugernavn og kodeord i variabler
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password_repeat = $_POST['password-repeat'];

    // Tjekker hvorvidt at brugernavn eller kodeord er tomt
    // Hvis dette er tilfældet sendes brugeren tilbage til signup siden med en fejlmeddelelse
    if(empty($username) || empty($password) || empty($password_repeat)) {
        header("location: ../signup.php?error=emptyfields&username=".$username);
        exit();
    }
    // Regex tjek som sørger for at der kun bruges bogstaver a-z (Store og små),
    // tal (0-9) og der ikke bruges specialtegn
    elseif(!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        header("location: ../signup.php?error=invaliduser");
        exit();
    }
    // Tjekker hvorvidt de to kodeords felter stemmer overens, ellers sendes
    // brugeren tilbage til signup siden med en fejlmeddelelse
    elseif($password !== $password_repeat){
        header("location: ../signup.php?error=passwordcheck&username=".$username);
        exit();
    }
    else{
        // SQL forespørgsel der vælger 'username' fra 'login' tabel hvor 'username' er lig det indtastede brugernavn
        $sqlread = "SELECT username FROM (login) WHERE username=?";
        $stmt = mysqli_stmt_init($db_connection);

        // Tjekker hvorvidt den oprettede forespørgsel er gyldig
        // Hvis ikke; sendes brugeren til signup med en fejlmeddelelse
        if(!mysqli_stmt_prepare($stmt, $sqlread)){
            header("location: ../signup.php?error=sqlerror");
            exit();
        }
        else{
            // Binder variablen "username" til forespørgslens parameter 
            mysqli_stmt_bind_param($stmt, "s", $username);

            // Udfører forespørgslen
            mysqli_stmt_execute($stmt);

            // Gemmer SQL resultatet på klientsiden i en buffer
            mysqli_stmt_store_result($stmt);

            // Gemmer antallet af rækker i en variabel
            $resultcheck = mysqli_stmt_num_rows($stmt);

            // Tjekker hvorvidt der er data returneret fra forespørgslen
            // Hvis der er, betyder det at brugernavnet allerede er optaget
            // og brugeren sendes tilbage til signup siden med en fejlmeddelelse
            if ($resultcheck > 0){
                header("location: ../signup.php?error=usertaken");
                exit();
            }
            // Hvis brugeren ikke findes i tabellen, oprettes brugeren i databasen
            else{
                // SQL forespørgsel som indsætter brugernavn og kodeord i 'login' tabellen
                $query = "INSERT INTO login (username, password) VALUES (?, ?)";
                $stmt_ins = mysqli_stmt_init($db_connection);

                // Tjekker hvorvidt den oprettede forespørgsel er gyldig
                // Hvis ikke; sendes brugeren til signup med en fejlmeddelelse
                if (!mysqli_stmt_prepare($stmt_ins, $query)){
                    header("location: ../signup.php?error=sqlerror");
                    exit();
                }
                else{
                    // Enkrypterer kodeordet før det bliver gemt i databasen
                    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

                    // Binder brugernavn og det enkrypterede kodeord til forespørgslen
                    mysqli_stmt_bind_param($stmt_ins, "ss", $username, $hashedPwd);

                    // Forespørgsel udføres
                    mysqli_stmt_execute($stmt_ins);

                    // Brugeren sendes til signup siden med en succes parameter
                    header("Location: ../signup.php?signup=success");
                    exit();
                }
            }
        }
    }

    // Sørger for at alle forbindelser til databasen er lukket
    mysqli_stmt_close($stmt_ins);
    mysqli_stmt_close($stmt);
    mysqli_close($db_connection);
}
else{
    // Hvis der ikke er sendt en POST forespørgsel, sendes brugeren til signup siden
    header("Location: ../signup.php");
    exit();
}
?>