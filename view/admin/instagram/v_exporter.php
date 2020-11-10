<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <script src="vendor/chart.js/Chart.min.js"></script>


</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php
            include 'view/admin/sidebar.php'
        ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php
                    include 'view/admin/navbar.php'
                ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Generation PowerPoint Instagram</h1>
                    </div>
                    <form id='bilan'>
                        <div class="form-group row">
                            <label for="example-page-input" class="col-lg-2 col-form-label">Pages disponible</label>
                            <div class="col-lg-10">
                            <select class="form-control" id='choixPageInsta' style="max-width: 300px;" required>
                            <option value=""  data-nom=""> </option>
                            <?php
                                echo $selectPageInsta;
                            ?>
                            </select>
                            </div>
                        </div>
                        <div class="form-group row" >
                            <label for="example-date-input" class="col-lg-2 col-form-label">Mois</label>
                            <div class="col-lg-10">
                            <input class="form-control" type="month" id="dateDebut" style="max-width: 300px;" required>
                            </div>
                        </div> 
                        <!-- <div class="form-group row" >
                            <label for="example-date-input" class="col-lg-2 col-form-label">Date de </label>
                            <div class="col-lg-10">
                            <input class="form-control" type="date" value="<?php echo date('Y-m-d'); ?>" id="dateFin" style="max-width: 300px;">
                            </div>
                        </div> -->
                        <button type="submit" class="btn btn-primary">Generer PowerPoint
                            <section>
                                <progress value="0" max="100" id="progress_bar"></progress>
                            </section>
                        </button>
                    </form>
                    <div id="erreur"></div>

                    <div class="card mb-3 mt-2">
                        <div class="card-header">
                            <i class="fas fa-chart-area"></i>
                            Nombre d'interaction par post</div>
                        <div class="card-body">
                            <canvas id="myAreaChart2" width="100%" height="30"></canvas>
                        </div>
                    </div>

                    <div id="chartdiv" style='width: 100%;height: 500px;'></div>
                    <div id="editor"></div><br/>


                                    <!-- Resources -->
                    <script src="https://www.amcharts.com/lib/4/core.js"></script>
                    <script src="https://www.amcharts.com/lib/4/charts.js"></script>
                    <script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>

                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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
                        $('#bilan').submit(function (e) { 
                            e.preventDefault();
                            $('#erreur').html('');
                            $("#progress_bar").val("0");
                            //on réinitialise le contenu de le l'HTML contenant le canvas, évitant un bug d'affichage
                            $(".card-body").html("");
                            $(".card-body").html('<canvas id="myAreaChart2" width="100%" height="30"></canvas>');

                            var idPageInsta = $('#choixPageInsta').val();

                            var token = $('#choixPageInsta').find('option:selected').data('value');
                            var mois = $('#dateDebut').val();

                            mois = new Date(mois);

                            var dateDebut = new Date(mois.getFullYear(), mois.getMonth(), 1);
                            var dateSince = dateDebut.getFullYear() + '-' + ((dateDebut.getMonth() > 8) ? (dateDebut.getMonth() + 1) : ('0' + (dateDebut.getMonth() + 1))) + '-' + ((dateDebut.getDate() > 9) ? dateDebut.getDate() : ('0' + dateDebut.getDate()));

                            var dateFin = new Date(mois.getFullYear(), mois.getMonth() + 1, 0);
                            var dateUntil = dateFin.getFullYear() + '-' + ((dateFin.getMonth() > 8) ? (dateFin.getMonth() + 1) : ('0' + (dateFin.getMonth() + 1))) + '-' + ((dateFin.getDate() > 9) ? dateFin.getDate() : ('0' + dateFin.getDate()));
                            
                            var url = 'https://graph.facebook.com/v4.0/' + idPageInsta + '/insights?metric=follower_count,reach,impressions&period=day&since=' + dateSince + '&until=' + dateUntil + '&access_token=' + token;               
                            $.get(url, function (data) {
                                var followergagneMensuel = 0;
                                var reachMensuelPageInsta = 0;
                                var impressionMensuelPageInsta = 0;
                                data.data[0].values.forEach(element => {
                                    followergagneMensuel += element.value
                                });
                                data.data[1].values.forEach(element => {
                                    reachMensuelPageInsta += element.value
                                });
                                data.data[2].values.forEach(element => {
                                    impressionMensuelPageInsta += element.value
                                });
                                var url = `https://graph.facebook.com/v8.0/${idPageInsta}?fields=id,media{id,caption,like_count,media_type,comments_count,thumbnail_url,media_url,timestamp}&access_token=${token}`;
                                $.get(url, function (data) {
                                    var tabDateMedia = [];
                                    var tabEngagementMedia = [];
                                    var nbMediaMensuel = 0;
                                    var interactionPostInstaMensuel = 0;
                                    data.media.data.forEach(media => {
                                        var dateMedia = new Date(media.timestamp);
                                        if (dateMedia.getMonth() + 1 == mois.getMonth() + 1) {
                                            nbMediaMensuel++;
                                            var date = ((dateMedia.getDate() > 9) ? dateMedia.getDate() : ('0' + dateMedia.getDate())) + '/' + ((dateMedia.getMonth() > 8) ? (dateMedia.getMonth() + 1) : ('0' + (dateMedia.getMonth() + 1))) + '/' + dateMedia.getFullYear() + ' ' + dateMedia.getHours() + 'h' +  ((dateMedia.getMinutes() > 9) ? dateMedia.getMinutes() : ('0' + dateMedia.getMinutes()));
                                            tabDateMedia.push(date);
                                            tabEngagementMedia.push(media.like_count + media.comments_count);
                                            interactionPostInstaMensuel += media.like_count + media.comments_count;
                                            var idMedia = media.id;
                                            var url =`https://graph.facebook.com/v8.0/${idMedia}/insights?metric=impressions,reach&access_token=${token}`;
                                            $.get(url, function (data) {
                                                
                                            });
                                        }
                                        
                                    });
                                    /* 
                                    Données mensuel :

                                    Follower gagné Mensuel
                                    Reach page mensuel
                                    Impression page mensuel
                                    nbMedia mensuel
                                    Interaction Post mensuel
                                    
                                     */
                                    var url = 'https://graph.facebook.com/v4.0/' + idPageInsta + '/insights/audience_gender_age/lifetime?&access_token=' + token;               
                                    $.get(url,function (data) {
                                    
                                        function verifValeur(params) {
                                            if (typeof params === 'number') {
                                                return params
                                            } else {
                                                return 0
                                            }
                                        }

                                        totalFans = 0;
                                        totalFans += verifValeur(data.data[0].values[0].value["F.13-17"]);
                                        totalFans += verifValeur(data.data[0].values[0].value["F.18-24"]);
                                        totalFans += verifValeur(data.data[0].values[0].value["F.25-34"]);
                                        totalFans += verifValeur(data.data[0].values[0].value["F.35-44"]);
                                        totalFans += verifValeur(data.data[0].values[0].value["F.45-54"]);
                                        totalFans += verifValeur(data.data[0].values[0].value["F.55-64"]);
                                        totalFans += verifValeur(data.data[0].values[0].value["F.65+"]);
                                        totalFans += verifValeur(data.data[0].values[0].value["M.13-17"]);
                                        totalFans += verifValeur(data.data[0].values[0].value["M.18-24"]);
                                        totalFans += verifValeur(data.data[0].values[0].value["M.25-34"]);
                                        totalFans += verifValeur(data.data[0].values[0].value["M.35-44"]);
                                        totalFans += verifValeur(data.data[0].values[0].value["M.45-54"]);
                                        totalFans += verifValeur(data.data[0].values[0].value["M.55-64"]);
                                        totalFans += verifValeur(data.data[0].values[0].value["M.65+"]);
                                        
                                        femme13 = verifValeur(data.data[0].values[0].value["F.13-17"]);
                                        femme18 = verifValeur(data.data[0].values[0].value["F.18-24"]);
                                        femme25 = verifValeur(data.data[0].values[0].value["F.25-34"]);
                                        femme35 = verifValeur(data.data[0].values[0].value["F.35-44"]);
                                        femme45 = verifValeur(data.data[0].values[0].value["F.45-54"]);
                                        femme55 = verifValeur(data.data[0].values[0].value["F.55-64"]);
                                        femme65 = verifValeur(data.data[0].values[0].value["F.65+"]);
                                        homme13 = verifValeur(data.data[0].values[0].value["M.13-17"]);
                                        homme18 = verifValeur(data.data[0].values[0].value["M.18-24"]);
                                        homme25 = verifValeur(data.data[0].values[0].value["M.25-34"]);
                                        homme35 = verifValeur(data.data[0].values[0].value["M.35-44"]);
                                        homme45 = verifValeur(data.data[0].values[0].value["M.45-54"]);
                                        homme55 = verifValeur(data.data[0].values[0].value["M.55-64"]);
                                        homme65 = verifValeur(data.data[0].values[0].value["M.65+"]);

                                        am4core.ready(function() {

                                            // Themes begin
                                            am4core.useTheme(am4themes_animated);
                                            // Themes end

                                            // Create chart instance
                                            var chart = am4core.create("chartdiv", am4charts.XYChart);

                                            // Add data
                                            chart.data = [{
                                                "age": "65+",
                                                "female": -Math.abs((femme65/totalFans*100).toFixed(2)),
                                                "male": (homme65/totalFans*100).toFixed(2)
                                            }, {
                                                "age": "55-64",
                                                "female": -Math.abs((femme55/totalFans*100).toFixed(2)),
                                                "male": (homme55/totalFans*100).toFixed(2)
                                            }, {
                                                "age": "45-54",
                                                "female": -Math.abs((femme45/totalFans*100).toFixed(2)),
                                                "male": (homme45/totalFans*100).toFixed(2)
                                            }, {
                                                "age": "35-44",
                                                "female": -Math.abs((femme35/totalFans*100).toFixed(2)),
                                                "male": (homme35/totalFans*100).toFixed(2)
                                            }, {
                                                "age": "25-34",
                                                "female": -Math.abs((femme25/totalFans*100).toFixed(2)),
                                                "male": (homme25/totalFans*100).toFixed(2)
                                            }, {
                                                "age": "18-24",
                                                "female": -Math.abs((femme18/totalFans*100).toFixed(2)),
                                                "male": (homme18/totalFans*100).toFixed(2)
                                            }, {
                                                "age": "13-17",
                                                "female": -Math.abs((femme13/totalFans*100).toFixed(2)),
                                                "male": (homme13/totalFans*100).toFixed(2)
                                            }];

                                            // Use only absolute numbers
                                            chart.numberFormatter.numberFormat = "#.#s";

                                            // Create axes
                                            var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
                                            categoryAxis.dataFields.category = "age";
                                            categoryAxis.renderer.grid.template.location = 0;
                                            categoryAxis.renderer.inversed = true;

                                            var valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
                                            valueAxis.extraMin = 0.1;
                                            valueAxis.extraMax = 0.1;
                                            valueAxis.renderer.minGridDistance = 40;
                                            valueAxis.renderer.ticks.template.length = 5;
                                            valueAxis.renderer.ticks.template.disabled = false;
                                            valueAxis.renderer.ticks.template.strokeOpacity = 0.4;
                                            valueAxis.renderer.labels.template.adapter.add("text", function(text) {
                                                return text == "Male" || text == "Female" ? text : text + "%";
                                            })

                                            // Create series
                                            var male = chart.series.push(new am4charts.ColumnSeries());
                                            male.dataFields.valueX = "female";
                                            male.dataFields.categoryY = "age";
                                            male.clustered = false;

                                            var maleLabel = male.bullets.push(new am4charts.LabelBullet());
                                            maleLabel.label.text = "{valueX}%";
                                            maleLabel.label.hideOversized = false;
                                            maleLabel.label.truncate = false;
                                            maleLabel.label.horizontalCenter = "right";
                                            maleLabel.label.dx = -10;

                                            var female = chart.series.push(new am4charts.ColumnSeries());
                                            female.dataFields.valueX = "male";
                                            female.dataFields.categoryY = "age";
                                            female.clustered = false;

                                            var femaleLabel = female.bullets.push(new am4charts.LabelBullet());
                                            femaleLabel.label.text = "{valueX}%";
                                            femaleLabel.label.hideOversized = false;
                                            femaleLabel.label.truncate = false;
                                            femaleLabel.label.horizontalCenter = "left";
                                            femaleLabel.label.dx = 10;

                                            var maleRange = valueAxis.axisRanges.create();
                                            maleRange.value = -10;
                                            maleRange.endValue = 0;
                                            maleRange.label.text = "Femme";
                                            maleRange.label.fill = chart.colors.list[0];
                                            maleRange.label.dy = 20;
                                            maleRange.label.fontWeight = '600';
                                            maleRange.grid.strokeOpacity = 1;
                                            maleRange.grid.stroke = male.stroke;

                                            var femaleRange = valueAxis.axisRanges.create();
                                            femaleRange.value = 0;
                                            femaleRange.endValue = 10;
                                            femaleRange.label.text = "Homme";
                                            femaleRange.label.fill = chart.colors.list[1];
                                            femaleRange.label.dy = 20;
                                            femaleRange.label.fontWeight = '600';
                                            femaleRange.grid.strokeOpacity = 1;
                                            femaleRange.grid.stroke = female.stroke;

                                        }); 
                                    });
                                    
                                    //on défini l'échelle maximale de notre graphique
                                    var max = Math.ceil(Math.max(...tabEngagementMedia)) + 5;
                                    var ctx = document.getElementById("myAreaChart2");
                                                                        
                                    var myLineChart = new Chart(ctx, {
                                        type: 'line',
                                        data: {
                                            labels: tabDateMedia,
                                            datasets: [{
                                                label: "Engagement",
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
                                                data: tabEngagementMedia,
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

                                });
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
        include 'view/admin/footer.php';
    ?>
    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pret à partir ?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Voulez vous vous deconnecter ?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                    <a class="btn btn-primary" href="index.php?a=d">Se deconnecter</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
</body>

</html>