<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Nautilus Social Manager - Bilan Facebook</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/script.js"></script>
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php
            include 'view/private/inc/sidebar.php'
        ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php
                    include 'view/private/inc/navbar.php'
                ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Bilan Facebook</h1>
                    </div>
                    <form id="bilan">
                        <div class="form-group row" >
                            <label for="example-page-input" class="col-lg-2 col-form-label">Pages disponible</label>
                            <div class="col-lg-10">
                                <select class="form-control monForm" name="selectedValue" style="max-width: 300px;" id="pageFB" required>
                                    <option value=""></option>
                                    <?php
                                        foreach($listePageFB as $pageFB){
                                        $token = getComptesFB($pageFB['id_comptes']);
                                        echo '<option value="' . $pageFB['id'] . '" data-value="' . $token . '" data-nom="' . $pageFB['nom'] . '">' . $pageFB['nom'] . '</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row" >
                            <label for="example-date-input" class="col-lg-2 col-form-label">Date de début</label>
                            <div class="col-lg-10">
                                <input class="form-control" type="date" value="<?php echo date('Y-m-d'); ?>" id="dateDebut" style="max-width: 300px;" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Go</button>
                    </form>
                    

                    <div id="erreur"></div>

                    <div id="result" class="container row" style="max-width: initial;"></div>

                    <script>
                        //a chaque changement de mes select dans mon formulaire, on execute la fonction
                        function msgErreur(texte) {
                            var alert = `
                                <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert" >
                                    <strong>Erreur !</strong> ${texte}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            `;
                            return alert;
                        }
                        $('#bilan').submit(function (e) { 
                            e.preventDefault();
                            var idPageFb = $('#pageFB').val();
                            var token = $('#pageFB').find('option:selected').data('value');
                            var dateDebut = $('#dateDebut').val();

                            $.get(`https://graph.facebook.com/v4.0/${idPageFb}?fields=id,name,posts{id,full_picture,message,reactions.summary(true),created_time,comments.summary(true),shares},fan_count&access_token=${token}`,
                                function (data, textStatus) {
                                    switch (textStatus) {
                                        case 'success':
                                            var nbPost = 0;
                                            data.posts.data.forEach(post => {
                                                var datePost = new Date(post.created_time);
                                                var dateFormatte = ((datePost.getDate() > 9) ? datePost.getDate() : ('0' + datePost.getDate())) + '/' + ((datePost.getMonth() > 8) ? (datePost.getMonth() + 1) : ('0' + (datePost.getMonth() + 1))) + '/' + datePost.getFullYear() + ' à ' + datePost.getHours() + 'h' +  ((datePost.getMinutes() > 9) ? datePost.getMinutes() : ('0' + datePost.getMinutes()));
                                                if (post.created_time > dateDebut) {
                                                    nbPost++;
                                                    var img = post.full_picture;
                                                    var date = dateFormatte;
                                                    var reactions = post.reactions.summary.total_count;
                                                    var commentaire = post.comments.summary.total_count;
                                                    var partages = 0;
                                                    if (post.hasOwnProperty('shares')) {
                                                        partages = post.shares.count
                                                    }
                                                    var tokenPageFB = '';
                                                    var idMedia =post.id
                                                    var clics = 0;
                                                    var reach = 0;
                                                    var vue = 0
                                                    $.ajax({
                                                        type: "GET",
                                                        url: `https://graph.facebook.com/me/accounts?limit=50&access_token=${token}`,
                                                        async: false,
                                                        dataType: "json",
                                                        success: function (response) {
                                                            response.data.forEach(post => {
                                                                if (post.id == idPageFb) {
                                                                    tokenPageFB = post.access_token;
                                                                }
                                                            });
                                                            $.ajax({
                                                                type: "GET",
                                                                url: `https://graph.facebook.com/v4.0/${idMedia}/insights/post_clicks_unique,post_impressions_unique,post_video_views?access_token=${tokenPageFB}`,
                                                                dataType: "json",
                                                                async: false,
                                                                success: function (response) {
                                                                    clics = response.data[0].values[0].value
                                                                    reach = response.data[1].values[0].value
                                                                    vue = response.data[2].values[0].value
                                                                    var ligne = '';
                                                                    if (vue == 0) {
                                                                        ligne = '';
                                                                    } else {
                                                                        ligne = `<strong>Nb vue : </strong>${vue}<br>`
                                                                    }
                                                                    var carte = `
                                                                        <div class="card m-2" style="width: 18rem;">
                                                                            <img class="card-img-top" src="${img}">
                                                                            <div class="card-body">
                                                                                <p class="card-text">
                                                                                    <strong>Date : </strong>${date}<br>
                                                                                    <strong>réactions : </strong>${reactions.toLocaleString()}<br>
                                                                                    <strong>Commentaire : </strong>${commentaire.toLocaleString()}<br>
                                                                                    <strong>Partages : </strong>${partages.toLocaleString()}<br>
                                                                                    <strong>clics : </strong>${clics.toLocaleString()}<br>
                                                                                    <strong>Reach : </strong>${reach.toLocaleString()}<br>
                                                                                    ${ligne}
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    `;
                                                                    /* Ajout de la carte au html */
                                                                    $( "#result" ).append(carte);
                                                                }
                                                            });
                                                        }
                                                    });
                                                }
                                            });
                                            break;
                                    
                                        default:
                                            $('#erreur').html(msgErreur("Serveur indisponible ! Veuillez réessayer plus tard ou reliez votre compte à l'application"));      
                                            break;
                                    }
                                }
                            );
                        });
                    </script>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Nautilus 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <?php
        include 'view/private/inc/footer.php';
    ?>
    <!-- Logout Modal-->
    <?php
        include 'view/private/inc/modalDeconnexion.php'
    ?>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
</body>

</html>