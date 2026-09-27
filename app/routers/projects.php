<?php

use App\Controllers\ProjectsController;

include_once "../app/controllers/projectsController.php";


switch ($_GET['projects']):
        //ROUTE DETAILS D'UN PROJET 
    case 'show':
        ProjectsController\showAction($connexion, (int)$_GET['id']);
        break;
    case 'addForm':
        //Affichage du formulaire d'ajout
        ProjectsController\addFormAction($connexion);
        break;

    case 'addInsert':
        //Traitement de l'ajout d'un projet
        ProjectsController\addInsertAction($connexion, $_POST, $_FILES);
        break;

    case 'editForm':
        //Affichage du formulaire de modification
        ProjectsController\editFormAction($connexion, (int)$_GET['id']);
        break;

    case 'editUpdate':
        //Traitement de la modification d'un projet
        ProjectsController\editUpdateAction($connexion, (int)$_GET['id'], $_POST, $_FILES);
        break;

    case 'delete':
        //Traitement de la suppression d'un projet
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        ProjectsController\deleteAction($connexion, (int)$_GET['id']);
        break;
    //ROUTE LISTE DES PROJETS
    case 'index':
    default:
        ProjectsController\indexAction($connexion);
        break;
endswitch;
