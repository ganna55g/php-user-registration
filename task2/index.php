<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>User Registration</h2>

    <form action="process.php?id=105" method="POST" enctype="multipart/form-data">
        <div class="box">
            <label for="Name">Name:</label>
            <input type="text" name="name" id="Name">
            <span style="color: red;">*<?php echo $_SESSION["errors"]["name"] ?? "" ?></span>
        </div>
         <br>

          <div class="box">
            <label for="Email">Email:</label>
            <input type="email" name="email" id="Email">
            <span style="color: red;">*<?php echo $_SESSION["errors"]["email"] ?? "" ?></span>
        </div>
        <br>

          <div class="box">
            <label for="lang">Language:</label>
             <select name="lang" id="lang">
                <option value="" <?php echo (( $_SESSION["old"]["lang"] ?? "")==="")?"selected":""  ?> hidden></option>
                <option value="ar">Arabic</option>
                <option value="en">English</option>
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
