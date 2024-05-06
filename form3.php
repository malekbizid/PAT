<?php
try {
    $db = new PDO('mysql:host=localhost;dbname=réclamation', 'root', '');

    // Récupération des données du formulaire
    $nom = $_POST['nom'];
    $mail = $_POST['mail'];
    $réclamation = $_POST['réclamation'];

    // Requête SQL pour insérer la nouvelle personne
    $insert = $db->prepare('INSERT INTO personnes (nom, mail, réclamation) VALUES (:nom, :mail, :réclamation)');
    $insert->execute(array(
        ':nom' => $nom,
        ':mail' => $mail,
        ':réclamation' => $réclamation
    ));

    echo "Nouvelle personne insérée avec succès";

    // Fermeture de la connexion à la base de données
    unset($db);
} catch (PDOException $e) {
    echo "Erreur Ajout Personne : " . $e->getMessage() . "<br/>";
    die();
}
?>