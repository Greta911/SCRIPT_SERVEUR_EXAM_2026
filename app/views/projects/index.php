<?php

/** @var array $projects
 * @var int $totalPages
 * @var int $page
 */

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
                <p class="ct-byline">par <?php echo $project['creatifPseudo']; ?></a> ·
                    <span><?php echo \Core\Helpers\dateFormator($project['dateCreation'], 'd'); ?></span>
                    <span><?php echo \Core\Helpers\dateFormator($project['dateCreation'], 'M'); ?></span>
                    <span><?php echo \Core\Helpers\dateFormator($project['dateCreation'], 'Y'); ?></span>
                </p>
                <p><?php echo \Core\Helpers\truncate($project['texte']); ?></p>
                <a class="ct-btn ct-btn--primary ct-btn--sm" href="projects/<?php echo $project['id']; ?>/<?php echo \Core\Helpers\slugify($project['titre']); ?>.html">Voir le projet</a>
            </div>
        </div>
    </article>
<?php endforeach; ?>

<!-- Pagination : 10 projets par page -->
<?php if (isset($totalPages) && $totalPages > 1): ?>
    <nav aria-label="Navigation entre les pages de projets">
        <ul class="pagination ct-pagination" style="justify-content: center">
            <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="projects/page/<?php echo $page - 1; ?>">Précédent</a>
                </li>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item active <?php echo ($i === $page) ? 'active' : ''; ?>">
                    <a class="page-link" href="projects/page/<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
            <?php if ($page < $totalPages): ?>
                <li class="page-item">
                    <a class="page-link" href="projects/page/<?php echo $page + 1; ?>">Suivant</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
<?php endif; ?>