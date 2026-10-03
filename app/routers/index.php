<?php

if (isset($_GET['projects'])):
    include_once '../app/routers/projects.php';
else:
    //ROUTE DES PROJETS
    include_once '../app/controllers/projectsController.php';
    \App\Controllers\ProjectsController\indexAction($connexion);
endif;
