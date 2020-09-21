<?php
    // Sørger for at den individuelle session fortsat kører
    session_start();

    // Frigør alle sessions variabler
    session_unset();

    // Fjerner alt data relateret til denne session
    session_destroy();

    // Sender brugeren tilbage til forsiden
    header("Location: ../index.php");
?>