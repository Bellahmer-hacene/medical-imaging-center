 <?php
session_start();
  if ($_SESSION['user'] != "secretaire" ) {
    header('Location: ../EspaceSecretaire.php'); die;
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
$code_rdv=htmlspecialchars(addslashes($_GET['id']));
 $url=htmlspecialchars($_GET["url"]);
 
  if ($bdd->query("DELETE FROM rdv
          WHERE id='$code_rdv'") == TRUE) {
      header("Location: ../$url"); die;}
else{
      echo'echec lors de la suppresion';}

?>
  