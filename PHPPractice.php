<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Practice</title>
</head>
<body>
    
<?php
// Giver adgang til vores mysql forbindelse.
// Dette PHP dokument der giver forbindelse til mysql er placeret udenfor den mappe vi bruger til at vise sider.
// Dette øger sikkerheden, så vores databasenavn og eventuelle koder er eksponeret for misbrug.
require_once('../mysqli_connect.php');

// To variabler med forskellige tal bliver udregnet og kaldt med echo
$number1 = 10;
$number2 = 5;
echo $number1 + $number2;
echo "<br>";

// To tekststrenge med forskellige værdier bliver kaldt med echo.
$text = "Hello";
$othertext = "Nicklas.";
echo "$text $othertext";
echo "<br>";

// To tekstrstrenge med forskellige værdier bliver konkateneret og kaldt med echo.
$string = "Concatenation hap";
$concatenate = "pens here.";
echo $string . $concatenate;
echo "<br>";

// Kalder funktionen "queries" med database forbindelsen som parameter
queries($db_connection);

function queries($connection){
    // SELECT query til mysql - Kalder alle kolonner og rækker 
    $sqlread = "SELECT * FROM test";

    // Resultatet af SELECT query
    $result = $connection->query($sqlread);

    // Hvis tabellen har data, vises de på siden
    if ($result->num_rows > 0){
        while ($row = $result->fetch_assoc()) {
            echo "ID: " . $row['ID']. "<br>Besked: " . $row['Besked']. "<br>";
        }
    }
    // Hvis der ikke er noget data oprettes en INSERT query og funktionen bliver kaldt igen for at vise dataen(Recursive function)
    else{
        // En forespørgsel i form a en string
        $query = "INSERT INTO test (Besked) VALUES ('Min næste besked')";
    
        // Hvis forbindelsen med vores forespørgsel er succesfuld udskrives en successbesked.
        if ($connection->query($query) === TRUE) {
            // Hvis 
            queries($connection);
        }
        else{
            // Hvis ikke, udskrives en fejlbesked med information om hvorfor.
            // NOTE: Normalt ville man aldrig fodre fejlbeskeder til klienten, dette burder KUN gøres i et testmiljø.
            echo "Error: " . $query . "<br>" . $connection->error;
        };
    }
}


?>

</body>
</html>