<?php
  // Henter header information fra "header.php"
  require('header.php');
?>

<main>
    <?php
        // Tjekker hvorvidt en variabel har en værdi og i så fald, at den ikke er NULL
        if (isset($_POST['submit'])){

            // Instantiering af et array til manglende indtastning
            $data_missing = array();

            // Hvis feltet er tomt bliver en beskrivende string tilføjet til array "$data_missing"
            if (empty($_POST['InputName'])){
                $data_missing[] = 'Navn';
            }
            else{
                // Hvis feltet ikke er tomt fjernes whitespace
                $navn = trim($_POST['InputName']);
            }
            
            if (empty($_POST['InputAddress'])){
                $data_missing[] = 'Adresse';
            }
            else{
                $adresse = trim($_POST['InputAddress']);
            }

            if (empty($_POST['InputEmail'])){
                $data_missing[] = 'Email';
            }
            else{
                $email = trim($_POST['InputEmail']);
            }

            if (empty($_POST['InputPhone'])){
                $data_missing[] = 'Telefon';
            }
            else{
                $telefon = trim($_POST['InputPhone']);
            }

            if (empty($_POST['InputMessage'])){
                $data_missing[] = 'Besked';
            }
            else{
                $besked = trim($_POST['InputMessage']);
            }

            // Hvis array "$data_missing" er tom (Alle felter er udfyldt) køres denne kode
            if (empty($data_missing)){
                // Sørger for at database forbindelsen kan bruges
                require_once('../mysql_connect.php');

                // Forespørgslen der sendes til databasen 
                $query = "INSERT INTO formdata (Navn, Adresse, Email, Telefon, Besked, Dato, Brugerid) VALUES (?, ?, ?, ?, ?, NOW(), ?)";

                $stmt = mysqli_stmt_init($db_connection);

                if (!mysqli_stmt_prepare($stmt, $query)){
                    header("location: index.php?error=sqlerror");
                    exit();
                }
                else{
                    mysqli_stmt_bind_param($stmt, "sssssi", $navn, $adresse, $email, $telefon, $besked, $_SESSION['id']);
                    mysqli_stmt_execute($stmt);

                    header("Location: index.php?form=success");
                    exit();
                }
            }
            else{
                // Opsætning til at vise hvad der mangler i formularen
                echo "<div class='container'><div class='row d-flex justify-content-center'><div class='col-sm'><p>Du skal indtaste de følgende data:</p>";

                // Viser hvert element i "$data_missing" array
                foreach ($data_missing as $missing){
                    echo "<p><strong>$missing</strong></p>";
                }
                echo "</div></div></div>";
            }
            mysqli_stmt_close($stmt);
            mysqli_close($db_connection);
        }

        
  if (isset($_SESSION['username'])){
    echo '
    <div class="container">
      <div class="row d-flex justify-content-center">
        <div class="col-sm-6">
          <form action="./viskontakt.php" method="post">
            <div class="form-group">
              <label for="InputName">Navn</label>
              <input type="text" class="form-control" name="InputName" id="InputName">
            </div>
            <div class="form-group">
              <label for="InputAddress">Adresse</label>
              <input type="text" class="form-control" name="InputAddress" id="InputAddress">
            </div>
            <div class="form-group">
              <label for="InputEmail">Email</label>
              <input type="email" class="form-control" name="InputEmail" id="InputEmail">
            </div>
            <div class="form-group">
              <label for="InputPhone">Telefon</label>
              <input type="text" class="form-control" name="InputPhone" id="InputPhone">
            </div>
            <div class="form-group">
              <label for="InputMessage">Besked</label>
              <textarea class="form-control" name="InputMessage" id="InputMessage" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-success" name="submit">Submit</button>
          </form>
        </div>
      </div>
    </div>';
  }
  else{
    echo "<div class='container'><div class='row d-flex justify-content-center'><div class='col-sm-6'><br><p class='text-center border rounded border-danger'>Please log in to use the form!</p></div></div></div>";
  }
?>
</main>
<?php
  // Henter footer information fra "footer.php"
  require('footer.php');
?>