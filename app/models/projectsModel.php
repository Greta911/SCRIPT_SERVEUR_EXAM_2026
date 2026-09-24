<?php

namespace App\Models\ProjectsModel;

use \PDO;

function findAll(PDO $connexion, int $limit = 10)
{
    $sql = "SELECT *
            FROM projets
            ORDER BY dateCreation DESC
            LIMIT :limit;";
    $rs = $connexion->prepare($sql);
    $rs->bindValue(':limit', $limit, PDO::PARAM_INT);
    $rs->execute();
    return $rs->fetchAll(PDO::FETCH_ASSOC);
}
