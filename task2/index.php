<?php
session_start();

$old = $_SESSION["old"] ?? $_SESSION["user"] ?? [];
$formId = $old["id"] ?? 105;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>User Registration</h2>

    <form action="process.php?id=<?php echo htmlspecialchars($formId); ?>" method="POST" enctype="multipart/form-data">
        <div class="box">
            <label for="Name">Name:</label>
            <input type="text" name="name" id="Name" value="<?php echo htmlspecialchars($old["name"] ?? ""); ?>">
            <span style="color: red;">*<?php echo $_SESSION["errors"]["name"] ?? "" ?></span>
        </div>
         <br>

          <div class="box">
            <label for="Email">Email:</label>
            <input type="email" name="email" id="Email" value="<?php echo htmlspecialchars($old["email"] ?? ""); ?>">
            <span style="color: red;">*<?php echo $_SESSION["errors"]["email"] ?? "" ?></span>
        </div>
        <br>

        <div class="box">
            <label for="Password">Password:</label>
            <input type="password" name="password" id="Password">
            <span style="color: red;">*<?php echo $_SESSION["errors"]["password"] ?? "" ?></span>
        </div>
        <br>

          <div class="box">
            <label for="lang">Language:</label>
             <select name="lang" id="lang">
                <option value="" <?php echo (( $old["lang"] ?? "")==="")?"selected":""  ?> hidden></option>
                <option value="ar" <?php echo (($old["lang"] ?? "")==="ar")?"selected":""; ?>>Arabic</option>
                <option value="en" <?php echo (($old["lang"] ?? "")==="en")?"selected":""; ?>>English</option>
            </select>
            <span style="color: red;">*<?php echo $_SESSION["errors"]["lang"] ?? "" ?></span>
        </div>
        <br>

        <div class="box">
            <label for="Image">Profile Image:</label>
            <input type="file" name="image" id="Image">
            <span style="color: red;">*<?php echo $_SESSION["errors"]["image"] ?? "" ?></span>
        </div>
         <br>


        <button>submit</button>

    </form>




</body>
</html>
