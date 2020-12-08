<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Gestion utilisateurs</h1>
    <a class="btn btn-primary" href="index.php?a=ga" role="button">Retour</a>
</div>
<form method="post">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Modification de l'utilisateur : <?php  echo $utilisateur['pseudo'] ?></h6>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label>Pseudo</label>
                <input type="text" class="form-control" value='<?php  echo $utilisateur['pseudo']  ?>' readOnly>
            </div>
            <div class="form-group">
                <label>Identifiant</label>
                <input type="text" class="form-control" name="login" value='<?php  echo $utilisateur['login']  ?>' required>
            </div>
            <div class="form-group">
                <label>Mot de passe</label>
                <input type="text" class="form-control" name="mdp" value='<?php  echo $utilisateur['mdp']  ?>' required>
            </div>
        </div>
    </div>
    <button type="submit" name='submitUpdateUtilisateur' class="btn btn-warning">Modifier utilisateur</button>
</form>