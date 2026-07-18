<?php

session_start();

if($_SERVER["REQUEST_METHOD"] !== "POST"){
    die("get method not allowed");
}

/*-----------FUNCTIONS-------*/

function isInputEmpty($value){
    return empty(trim($value));
}

function validateName($name){
    return preg_match('/^[A-Za-z ]+$/', $name);
}

function validateEmail($email){
    return preg_match('/^[^\s@]+@[^\s@]+\.[^\s@]+$/', $email);
}

function validatePassword($password){
    // at least 8 chars, 1 uppercase, 1 lowercase, 1 digit, 1 special char
    return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password);
}

function encryptPassword($password){
    return password_hash($password, PASSWORD_DEFAULT);
}

function uploadImage($file){
    $allowedExtensions = ["png", "jpg", "jpeg", "webp"];

    $fileName = $file["name"];
    $originalName = pathinfo($fileName, PATHINFO_FILENAME);
    $originalExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if(!in_array($originalExtension, $allowedExtensions)){
        return ["success" => false, "message" => "Type of image not allowed"];
    }

    $currentTime = time();
    $newFileName = "{$originalName}-{$currentTime}.{$originalExtension}";
    $uploadDir = __DIR__ . "/uploads";

    if(!is_dir($uploadDir)){
        mkdir($uploadDir);
    }

    $uploadPath = $uploadDir . "/{$newFileName}";

    if(move_uploaded_file($file["tmp_name"], $uploadPath)){
        return ["success" => true, "filename" => $newFileName];
    }

    return ["success" => false, "message" => "Failed to upload image"];
}

function updateUserData($id, $name, $email, $hashedPassword, $lang, $newFileName){
    $_SESSION["user"] = [
        "id" => $id,
        "name" => $name,
        "email" => $email,
        "password" => $hashedPassword,
        "lang" => $lang,
        "newFileName" => $newFileName,
    ];
}



$errors = [];
$old = [];


$id = $_GET["id"] ?? "";
$old["id"] = $id;
if(isInputEmpty($id)){
    $errors["id"] = "id is required!";
}


$name = $_POST["name"] ?? "";
$old["name"] = $name;
if(isInputEmpty($name)){
    $errors["name"] = "name is required!";
}elseif(!validateName($name)){
    $errors["name"] = "name must contain letters and spaces only";
}

$email = $_POST["email"] ?? "";
$old["email"] = $email;
if(isInputEmpty($email)){
    $errors["email"] = "email is required!";
}elseif(!validateEmail($email)){
    $errors["email"] = "email format is invalid";
}

$password = $_POST["password"] ?? "";
if(isInputEmpty($password)){
    $errors["password"] = "password is required!";
}elseif(!validatePassword($password)){
    $errors["password"] = "password must be at least 8 characters and include uppercase, lowercase, digit and special character";
}

$lang = $_POST["lang"] ?? "";
$old["lang"] = $lang;
if(isInputEmpty($lang)){
    $errors["lang"] = "language is required!";
}


$isEditing = isset($_SESSION["user"]) && (string)$_SESSION["user"]["id"] === (string)$id;


$newFileName = $isEditing ? $_SESSION["user"]["newFileName"] : "";

if(isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK){
    $result = uploadImage($_FILES["image"]);
    if(!$result["success"]){
        $errors["image"] = $result["message"];
    }else{
        $newFileName = $result["filename"];
    }
}elseif(!$isEditing){
    $errors["image"] = "profile image is required";
}

if(!empty($errors)){
    $_SESSION["errors"] = $errors;
    $_SESSION["old"] = $old;
    header("Location:index.php");
    exit;
}

$hashedPassword = encryptPassword($password);

updateUserData($id, $name, $email, $hashedPassword, $lang, $newFileName);

unset($_SESSION["errors"]);
unset($_SESSION["old"]);

header("Location:profile.php");
exit;
