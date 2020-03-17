<nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="#">Multi-Écoute</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="home.php">Acceuil<span class="sr-only">(current)</span></a>
            </li>
            <?php if($_SESSION['admin'] == 1) {?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Manager les profiles
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="create.php">Creation</a>
                        <a class="dropdown-item" href="modify.php">Modification</a>
                        <a class="dropdown-item" href="delete.php">Suppression</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Évaluation
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="evalinterv.php">Éval. Intervenants</a>
                        <a class="dropdown-item" href="listeval.php">Liste des évaluations</a>
                        <a class="dropdown-item" href="servereval.php">Éxporter les évaluations </a>
                    </div>
                </li>
            <?php }?>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?= $_SESSION['name'] ?>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="profile.php">Profil</a>
                    <a class="dropdown-item" href="includes/logout.php">Déconnexion</a>
                </div>
            </li>
        </ul>
    </div>
</nav>