<?php 
    session_start();
    if(!array_key_exists('isConnected', $_SESSION)){
        if(isset($_POST['identifiant'])){
            $co = new mysqli("nicolnu91.mysql.db","nicolnu91","testAutobonplan91","nicolnu91");
            $requete="SELECT login, password, level, name FROM USERS";
            $result = $co->query($requete);
            if ($result) {
                while($row = $result->fetch_assoc()) {
                    if($row['login']==$_POST['identifiant'] && $row['password']==$_POST['password']){
                        $_SESSION['isConnected']=true;
                        $_SESSION['level']=$row['level'];
                        $_SESSION['nom']=$row['name'];
                        header('Location: /autobonplan/index.php');

                    }

                }
            }
        }
    }
    else {
        header('Location: /autobonplan/index.php'); 
    }
    
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="connexion.css">
    
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
    <!--<div class="connexion-container">
        <div class="connexion-back">
            <form>
                <input type="text" name="identifiant" id="identifiant" placeholder="Identifiant">
                <input type="password" name="password" id="password" placeholder="Mot de passe">
                <button type="submit">Se connecter</button>
            </form>
        </div>
    </div>-->
    <div class="background">
        <img src="images/porsche.jpg" class="backgroundImg">
    </div>

    <div class="container">
        <div class="box">
            <img src="images/logo.png" class="logo">
            <div class="titre">Veuillez vous connecter :</div>
            <form method='POST'>
                <input type="text" name="identifiant" id="identifiant" placeholder="Identifiant" required><br>
                <input type="password" name="password" id="password" placeholder="Mot de passe" required><br>
                <button type="submit">Se connecter</button>
            </form>
            <div class="more"><a href="https://www.autobonplan.com" target="_blank">Accédez à plus d'infos sur notre site.</a></div>
        </div>
    </div>
</body>
</html>