   <?php

    /** @var array $creatifs
     * @var array $tags
 
     */

    ?>
   <div class="col-lg-4">
       <!-- Widget Créa'tifs -->
       <div class="ct-side-card">
           <h5 class="ct-side-card__head">Les créa'tifs</h5>
           <div class="ct-side-card__body">
               <ul class="ct-creatif-list">
                   <?php foreach ($creatifs as $creatif): ?>
                       <li>
                           <img class="ct-avatar" src="images/<?php echo $creatif['image']; ?>" alt="<?= htmlspecialchars($creatif['pseudo']); ?>" />
                           <a href="?creative=<?= $creatif['id']; ?>"><?= htmlspecialchars($creatif['pseudo']); ?></a>
                           <span class="ct-count">4</span>
                       </li>
                   <?php endforeach; ?>
               </ul>
           </div>
       </div>

       <!-- Widget Tags -->
       <div class="ct-side-card">
           <h5 class="ct-side-card__head">Tags</h5>
           <div class="ct-side-card__body">
               <ul class="ct-tags">
                   <?php foreach ($tags as $tag): ?>
                       <li><a class="ct-tag" href="?tag=<?= $tag['id']; ?>"><?= htmlspecialchars($tag['nom']); ?></a></li>
                   <?php endforeach; ?>
               </ul>
           </div>
       </div>
   </div>