<?php

namespace App\Models\CreatifsModel;

use \PDO;

function findAll(PDO $connexion): array
{
    $sql = "SELECT * 
            FROM creatifs 
            ORDER BY pseudo ASC;";
    return $connexion->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}
