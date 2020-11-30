<?php
    session_unset();
    session_destroy();
    /* Redirection connexion */
    header("location:index.php")
?>