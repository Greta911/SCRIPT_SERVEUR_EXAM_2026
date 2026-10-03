<?php

namespace App\Controllers\ProjectsController;

use \PDO;
use \App\Models\ProjectsModel;
use \App\Models\CreatifsModel;

include_once '../app/models/projectsModel.php';
include_once '../app/models/creatifsModel.php';

function indexAction(PDO $connexion): void
{
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

    global $content, $title, $showHero;
    $showHero = true;
    ob_start();
    include '../app/views/projects/index.php';
    $content = ob_get_clean();
}


function showAction(PDO $connexion, int $id)
{
    $project = ProjectsModel\findOneById($connexion, $id);
    $projectTags = ProjectsModel\findTagsByProjectId($connexion, $id); //Liste des tags du projet

    if (!$project) {
        header('Location: ' . PUBLIC_BASE_URL);
        exit();
    }

    global $content, $title, $showHero;
    $showHero = true;
    $title = $project['titre'];

    ob_start();
    include '../app/views/projects/show.php';
    $content = ob_get_clean();
}


//-----------------CRUD-------------

//Affiche le formulaire
function addFormAction(PDO $connexion)
{
    $project = [
        'id' => null,
        'titre' => '',
        'texte' => '',
        'image' => '',
        'creatif' => null
    ];

    $isEdit = false;
    $slug = '';
    $formAction = "projects/add/insert.html";


    $creatifs = CreatifsModel\findAll($connexion);
    $tags = ProjectsModel\findAllTags($connexion); // Tous les tags
    $projectTagIds = []; // Aucun tag coché au départ

    global $content, $title, $showHero;
    $showHero = false;
    $title = "Ajouter un projet";

    ob_start();
    include '../app/views/projects/form.php';
    $content = ob_get_clean();
}

//Traite l'insertion puis redirige vers l'accueil
function addInsertAction(PDO $connexion, array $data, array $files)
{
    //Gestion basique du nom d'image
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


    $tagIds = $data['tags'] ?? []; //Récupère le tableau des cases cochées (ou tableau vide si rien coché)

    ProjectsModel\insertOne($connexion, $projectData, $tagIds);

    //Redirection vers l'accueil
    header('Location: ' . PUBLIC_BASE_URL);
    exit();
}

//Affiche le formulaire d'édition
function editFormAction(PDO $connexion, int $id)
{

    $project = ProjectsModel\findOneById($connexion, $id);
    $creatifs = CreatifsModel\findAll($connexion);

    $tags = ProjectsModel\findAllTags($connexion);
    $projectTagIds = ProjectsModel\findTagIdsByProjectId($connexion, $id); //Tags déjà associés

    $isEdit = true;
    $slug = \Core\Helpers\slugify($project['titre']);
    $formAction = "projects/{$project['id']}/{$slug}/edit/update.html";

    global $content, $title;
    $title = "Éditer le projet";

    ob_start();
    include '../app/views/projects/form.php';
    $content = ob_get_clean();
}

//Traite la modification puis redirige vers l'accueil
function editUpdateAction(PDO $connexion, int $id, array $data, array $files)
{
    //Récupérer le projet actuel pour conserver l'image si aucune nouvelle n'est envoyée
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

    $tagIds = $data['tags'] ?? [];

    ProjectsModel\updateOne($connexion, $id, $projectData, $tagIds);

    header('Location: ' . PUBLIC_BASE_URL);
    exit();
}

//Supprime un projet puis redirige
function deleteAction(PDO $connexion, int $id)
{

    include_once '../app/models/projectsModel.php';
    try {
        //Supprimer le projet via le modèle (qui supprime aussi les tags liés)
        $success = ProjectsModel\deleteOne($connexion, $id);

        if (!$success) {
            //message d'erreur en session
            $_SESSION['error'] = "Impossible de supprimer le projet.";
        }
    } catch (\PDOException $e) {
        //Enregistrement du log d'erreur si la suppression échoue
        error_log($e->getMessage());
    }

    header('Location: ' . PUBLIC_BASE_URL . '/projects');
    exit();
}
