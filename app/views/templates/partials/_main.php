<div class="container ct-content-wrap">
    <div class="row">
        <!-- Colonne principale -->
        <div class="col-lg-8">
            <?php echo $content ?>

            <!-- Pagination : 10 projets par page -->
            <nav aria-label="Navigation entre les pages de projets">
                <ul class="pagination ct-pagination" style="justify-content: center">
                    <li class="page-item">
                        <a class="page-link" href="#">Précédent</a>
                    </li>
                    <li class="page-item active">
                        <a class="page-link" href="#">1</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">2</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">3</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">Suivant</a>
                    </li>
                </ul>
            </nav>
        </div>
        <!-- Colonne latérale -->
        <?php include '../app/views/templates/partials/_aside.php' ?>
    </div>
    <!-- /.row -->
</div>