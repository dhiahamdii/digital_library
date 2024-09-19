<?php
require_once '../config/database.php';

class Emprunt {
    private $conn;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function create($utilisateur_id, $document_id, $date_emprunt, $date_retour_prevue) {
        $query = "INSERT INTO emprunts (utilisateur_id, document_id, date_emprunt, date_retour_prevue) VALUES (:utilisateur_id, :document_id, :date_emprunt, :date_retour_prevue)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':utilisateur_id', $utilisateur_id);
        $stmt->bindParam(':document_id', $document_id);
        $stmt->bindParam(':date_emprunt', $date_emprunt);
        $stmt->bindParam(':date_retour_prevue', $date_retour_prevue);
        return $stmt->execute();
    }

    public function read($id) {
        $query = "SELECT e.*, d.titre as document_titre, u.nom as utilisateur_nom 
                  FROM emprunts e 
                  JOIN documents d ON e.document_id = d.id 
                  JOIN utilisateurs u ON e.utilisateur_id = u.id 
                  WHERE e.id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $date_retour_reelle) {
        $query = "UPDATE emprunts SET date_retour_reelle = :date_retour_reelle WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':date_retour_reelle', $date_retour_reelle);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM emprunts WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getAllEmprunts() {
        $query = "SELECT e.*, d.titre as document_titre, u.nom as utilisateur_nom 
                  FROM emprunts e 
                  JOIN documents d ON e.document_id = d.id 
                  JOIN utilisateurs u ON e.utilisateur_id = u.id 
                  ORDER BY e.date_emprunt DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEmpruntsByUser($utilisateur_id) {
        $query = "SELECT e.*, d.titre as document_titre 
                  FROM emprunts e 
                  JOIN documents d ON e.document_id = d.id 
                  WHERE e.utilisateur_id = :utilisateur_id 
                  ORDER BY e.date_emprunt DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':utilisateur_id', $utilisateur_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLateReturns() {
        $query = "SELECT e.*, d.titre as document_titre, u.nom as utilisateur_nom 
                  FROM emprunts e 
                  JOIN documents d ON e.document_id = d.id 
                  JOIN utilisateurs u ON e.utilisateur_id = u.id 
                  WHERE e.date_retour_prevue < CURDATE() AND e.date_retour_reelle IS NULL 
                  ORDER BY e.date_retour_prevue ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalEmprunts() {
        $query = "SELECT COUNT(*) as total FROM emprunts";
        $stmt = $this->conn->query($query);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function prolongerEmprunt($id) {
        $query = "UPDATE emprunts SET date_retour_prevue = DATE_ADD(date_retour_prevue, INTERVAL 14 DAY) WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}