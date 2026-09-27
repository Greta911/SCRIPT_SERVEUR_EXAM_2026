<?php
//ROUTE SHOW: detail d'un post
//PATTERN: /posts/id/slug
//URL: ?posts=show&id=x
//CTRL: postsController
//ACTION: show

if (isset($_GET['projects'])):
    include_once '../app/routers/projects.php';
else:
    //ROUTE DES PROJETS
    include_once '../app/controllers/projectsController.php';
    \App\Controllers\ProjectsController\indexAction($connexion);
endif;
