<?php

/** @var array $projects */

?>
<?php foreach ($projects as $project): ?>
    <article class="ct-card">
        <div class="row">
            <div class="col-md-4">
                <a href="projects/<?php echo $project['id']; ?>/<?php echo \Core\Helpers\slugify($project['titre']); ?>">
                    <img class="img-fluid mb-3 mb-md-0" src="images/<?php echo $project['image']; ?>" alt="<?php echo $project['titre']; ?>" />
                </a>
            </div>
            <div class="col-md-8">
                <h3><a href="projects/<?php echo $project['id']; ?>/<?php echo \Core\Helpers\slugify($project['titre']); ?>"><?php echo $project['titre']; ?></a></h3>
                <p class="ct-byline">par <?php echo $project['creatif']; ?></a> · 17 août 2017</p>
                <p><?php echo \Core\Helpers\truncate($project['texte']); ?></p>
                <a class="ct-btn ct-btn--primary ct-btn--sm" href="projects/<?php echo $project['id']; ?>/<?php echo \Core\Helpers\slugify($project['titre']); ?>">Voir le projet</a>
            </div>
        </div>
    </article>
<?php endforeach; ?>