<?php
require_once '../models/Document.php';
require_once '../models/Emprunt.php';

class AdminController {
    private $documentModel;
    private $empruntModel;

    public function __construct() {
        $this->documentModel = new Document();
        $this->empruntModel = new Emprunt();
    }

    public function dashboard() {
        // Fetch data from models
        $totalDocuments = $this->documentModel->getTotalDocuments();
        $totalEmprunts = $this->empruntModel->getTotalEmprunts();
        $topDocuments = $this->documentModel->getTopDocuments();
        $lateReturns = $this->empruntModel->getLateReturns();

        // Pass the variables to the view
        include '../views/admin/dashboard.php';
    }
    

    public function rechercheMulticritere() {
        $criteria = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $criteria['titre'] = filter_input(INPUT_POST, 'titre', FILTER_SANITIZE_STRING);
            $criteria['auteur'] = filter_input(INPUT_POST, 'auteur', FILTER_SANITIZE_STRING);
            $criteria['annee'] = filter_input(INPUT_POST, 'annee', FILTER_VALIDATE_INT);
            $criteria['type'] = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING);
        }

        $documents = $this->documentModel->search($criteria);
        include '../views/admin/recherche_multicritere.php';
    }

    
   
}