<?php

/** @var array $project 
 * @var array $creatifs
 */
// Détermination du mode (Ajout ou Édition)
$isEdit = !empty($project['id']);
$slug = $isEdit ? \Core\Helpers\slugify($project['titre']) : '';

// URL de l'action selon le mode
$formAction = $isEdit
    ? "projects/{$project['id']}/{$slug}/edit/update.html"
    : "projects/add/insert.html";
?>

<div class="container" style="margin-top: 2.5rem">
    <div class="row">
        <div class="col-lg-8 py-3">

            <!-- Titre dynamique -->
            <h1 class="mb-4"><?php echo $isEdit ? 'Modifier le projet' : 'Ajouter un projet'; ?></h1>

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
    </div>
</div>