<?php
require_once '../config/database.php';

class Document {
    private $conn;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function create($titre, $auteur, $annee, $type) {
        $query = "INSERT INTO documents (titre, auteur, annee, type) VALUES (:titre, :auteur, :annee, :type)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':titre', $titre);
        $stmt->bindParam(':auteur', $auteur);
        $stmt->bindParam(':annee', $annee);
        $stmt->bindParam(':type', $type);
        return $stmt->execute();
    }

    public function read($id) {
        $query = "SELECT * FROM documents WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $titre, $auteur, $annee, $type) {
        $query = "UPDATE documents SET titre = :titre, auteur = :auteur, annee = :annee, type = :type WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':titre', $titre);
        $stmt->bindParam(':auteur', $auteur);
        $stmt->bindParam(':annee', $annee);
        $stmt->bindParam(':type', $type);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM documents WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function search($criteria) {
        $query = "SELECT * FROM documents WHERE 1=1";
        $params = [];

        if (!empty($criteria['titre'])) {
            $query .= " AND titre LIKE :titre";
            $params[':titre'] = '%' . $criteria['titre'] . '%';
        }

        if (!empty($criteria['auteur'])) {
            $query .= " AND auteur LIKE :auteur";
            $params[':auteur'] = '%' . $criteria['auteur'] . '%';
        }

        if (!empty($criteria['annee'])) {
            $query .= " AND annee = :annee";
            $params[':annee'] = $criteria['annee'];
        }

        if (!empty($criteria['type'])) {
            $query .= " AND type = :type";
            $params[':type'] = $criteria['type'];
        }

        $stmt = $this->conn->prepare($query);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTopDocuments($limit = 5) {
        $query = "SELECT d.id, d.titre, COUNT(e.id) as emprunts 
                  FROM documents d 
                  LEFT JOIN emprunts e ON d.id = e.document_id 
                  GROUP BY d.id 
                  ORDER BY emprunts DESC 
                  LIMIT :limit";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalDocuments() {
        $query = "SELECT COUNT(*) as total FROM documents";
        $stmt = $this->conn->query($query);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
}