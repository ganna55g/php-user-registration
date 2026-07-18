<?php

session_start();

unset($_SESSION["errors"]);
unset($_SESSION["old"]);

$_SESSION["edit"] = true;

header("Location: index.php");

exit;

?>
