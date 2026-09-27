<?php

use App\Controllers\ProjectsController;

include_once "../app/controllers/projectsController.php";


switch ($_GET['projects']):
        //ROUTE DETAILS D'UN PROJET 
    case 'show':
        ProjectsController\showAction($connexion, (int)$_GET['id']);
        break;
    //ROUTE LISTE DES PROJETS
    default:
        ProjectsController\indexAction($connexion);
        break;
endswitch;
