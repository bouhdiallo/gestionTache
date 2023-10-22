<?php
session_start();
$_SESSION['c'] = array();

$servername = 'localhost';
$username = 'root';
$database = 'gestiontache';
$password = '';
// on établit la connexion avec la base de données
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
// on vérifie si les champs sont définis
if (isset($_POST['creation'])) {
    $nom_utilisateur = $_POST['utilisateur'];
    $adress_mail = $_POST['adresse'];
    $mot_de_pass = $_POST['mtp'];

    $sql1 = ("INSERT INTO utilisateur (nom, adressMail, motPss) VALUES (:nom,:adressMail,:motPss)");
    // préparons la requête
    $inscription = $conn->prepare($sql1);
    // on attribue les espaces réservés à des valeurs
    $inscription->bindParam(':nom', $nom_utilisateur);
    $inscription->bindParam(':adressMail', $adress_mail);
    $inscription->bindParam(':motPss', $mot_de_pass);
    // on exécute la requête
    $inscription->execute();
}


// on vérifie si les champs sont définis pour la connexion 
if(isset($_POST['connexion'])) {
    $nom_utilisateur =$_POST['user'];
    $mot_de_pass = $_POST['pass'];

    $sql2 = ("SELECT * FROM utilisateur WHERE nom = :user AND motPss = :pass") ;

    //on prepare la requete
    $connect = $conn->prepare($sql2);
    //on lie les parametres avec des valeurs
    $connect->bindParam(':user',$nom_utilisateur);
    $connect->bindParam(':pass',$mot_de_pass);

    //on execute la requete
    $connect->execute();

    //on recupere les resultats 
   $resultat=$connect->fetch(PDO::FETCH_ASSOC); 
   
   // on recupere le resusltat qu'on met dans la session
      $_SESSION['c'][] = $resultat;
   
      if($resultat) {
      header('location:gestiontaches.php');
       exit;
      } else {
       echo "ce compte n'existe pas, va t'inscrire";
      }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div id="creation">
        <h1><strong>creation de compte et connexion</strong></h1>
</div>

    <div id="general">
    
<form method="post" action="">
   <div id="inscription">

   <h4>Creer un compte</h4>

   <label for="">nom d'utilisateur:</label><br>
   <input type="text" id="" name="utilisateur"><br><br>

   <label for="">adresse mail:</label><br>
   <input type="text" id="" name="adresse"><br><br>

   <label for="">mot de pass</label><br>
   <input type="text" id="" name="mtp"><br><br>

   <label for="">Confirmation:</label><br>
   <input type="text" id="" name="confirme"><br><br>

   <input type="submit"  id="creer" name="creation" value="creation" >

   </div>
</form>

<form method="post" action="">
   <div id="connexion">
   <h4>Connexion</h4>
   
   <label for="">nom d'utilisateur</label><br>
   <input type="text" id="" name="user"><br><br>

   <label for="">mot de pass</label><br>
   <input type="text" id="" name="pass"><br><br>

   <input type="submit"  id="connecter" name="connexion" value="connexion" >
   </div>
   </div>
</form>
</body>
</html>