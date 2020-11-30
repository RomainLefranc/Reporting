<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Nautilus Social Manager - Rapport Instagram</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <script src="vendor/jquery/jquery.min.js"></script>
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">

    <!-- Page level plugin JavaScript-->
    <script src="vendor/chart.js/Chart.min.js"></script>
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
                        <h1 class="h3 mb-0 text-gray-800">Rapport Instagram</h1>
                    </div>
                    <div class="container row">
                        <form id='rapport' class='row'>
                            <div class="col-6">
                                <div class="form-group row" >
                                    <label class="col-lg-3 col-form-label">Pages disponible</label>
                                    <div class="col-lg-9">
                                        <select class="form-control monForm1" name="selectedValue" style="max-width: 300px;" id="pageInsta" required>
                                            <option value="" data-nom=""> </option>
                                            <?php
                                                echo $selectPageInsta
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row" >
                                    <label for="example-categorie-input" class="col-lg-3 col-form-label">Trier par</label>
                                    <div class="col-lg-9">
                                        <select class="form-control monForm1" name="selectedValue" style="max-width: 300px;" id="tri" required>
                                            <option value=""></option>
                                            <option value="2"> Nombre d'interaction par post</option>    
                                        </select>
                                    </div>
                                </div>
                            </div>  
                            <div class="col-6">
                                <div class="form-group row" >
                                    <label class="col-lg-3 col-form-label">Date de début</label>
                                    <div class="col-9">
                                        <input class="form-control monForm1" type="date"  id="dateDebut" style="max-width: 300px;" required>
                                    </div>
                                </div>
                                <div class="form-group row" >
                                    <label class="col-lg-3 col-form-label">Date de fin</label>
                                    <div class="col-9">
                                        <input class="form-control monForm1" type="date"  id="dateFin" style="max-width: 300px;" required>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Rapport</button>
                        </form>
                    </div>
                    <div id="erreur"></div>
                    <!-- Area Chart Example-->
                    <div class="card mb-3 mt-2">
                        <div class="card-header">
                            <i class="fas fa-chart-area"></i> Nombre d'interaction par post
                        </div>
                        <div class="card-body rapport">
                            <canvas id="myAreaChart" width="100%" height="30"></canvas>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
                <script>
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
                    function formatterDate(date) {
                        return ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '/' + ((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '/' + date.getFullYear() + ' ' + date.getHours() + 'h' +  ((date.getMinutes() > 9) ? date.getMinutes() : ('0' + date.getMinutes()));
                    }
                    $('#rapport').submit(function (e) { 
                        e.preventDefault();

                        /* Initialisation à zero des affichages et des erreurs */
                        $('#myAreaChart').remove();
                        $('.rapport').append('<canvas id="myAreaChart" width="100%" height="30"></canvas>');
                        $("#msg").html("");

                        /* Récuperation de l'id de la page Instagram */
                        var idPageInsta = $("#pageInsta").val();

                        /* Récuperation du type de tri */
                        var typeTri = $('#tri').val();

                        /* Récuperation du token utilisateur */
                        var token = $('#pageInsta').find('option:selected').data('value');

                        /* Récuperation de la date de debut */
                        var dateDebut = $('#dateDebut').val();
                        dateDebut = new Date(dateDebut);

                        /* Récuperation de la date de fin */
                        var dateFin = $('#dateFin').val();
                        dateFin = new Date(dateFin);

                        /* Verification de la validité de la periode choisi */
                        if (dateFin > dateDebut) {
                            /* Récuperation des post de la page Instagram */
                            $.get(`https://graph.facebook.com/v8.0/${idPageInsta}?fields=id,media{id,caption,like_count,media_type,comments_count,thumbnail_url,media_url,timestamp}&access_token=${token}`,
                                function (data) {
                                    var tabDates = [];
                                    var tabInteraction = [];
                                    var nbMedia = 0;
                                    data.media.data.reverse();
                                    data.media.data.forEach(media => {
                                        var dateMedia = new Date(media.timestamp);
                                        /* Verification de la validité de la date du post */
                                        if (dateMedia >= dateDebut && dateMedia <= dateFin) {
                                            nbMedia++;
                                            dateMedia = formatterDate(dateMedia);
                                            tabDates.push(dateMedia);
                                            tabInteraction.push(media.comments_count + media.like_count)
                                        }
                                    });
                                    if (nbMedia == 0) {
                                        $('#erreur').html(msgErreur('Aucun post trouvé'));
                                    } else {
                                        // Definition de l'echelle du graphique
                                        var max = Math.ceil(Math.max(...tabInteraction)) + 5;

                                        // Definition de la police et de la chouleur du fond du graphe
                                        Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
                                        Chart.defaults.global.defaultFontColor = '#292b2c';

                                        /* Récuperation de l'element qui deviendra le graphique */
                                        var ctx = document.getElementById("myAreaChart");

                                        /* Création du graphique */
                                        var myLineChart = new Chart(ctx, {
                                            type: 'line',
                                            data: {
                                                labels: tabDates,
                                                datasets: [{
                                                    label: "Interactions",
                                                    lineTension: 0.3,
                                                    backgroundColor: "rgba(2,117,216,0.2)",
                                                    borderColor: "rgba(2,117,216,1)",
                                                    pointRadius: 5,
                                                    pointBackgroundColor: "rgba(2,117,216,1)",
                                                    pointBorderColor: "rgba(255,255,255,0.8)",
                                                    pointHoverRadius: 5,
                                                    pointHoverBackgroundColor: "rgba(2,117,216,1)",
                                                    pointHitRadius: 50,
                                                    pointBorderWidth: 2,
                                                    data: tabInteraction,
                                                }],
                                            },
                                            options: {
                                                scales: {
                                                    xAxes: [{
                                                        time: {
                                                            unit: 'date'
                                                        },
                                                        gridLines: {
                                                            display: false
                                                        },
                                                        ticks: {
                                                            maxTicksLimit: 7
                                                        }
                                                    }],
                                                    yAxes: [{
                                                        ticks: {
                                                            min: 0,
                                                            max: max,
                                                            maxTicksLimit: 5
                                                        },
                                                        gridLines: {
                                                            color: "rgba(0, 0, 0, .125)",
                                                        }
                                                    }],
                                                },
                                                legend: {
                                                    display: false
                                                }
                                            }
                                        });
                                    }
                                }
                            );
                        } else {
                            $('#erreur').html(msgErreur('Periode invalide'));
                        }
                        
                    });
                </script>
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