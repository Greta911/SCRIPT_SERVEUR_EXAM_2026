<?php

namespace App\Controllers\ProjectsController;

use \PDO;
use \App\Models\ProjectsModel;

function indexAction(PDO $connexion)
{
    include_once '../app/models/projectsModel.php';
    $projects = ProjectsModel\findAll($connexion);

    global $content;
    ob_start();
    include '../app/views/projects/index.php';
    $content = ob_get_clean();
}
