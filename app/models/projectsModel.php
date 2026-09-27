<?php

namespace App\Models\ProjectsModel;

use \PDO;

function findAll(PDO $connexion, int $limit = 10)
{
    $sql = "SELECT p.*, 
                   c.id AS creatifID,
                   c.pseudo AS creatifPseudo
            FROM projets p
            JOIN creatifs c ON p.creatif = c.id
            ORDER BY p.dateCreation DESC
            LIMIT :limit;";
    $rs = $connexion->prepare($sql);
    $rs->bindValue(':limit', $limit, PDO::PARAM_INT);
    $rs->execute();
    return $rs->fetchAll(PDO::FETCH_ASSOC);
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
