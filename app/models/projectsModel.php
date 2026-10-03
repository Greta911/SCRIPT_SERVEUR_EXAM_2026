<?php

namespace App\Models\ProjectsModel;

use \PDO;

//Récupère tous les projets
function findAll(PDO $connexion, int $limit = 10, int $offset = 0): array
{
    $sql = "SELECT p.*, 
                   c.id AS creatifID,
                   c.pseudo AS creatifPseudo
            FROM projets p
            JOIN creatifs c ON p.creatif = c.id
            ORDER BY p.dateCreation DESC
            LIMIT :limit OFFSET :offset;";
    $rs = $connexion->prepare($sql);
    $rs->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
    $rs->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
    $rs->execute();
    return $rs->fetchAll(PDO::FETCH_ASSOC);
}

//Compteur des projets pour la pagination
function countAll(PDO $connexion): int
{
    $sql = "SELECT COUNT(*) 
            FROM projets;";
    return (int) $connexion->query($sql)->fetchColumn();
}

//Récupère un projet par son id
function findOneById(PDO $connexion, int $id)
{
    $sql = "SELECT p.*, 
                   c.id AS creatifID,
                   c.pseudo AS creatifPseudo
            FROM projets p
            JOIN creatifs c ON p.creatif = c.id 
            WHERE p.id = :id;";
    $rs = $connexion->prepare($sql);
    $rs->bindValue(':id', $id, PDO::PARAM_INT);
    $rs->execute();
    return $rs->fetch(PDO::FETCH_ASSOC);
}

//Récupère la liste de TOUS les tags disponibles pour le formulaire
function findAllTags(PDO $connexion): array
{
    $sql = "SELECT * 
            FROM tags 
            ORDER BY nom ASC;";
    return $connexion->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

//Récupère les IDs des tags associés à un projet donné
function findTagIdsByProjectId(PDO $connexion, int $projectId): array
{
    $sql = "SELECT tag 
            FROM projets_has_tags 
            WHERE projet = :projet_id;";
    $rs = $connexion->prepare($sql);
    $rs->execute([':projet_id' => $projectId]);
    return $rs->fetchAll(PDO::FETCH_COLUMN); //Renvoie un tableau simple d'IDs ex: [1, 3, 5]
}

//Récupère les objets tags complets d'un projet (pour l'affichage dans la vue 'project.show')
function findTagsByProjectId(PDO $connexion, int $projectId): array
{
    $sql = "SELECT t.* 
            FROM tags t
            JOIN projets_has_tags pht ON t.id = pht.tag
            WHERE pht.projet = :projet_id;";
    $rs = $connexion->prepare($sql);
    $rs->execute([':projet_id' => $projectId]);
    return $rs->fetchAll(PDO::FETCH_ASSOC);
}

//Associe un tableau de tag_ids à un projet
function syncTags(PDO $connexion, int $projectId, array $tagIds): void
{
    //Suppression des anciennes associations
    $rsDelete = $connexion->prepare("DELETE 
                                       FROM projets_has_tags 
                                       WHERE projet = :projet_id");
    $rsDelete->execute([':projet_id' => $projectId]);

    //Insertion des nouvelles associations
    if (!empty($tagIds)) {
        $sqlInsert = "INSERT INTO projets_has_tags (projet, tag) 
                      VALUES (:projet_id, :tag_id)";
        $rsInsert = $connexion->prepare($sqlInsert);

        foreach ($tagIds as $tagId) {
            $rsInsert->execute([
                ':projet_id' => $projectId,
                ':tag_id'    => (int)$tagId
            ]);
        }
    }
}

//-----------------CRUD FUNCTIONS----------------------

//INSERT
function insertOne(PDO $connexion, array $data, array $tagIds = []): bool
{
    $sql = "INSERT INTO projets (titre, texte, image, creatif, dateCreation) 
            VALUES (:titre, :texte, :image, :creatif, NOW());";

    $rs = $connexion->prepare($sql);

    $success = $rs->execute([
        ':titre'   => $data['titre'],
        ':texte'   => $data['texte'],
        ':image'   => $data['image'],
        ':creatif' => $data['creatif']
    ]);

    if ($success) {
        $projectId = (int)$connexion->lastInsertId();
        syncTags($connexion, $projectId, $tagIds);
    }

    return $success;
}

//MODIFY
function updateOne(PDO $connexion, int $id, array $data, array $tagIds = []): bool
{
    $sql = "UPDATE projets 
            SET titre = :titre, 
                texte = :texte, 
                image = :image, 
                creatif = :creatif 
            WHERE id = :id;";

    $rs = $connexion->prepare($sql);
    $success = $rs->execute([
        ':titre'   => $data['titre'],
        ':texte'   => $data['texte'],
        ':image'   => $data['image'],
        ':creatif' => $data['creatif'],
        ':id'      => $id
    ]);

    if ($success) {
        syncTags($connexion, $id, $tagIds);
    }

    return $success;
}

//DELETE
function deleteOne(PDO $connexion, int $id): bool
{
    //Supprimer d'abord les associations de tags liées au projet
    $sqlTags = "DELETE 
                FROM projets_has_tags 
                WHERE projet = :id;";
    $rsTags = $connexion->prepare($sqlTags);
    $rsTags->bindValue(':id', $id, PDO::PARAM_INT);
    $rsTags->execute();

    //Supprimer ensuite le projet lui-même
    $sqlProject = "DELETE 
                   FROM projets 
                   WHERE id = :id;";
    $rsProject = $connexion->prepare($sqlProject);
    $rsProject->bindValue(':id', $id, PDO::PARAM_INT);

    return $rsProject->execute();
}
