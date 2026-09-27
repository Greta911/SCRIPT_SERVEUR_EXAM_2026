<?php

namespace App\Controllers\ProjectsController;

use \PDO;
use \App\Models\ProjectsModel;

function indexAction(PDO $connexion)
{
    include_once '../app/models/projectsModel.php';
    $projects = ProjectsModel\findAll($connexion);

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
