<?php
// Vérifie si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collecte et nettoie les données du formulaire
    $nomUtilisateur = filter_input(INPUT_POST, 'nomUtilisateur', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $interetAnimaux = $_POST['interetAnimaux']; 
    $commentaires = filter_input(INPUT_POST, 'commentaires', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Valide les données
    if (empty($nomUtilisateur)) {
        echo "Le nom est requis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Format d'email invalide.";
    } else {
        // Connexion à la base de données
        $servername = "localhost";
        $username = "username";
        $password = "password";
        $dbname = "myDB";

        // Crée une connexion
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Vérifie la connexion
        if ($conn->connect_error) {
            die("Échec de la connexion : " . $conn->connect_error);
        }

        // Prépare et lie les paramètres
        $stmt = $conn->prepare("INSERT INTO enquete (nomUtilisateur, email, interetAnimaux, commentaires) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nomUtilisateur, $email, $interetAnimaux, $commentaires);

        // Exécute la requête
        if ($stmt->execute()) {
            echo "Enquête soumise avec succès.";
            // Envoie un email de confirmation
            $to = $email;
            $subject = "Confirmation de soumission de l'enquête";
            $message = "Bonjour $nomUtilisateur,\n\nMerci d'avoir rempli notre enquête. Voici les informations que vous avez soumises :\nNom: $nomUtilisateur\nEmail: $email\nIntérêt pour les animaux: $interetAnimaux\nCommentaires: $commentaires\n\nCordialement,\nL'équipe d'enquête";
            $headers = "From: webmaster@example.com";

            if (mail($to, $subject, $message, $headers)) {
                echo " Un email de confirmation a été envoyé à : $email";
            } else {
                echo " L'email de confirmation n'a pas pu être envoyé.";
            }
        } else {
            echo "Erreur lors de la soumission de l'enquête : " . $stmt->error;
        }

        // Ferme la déclaration et la connexion
        $stmt->close();
        $conn->close();
    }
}
?>