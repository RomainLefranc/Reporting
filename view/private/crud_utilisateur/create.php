<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Gestion utilisateurs</h1>
    <a class="btn btn-primary" href="index.php?a=ga" role="button">Retour</a>
</div>
<form method="post">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Création utilisateur</h6>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label>Pseudo</label>
                <input type="text" class="form-control" required name="pseudo">
            </div>
            <div class="form-group">
                <label>Identifiant</label>
                <input type="text" class="form-control" required name="login">
            </div>
            <div class="form-group">
                <label>Mot de passe</label>
                <input type="text" class="form-control" required name="mdp">
            </div>
        </div>
    </div>
    <button type="submit" name='submitCreateUtilisateur' class="btn btn-primary">Ajouter utilisateur</button>
</form>