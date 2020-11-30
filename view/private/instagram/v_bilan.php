<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Nautilus Social Manager - Bilan Instagram</title>
    
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <script src="vendor/jquery/jquery.min.js"></script>
    
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
                        <h1 class="h3 mb-0 text-gray-800">Bilan Instagram</h1>
                    </div>
                    <form id='bilan'>
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label">Pages disponible</label>
                            <div class="col-lg-10">
                                <select class="form-control" id='choixPageInsta' style="max-width: 300px;" required>
                                    <option></option>
                                    <?php
                                        echo $selectPageInsta;
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row" >
                            <label class="col-lg-2 col-form-label">Date minimum</label>
                            <div class="col-lg-10">
                                <input class="form-control" type="date" id="dateDebut" style="max-width: 300px;" required>
                            </div>
                        </div> 
                        <button type="submit" class="btn btn-primary">Bilan</button>
                    </form>
                    <div id="erreur"></div>
                    <div id="result" class="row mt-2"></div>
                    <script>
                        $('#bilan').submit(function (e) { 

                            e.preventDefault();

                            /* Initialisation à zero des erreurs et des affichages */
                            $('#result').html('');
                            $('#erreur').html('');

                            /* Récuperation de l'id de la page instagram */
                            var idPageInsta = $('#choixPageInsta').val();

                            /* Récuperation du token utilisateur */
                            var token = $('#choixPageInsta').find('option:selected').data('value');

                            /* Récuperation de la date de debut choisi par l'utilisateur */
                            var dateDebut = $('#dateDebut').val(); 

                            function msgErreur(texte) {
                                var alert = `
                                <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert" >
                                    <strong>Erreur !</strong> ${texte}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>`;
                                return alert;
                            }
                            /* Récuperation de tout les post Instagram de la page insta */
                            $.get(`https://graph.facebook.com/v8.0/${idPageInsta}?fields=id,media{id,like_count,media_type,comments_count,thumbnail_url,media_url,timestamp}&access_token=${token}`, function (data, textStatus) {
                                /* Verification de la reponse de l'API */
                                switch (textStatus) {
                                    case 'success':
                                        
                                        nbMedia = 0

                                        data.media.data.forEach(media => {

                                            var date = new Date(media.timestamp);

                                            var dateFormatte = ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '/' + ((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '/' + date.getFullYear() + ' à ' + date.getHours() + 'h' +  ((date.getMinutes() > 9) ? date.getMinutes() : ('0' + date.getMinutes()));
                                            if (media.timestamp > dateDebut) {
                                                nbMedia++;
                                                var dateMedia = dateFormatte;
                                                var nbLike = media.like_count;
                                                var nbComments = media.comments_count;
                                                var idMedia = media.id;
                                                switch (media.media_type) {
                                                    case 'VIDEO':
                                                        var img = media.thumbnail_url;
                                                        var url =`https://graph.facebook.com/v8.0/${idMedia}/insights?metric=impressions,reach,video_views&access_token=${token}`;
                                                        break;
                                                
                                                    default:
                                                        var img = media.media_url;
                                                        var url =`https://graph.facebook.com/v8.0/${idMedia}/insights?metric=impressions,reach&access_token=${token}`;
                                                        break;
                                                }
                                                /* Récuperation des insight du post */
                                                $.ajax({
                                                    url: url,
                                                    dataType: "json",
                                                    async: false,
                                                    success: function (response) {
                                                        var impression = response.data[0].values[0].value;
                                                        var reach = response.data[1].values[0].value;
                                                        var ligne = ""
                                                        var nbVue = 0;
                                                        if (response.data.length >= 3) {
                                                            nbVue = response.data[2].values[0].value
                                                            ligne = `<strong>Vue videos : </strong>${nbVue}<br>`
                                                        }
                                                        /* Préparation de la carte */
                                                        var carte = `
                                                            <div class="card m-2" style="width: 18rem;">
                                                                <img class="card-img-top" src="${img}">
                                                                <div class="card-body">
                                                                    <p class="card-text">
                                                                        <strong>Date : </strong>${dateFormatte}<br>
                                                                        <strong>like : </strong>${nbLike}<br>
                                                                        <strong>Commentaire : </strong>${nbComments}<br>
                                                                        <strong>Impression : </strong>${impression}<br>
                                                                        ${ligne}
                                                                        <strong>Reach : </strong>${reach}<br>
                                                                        <strong>Taux d'engagement </strong>${(((nbLike + nbComments)/reach)*100).toFixed(2)+' %'}
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
                                        if (nbMedia == 0) {
                                            $('#erreur').html(msgErreur('Aucun post pour cette periode, veuillez choisir une date plus ancienne'));
                                        }
                                        break;
                                    
                                    default:
                                        $('#erreur').html(msgErreur("Serveur indisponible ! Veuillez réessayer plus tard ou reliez votre compte à l'application"));      
                                        break;
                                }  
                            });
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