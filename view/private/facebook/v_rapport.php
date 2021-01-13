<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Nautilus Social Manager - Rapport Facebook</title>

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
                        <h1 class="h3 mb-0 text-gray-800">Rapport Facebook</h1>
                    </div>
                    <div class="container row">
                        <div class="col-6">
                            <div class="form-group row" >
                                <label for="example-page-input" class="col-lg-3 col-form-label">Pages disponible</label>
                                <div class="col-lg-9">
                                    <select class="form-control monForm1" name="selectedValue" style="max-width: 300px;" id="example-page-input">
                                        <option value="null"  data-nom=""> </option>
                                        <?php
                                            foreach($listePageFB as $pageFB){
                                            $token = getComptesFB($pageFB['id_comptes']);
                                            echo '<option value="' . $pageFB['id'] . '" data-value="' . $token . '">' . $pageFB['nom'] . '</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row" >
                                <label for="example-categorie-input" class="col-lg-3 col-form-label">Trier par</label>
                                <div class="col-lg-9">
                                    <select class="form-control monForm1" name="selectedValue" style="max-width: 300px;" id="example-categorie-input">
                                        <option value="" selected="selected"> </option>
                                        <option value="2" selected="selected"> Nombre de likes par post</option>    
                                    </select>
                                </div>
                            </div>
                        </div>  
                        <div class="col-6">
                            <div class="form-group row" >
                                <label for="example-date-input1" class="col-lg-3 col-form-label">Date de début</label>
                                <div class="col-9">
                                    <input class="form-control monForm1" type="date" value="<?php echo date('Y-m-d'); ?>" id="example-date-input1" style="max-width: 300px;">
                                </div>
                            </div>
                            <div class="form-group row" >
                                <label for="example-date-input2" class="col-lg-3 col-form-label">Date de fin</label>
                                <div class="col-9">
                                    <input class="form-control monForm1" type="date" value="<?php echo date('Y-m-d'); ?>" id="example-date-input2" style="max-width: 300px;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="msg"></div>
                    <div id="erreur"></div>

                    <!-- Area Chart Example-->
                    <div class="card mb-3">
                    <div class="card-header">
                        <i class="fas fa-chart-area"></i>
                        Nombre de likes par post</div>
                    <div class="card-body">
                        <canvas id="myAreaChart" width="100%" height="30"></canvas>
                    </div>
                    </div>

                    <div id="editor"></div><br/>
                </div>
                <!-- /.container-fluid -->
                <script>
                    //a chaque changement de mes select dans mon formulaire, on execute la fonction
                    $( ".monForm1" ).change(function() {
                        //on réinitialise le contenu de l'HTML contenant le canvas, évitant un bug d'affichage
                        $(".card-body").html("");
                        $(".card-body").html('<canvas id="myAreaChart" width="100%" height="30"></canvas>');
                        //on réinitialise le contenu de l'HTML affichant une message d'erreur
                        $("#msg").html("");

                        //on récupère l'id de la page selectionné
                        var str = $("#example-page-input").val();
                        //on récupère la catégorie selectionné
                        var cat = $("#example-categorie-input").val();
                        //on récupère le token de la page selectionné
                        var selected = $('#example-page-input').find('option:selected');
                        var token = selected.data('value'); 
                        //on récupère les dates selectionnées
                        var date1 = $("#example-date-input1").val();
                        var date2 = $("#example-date-input2").val();
                        
                        var monUrl = 'https://graph.facebook.com/v4.0/' + str + '?fields=id,name,posts{id,picture,message,reactions.summary(true),created_time,comments.summary(true),shares},fan_count&access_token=' + token;
                        $.ajax(
                            {
                            url : monUrl,
                            complete :
                                function(xhr, textStatus){

                                if (textStatus == "success") {
                                
                                    var response = JSON.parse(xhr.responseText);
                                    var htm = "";
                                    //si l'utilisateur n'a pas selectionné de page, on lui propose de selectionner une page
                                    if(response.posts === undefined || str == "null"){
                                    htm += "<p>Veuillez selectioner une page</p>";
                                    }else{
                                    var lesDates = [];
                                    var lesFans = [];
                                    //boucle for pour construire mes array de dates et de fans en prenant en compte les dates sélectionnées
                                    for(var i = response.posts.data.length - 1; i >= 0; i--){
                                        if(response.posts.data[i].created_time > date1 && response.posts.data[i].created_time < date2){
                                        if(i < (response.posts.data.length)){
                                            //on converti la date dans un format lisible et compréhensible
                                            var date = new Date(response.posts.data[i].created_time);
                                            var maDate = ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '/' + ((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '/' + date.getFullYear() + ' ' + date.getHours() + 'h' +  ((date.getMinutes() > 9) ? date.getMinutes() : ('0' + date.getMinutes()));

                                            lesDates.push(maDate);
                                            lesFans.push(response.posts.data[i].reactions.summary.total_count);
                                        }
                                        }
                                        
                                    }
                                    
                                    //on vérifie si des posts ont été trouvé
                                    if(lesDates.length == 0){
                                        $("#msg").html("Aucun post n'a été trouvé entre ces deux dates");
                                    }else{
                                    //on défini l'échelle maximale de notre graphique
                                    var max = Math.ceil(Math.max(...lesFans)) + 5;

                                    // Set new default font family and font color to mimic Bootstrap's default styling
                                    Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
                                    Chart.defaults.global.defaultFontColor = '#292b2c';

                                    // Area Chart Example
                                    
                                    var ctx = document.getElementById("myAreaChart");
                                    
                                    var myLineChart = new Chart(ctx, {
                                        type: 'line',
                                        data: {
                                        labels: lesDates,
                                        datasets: [{
                                            label: "Sessions",
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
                                            data: lesFans,
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

                                    $( "#result" ).html( htm );
                                }else{
                                    if(selected.data("nom") != ""){
                                    $( "#erreur" ).addClass( "erreur" );
                                    $('#erreur').html("Serveur indisponible ! Veuillez réessayer plus tard ou reliez votre compte à l'application");
                                    }
                                }
                                }
                            }
                        );
                        
                    })
                    .trigger( "change" );
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