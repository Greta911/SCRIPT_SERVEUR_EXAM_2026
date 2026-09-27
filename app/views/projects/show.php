 <?php

    /** @var array $project */

    ?>

 <div class="container" style="margin-top: 2.5rem">
     <div class="row">
         <!-- Colonne principale -->
         <div class="col-lg-12">
             <h1><?php echo $project['titre']; ?></h1>
             <p class="ct-byline">par <a href="#"><?php echo $project['creatifPseudo']; ?></a> ·
                 <span><?php echo \Core\Helpers\dateFormator($project['dateCreation'], 'd/m/Y'); ?></span>
             </p>

             <div class="mb-4">
                 <a href="projects/<?php echo $project['id']; ?>/<?php echo \Core\Helpers\slugify($project['titre']); ?>/edit/form.html" class="ct-btn ct-btn--primary">Éditer le projet</a>
                 <a href="projets/delete/<?php echo $project['id']; ?>/<?php echo \Core\Helpers\slugify($project['titre']); ?>.html" class="ct-btn ct-btn--danger" onclick="return confirm('Supprimer définitivement ce projet ?');">Supprimer le projet</a>
             </div>

             <article class="ct-card">
                 <div class="row">
                     <div class="col-md-6">
                         <img class="img-fluid mb-3 mb-md-0" src="images/<?php echo $project['image']; ?>" alt="<?php echo $project['titre']; ?>" />
                     </div>
                     <div class="col-md-6">
                         <p><?php echo nl2br($project['texte']); ?></p>
                     </div>
                 </div>
             </article>
         </div>
     </div>
 </div>