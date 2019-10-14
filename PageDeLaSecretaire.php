<?php
//verifier que la secretaire c'est connecter sinon rediriger vers la page de connection
session_start();
if(!isset($_SESSION['user'])){
    header('Location: EspaceSecretaire.php');
}
include("includes/config.php");
if(!isset($_GET['type'])){$t='';}else{
$t='';// variable contenant le type de l'examen pour le trie du tableau
$t=$_GET['type'];}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Espace secretaire </title>
<link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style3.css">
          
</head>
<body>  
           
                    
<header> 
                    <div id ="titre">   
                    <h1>Centre d'Imagerie Médicale Mahmoudi</h1> 
                    </div>
</header>
            <nav>   
                <a class='anis' href=<?php echo(URL."/PageDeLaSecretaire.php")  ?>>Nouveaux rendez-vous   </a>
                <a href=<?php echo(URL."/rdvconfirmer.php")  ?>>Rendez-vous confirmés  </a>
                <a href=<?php echo(URL."/aujourd'hui.php")  ?>>Rendez-vous d'aujourd'hui  </a>
                <a href=<?php echo(URL."/includes/deconnexion.php")  ?>> Deconnexion  </a>
            </nav>

<div class="dropdown">
  <button class="dropbtn">Trier par <i class="fas fa-sort-down"></i></button>
  <div class="dropdown-content">
    <a href=<?php echo(URL."/PageDeLaSecretaire.php")?>>tout</a>
     <a  href=<?php echo(URL."/PageDeLaSecretaire.php?type='IRM'")?>>IRM</a>
    <a  href=<?php echo(URL."/PageDeLaSecretaire.php?type='Mamographie'")?>>Mamographie</a>
    <a  href=<?php echo(URL."/PageDeLaSecretaire.php?type='Radio'")?>>Radio</a>
  </div>
</div> 

<section>        
    <table border cellspacing=15 cellpadding=15 > 
    
<?php
    //connection et reccuperation des rendez-vous de la basse de données
     try
        {
            $bdd = new PDO('mysql:host='.DB_HOSTNAME.';dbname='.DB_DATABASE.';charset=utf8', DB_USERNAME, DB_PASSWORD);
        }
        catch(Exception $e)
        {
                die('Erreur : '.$e->getMessage());

        }
        $bdd->query("DELETE FROM rdv WHERE dat<CURDATE()  "); 
    if($t==''){
 $sql="SELECT id,nom,prenom,telephone,email,date_n,examen,dat,heure,valide FROM rdv where dat>=CURDATE() and valide =0 ORDER BY id desc ";
    } else{
$sql="SELECT id,nom,prenom,telephone,email,date_n,examen,dat,heure,valide FROM rdv where dat>=CURDATE() and valide =0 and examen=$t ORDER BY id desc ";
    }              
      $resultat = $bdd->query($sql);
      if(!empty($resultat)){
    ?>
    <tr>
        <th><p align='center'><b>Nom</b></th>
        <th><p align='center'><b>Prenom</b></th>
        <th><p align='center'><b>Telephone</b></th>
        <th><p align='center'><b>E-mail</b></th>
        <th><p align='center'><b>Date de naissance</b></th>
        <th><p align='center'><b>Examen</b></th>
        <th><p align='center'><b>Date</b></th>
        <th><p align='center'><b>Heure</b></th>
        <th><p align='center'><b>Action</b></th>
        
    </tr>
    <?php
    while( $line = $resultat->fetch()){
    ?>
    <tr>
        <td><?php echo '<b>'.$line['nom'].'  </b>'; ?></td>
        <td><?php echo '<b>'.$line['prenom'].'  </b>' ; ?></td>
        <td><?php echo '<b>0'.$line['telephone'].'  </b>' ; ?></td>
        <td><?php echo '<b>'.$line['email'].'  </b>'; ?></td>
        <td><?php echo '<b>'.$line['date_n'].'  </b>'; ?></td>
        <td><?php echo '<b>'.$line['examen'].'  </b>'; ?></td>
        <td><?php echo '<b>'.$line['dat'].'  </b>'; ?></td>
        <td><?php echo '<b>'.$line['heure'].'  </b>'; ?></td>
       <?php if($t==''){?>
        <td>
        <a href="includes/valider.php?id=<?php echo $line['id']; ?>&url=PageDeLaSecretaire.php " >Confirmer </a>
        <a href="includes/supprimer.php?id=<?php echo $line['id']; ?>&url=PageDeLaSecretaire.php " >Supprimer</a>
        
        </td><?php }else{ ?>
<td class="insine">
       <a href="includes/valider.php?id=<?php echo $line['id']; ?>&url=PageDeLaSecretaire.php?type=<?php echo $t; ?> " >Confirmer</a>
       <a href="includes/supprimer.php?id=<?php echo $line['id']; ?>&url=PageDeLaSecretaire.php?type=<?php echo $t; ?>" >Supprimer </a>
</td>
        
      <?php  }?>
    </tr>
    <?php }}   ?>
     
</table>
        
</section>    
</body>
</html>