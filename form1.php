<?php
try {
    $db = new PDO('mysql:host=localhost;dbname=contact', 'root', '');

    // Récupération des données du formulaire
    $nom = $_POST["nom"];
    $adresse = $_POST["adresse"];
    $numéro = $_POST["numéro"];
    $objet = $_POST["objet"];
    $extra = $_POST["extra"];

    // Requête SQL pour insérer la nouvelle personne
    $insert = $db->prepare('INSERT INTO personnes (nom, adresse, numéro, objet, extra) VALUES (:nom, :adresse, :numéro, :objet, :extra)');
    $insert->execute(array(
        ':nom' => $nom,
        ':adresse' => $adresse,
        ':numéro' => $numéro,
        ':objet' => $objet,
        ':extra' => $extra,
    ));

    echo "Nouvelle personne insérée avec succès";

    // Fermeture de la connexion à la base de données
    unset($db);
} catch (PDOException $e) {
    echo "Erreur Ajout Personne : " . $e->getMessage() . "<br/>";
    die();
}
?>
