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
    <h1 class="det">details</h1>
</body>
</html>

<?php

$servername = 'localhost';
$username = 'root';
$database = 'gestiontache';
$password = '';

// Établir la connexion avec la base de données
$db = new PDO("mysql:host=$servername;dbname=$database", $username, $password);



$id_tache = $_SESSION['result']['id_tache'];
$nomTache = $_SESSION['result']['nomTache'];   // on recupere nom tache a partir de la session['result] et on l'affecte a la variabla nomTache
$description = $_SESSION['result']['description'];
$dateEcheance = $_SESSION['result']['dateEcheance'];
$priorite = $_SESSION['result']['priorite'];
$etat = $_SESSION['result']['etat'];

// on affiche 
     echo '<div class="suprimer">';
 echo '<h2>' . $id_tache . '</h2>';
echo '<p>' . $nomTache . '</p>';
echo '<h5>Statut : ' . $description . '</h5>';
echo '<h5>Statut : ' . $dateEcheance. '</h5>';
echo '<h5>Statut : ' . $priorite . '</h5>';
echo '<h5>Statut : ' . $etat . '</h5>';
echo '<form method="post" action="">';
echo '<input type="submit" class="ter" name="termine" value="marquer comme terminée">';
echo '<input type="submit" class="sup" name="sup" value="sup">';
        echo '</form>';
        echo '</div>';

// fassons de tel sorte que nous puissons supprimer une tache dans la base de données
        if (isset($_POST['sup'])) {
            // Récupérez l'ID de la tâche à supprimer depuis la session
            $id_tache = $_SESSION['result']['id_tache'];
        
            // Effectuez l'action pour supprimer la tâche de la base de données
            $sqlSuppression = "DELETE FROM taches WHERE id_tache = :id_tache";
            $suppression = $db->prepare($sqlSuppression);
            $suppression->bindParam(':id_tache', $id_tache, PDO::PARAM_INT);
        
            if ($suppression->execute()) {
                echo "Suppression réussie";
                header('Location: gestiontaches.php'); // Redirigez vers la page "details.php" ou la page de confirmation.
                exit; // Assurez-vous de terminer le script après la redirection.
            } else {
                echo "La suppression a échoué.";
            }
        }



        if (isset($_POST['termine'])) {
            // Récupérez l'ID de la tâche à marquer comme terminée depuis la session
            $id_tache = $_SESSION['result']['id_tache'];
        
            // Effectuez l'action pour marquer la tâche comme terminée dans la base de données en mettant à jour l'état.
            $nouvel_etat = "Terminée"; // L'état que vous souhaitez définir
        
            $sqlMiseAJour = "UPDATE taches SET etat = :nouvel_etat WHERE id_tache = :id_tache";
            $miseAJour = $db->prepare($sqlMiseAJour);
            $miseAJour->bindParam(':nouvel_etat', $nouvel_etat, PDO::PARAM_STR);
            $miseAJour->bindParam(':id_tache', $id_tache, PDO::PARAM_INT);
        
            if ($miseAJour->execute()) {
                // Redirigez l'utilisateur vers la page "gestiontache" après avoir marqué la tâche comme terminée.
                //header('Location: gestiontache.php');
                echo "tache terminée avec succes.";

            } else {
                echo "La mise à jour de l'état a échoué.";
            }
        }
        





        ?>


  