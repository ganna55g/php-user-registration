<?php

session_start();

if($_SERVER["REQUEST_METHOD"] !== "POST"){
    die("get method not allowed");
}

$errors = [];
$old = [];

/*-----------GET-------*/
$id = $_GET["id"] ?? "";
$old["id"] = $id;
if(empty ($id)){
    $errors["id"] = "id is required!";
}

/*-----------POST-------*/
$name = $_POST["name"] ?? "";
$old["name"] = $name;
if(empty ($name)){
    $errors["name"] = "name is required!";
}

$email = $_POST["email"] ?? "";
$old["email"] = $email;
if(empty ($email)){
    $errors["email"] = "email is required!";
}

$lang = $_POST["lang"] ?? "";
$old["lang"] = $lang;
if(empty ($lang)){
    $errors["lang"] = "language is required!";
}

$newFileName = "";

if(isset($_FILES["image"]) && $_FILES["image"]["error"]===UPLOAD_ERR_OK){
    $file = $_FILES["image"];
    $fileName = $file["name"];
    $originalName = pathinfo($fileName,PATHINFO_FILENAME);
    $originalExtension = pathinfo($fileName,PATHINFO_EXTENSION);
    $tmPath = $file["tmp_name"];

    $allowedExtensions = ["png" , "jpg" , "jpeg"];
    if(!in_array($originalExtension, $allowedExtensions)){
        $errors["image"] = "Type of image not allowed";
    }else{
        $currentTime = time();
        $newFileName = "{$originalName}-{$currentTime}.{$originalExtension}";
        $uploadDir = __DIR__ . "/uploads";
        if(!is_dir($uploadDir)){
            mkdir($uploadDir);
        }

        $uploadPath = $uploadDir . "/{$newFileName}";

        move_uploaded_file($tmPath, $uploadPath);

    }


}else{
    $errors["image"] = "profile image is required";
}

if(!empty($errors)){
    $_SESSION["errors"] = $errors;
    $_SESSION["old"] = $old;
    header("Location:index.php");
    exit;
}

$_SESSION["user"] = [
    "id" => $id,
    "name" => $name,
    "email" => $email,
    "lang" => $lang,
    "newFileName" => $newFileName,
    
];

header("Location:profile.php");
exit;

