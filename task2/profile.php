<?php session_start();?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>profile</title>
</head>
<body>
   <h2>Superglobals App</h2> 

   <p>ID: <?php echo $_SESSION["user"]["id"] ?></p>
   <p>Name: <?php echo $_SESSION["user"]["name"] ?> </p>
   <p>Email: <?php echo $_SESSION["user"]["email"] ?> </p>
   <p>Language: <?php echo $_SESSION["user"]["lang"] ?> </p>

   <img src="uploads/<?php echo $_SESSION["user"]["newFileName"]; ?>">
   
  
</body>
</html>