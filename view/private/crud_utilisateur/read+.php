<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Gestion utilisateurs</h1>
</div>
<?php
    if (isset($_GET['msg'])) {
        $msg = htmlspecialchars($_GET['msg']);

        switch ($msg) {
            case 1:
                $msg = "Ajout effectué";
                $typeMsg = 'success';
                break;
            case 2:
                $msg = "Suppression effectué";
                $typeMsg = 'success';
                break;
            case 3:
                $msg = "Modification effectué";
                $typeMsg = 'success';
                break;
            case 4:
                $msg = "Cette utilisateur n'existe pas";
                $typeMsg = 'danger';
                break;
        }
        echo '
        <div class="alert alert-'.$typeMsg.' alert-dismissible fade show mt-3" role="alert">'.$msg.'
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        ';
    }
?> 
<div class="card shadow mb-4 mt-3">
    <div class="card-header py-3">
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Liste utilisateur</h6>
            <a class="btn btn-primary btn-sm" href="index.php?a=ga&crud=c" role="button"><i class="fas fa-plus"></i></a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="tableUser">
                <thead class="thead-dark">
                    <th class="rounded-left border-0 align-middle">Pseudo</th>
                    <th class="border-0 align-middle">Identifiant</th>
                    <th class="border-0 align-middle">mot de passe</th>
                    <th class="rounded-right border-0 align-middle">Action</th>
                </thead>
                <tbody>
                    <?php
                        foreach ($listeUtilisateur as $utilisateur) {
                            echo '
                                <tr>
                                    <td class="align-middle">'.$utilisateur["pseudo"].'</td>
                                    <td class="align-middle">'.$utilisateur["login"].'</td>
                                    <td class="align-middle">'.$utilisateur["mdp"].'</td>
                                    <td class="align-middle">
                                        <div class="btn-group" role="group">
                                            <a class="btn btn-warning btn-sm align-middle" href="index.php?a=ga&crud=u&iu='.$utilisateur['id'].'" role="button"><i class="fas fa-pen"></i></a>
                                            <a class="btn btn-danger btn-sm align-middle" href="index.php?a=ga&crud=d&iu='.$utilisateur['id'].'" role="button"><i class="fas fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            ';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
$(document).ready( function () {
    $('#tableUser').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/French.json"
        },
        "columnDefs": [
            { "orderable": false, "targets": 1 }
        ]
    });
} );
</script>