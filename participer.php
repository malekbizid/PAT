<?php
// Vérifiez si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Nettoyez les données du formulaire pour éviter les injections SQL
    $nomComplet = trim(filter_input(INPUT_POST, 'nomComplet', FILTER_SANITIZE_STRING));
    $telephone = trim(filter_input(INPUT_POST, 'telephone', FILTER_SANITIZE_STRING));
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $interetCours = trim(filter_input(INPUT_POST, 'interetCours', FILTER_SANITIZE_STRING));

    // Vérifiez si les champs ne sont pas vides
    if (empty($nomComplet) || empty($telephone) || empty($email) || empty($interetCours)) {
        // Gérez l'erreur 
        echo "Veuillez remplir tous les champs obligatoires.";
    } else {
        // Vérifiez la validité de l'email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Adresse e-mail non valide.";
        } else {
            // Vérifiez la validité du numéro de téléphone
            if (!preg_match("/^\d+$/", $telephone)) {
                echo "Numéro de téléphone non valide.";
            } else {
                // Les données sont valides, procédez à l'envoi des données
                // Connexion à la base de données
                $conn = new mysqli('localhost', 'username', 'password', 'nom_de_la_base_de_donnees');
            
                // Vérifiez la connexion
                if ($conn->connect_error) {
                    die("Échec de la connexion: " . $conn->connect_error);
                }
            
                // Préparez une déclaration d'insertion
                $stmt = $conn->prepare("INSERT INTO etudiants (nomComplet, telephone, email, interetCours) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $nomComplet, $telephone, $email, $interetCours);
            
                // Exécutez la déclaration préparée
                if ($stmt->execute()) {
                    // Affichez un message de succès ou redirigez l'utilisateur
                    echo "Inscription réussie!";
                } else {
                    echo "Erreur: " . $stmt->error;
                }
            
                // Fermez la déclaration et la connexion
                $stmt->close();
                $conn->close();
            }
            
        }
    }
}
?>
