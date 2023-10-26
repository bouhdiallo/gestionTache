<?php
session_start();








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
<div id="tache">
        <h2>Gestion de mes Taches</h2>
      </div>
      </body>
</html>
      <?php
$servername = 'localhost';
$username = 'root';
$database = 'gestiontache';
$password = '';
// Établir la connexion avec la base de données
$db = new PDO("mysql:host=$servername;dbname=$database", $username, $password);

if (isset($_POST['ajouter'])) {
    // Traitez l'ajout de la tâche dans la base de données
    $nomTache = $_POST['titre'];
    $description = $_POST['desc'];
    $dateEcheance = $_POST['dateEcheance'];
    $priorite = $_POST['priorite'];
    $statut = $_POST['statut'];
    //on defini l'identifiant de l'utilisateur
    $id_utilisateur = $_SESSION['c']["id_utilisateur"];
    //$id_utilisateur = $_SESSION['c'][0];
    //on fait l'insertion
     $sql3 = ("INSERT INTO taches (nomTache, description, dateEcheance, priorite, etat,id_utilisateur) VALUES (:titre,:desc,:dateEcheance,:priorite,:statut,:id_utilisateur)");
    //on prepare la requete
    $gestion = $db->prepare($sql3);
//on lie les parametres avec des valeurs
$gestion->bindParam(':titre',$nomTache);
$gestion->bindParam(':desc',$description);
$gestion->bindParam(':dateEcheance',$dateEcheance);
$gestion->bindParam(':priorite',$priorite);
$gestion->bindParam(':statut',$statut);
$gestion->bindParam(':id_utilisateur', $id_utilisateur);

if ($gestion->execute()){ 
    

    // Après avoir ajouté la tâche, affichons un bouton "Voir les détails".
    echo '<div class="vente">';
    echo '<h2>' . $_POST['titre'] . '</h2>';
    echo '<p>' . $_POST['desc'] . '</p>';
    echo '<h6>Priorité : ' . $_POST['priorite'] . '</h6>';
    echo '<h5>Statut : ' . $_POST['statut'] . '</h5>';
    echo '<form method="post" action="">';
    echo '<input type="submit" class="detail" name="voir" value="Voir">';
    echo '</form>';
    echo '</div>';
}
 }


        if (isset($_POST['voir'])) {
            $id_utilisateur = $_SESSION['c']["id_utilisateur"];
        
            $sql4 = "SELECT * FROM taches WHERE id_utilisateur = :id_utilisateur";
            $detail = $db->prepare($sql4);
            $detail->bindParam(':id_utilisateur', $id_utilisateur);
            $detail->execute();
            $affichage = $detail->fetch(PDO::FETCH_ASSOC);
            $_SESSION['result'] = $affichage;
            header('Location:details.php');
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

    <div id="ajout">
        <h3>Ajouter une nouvelle tâche</h3>
        <form method="post" action="">
        <label for="titre">Titre :</label><br>
    <input type="text" name="titre"><br><br>

    <label for="titre">Priorité:</label><br>
    <select name="priorite" id="prio">
    <option value="Haute">Haute</option>
    <option value="Moyenne">Moyenne</option>
    <option value="Basse">Basse</option>
    </select><br><br>

    <label for="titre">Statut:</label><br>
    <select name="statut" id="prio">
    <option value="enCours">En cours</option>
    <option value="attente">En attente</option>
    <option value="Terminée">Terminée</option>
    </select><br><br>

    <label for="">date d'echeance</label><br>
    <input type="date" name="dateEcheance"><br><br>

    <label for="">Description :</label> <br>
    <textarea name="desc" id="desc" cols="175" rows="4"></textarea><br>

            <input type="submit" id="ajouter" name="ajouter" value="Ajouter">
        </form>
    </div>
</body>
</html>
