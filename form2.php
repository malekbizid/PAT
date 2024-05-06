<?php
try {
    $db = new PDO('mysql:host=localhost;dbname=avis', 'root', '');

    // Récupération des données du formulaire
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Requête SQL pour insérer la nouvelle personne
    $insert = $db->prepare('INSERT INTO personnes (nom, email, mesage) VALUES (:nom, :email, :mesage)');
    $insert->execute(array(
        ':nom' => $nom,
        ':email' => $email,
        ':mesage' => $mesage
    ));

    echo "Nouvelle personne insérée avec succès";

    // Fermeture de la connexion à la base de données
    unset($db);
} catch (PDOException $e) {
    echo "Erreur Ajout Personne : " . $e->getMessage() . "<br/>";
    die();
}
?>