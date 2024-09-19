<?php
session_start();

require_once '../config/database.php';
require_once '../controllers/AdminController.php';
require_once '../controllers/BibliothecaireController.php';
require_once '../controllers/UtilisateurController.php';

$action = $_GET['action'] ?? 'home';

$adminController = new AdminController();
$bibliothecaireController = new BibliothecaireController();
$utilisateurController = new UtilisateurController();

switch ($action) {
    case 'adminDashboard':
        if ($_SESSION['user_role'] === 'admin') {
            $adminController->dashboard();
        } else {
            header('Location: index.php?error=1');
        }
        break;
    case 'rechercheMulticritere':
        if ($_SESSION['user_role'] === 'admin' || $_SESSION['user_role'] === 'bibliothecaire') {
            $adminController->rechercheMulticritere();
        } else {
            header('Location: index.php?error=1');
        }
        break;
    case 'statistiquesEmprunts':
        if ($_SESSION['user_role'] === 'admin') {
            $adminController->statistiquesEmprunts();
        } else {
            header('Location: index.php?error=1');
        }
        break;
    case 'gererDocuments':
        if ($_SESSION['user_role'] === 'admin' || $_SESSION['user_role'] === 'bibliothecaire') {
            $bibliothecaireController->gererDocuments();
        } else {
            header('Location: index.php?error=1');
        }
        break;
    case 'ajouterDocument':
        if ($_SESSION['user_role'] === 'admin' || $_SESSION['user_role'] === 'bibliothecaire') {
            $bibliothecaireController->ajouterDocument();
        } else {
            header('Location: index.php?error=1');
        }
        break;
    case 'modifierDocument':
        if ($_SESSION['user_role'] === 'admin' || $_SESSION['user_role'] === 'bibliothecaire') {
            $bibliothecaireController->modifierDocument();
        } else {
            header('Location: index.php?error=1');
        }
        break;
    case 'supprimerDocument':
        if ($_SESSION['user_role'] === 'admin' || $_SESSION['user_role'] === 'bibliothecaire') {
            $bibliothecaireController->supprimerDocument();
        } else {
            header('Location: index.php?error=1');
        }
        break;
    case 'gererEmprunts':
        if ($_SESSION['user_role'] === 'admin' || $_SESSION['user_role'] === 'bibliothecaire') {
            $bibliothecaireController->gererEmprunts();
        } else {
            header('Location: index.php?error=1');
        }
        break;
    case 'retournerDocument':
        if ($_SESSION['user_role'] === 'bibliothecaire') {
            $bibliothecaireController->retournerDocument();
        } else {
            header('Location: index.php?error=1');
        }
        break;
    case 'prolongerEmprunt':
        if ($_SESSION['user_role'] === 'bibliothecaire') {
            $bibliothecaireController->prolongerEmprunt();
        } else {
            header('Location: index.php?error=1');
        }
        break;
    case 'rechercheDocuments':
        $utilisateurController->rechercheDocuments();
        break;
    case 'emprunterDocument':
        if (isset($_SESSION['user_id'])) {
            $utilisateurController->emprunterDocument();
        } else {
            header('Location: index.php?action=login');
        }
        break;
    case 'historiqueEmprunts':
        if (isset($_SESSION['user_id'])) {
            $utilisateurController->historiqueEmprunts();
        } else {
            header('Location: index.php?action=login');
        }
        break;
        case 'login':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $email = $_POST['email'] ?? '';
                $password = $_POST['password'] ?? '';
                
                if ($utilisateurController->login($email, $password)) {
                    // Get the user role from the session
                    $role = $_SESSION['user_role'] ?? '';
                    
                    // Redirect based on the user role
                    switch ($role) {
                        case 'admin':
                            header('Location: index.php?action=adminDashboard');
                            break;
                        case 'bibliothecaire':
                            header('Location: index.php?action=gererDocuments');
                            break;
                        case 'user':
                        default:
                            header('Location: index.php?action=home');
                            break;
                    }
                    exit; // Ensure no further code is executed
                } else {
                    $error = 'Invalid credentials';
                    include '../views/login.php';
                }
            } else {
                include '../views/login.php';
            }
            break;
    case 'register':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            if ($utilisateurController->register($name, $email, $password)) {
                header('Location: index.php?action=login');
            } else {
                $error = 'Registration failed';
                include '../views/register.php';
            }
        } else {
            include '../views/register.php';
        }
        break;
    case 'logout':
        session_start();
        session_unset();
        session_destroy();
        header('Location: index.php?action=login');
        break;
    default:
        // Page d'accueil ou page 404
        include '../views/home.php';
        break;
}