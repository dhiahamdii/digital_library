<?php
require_once '../models/Document.php';
require_once '../models/Emprunt.php';
require_once '../config/database.php';

class UtilisateurController {
    private $documentModel;
    private $empruntModel;
    private $conn;

    public function __construct() {
        $this->documentModel = new Document();
        $this->empruntModel = new Emprunt();
        $this->conn = Database::getInstance()->getConnection();
    }

    public function rechercheDocuments() {
        $criteria = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $criteria['titre'] = filter_input(INPUT_POST, 'titre', FILTER_SANITIZE_STRING);
            $criteria['auteur'] = filter_input(INPUT_POST, 'auteur', FILTER_SANITIZE_STRING);
            $criteria['annee'] = filter_input(INPUT_POST, 'annee', FILTER_VALIDATE_INT);
            $criteria['type'] = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING);
        }

        $documents = $this->documentModel->search($criteria);
        include '../views/utilisateur/recherche.php';
    }

    public function emprunterDocument() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $document_id = filter_input(INPUT_POST, 'document_id', FILTER_VALIDATE_INT);
            $utilisateur_id = $_SESSION['user_id']; // Ensure user is logged in
            $date_emprunt = date('Y-m-d');
            $date_retour_prevue = date('Y-m-d', strtotime('+14 days'));

            if ($document_id && $utilisateur_id) {
                $result = $this->empruntModel->create($utilisateur_id, $document_id, $date_emprunt, $date_retour_prevue);
                if ($result) {
                    header('Location: index.php?action=historiqueEmprunts&success=1');
                    exit;
                }
            }
            header('Location: index.php?action=rechercheDocuments&error=1');
            exit;
        }
    }

    public function historiqueEmprunts() {
        $utilisateur_id = $_SESSION['user_id']; // Ensure user is logged in
        $emprunts = $this->empruntModel->getEmpruntsByUser($utilisateur_id);
        include '../views/utilisateur/historique.php';
    }

    public function login($email, $password) {
        $stmt = $this->conn->prepare('SELECT * FROM utilisateurs WHERE email = :email');
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['mot_de_passe'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['role'];
            return true;
        }
        return false;
    }

    public function register($name, $email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->conn->prepare('INSERT INTO utilisateurs (nom, email, mot_de_passe) VALUES (:nom, :email, :mot_de_passe)');
        return $stmt->execute([
            ':nom' => $name,
            ':email' => $email,
            ':mot_de_passe' => $hashedPassword
        ]);
    }
    
}
