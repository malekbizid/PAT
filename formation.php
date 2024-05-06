<?php
// Vérifie si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collecte et nettoie les données du formulaire
    $nomOrganisation = filter_input(INPUT_POST, 'nomOrganisation', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $personneContact = filter_input(INPUT_POST, 'personneContact', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $telephone = filter_input(INPUT_POST, 'telephone', FILTER_SANITIZE_NUMBER_INT);
    $collaborationInterest = filter_input(INPUT_POST, 'collaborationInterest', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Valide les données
    if (empty($nomOrganisation) || empty($personneContact) || empty($email) || empty($telephone) || empty($collaborationInterest)) {
        echo "Tous les champs sont obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Format d'email invalide.";
    } elseif (!preg_match('/^\d+$/', $telephone)) {
        echo "Le numéro de téléphone doit contenir uniquement des chiffres.";
    } else {
        // Traite les données (par exemple, enregistre dans une base de données, envoie un email)
        $servername = "localhost";
        $username = "nom_utilisateur";
        $password = "mot_de_passe";
        $dbname = "nom_de_base_de_donnees";

        // Crée une connexion
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Vérifie la connexion
        if ($conn->connect_error) {
            die("Échec de la connexion : " . $conn->connect_error);
        }

        // Prépare et lie les paramètres
        $stmt = $conn->prepare("INSERT INTO collaboration_requests (nomOrganisation, personneContact, email, telephone, collaborationInterest) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $nomOrganisation, $personneContact, $email, $telephone, $collaborationInterest);

        // Exécute la requête
        if ($stmt->execute()) {
            echo "Demande de collaboration soumise avec succès.";
            // Envoie un email de confirmation (implémentez cette partie selon vos besoins)
        } else {
            echo "Erreur : " . $stmt->error;
        }

        // Ferme la déclaration et la connexion
        $stmt->close();
        $conn->close();
    }
}
?>
