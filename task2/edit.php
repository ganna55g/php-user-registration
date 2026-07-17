<?php

session_start();

$_SESSION["edit"] = true;

header("Location: index.php");

?>
