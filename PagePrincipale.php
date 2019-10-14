<?php
$c=0;
include("includes/config.php");
//verifier si l'utilisateur a clicker sur le bouton envoyer
if($_SERVER['REQUEST_METHOD'] === "POST")
{   
    //verifier que les champs ne sont pas vides 
    if(!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['telephone'])&& !empty($_POST['nature']) &&          !empty($_POST['email']) &&!empty($_POST['date_n']) && !empty($_POST['examen']) && !empty($_POST['dat'])&&              !empty($_POST['heure']))
    { 
        $nom=htmlspecialchars($_POST['nom']);
        $prenom=htmlspecialchars($_POST['prenom']);
        $telephone=htmlspecialchars($_POST['telephone']);
        $nature=htmlspecialchars($_POST['nature']);
        $email=htmlspecialchars($_POST['email']);
        $examen=htmlspecialchars($_POST['examen']);
        $date_n=htmlspecialchars($_POST['date_n']);
        $dat=htmlspecialchars($_POST['dat']);
        $heure=htmlspecialchars($_POST['heure']);
            $errors = [];       //tableau contenant les erreurs de l'utilisateur
            if(mb_strlen($nom) < 3){
                $errors[] = "Nom trop court, minimum 3 caractéres. ";
                
            }if(mb_strlen($prenom) < 3){
                $errors[] = "Prenom trop court, minimum 3 caractéres.";
            
            }if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                $errors[] = "Adresse e-mail invalide ";

            }if( date('Y-m-d')<$date_n ){
                $errors[] = "Date de naissance incorrect";

            }if(!preg_match('#^0[567][0-9]{8}$#',$telephone)){
                $errors[] = "Numero de telephone incorrect";         
            }
            try {
                    $bdd = new PDO('mysql:host=localhost;dbname=imagerie;charset=utf8', 'root', '');
                }
            catch(Exception $e)
                {
                    die('Erreur : '.$e->getMessage());

                }    
    $reponse = $bdd->query("SELECT dat,heure,examen FROM rdv WHERE dat='$dat' AND heure='$heure' AND examen='$examen'");
    
             if ($donnes=$reponse->fetch()){
                $errors[] = "Horaire indisponible pour cette examen.";   
             }
             if(date('Y-m-d')>=$dat){
                $errors[] = "Cette date est depassée.";             
             }
             if('08:00'>$heure || $heure>'17:00'){
                $errors[] = "Horaire incorrect(les rdv se font de 8h a 17h)";
             }      
                    //si il n'y a pas d'erreurs on insert les information du patient en basse de donnée
                    if(count($errors) == 0)              
                    {                  
                    $sql="INSERT INTO rdv(nom,prenom,telephone,email,date_n,nature,examen,dat,heure) VALUES    ('$nom','$prenom',$telephone,'$email','$date_n','$nature','$examen','$dat','$heure')";
                        if($bdd->query($sql)){
                          $c=1;
                        }else
                        { echo "erreur lors de l'insertion"; } 
                    }
    }else{
    $errors[]="Veullez remplire tous les champs.";
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset = "utf-8"/>
       
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <title> Page d'acceuil </title>
    </head>
    
    <body>
       <?php
        //affichage d'un message de confirmation de la transmission des information
        if($c==1){
            echo '<div class="bloc">';
                 echo'<div class="con">';
                 echo ' <span class="closebtn" onclick="this.parentElement.style.display=';
                 echo "'none' "; echo '">&times;</span>';
            if( $nature=='Homme'){$sex='Monsieur';}elseif($nature=='Femme'){$sex='Madame';}
            echo"Bonjour ".$sex." ".$nom." votre rendez-vous pour le ".$dat." a ".$heure." a été enregistré, vous recevrez un e-mail une fois votre rendez-vous confirmé ";
                
                 echo'</div>';
                 echo'</div>';           
        }
        //affichage d'un message d'erreur
             if(isset($errors) && count($errors)){
                 echo '<div class="bloc">';
                 echo'<div class="alertt">';
                 echo ' <span class="closebtn" onclick="this.parentElement.style.display=';
                 echo "'none' "; echo '">&times;</span>';
                 foreach($errors as $error){
                     echo $error.'</br>';
                 }
                 echo'</div>';
                 echo'</div>';
             }    ?>
<div id="bloc_page">
        <header>              
                <div id ="logo">
                    <img src="Images/logo.png" alt="Logo du centre">
                </div>              
                <div id="titre_principal">
                    <h1>Centre d'Imagerie Médicale Mahmoudi</h1> 
                </div>      
        </header>
        <nav>
           <p>Prise de rendez-vous <p>
        </nav>      
<section>        
            <div id = "info">
               <p>Rendez-vous disponibles<br>tous les jours de 08h à 17h</p>
            </div>     
         
         
<div id ="form">
    <form data-parsley-validate="" name="formulaire" action="" method="post" >
<fieldset> 
              <legend>Merci de remplir les champs ci-dessous:</legend>
 <table>
 <tr><td> Nom: </td><td>  
 <input validateString() class='in' type=text size=40 name="nom" required="requered" data-parsley-minlength="3" data-parsley-trigger="change"></td></tr>
 <tr><td>Prenom:</td><td>
 <input class='in'type=text size=40 name="prenom" required="required" data-parsley-minlength="3" data-parsley-trigger="change"></td></tr>
 <tr><td>Téléphone:</td><td>
 <input class='in' type=text size=40 name="telephone" maxlength="10" required="required" data-parsley-minlength="10" data-parsley-trigger="change"  data-parsley-type="number"></td></tr>
 <tr><td>E-Mail: </td><td>
<input class='in'  type="email" size=40 name="email" required="required" data-parsley-trigger="keypress" ></td></tr>
 <tr><td> Date de naissance:  </td><td>
<input type="date" size=40 name="date_n" required="required"></td></tr>
 <tr><td> Nature  </td><td>  <p class="nature"> <input type="radio" name="nature" value="Homme" required='required' />Homme 
                               <input type="radio" name="nature" value="Femme" required='' />Femme </p> </td></tr>
 <tr><td> Examen  </td><td> 
                   <select name="examen" required="required">
                    <option value="IRM"> IRM </option>
                    <option value="Radio"> Radio </option>
                    <option value="Mamographie"> Mamographie </option>
                    </select>  </td></tr> 
<tr><td>Date :</td><td>  
<input type="date" name="dat" required="required" /></td></tr>
<tr><td>Heure :</td><td> <select name="heure" required="required">
                            <option value="08:00"> 08:00 </option>
                            <option value="08:30"> 08:30 </option>
                            <option value="09:00"> 09:00 </option>
                            <option value="09:30"> 09:30 </option>
                            <option value="10:00"> 10:00 </option> 
                            <option value="10:30"> 10:30 </option>
                            <option value="11:00"> 11:00 </option> 
                            <option value="11:30"> 11:30 </option> 
                            <option value="12:00"> 12:00 </option> 
                            <option value="12:30"> 12:30 </option>
                            <option value="13:00"> 13:00 </option>
                            <option value="13:30"> 13:30 </option>
                            <option value="14:00"> 14:00 </option>
                            <option value="14:30"> 14:30 </option>
                            <option value="15:00"> 15:00 </option>
                            <option value="15:30"> 15:30 </option>
                            <option value="16:00"> 16:00 </option>
                            <option value="16:30"> 16:30 </option>
                            <option value="17:00"> 17:00 </option>    
                        </select> </td></tr>                                                            
 </table>
 <div id ="bouton">    
 <input type="submit" class="button" value="Envoyer" onClick="return verifform()" >
 <input type="reset" class="button" value="Annuler"> 
 </div>
</fieldset>
 </form>

</div>       
</section> 
 
<footer>        
        <p>Tel : 026 11 00 63 </p>
        <p> E-mail : radiologie@hcm-dz.com </p> 
        <p>Adresse : 5 Rue Frères Belhadj, Tizi Ouzou</p>
</footer>
                                      
     </div>
     <script src="librairie/jquery.min.js" ></script>
     <script src="librairie/parsley.min.js" ></script>
    </body>
</html>