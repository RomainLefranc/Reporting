<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Nautilus Social Manager - Comparatif Facebook</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Page level plugin JavaScript-->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php
            include 'view/admin/inc/sidebar.php'
        ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php
                    include 'view/admin/inc/navbar.php'
                ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Comparatif Facebook</h1>
                    </div>
                    <div class="container row col-12">
                        <!------------------------PHP affichant la totalité des pages de notre BDD----------------------------->
                        <?php
                            $moitie = sizeof($listePageFB)/2;
                            $listePageFBGauche = array_slice($listePageFB,0,intval($moitie));
                            
                            $listePageFBDroite =  array_slice($listePageFB,$moitie);

                        echo '<div class="col-6">';
                            foreach ($listePageFBGauche as $pageFB) {
                                $token = getComptesFB( $pageFB['id_comptes']);
                                echo '
                                    <div class="form-check">
                                        <input class="form-check-input position-static" type="checkbox" id="blankCheckbox" data-value="'.$token.'" value="'.$pageFB['id'].'">
                                        <label class="form-check-label">
                                        '.$pageFB['nom'].'
                                        </label>
                                    </div>
                                ';
                            }
                        echo '</div>';

                        echo '<div class="col-6">';
                            foreach ($listePageFBDroite as $pageFB) {
                                $token = getComptesFB( $pageFB['id_comptes']);
                                echo '
                                    <div class="form-check">
                                        <input class="form-check-input position-static" type="checkbox" id="blankCheckbox" data-value="'.$token.'" value="'.$pageFB['id'].'">
                                        <label class="form-check-label">
                                        '.$pageFB['nom'].'
                                        </label>
                                    </div>
                                ';
                            }
                        echo '</div>';
                        ?>

                        <button class="btn btn-primary" id="btnfan">Valider</button>
                        </div>

                        <div id="erreur"></div>
                        

                        <div class="col-lg-12">
                            <div class="card mb-3 mt-2">
                                <div class="card-header">
                                <i class="fas fa-chart-bar"></i>
                                Comparatif du nombre de fans par page</div>
                                <div class="card-body">
                                <canvas id="myBarChart" width="100%" height="50"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- HTML -->
                        <div id="chartdiv"></div>
                        <div id="editor"></div><br/>
                        
                        
                        <!------------------------SCRIPT permettant l'affichage de graphique----------------------------->

                        <!-- Chart code -->
                        <script>
                            //au click sur le bouton, on lance la fonction qui activera les deux graphiques
                            $("#btnfan").click(function(){
                            
                            var pagesArrays = [];
                            var count = $('input:checkbox:checked').length;
                            var lesPages = [];
                            var lesFans = [];

                            //boucle for pour récupérer les données de chacune des pages sélectionnées
                            for(var i = 0; i < count; i++){
                                //on selectionne l'id de la page
                                pagesArrays.push($('input:checkbox:checked')[i].value);
                                //on selectionne le token de la page
                                var token = $('input:checkbox:checked')[i].getAttribute('data-value');
                                
                                //on lance l'ajax qui récupérera les données via l'API
                                var monUrl = 'https://graph.facebook.com/v4.0/' + pagesArrays[i] + '?fields=name,fan_count,picture&access_token=' + token;
                                $.ajax(
                                {
                                    url : monUrl,
                                    complete :
                                    function(xhr, textStatus){
                                        if (textStatus == "success") {
                                        var response = JSON.parse(xhr.responseText);
                                        //on réinitialise le contenu de le l'HTML contenant le canvas, évitant un bug d'affichage
                                        $(".card-body").html("");
                                        $(".card-body").html('<canvas id="myBarChart" width="100%" height="50"></canvas>');       
                                        
                                        //on contruit nos deux variable pour notre graphique numero 1
                                        lesPages.push(response['name']);
                                        lesFans.push(response['fan_count']);

                                        //////////////////graphique 1/////////////////////////////////////////////////////////
                                        var max = (Math.ceil(Math.max(...lesFans)/10000)*10000);

                                        // Set new default font family and font color to mimic Bootstrap's default styling
                                        Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
                                        Chart.defaults.global.defaultFontColor = '#292b2c';
                                        
                                        // Bar Chart Example
                                        var ctx = document.getElementById("myBarChart");
                                        var myLineChart = new Chart(ctx, {
                                            type: 'bar',
                                            data: {
                                            labels: lesPages,
                                            datasets: [{
                                                label: "Fans",
                                                backgroundColor: "rgba(2,117,216,1)",
                                                borderColor: "rgba(2,117,216,1)",
                                                data: lesFans,
                                            }],
                                            },
                                            options: {
                                            scales: {
                                                xAxes: [{
                                                time: {
                                                    unit: 'month'
                                                },
                                                gridLines: {
                                                    display: false
                                                },
                                                ticks: {
                                                    maxTicksLimit: 6
                                                }
                                                }],
                                                yAxes: [{
                                                ticks: {
                                                    min: 0,
                                                    max: max,
                                                    maxTicksLimit: 5
                                                },
                                                gridLines: {
                                                    display: true
                                                }
                                                }],
                                            },
                                            legend: {
                                                display: false
                                            },
                                            events: false,
                                            tooltips: {
                                                enabled: false
                                            },
                                            hover: {
                                                animationDuration: 0
                                            },
                                            animation: {
                                                duration: 1,
                                                onComplete: function () {
                                                    var chartInstance = this.chart,
                                                        ctx = chartInstance.ctx;
                                                    ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                                                    ctx.textAlign = 'center';
                                                    ctx.textBaseline = 'bottom';

                                                    this.data.datasets.forEach(function (dataset, i) {
                                                        var meta = chartInstance.controller.getDatasetMeta(i);
                                                        meta.data.forEach(function (bar, index) {
                                                            var data = dataset.data[index];                            
                                                            ctx.fillText(data, bar._model.x, bar._model.y - 5);
                                                        });
                                                    });
                                                }
                                            }
                                            }
                                        });
                                        /////////fin grapgique 1////////////////////////////////////////////////////////////////////////////////
                                        }else{
                                        $( "#erreur" ).addClass( "erreur" );
                                        $('#erreur').html("Serveur indisponible ! Veuillez réessayer plus tard ou reliez votre compte à l'application");
                                        }
                                    }
                                });

                            }

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
        include 'view/admin/inc/footer.php';
    ?>
    <!-- Logout Modal-->
    <?php
        include 'view/admin/inc/modalDeconnexion.php'
    ?>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
</body>

</html>