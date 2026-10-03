<?php

/** @var array $project 
 * @var array $creatifs
 * @var array $isEdit
 * @var string $formAction
 * @var string $slug
 * @var object $tags
 * @var array $projectTagIds
 * 
 */
?>

<!-- Titre dynamique -->
<h1 class="mb-4"><?php echo $isEdit ? 'Modifier le projet' : 'Ajouter un projet'; ?></h1>
<div class="py-3">
    <form action="<?php echo $formAction; ?>" method="post" enctype="multipart/form-data" class="ct-form-card">

        <!-- Titre -->
        <label for="title">Titre du projet</label>
        <input
            type="text"
            name="title"
            id="title"
            class="form-control"
            placeholder="Ex : Frange Kamikaze"
            value="<?php echo htmlspecialchars($project['titre']); ?>"
            required />

        <!-- Description -->
        <label for="text">Description</label>
        <textarea
            id="text"
            name="text"
            class="form-control"
            rows="5"
            placeholder="Racontez l'histoire (courageuse) de ce projet..."
            required><?php echo htmlspecialchars($project['texte']); ?></textarea>

        <!-- Image -->
        <label for="creatif-file">Photo du résultat</label>
        <?php if ($isEdit && !empty($project['image'])): ?>
            <div class="mb-2">
                <small>Image actuelle :</small><br>
                <img src="images/<?php echo $project['image']; ?>" alt="<?php echo htmlspecialchars($project['titre']); ?>" style="max-height: 100px;" class="img-thumbnail" />
            </div>
        <?php endif; ?>
        <div class="ct-dropzone">
            ✂️ Glissez une image ou choisissez-la ci-dessous
            <input type="file" class="form-control-file" id="creatif-file" name="image" />
        </div>

        <!-- Sélection du Créa'tif -->
        <label for="category">Créa'tif</label>
        <select id="category" name="category_id" class="form-control" required>
            <option value="" disabled <?php echo !$isEdit ? 'selected' : ''; ?>>Sélectionnez le créa'tif</option>
            <?php foreach ($creatifs as $creatif): ?>
                <option
                    value="<?php echo $creatif['id']; ?>"
                    <?php echo ($isEdit && $creatif['id'] == $project['creatif']) ? 'selected' : ''; ?>>
                    <?php echo $creatif['pseudo']; ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Tags <span style="font-weight:400;font-size:.8rem;color:#4a3a5a">(facultatif)</span></label>
        <div class="ct-tag-choice">
            <?php foreach ($tags as $tag): ?>
                <label>
                    <input
                        type="checkbox"
                        name="tags[]"
                        value="<?= $tag['id'] ?>"
                        <?= in_array($tag['id'], $projectTagIds) ? 'checked' : '' ?> />
                    <?= htmlspecialchars($tag['nom']) ?>
                </label>
            <?php endforeach; ?>
        </div>

        <!-- Boutons d'action -->
        <div class="mt-4">
            <input class="ct-btn ct-btn--primary" type="submit" value="<?php echo $isEdit ? 'Mettre à jour' : 'Enregistrer'; ?>" />
            <?php if ($isEdit): ?>
                <a class="ct-btn ct-btn--ghost" href="projets/<?php echo $project['id']; ?>/<?php echo $slug; ?>.html">Annuler</a>
            <?php else: ?>
                <input class="ct-btn ct-btn--ghost" type="reset" value="Réinitialiser" />
            <?php endif; ?>
        </div>

    </form>
</div>