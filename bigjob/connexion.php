<?php

include('bdd.php');
include('user.php');
$user = new User('');
if(!empty($_POST)){
$login =$_POST['login'];
$password =$_POST['password'];
$user->connect($login, $password,$bdd);
$user->isConnected();
}
var_dump($_SESSION);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/style.css">
    <title>Connexion</title>
</head>
<body>
    
<h1>Connexion<h1>
    <form method="post" action="">
        <p>login</p>
        <input type="text" name="login">
        <p>Password</p>
        <input type="password" name="password">
        <button type="submit" name="Se connecter">Se connecter</button>
    </form>
    <button><a href="inscription.php">S'inscrire</a></button>
    <button><a href="logout.php">Se déconnecter</a></button>

    <script src="./js/script.js"></script>
</body>

</html>