<?php

namespace App\Controllers\ProjectsController;

use \PDO;
use \App\Models\ProjectsModel;
use \App\Models\CreatifsModel;

include_once '../app/models/creatifsModel.php';
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
    include_once '../app/models/projectsModel.php';

    $project = [
        'id' => null,
        'titre' => '',
        'texte' => '',
        'image' => '',
        'creatif' => null
    ];

    include_once '../app/models/creatifsModel.php';
    $creatifs = CreatifsModel\findAll($connexion);
    global $content, $title;
    $title = "Ajouter un projet";

    ob_start();
    include '../app/views/projects/form.php';
    $content = ob_get_clean();
}

//Traite l'insertion puis redirige vers l'accueil
function addInsertAction(PDO $connexion, array $data, array $files)
{
    include_once '../app/models/projectsModel.php';

    // Gestion basique du nom d'image
    $imageName = 'default.jpg';
    if (!empty($files['image']['name'])) {
        $imageName = $files['image']['name'];
        move_uploaded_file($files['image']['tmp_name'], 'images/' . $imageName);
    }

    $projectData = [
        'titre'   => $data['title'],
        'texte'   => $data['text'],
        'image'   => $imageName,
        'creatif' => (int)$data['category_id']
    ];

    ProjectsModel\insertOne($connexion, $projectData);

    // Redirection vers l'accueil
    header('Location: ' . PUBLIC_BASE_URL);
    exit();
}

//Affiche le formulaire d'édition
function editFormAction(PDO $connexion, int $id)
{
    include_once '../app/models/projectsModel.php';
    $project = ProjectsModel\findOneById($connexion, $id);
    $creatifs = CreatifsModel\findAll($connexion);

    global $content, $title;
    $title = "Éditer le projet";

    ob_start();
    include '../app/views/projects/form.php';
    $content = ob_get_clean();
}

//Traite la modification puis redirige vers l'accueil
function editUpdateAction(PDO $connexion, int $id, array $data, array $files)
{
    include_once '../app/models/projectsModel.php';
    // Récupérer le projet actuel pour conserver l'image si aucune nouvelle n'est envoyée
    $currentProject = ProjectsModel\findOneById($connexion, $id);
    $imageName = $currentProject['image'];

    if (!empty($files['image']['name'])) {
        $imageName = $files['image']['name'];
        move_uploaded_file($files['image']['tmp_name'], 'images/' . $imageName);
    }

    $projectData = [
        'titre'   => $data['title'],
        'texte'   => $data['text'],
        'image'   => $imageName,
        'creatif' => (int)$data['category_id']
    ];
    ProjectsModel\updateOne($connexion, $id, $projectData);

    header('Location: ' . PUBLIC_BASE_URL);
    exit();
}

//Supprime un projet puis redirige
function deleteAction(PDO $connexion, int $id)
{

    include_once '../app/models/projectsModel.php';

    //Supprimer d'abord les associations du projet dans la table de jonction
    $sqlTags = "DELETE FROM projets_has_tags 
                WHERE projet = :id;";
    $stmtTags = $connexion->prepare($sqlTags);
    $stmtTags->bindValue(':id', $id, PDO::PARAM_INT);
    $stmtTags->execute();

    //Supprimer ensuite le projet
    $sqlProject = "DELETE FROM projets 
                   WHERE id = :id;";
    $stmtProject = $connexion->prepare($sqlProject);
    $stmtProject->bindValue(':id', $id, PDO::PARAM_INT);

    return $stmtProject->execute();
}
