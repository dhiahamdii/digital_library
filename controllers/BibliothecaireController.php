<?php
require_once '../models/Document.php';
require_once '../models/Emprunt.php';

class BibliothecaireController {
    private $documentModel;
    private $empruntModel;

    public function __construct() {
        $this->documentModel = new Document();
        $this->empruntModel = new Emprunt();
    }

    public function gererDocuments() {
        $documents = $this->documentModel->search([]);
        include '../views/bibliothecaire/gestion_documents.php';
    }

    public function ajouterDocument() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titre = filter_input(INPUT_POST, 'titre', FILTER_SANITIZE_STRING);
            $auteur = filter_input(INPUT_POST, 'auteur', FILTER_SANITIZE_STRING);
            $annee = filter_input(INPUT_POST, 'annee', FILTER_VALIDATE_INT);
            $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING);

            if ($titre && $auteur && $annee && $type) {
                $result = $this->documentModel->create($titre, $auteur, $annee, $type);
                if ($result) {
                    header('Location: index.php?action=gererDocuments&success=1');
                    exit;
                }
            }
            header('Location: index.php?action=gererDocuments&error=1');
            exit;
        }
        include '../views/bibliothecaire/ajouter_document.php';
    }

    public function modifierDocument() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titre = filter_input(INPUT_POST, 'titre', FILTER_SANITIZE_STRING);
            $auteur = filter_input(INPUT_POST, 'auteur', FILTER_SANITIZE_STRING);
            $annee = filter_input(INPUT_POST, 'annee', FILTER_VALIDATE_INT);
            $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING);

            if ($id && $titre && $auteur && $annee && $type) {
                $result = $this->documentModel->update($id, $titre, $auteur, $annee, $type);
                if ($result) {
                    header('Location: index.php?action=gererDocuments&success=1');
                    exit;
                }
            }
            header('Location: index.php?action=gererDocuments&error=1');
            exit;
        }
        $document = $this->documentModel->read($id);
        include '../views/bibliothecaire/modifier_document.php';
    }

    public function supprimerDocument() {
        $id = filter_input(INPUT_POST, 'document_id', FILTER_VALIDATE_INT);
        if ($id) {
            $result = $this->documentModel->delete($id);
            if ($result) {
                header('Location: index.php?action=gererDocuments&success=1');
                exit;
            }
        }
        header('Location: index.php?action=gererDocuments&error=1');
        exit;
    }

    public function gererEmprunts() {
        $emprunts = $this->empruntModel->getAllEmprunts();
        include '../views/bibliothecaire/gestion_emprunts.php';
    }

    public function retournerDocument() {
        $emprunt_id = filter_input(INPUT_POST, 'emprunt_id', FILTER_VALIDATE_INT);
        $date_retour = filter_input(INPUT_POST, 'date_retour', FILTER_SANITIZE_STRING);

        if ($emprunt_id && $date_retour) {
            $result = $this->empruntModel->update($emprunt_id, $date_retour);
            if ($result) {
                header('Location: index.php?action=gererEmprunts&success=1');
                exit;
            }
        }
        header('Location: index.php?action=gererEmprunts&error=1');
        exit;
    }

    public function prolongerEmprunt() {
        $emprunt_id = filter_input(INPUT_POST, 'emprunt_id', FILTER_VALIDATE_INT);

        if ($emprunt_id) {
            $result = $this->empruntModel->prolongerEmprunt($emprunt_id);
            if ($result) {
                header('Location: index.php?action=gererEmprunts&success=1');
                exit;
            }
        }
        header('Location: index.php?action=gererEmprunts&error=1');
        exit;
    }
}