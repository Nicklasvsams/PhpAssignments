<?php
    // Henter header information fra "header.php"
    require('header.php');
?>
<main>
    <?php
    echo "<br>";

    // Tjekker hvorvidt en bruger er logget ind
    if (isset($_SESSION['username'])){
        
        // Tjekker hvorvidt brugeren er "Admin"
        if ($_SESSION['username'] == "Admin"){
            
            // Sørger for at der kan oprettes forbindelse til databasen
            require_once('../mysql_connect.php');

            // SQL forespørgsel der vælger alt (*) fra formdata tabellen og sorterer dem efter ID i omvendt ordre
            $sqlread = "SELECT * FROM `formdata`, `login` WHERE formdata.Brugerid = login.id ORDER BY formdata.ID DESC";
    
            // Gemmer resultatet fra forespørgslen i en variabel
            $result = $db_connection->query($sqlread);
    
            // Tjekker om der findes data i den tabel forespørgslen bliver sendt til
            if ($result->num_rows > 0){
                
                // Går igennem hvert række i tabellen og udskriver kontaktform data til Admin
                while ($row = $result->fetch_assoc()){
                    echo "<div class='container'><div class='row  d-flex justify-content-center'><div class='col-sm-6 border rounded'>";
                    echo "<h3>Form created by " . $row['username'] . "</h3>Dato: " . $row['Dato'] . "<br>Navn: " . $row['Navn'] . "<br>Adresse: " . $row['Adresse'] . "<br>Email: " . $row['Email'] . "<br>Telefon: " . $row['Telefon'] . "<br>Besked:<br>";
                    echo "<br><div class='border rounded px-2'>" . $row['Besked'] . "</div><br>";
                    echo "</div></div></div><br><br>";
                };
            }
        }
        // Hvis brugeren ikke er Admin får de at vide at de ikke er autoriserede
        else{
            echo "<div class='container'><div class='row d-flex justify-content-center'><div class='col-sm-6'><p class='text-center border rounded border-danger'>Unauthorized access!</p></div></div></div>";
        }

        // Sørger for at alle forbindelser til databasen er lukket
        mysqli_close($db_connection);

    }
    // Hvis brugeren ikke er logget ind får de at vide at de ikke er autoriserede
    else{
        echo "<div class='container'><div class='row d-flex justify-content-center'><div class='col-sm-6'><p class='text-center border rounded border-danger'>Unauthorized access!</p></div></div></div>";
    }
    ?>
</main>
<?php
    // Henter footer information fra "footer.php"
    require('footer.php');
?>