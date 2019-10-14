 <?php
session_start();
  if ($_SESSION['user'] != "secretaire" ) {
    header('Location: ../login.php'); die;
  }
include("config.php");
try
{
    $bdd = new PDO('mysql:host='.DB_HOSTNAME.';dbname='.DB_DATABASE.';charset=utf8', DB_USERNAME, DB_PASSWORD);
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());

}
$code_rdv=htmlspecialchars($_GET['id']);
 $url=htmlspecialchars($_GET["url"]);
if ($bdd->query("UPDATE rdv SET valide =1 WHERE id ='$code_rdv'") == TRUE) {
      header("Location: ../$url"); die;}
else{
      echo'echec lors de la validation';}

?>