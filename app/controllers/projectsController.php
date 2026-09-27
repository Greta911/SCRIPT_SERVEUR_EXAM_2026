<?php

namespace App\Controllers\ProjectsController;

use \PDO;
use \App\Models\ProjectsModel;

function indexAction(PDO $connexion): void
{
    include_once '../app/models/projectsModel.php';

    //Paramètres de pagination
    $limit = 10;
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
    if ($page < 1) {
        $page = 1;
    }
    $offset = ($page - 1) * $limit;
    //Récupération des projets et du total
    $projects = ProjectsModel\findAll($connexion, $limit, $offset);
    $totalProjects = ProjectsModel\countAll($connexion);
    $totalPages = (int) ceil($totalProjects / $limit);

    global $content, $title;
    ob_start();
    include '../app/views/projects/index.php';
    $content = ob_get_clean();
}


function showAction(PDO $connexion, int $id)
{
    include_once '../app/models/projectsModel.php';
    $project = ProjectsModel\findOneById($connexion, $id);

    if (!$project) {
        header('Location: ' . PUBLIC_BASE_URL);
        exit();
    }

    global $content, $title;
    $title = $project['titre'];
    ob_start();
    include '../app/views/projects/show.php';
    $content = ob_get_clean();
}


//-----------------CRUD-------------

//Affiche le formulaire
function addFormAction(PDO $connexion)
{
    global $content, $title;
    $title = "Ajouter un projet";

    ob_start();
    include '../app/views/projects/addForm.php';
    $content = ob_get_clean();
}

//Traite l'insertion puis redirige vers l'accueil
function addInsertAction(PDO $connexion, array $data)
{
    include_once '../app/models/projectsModel.php';
    ProjectsModel\insertOne($connexion, $data);

    // Redirection vers l'accueil
    header('Location: ' . PUBLIC_BASE_URL);
    exit();
}

//Affiche le formulaire d'édition
function editFormAction(PDO $connexion, int $id)
{
    include_once '../app/models/projectsModel.php';
    $project = ProjectsModel\findOneById($connexion, $id);

    global $content, $title;
    $title = "Éditer le projet";

    ob_start();
    include '../app/views/projects/editForm.php';
    $content = ob_get_clean();
}

//Traite la modification puis redirige vers l'accueil
function editUpdateAction(PDO $connexion, int $id, array $data)
{
    include_once '../app/models/projectsModel.php';
    ProjectsModel\updateOne($connexion, $id, $data);

    header('Location: ' . PUBLIC_BASE_URL);
    exit();
}

//Supprime un projet puis redirige
function deleteAction(PDO $connexion, int $id)
{
    include_once '../app/models/projectsModel.php';
    ProjectsModel\deleteOne($connexion, $id);

    header('Location: ' . PUBLIC_BASE_URL);
    exit();
}
