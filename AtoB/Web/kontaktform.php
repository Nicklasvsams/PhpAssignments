<?php
  // Henter header information fra "header.php"
  require('header.php');
?>

<main>

<?php
  // Tjekker hvorvidt brugeren er logget ind og viser kontaktformularen hvis dette er tilfældet
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
    // Hvis brugeren ikke er logget ind bliver de bedt om at logge ind for at bruge denne side
    echo "<div class='container'><div class='row d-flex justify-content-center'><div class='col-sm-6'><br><p class='text-center border rounded border-danger'>Please log in to use the form!</p></div></div></div>";
  }
?>
</main>

<?php
  // Henter footer information fra "footer.php"
  require('footer.php');
?>