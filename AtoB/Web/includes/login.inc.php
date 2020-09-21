<?php
// Tjekker hvorvidt at der er blevet sendt en "POST" forespørgsel
if (isset($_POST['submit-login'])){
    // Sørger for at der kan oprettes forbindelse til databasen
    require_once('../../mysql_connect.php');

    // Gemmer brugernavn og kodeord i variabler
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Tjekker hvorvidt at brugernavn eller kodeord er tomt
    // Hvis dette er tilfældet sendes brugeren tilbage til forsiden med en fejlmeddelelse
    if (empty($username) || empty($password)){
        header("Location: ../index.php?error=emptyfields");
        
        // Sørger for at der ikke køres mere kode fra denne fil
        exit();
    }
    else{
        // SQL forespørgsel der vælger alt (*) fra "login" tabel hvor brugernavnet er lig det indtastede brugernavn
        $query = "SELECT * FROM (login) WHERE username=?";
        $stmt = mysqli_stmt_init($db_connection);

        // Tjekker hvorvidt forespørgslen er gyldig
        if(!mysqli_stmt_prepare($stmt, $query)){
            header("Location: ../index.php?error=sqlerror");
            exit();
        }
        else{
            // Binder brugernavns variablen til forespørgsels parameter
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);

            // Udfører forespørgslen og gemmer data i $result
            $result = mysqli_stmt_get_result($stmt);

            // Tjekker om der er et resultat fra databasen
            if ($row = mysqli_fetch_assoc($result)){

                // Tjekker hvorvidt det indtastede kodeord matcher det i databasen
                $pwdCheck = password_verify($password, $row['password']);
                if ($pwdCheck == false){
                    // Hvis ikke, sendes brugeren tilbage til forsiden med en fejlmeddelelse
                    // og koden slutter med at køre fra denne fil
                    header("Location: ../index.php?error=wrongpwd");
                    exit();
                }
                else if ($pwdCheck == true){
                    // Hvis kodeordet er gyldigt oprettes en session
                    session_start();
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['username'] = $row['username'];

                    header("Location: ../index.php?login=success");
                    exit();
                }
                else{
                    // Hvis der er en situation hvor $pwdCheck hverken er TRUE eller FALSE 
                    // sørges der for at brugeren ikke logges ind, da en fejl er opstået
                    header("Location: ../index.php?error=wrongpwd");
                    exit();
                }
            }
            else{
                // Hvis brugernavnet ikke findes, sendes brugeren tilbage til forsiden
                // med en fejlmeddelelse
                header("Location: ../index.php?error=nouser");
                exit();
            }
        }
    }

    // Sørger for at alle forbindelser til databasen er lukket
    mysqli_stmt_close($stmt);
    mysqli_close($db_connection);
}
else{
    // Hvis der ikke er sendt en POST forespørgsel, sendes brugeren til forsiden
    header("Location: ../index.php");
    exit();
}
?>