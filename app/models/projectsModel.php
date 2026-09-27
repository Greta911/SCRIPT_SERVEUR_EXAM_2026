<?php

namespace App\Models\ProjectsModel;

use \PDO;

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

function countAll(PDO $connexion): int
{
    $sql = "SELECT COUNT(*) 
            FROM projets;";
    return (int) $connexion->query($sql)->fetchColumn();
}

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

//-----------------CRUD FUNCTIONS----------------------

//INSERT
function insertOne(PDO $connexion, array $data): bool
{
    $sql = "INSERT INTO projets (titre, texte, image, creatif, dateCreation) 
            VALUES (:titre, :texte, :image, :creatif, NOW());";

    $stmt = $connexion->prepare($sql);
    return $stmt->execute([
        ':titre'   => $data['titre'],
        ':texte'   => $data['texte'],
        ':image'   => $data['image'],
        ':creatif' => $data['creatif']
    ]);
}

//MODIFY
function updateOne(PDO $connexion, int $id, array $data): bool
{
    $sql = "UPDATE projets 
            SET titre = :titre, 
                texte = :texte, 
                image = :image, 
                creatif = :creatif 
            WHERE id = :id;";

    $rs = $connexion->prepare($sql);
    $rs->bindValue(':titre', $data['titre'], PDO::PARAM_STR);
    $rs->bindValue(':texte', $data['texte'], PDO::PARAM_STR);
    $rs->bindValue(':image', $data['image'], PDO::PARAM_STR);
    $rs->bindValue(':creatif', $data['creatif'], PDO::PARAM_INT);
    $rs->bindValue(':id', $id, PDO::PARAM_INT);

    return $rs->execute();
}

//DELETE
function deleteOne(PDO $connexion, int $id): bool
{
    $sql = "DELETE FROM projets 
            WHERE id = :id;";
    $stmt = $connexion->prepare($sql);
    return $stmt->execute([':id' => $id]);
}
