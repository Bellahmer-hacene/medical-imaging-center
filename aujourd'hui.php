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
    <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style3.css">
    <title>Secretaire-<?php echo WEBSITE_NAME;?></title>
   
</head>
<body>
<header> 
          <div id ="titre">   
          <h1>Centre d'Imagerie Médicale Mahmoudi</h1> 
          </div>
</header>
            <nav>   
                <a href=<?php echo(URL."/PageDeLaSecretaire.php")  ?>> Nouveaux rendez-vous   </a>
                <a href=<?php echo(URL."/rdvconfirmer.php")  ?>> Rendez-vous confirmés  </a>
                <a class='anis' href=<?php echo(URL."/aujourd'hui.php")  ?>> Rendez-vous d'aujourd'hui  </a>
                <a href=<?php echo(URL."/includes/deconnexion.php")  ?>> Deconnexion  </a>
            </nav>
            
<div class="dropdown">
  <button class="dropbtn">Trier par</button>
  <div class="dropdown-content">
    <a href=<?php echo(URL."/aujourd'hui.php")?>>tout</a>
    <a  href=<?php echo(URL."/aujourd'hui.php?type='IRM'")?>>IRM</a>
    <a  href=<?php echo(URL."/aujourd'hui.php?type='Mamographie'")?>>Mamographie</a>
    <a  href=<?php echo(URL."/aujourd'hui.php?type='Radio'")?>>Radio</a>
  </div>
</div> 

<section>   
    
<table  border cellspacing=10 cellpadding=10 >
    <?php
        //connection et reccuperation des rendez-vous d'aujourd'hui de la basse de données
     try
        {
            $bdd = new PDO('mysql:host='.DB_HOSTNAME.';dbname='.DB_DATABASE.';charset=utf8', DB_USERNAME, DB_PASSWORD);
        }
        catch(Exception $e)
        {
                die('Erreur : '.$e->getMessage());

        }
             if($t==''){
             $sql="SELECT id,nom,prenom,telephone,email,date_n,examen,dat,heure,valide FROM rdv where dat=CURDATE() and valide =1 ORDER BY id asc ";
    } else{
$sql="SELECT id,nom,prenom,telephone,email,date_n,examen,dat,heure,valide FROM rdv where dat=CURDATE() and valide =1 and examen=$t ORDER BY id asc ";
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
        <th class="insine"><p align='center'><b>Action</b></th>
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
        <td class="insine"><a href="includes/supprimer.php?id=<?php echo $line['id']; ?>&url=aujourd'hui.php " > Supprimer  </a></td>
    <?php }else{ ?>
    <td class="insine"><a href="includes/supprimer.php?id=<?php echo $line['id']; ?>&url=aujourd'hui.php?type= <?php echo $t; ?> " > Supprimer  </a></td><?php  }?>
   
    </tr>
    <?php }} ?>
     
    </table> 
    </section> 
     <button onclick="print()"><i class="fas fa-print"></i> imprimer</button>
     <script src="librairie/fontawesome-all.js" ></script>
</body>
</html>