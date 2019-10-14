<?php
include("includes/config.php");
session_start();
$message ="";
//verifier si l'utilisateur a clicker sur le bouton envoyer
if($_SERVER['REQUEST_METHOD'] === "POST"){
    //verifier si l'utilisateur a clicker sur le bouton envoyer
    if(!empty($_POST['login']) && !empty($_POST['passwor'])){
    $login=htmlspecialchars(addslashes($_POST['login']));
    $passwor=htmlspecialchars(addslashes($_POST['passwor']));    
        try
        {
            $bdd = new PDO('mysql:host='.DB_HOSTNAME.';dbname='.DB_DATABASE.';charset=utf8', DB_USERNAME, DB_PASSWORD);
        }
        catch(Exception $e)
        {
            die('Erreur : '.$e->getMessage());

        }
        //verifier que le login et le mot de passe sont corrects
        $reponse = $bdd->query("SELECT passwor FROM admin where login ='".$login."' ");
        $row = $reponse->fetch();
        if($reponse->rowCount() == 1){
            if(crypt($passwor ,$row['passwor']) == $row['passwor'])
            {   $_SESSION['user'] = $login ;
                header('Location: PageDeLaSecretaire.php');//rediriger la secretaire vers sa page 
                die;
            }else{
                $message="Mot de passe incorrect !";
                 }}else{
                    $message="Login incorrect";
                       }  
    }else $message="veullez remplire les deux champ";
}?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Espace secretaire </title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style2.css">
</head>
<body>
<?php       //affichage d'un message d'erreur   
            if(!empty($message)){ echo'<div class="alertt">';
                 echo ' <span class="closebtn" onclick="this.parentElement.style.display=';
                 echo "'none' "; echo '">&times;</span>';
                       echo $message;echo'</div>';}?>
            
 <form name="formulaire" action="" method="post" autocomplete="off" class ="seco" >
    
 <label for="nom">Nom</label> 
 <input type=text id ="nom" size=20 name="login" required="required"> <br> 
 <label for="passwor">Mot de passe</label> 
 <input type=password id="passwor" size=20 name="passwor" required="required"> <br>
 <input type="submit" class ="connexion" value="Connexion" onClick="return verifform()" > 
 
 </form>
       
     
</body>
</html>