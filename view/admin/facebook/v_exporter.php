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
    <script src="js/script.js"></script>
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">


    <!-- Page level plugin CSS-->
    <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Bundle: Easiest to use, supports all browsers -->
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/pptxgenjs@2.6.0/dist/pptxgen.bundle.js"></script>

    <!-- Individual files: Add only what's needed to avoid clobbering loaded libraries -->
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/pptxgenjs@2.6.0/libs/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/pptxgenjs@2.6.0/libs/jszip.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/pptxgenjs@2.6.0/dist/pptxgen.min.js"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.min.js"></script>

    <script type="module" src="js/html2canvas.esm.js"></script>
    <script src="js/html2canvas.js"></script>
    <script src="js/html2canvas.min.js"></script>

    <script src="https://rawgit.com/gitbrent/PptxGenJS/master/dist/pptxgen.bundle.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/PptxGenJS/dist/pptxgen.shapes.js"></script>

    <!-- Page level plugin JavaScript-->
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

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
                        <h1 class="h3 mb-0 text-gray-800">Generation PowerPoint Facebook</h1>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group row" >
                            <label for="example-page-input" class="col-lg-3 col-form-label">Pages disponible</label>
                            <div class="col-lg-9">
                                <select class="form-control monForm" name="selectedValue" style="max-width: 300px;" id="example-page-input">
                                    <option value="null"> </option>
                                    <?php
                                        foreach($listePageFB as $pageFB){
                                        $token = getComptesFB( $pageFB['id_comptes']);
                                        echo '<option value="' . $pageFB['id'] . '" data-value="' . $token . '" data-nom="' . $pageFB['nom'] . '" data-id="' . $pageFB['id_comptes'].'">' . $pageFB['nom'] . '</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row" >
                            <label for="example-date-input1" class="col-lg-3 col-form-label">Date de début</label>
                            <div class="col-lg-9">
                                <input class="form-control monForm1" type="date" value="<?php echo date('Y-m-d'); ?>" id="example-date-input1" style="max-width: 300px;">
                            </div>
                        </div>

                        <div class="form-group row" >
                            <label for="example-date-input2" class="col-lg-3 col-form-label">Date de fin</label>
                            <div class="col-lg-9">
                                <input class="form-control monForm1" type="date" value="<?php echo date('Y-m-d'); ?>" id="example-date-input2" style="max-width: 300px;">
                            </div>
                        </div>
                    </div>

                    

                    <button class="btn btn-warning" id="cmd2" type="button">Générer un Powerpoint
                        <section>
                            <progress value="0" max="100" id="progress_selectionne"></progress>
                        </section>
                    </button>

                    <div id="erreur"></div>

                    <div class="card mb-3 mt-2">
                        <div class="card-header">
                            <i class="fas fa-chart-area"></i>
                            Nombre de likes par post</div>
                        <div class="card-body">
                            <canvas id="myAreaChart2" width="100%" height="30"></canvas>
                        </div>
                    </div>
                    

                    <!-- HTML -->
                    <div id="chartdiv" style='width: 100%;height: 500px;'></div>
                    <div id="editor"></div><br/>

                </div>
                <!-- /.container-fluid -->
                <!-- Resources -->
                <script src="https://www.amcharts.com/lib/4/core.js"></script>
                <script src="https://www.amcharts.com/lib/4/charts.js"></script>
                <script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>

                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
                <script>
                    
                    $('#cmd2').click(function () {

                        $( "#erreur" ).removeClass( "erreur" );
                        $("#erreur").html("");

                        //on réinitialise le contenu de le l'HTML contenant le canvas, évitant un bug d'affichage
                        $(".card-body").html("");
                        $(".card-body").html('<canvas id="myAreaChart2" width="100%" height="30"></canvas>');

                        var progress = document.querySelector('#progress_selectionne');
                                        
                        //on récupère l'id de la page selectionné
                        var idPage = $("#example-page-input").val();
                        
                        //on récupère le token de la page selectionné et l'id de l'utilisateur correspondant
                        var selected = $('#example-page-input').find('option:selected');
                        var token = selected.data('value'); 
                        var id = selected.data('id'); 
                        //on récupère les dates selectionnées
                        var date1 = $("#example-date-input1").val();
                        var date2 = $("#example-date-input2").val();

                        //on converti les dates dans un format yyyy-mm-dd
                        var date1 = new Date(date1);
                        var maDate1 = date1.getFullYear() + '-' + ((date1.getMonth() > 8) ? (date1.getMonth() + 1) : ('0' + (date1.getMonth() + 1))) + '-' + ((date1.getDate() > 9) ? date1.getDate() : ('0' + date1.getDate()));

                        var date2 = new Date(date2);
                        var maDate2 = date2.getFullYear() + '-' + ((date2.getMonth() > 8) ? (date2.getMonth() + 1) : ('0' + (date2.getMonth() + 1))) + '-' + ((date2.getDate() > 9) ? date2.getDate() : ('0' + date2.getDate()));
                        $("#progress_selectionne").val("5");

                        // To calculate the time difference of two dates 
                        var Difference_In_Time = date2.getTime() - date1.getTime(); 
                        
                        // To calculate the no. of days between two dates 
                        var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24); 

                        if(Difference_In_Days > 30 && Difference_In_Days < 94){

                        
                            //il faut récupérer le bon token de page
                            var monUrl2 = 'https://graph.facebook.com/' + id + '/accounts?limit=50&access_token=' + token;
                            
                            $.ajax(
                                {
                                    url : monUrl2,
                                    complete :
                                    function(xhr, textStatus){

                                        if (textStatus == "success") {
                                            var response = JSON.parse(xhr.responseText);

                                            for (var i = 0; i < response.data.length; i++){

                                                if (response.data[i].id == idPage){
                                                    var tokenPage = response.data[i].access_token;
                                                    
                                                }
                                            }
                                        
                                            
                                            $("#progress_selectionne").val("15");

                                            //on récupère les fans de la page pour les mois sélectionnés
                                            var monUrl = 'https://graph.facebook.com/v4.0/' + idPage + '/insights/page_fans/day?&since=' + maDate1 + '&until=' + maDate2 + '&access_token=' + tokenPage;               
                                            console.log(monUrl);
                                            $.ajax(                  
                                                {
                                                url : monUrl,
                                                complete :
                                                    function(xhr, textStatus){
                                                        if (textStatus == "success") {
                                                            
                                                            var response = JSON.parse(xhr.responseText);

                                                            if (typeof response.data[0] != "undefined") {
                                                                
                                                                longueur = response.data[0].values.length;
                                                                fans = response.data[0].values[longueur-1].value;

                                                                var date3 = new Date(response.data[0].values[0].end_time);
                                                                var maDate3 = date3.getFullYear() + '-' + ((date3.getMonth() > 8) ? (date3.getMonth() + 1) : ('0' + (date3.getMonth() + 1))) + '-' + ((date3.getDate() > 9) ? date3.getDate() : ('0' + date3.getDate()));
                                                                var premierMois = ((date3.getMonth() > 8) ? (date3.getMonth() + 1) : ('0' + (date3.getMonth() + 1)));
                                                                var fanMois = [];
                                                                for(var i = 0 ; i < longueur ; i++){
                                                                    var date4 = new Date(response.data[0].values[i].end_time);
                                                                    var maDate4 = date4.getFullYear() + '-' + ((date4.getMonth() > 8) ? (date4.getMonth() + 1) : ('0' + (date4.getMonth() + 1))) + '-' + ((date4.getDate() > 9) ? date4.getDate() : ('0' + date4.getDate()));
                                                                    if(premierMois != ((date4.getMonth() > 8) ? (date4.getMonth() + 1) : ('0' + (date4.getMonth() + 1))) ){

                                                                        fanMois.push( response.data[0].values[i-1].value );
                                                                        premierMois = ((date4.getMonth() > 8) ? (date4.getMonth() + 1) : ('0' + (date4.getMonth() + 1)));

                                                                    }
                                                                }

                                                                fanMois.push( response.data[0].values[i-1].value );

                                                                $("#progress_selectionne").val("30");

                                                                

                                                                //on récupère les commentaires, les reactions, les partages de posts
                                                                var monUrl = 'https://graph.facebook.com/v4.0/' + idPage + '?fields=id,name,posts.limit(70).since(' + maDate1 + ').until(' + maDate2 + '){id,full_picture,message,reactions.summary(true),created_time,comments.summary(true).limit(0),shares},fan_count&access_token=' + token;   
                                                                console.log(monUrl);
                                                                
                                                                $.ajax(
                                                                    {
                                                                    url : monUrl,
                                                                    complete :
                                                                        function(xhr, textStatus){
                                                                            var response = JSON.parse(xhr.responseText);
                                                                            
                                                                            if (typeof response.posts != "undefined") {
                                                                                
                                                                                var listpost = response;
                                                                                var nbPosts = response.posts.data.length;

                                                                                $("input:text").val("Glenn Quagmire");

                                                                                $("#progress_selectionne").val("50");

                                                                                //récupération des fans par genre
                                                                                var monUrl2 = 'https://graph.facebook.com/v4.0/' + idPage + '/insights/page_fans_gender_age?since=' + maDate2 + '&until=' + maDate2 + '&access_token=' + tokenPage;
                                                                                $.ajax(
                                                                                    {
                                                                                        url : monUrl2,
                                                                                        complete :
                                                                                        function(xhr, textStatus){
                                                                                            var response = JSON.parse(xhr.responseText);
                                                                                            //on gère le cas où aucune donnée est disponible
                                                                                            if (typeof response.data[0] != "undefined") {
                                                                                                totalFans = response.data[0].values[0].value["F.13-17"];
                                                                                                totalFans += response.data[0].values[0].value["F.18-24"];
                                                                                                totalFans += response.data[0].values[0].value["F.25-34"];
                                                                                                totalFans += response.data[0].values[0].value["F.35-44"];
                                                                                                totalFans += response.data[0].values[0].value["F.45-54"];
                                                                                                totalFans += response.data[0].values[0].value["F.55-64"];
                                                                                                totalFans += response.data[0].values[0].value["F.65+"];
                                                                                                totalFans += response.data[0].values[0].value["M.13-17"];
                                                                                                totalFans += response.data[0].values[0].value["M.18-24"];
                                                                                                totalFans += response.data[0].values[0].value["M.25-34"];
                                                                                                totalFans += response.data[0].values[0].value["M.35-44"];
                                                                                                totalFans += response.data[0].values[0].value["M.45-54"];
                                                                                                totalFans += response.data[0].values[0].value["M.55-64"];
                                                                                                totalFans += response.data[0].values[0].value["M.65+"];

                                                                                                femme13 = response.data[0].values[0].value["F.13-17"];
                                                                                                femme18 = response.data[0].values[0].value["F.18-24"];
                                                                                                femme25 = response.data[0].values[0].value["F.25-34"];
                                                                                                femme35 = response.data[0].values[0].value["F.35-44"];
                                                                                                femme45 = response.data[0].values[0].value["F.45-54"];
                                                                                                femme55 = response.data[0].values[0].value["F.55-64"];
                                                                                                femme65 = response.data[0].values[0].value["F.65+"];
                                                                                                homme13 = response.data[0].values[0].value["M.13-17"];
                                                                                                homme18 = response.data[0].values[0].value["M.18-24"];
                                                                                                homme25 = response.data[0].values[0].value["M.25-34"];
                                                                                                homme35 = response.data[0].values[0].value["M.35-44"];
                                                                                                homme45 = response.data[0].values[0].value["M.45-54"];
                                                                                                homme55 = response.data[0].values[0].value["M.55-64"];
                                                                                                homme65 = response.data[0].values[0].value["M.65+"];
                                                                                            }else{
                                                                                                totalFans = 0;

                                                                                                femme13 = 0;
                                                                                                femme18 = 0;
                                                                                                femme25 = 0;
                                                                                                femme35 = 0;
                                                                                                femme45 = 0;
                                                                                                femme55 = 0;
                                                                                                femme65 = 0;
                                                                                                homme13 = 0;
                                                                                                homme18 = 0;
                                                                                                homme25 = 0;
                                                                                                homme35 = 0;
                                                                                                homme45 = 0;
                                                                                                homme55 = 0;
                                                                                                homme65 = 0;
                                                                                            }

                                                                                            
                                                                                            


                                                                                            $("#progress_selectionne").val("60");

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

                                                                                            }); // end am4core.ready()

                                                                                            $("#progress_selectionne").val("70");

                                                                                            var htm = "";
                                                                                            var lesDates = [];
                                                                                            var lesFans = [];
                                                                                            var date11 = new Date(date1);
                                                                                            var date22 = new Date(date2);
                                                                                            //boucle for pour construire mes array de dates et de fans en prenant en compte les dates sélectionnées
                                                                                            for(var i = listpost.posts.data.length - 1; i >= 0; i--){
                                                                                                
                                                                                                var dateTime = new Date(listpost.posts.data[i].created_time);
                                                                                                if(dateTime > date11 && dateTime < date22){
                                                                                                    
                                                                                                    if(i < (listpost.posts.data.length)){
                                                                                                        //on converti la date dans un format lisible et compréhensible
                                                                                                        var date = new Date(listpost.posts.data[i].created_time);
                                                                                                        var maDate = ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '/' + ((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '/' + date.getFullYear() + ' ' + date.getHours() + 'h' +  ((date.getMinutes() > 9) ? date.getMinutes() : ('0' + date.getMinutes()));

                                                                                                        lesDates.push(maDate);
                                                                                                        lesFans.push(listpost.posts.data[i].reactions.summary.total_count);
                                                                                                    }
                                                                                                }
                                                                                            
                                                                                            }
                                                                                            //on défini l'échelle maximale de notre graphique
                                                                                            var max = Math.ceil(Math.max(...lesFans)) + 5;

                                                                                            // on défini un font et une couleur
                                                                                            Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
                                                                                            Chart.defaults.global.defaultFontColor = '#292b2c';

                                                                                            // Area Chart Example
                                                                                            
                                                                                            var ctx = document.getElementById("myAreaChart2");
                                                                                            
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


                                                                                            $( "#result" ).html( htm );

                                                                                            var mesReach = 0;
                                                                                            var mesReachOrga = 0;
                                                                                            var mesInteractions = 0;
                                                                                            var moisVerif = lesDates[0].substr(3,2);
                                                                                            var cumulPosts = 0;
                                                                                            var cumulInterac = 0;
                                                                                            var cumulReach = 0;
                                                                                            var postsParMois = [];
                                                                                            var interacParMois = [];
                                                                                            var reachParMois = [];
                                                                                            var meilleurReach = 0;
                                                                                            var clicsDuPost = 0;
                                                                                            var idDuPost = '';
                                                                                            var numPost = 0;
                                                                                            var tauxReaction = 0;
                                                                                            var date = "";
                                                                                            var imageMeilleurPost = "";

                                                                                            var taux1 = 0;
                                                                                            var taux2 = 0;
                                                                                            var taux3 = 0;
                                                                                            var numTaux1 = 0;
                                                                                            var numTaux2 = 0;
                                                                                            var numTaux3 = 0;
                                                                                            var reachTaux1 = 0;
                                                                                            var reachTaux2 = 0;
                                                                                            var reachTaux3 = 0;
                                                                                            var clicTaux1 = 0;
                                                                                            var clicTaux2 = 0;
                                                                                            var clicTaux3 = 0;
                                                                                            var maDateTaux1 = "";
                                                                                            var maDateTaux2 = "";
                                                                                            var maDateTaux3 = "";
                                                                                            var imgTaux1 = "";
                                                                                            var imgTaux2 = "";
                                                                                            var imgTaux3 = "";

                                                                                            var reach1 = 0;
                                                                                            var reach2 = 0;
                                                                                            var reach3 = 0;
                                                                                            var numReach1 = 0;
                                                                                            var numReach2 = 0;
                                                                                            var numReach3 = 0;
                                                                                            var tauxReach1 = 0;
                                                                                            var tauxReach2 = 0;
                                                                                            var tauxReach3 = 0;
                                                                                            var clicReach1 = 0;
                                                                                            var clicReach2 = 0;
                                                                                            var clicReach3 = 0;
                                                                                            var maDateReach1 = 0;
                                                                                            var maDateReach2 = 0;
                                                                                            var maDateReach3 = 0;
                                                                                            var imgReach1 = "";
                                                                                            var imgReach2 = "";
                                                                                            var imgReach3 = "";

                                                                                            var dernierReach1 = 1000000000;
                                                                                            var dernierReach2 = 1000000000;
                                                                                            var dernierReach3 = 1000000000;
                                                                                            var numDernierReach1 = 0;
                                                                                            var numDernierReach2 = 0;
                                                                                            var numDernierReach3 = 0;
                                                                                            var tauxDernierReach1 = 0;
                                                                                            var tauxDernierReach2 = 0;
                                                                                            var tauxDernierReach3 = 0;
                                                                                            var clicDernierReach1 = 0;
                                                                                            var clicDernierReach2 = 0;
                                                                                            var clicDernierReach3 = 0;
                                                                                            var maDateDernierReach1 = 0;
                                                                                            var maDateDernierReach2 = 0;
                                                                                            var maDateDernierReach3 = 0;
                                                                                            var imgDernierReach1 = "";
                                                                                            var imgDernierReach2 = "";
                                                                                            var imgDernierReach3 = "";

                                                                                            var lesMois = [];

                                                                                            $("#progress_selectionne").val("75");

                                                                                                //on calcule la progression qui devra être incrémenté a chaque boucle
                                                                                                var progressActuel = 75;
                                                                                                var progressCount = 20 / listpost.posts.data.length;
                                                                                            for(var g = 0 ; g < listpost.posts.data.length ; g++ ){
                                                                                                //on récupère les reach et click
                                                                                                var monUrl2 = 'https://graph.facebook.com/v4.0/' + listpost.posts.data[g].id + '/insights/post_engaged_users,post_impressions_unique,post_impressions_organic_unique,post_clicks?access_token=' + tokenPage;
                                                                                                
                                                                                                $.ajax(
                                                                                                    {
                                                                                                        url : monUrl2,
                                                                                                        async: false,
                                                                                                        complete :
                                                                                                        function(xhr, textStatus){
                                                                                                            var response = JSON.parse(xhr.responseText);

                                                                                                            progressActuel += progressCount;
                                                                                                            $("#progress_selectionne").val(progressActuel);
                                                                                                            

                                                                                                            //s'il y a des données, on initialise nos variables avec nos données sinon, ils prennent la valeur 0
                                                                                                            if (typeof response.data != "undefined") {
                                                                                                                var engagedUsers = response.data[0].values[0].value;
                                                                                                                var impressionUnique = response.data[1].values[0].value;
                                                                                                                var impressionOrganic = response.data[2].values[0].value;
                                                                                                                var postClicks = response.data[3].values[0].value;
                                                                                                            }else{
                                                                                                                var engagedUsers = 0;
                                                                                                                var impressionUnique = 0;
                                                                                                                var impressionOrganic = 0;
                                                                                                                var postClicks = 0;
                                                                                                            }
                                                                                                            //lors de la première boucle, on récupère les valeurs de la boucle pour ensuite procéder a des vérifications, cela correspond a la page Powerpoint pour TOP POST
                                                                                                            if(g == 0){
                                                                                                                meilleurReach = impressionUnique;
                                                                                                                idDuPost = listpost.posts.data[g].id;
                                                                                                                clicsDuPost = engagedUsers;
                                                                                                                tauxReaction = (clicsDuPost/meilleurReach*100).toFixed(2);
                                                                                                                imageMeilleurPost = listpost.posts.data[g].full_picture;
                                                                                                            }
                                                                                                            //on récupère la date de la boucle en cours
                                                                                                            date = new Date(listpost.posts.data[g].created_time);
                                                                                                            //on vérifie si le taux d'interaction du post de la boucle est suppérieur à l'actuel taux le plus élevé qu'on ait trouvé (taux1)
                                                                                                            //si c'est trouvé, le 3eme taux le plus élevé prend la valeur du 2eme taux le plus élevé, le 2eme taux prend la valeur du premier et le premier prend la valeur du post qu'on a vérifié
                                                                                                            //si ce n'est pas trouvé, on vérifie avec les autres taux etc
                                                                                                            if((engagedUsers / impressionUnique)*100 > taux1){
                                                                                                                numTaux3 = numTaux2;
                                                                                                                reachTaux3 = reachTaux2;
                                                                                                                clicTaux3 = clicTaux2;
                                                                                                                taux3 = taux2;
                                                                                                                imgTaux3 = imgTaux2;
                                                                                                                maDateTaux3 = maDateTaux2;

                                                                                                                numTaux2 = numTaux1;
                                                                                                                reachTaux2 = reachTaux1;
                                                                                                                clicTaux2 = clicTaux1;
                                                                                                                taux2 = taux1;
                                                                                                                imgTaux2 = imgTaux1;
                                                                                                                maDateTaux2 = maDateTaux1;
                                                                                                                
                                                                                                                numTaux1 = g;
                                                                                                                reachTaux1 = impressionUnique;
                                                                                                                clicTaux1 = postClicks;
                                                                                                                taux1 = (engagedUsers/impressionUnique)*100;
                                                                                                                imgTaux1 = listpost.posts.data[g].full_picture;
                                                                                                                
                                                                                                                maDateTaux1 = ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '/' + ((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '/' + date.getFullYear() + ' ' + date.getHours() + 'h' +  ((date.getMinutes() > 9) ? date.getMinutes() : ('0' + date.getMinutes()));
                                                                                                            }else if((engagedUsers/response.data[1].values[0].value)*100 > taux2){

                                                                                                                numTaux3 = numTaux2;
                                                                                                                reachTaux3 = reachTaux2;
                                                                                                                clicTaux3 = clicTaux2;
                                                                                                                taux3 = taux2;
                                                                                                                imgTaux3 = imgTaux2;
                                                                                                                maDateTaux3 = maDateTaux2;
                                                                                                                
                                                                                                                numTaux2 = g;
                                                                                                                reachTaux2 = impressionUnique;
                                                                                                                clicTaux2 = postClicks;
                                                                                                                taux2 = (engagedUsers/impressionUnique)*100;
                                                                                                                imgTaux2 = listpost.posts.data[g].full_picture;
                                                                                                                
                                                                                                                maDateTaux2 = ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '/' + ((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '/' + date.getFullYear() + ' ' + date.getHours() + 'h' +  ((date.getMinutes() > 9) ? date.getMinutes() : ('0' + date.getMinutes()));
                                                                                                            }else if((engagedUsers/impressionUnique)*100 > taux3){
                                                                                                                
                                                                                                                numTaux3 = g;
                                                                                                                reachTaux3 = impressionUnique;
                                                                                                                clicTaux3 = postClicks;
                                                                                                                taux3 = (engagedUsers/impressionUnique)*100;
                                                                                                                imgTaux3 = listpost.posts.data[g].full_picture;
                                                                                                                
                                                                                                                maDateTaux3 = ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '/' + ((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '/' + date.getFullYear() + ' ' + date.getHours() + 'h' +  ((date.getMinutes() > 9) ? date.getMinutes() : ('0' + date.getMinutes()));
                                                                                                            }


                                                                                                            //procédé similaire au taux d'interaction plus haut
                                                                                                            if(impressionUnique > reach1){
                                                                                                                reach3 = reach2;
                                                                                                                numReach3 = numReach2;
                                                                                                                clicReach3 = clicReach2;
                                                                                                                tauxReach3 = tauxReach2;
                                                                                                                imgReach3 = imgReach2;
                                                                                                                maDateReach3 = maDateReach2;

                                                                                                                reach2 = reach1;
                                                                                                                numReach2 = numReach1;
                                                                                                                clicReach2 = clicReach1;
                                                                                                                tauxReach2 = tauxReach1;
                                                                                                                imgReach2 = imgReach1;
                                                                                                                maDateReach2 = maDateReach1;

                                                                                                                reach1 = impressionUnique;
                                                                                                                numReach1 = g;
                                                                                                                clicReach1 = postClicks;
                                                                                                                tauxReach1 = (engagedUsers/impressionUnique*100);
                                                                                                                imgReach1 = listpost.posts.data[g].full_picture;
                                                                                                                
                                                                                                                maDateReach1 = ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '/' + ((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '/' + date.getFullYear() + ' ' + date.getHours() + 'h' +  ((date.getMinutes() > 9) ? date.getMinutes() : ('0' + date.getMinutes()));
                                                                                                            }else if(impressionUnique > reach2){
                                                                                                                reach3 = reach2;
                                                                                                                numReach3 = numReach2;
                                                                                                                clicReach3 = clicReach2;
                                                                                                                tauxReach3 = tauxReach2;
                                                                                                                imgReach3 = imgReach2;
                                                                                                                maDateReach3 = maDateReach2;

                                                                                                                reach2 = impressionUnique;
                                                                                                                numReach2 = g;
                                                                                                                clicReach2 = postClicks;
                                                                                                                tauxReach2 = (engagedUsers/impressionUnique*100);
                                                                                                                imgReach2 = listpost.posts.data[g].full_picture;
                                                                                                                
                                                                                                                maDateReach2 = ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '/' + ((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '/' + date.getFullYear() + ' ' + date.getHours() + 'h' +  ((date.getMinutes() > 9) ? date.getMinutes() : ('0' + date.getMinutes()));
                                                                                                            }else if(impressionUnique > reach3){
                                                                                                                reach3 = impressionUnique;
                                                                                                                numReach3 = g;
                                                                                                                clicReach3 = postClicks;
                                                                                                                tauxReach3 = (engagedUsers/impressionUnique*100);
                                                                                                                imgReach3 = listpost.posts.data[g].full_picture;
                                                                                                                
                                                                                                                maDateReach3 = ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '/' + ((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '/' + date.getFullYear() + ' ' + date.getHours() + 'h' +  ((date.getMinutes() > 9) ? date.getMinutes() : ('0' + date.getMinutes()));
                                                                                                            }


                                                                                                            
                                                                                                            //procédé similaire au taux d'intéraction et au reach plus haut
                                                                                                            if(impressionUnique < dernierReach1){
                                                                                                                dernierReach3 = dernierReach2;
                                                                                                                numDernierReach3 = numDernierReach2;
                                                                                                                clicDernierReach3 = clicDernierReach2;
                                                                                                                tauxDernierReach3 = tauxDernierReach2;
                                                                                                                maDateDernierReach3 = maDateDernierReach2;
                                                                                                                imgDernierReach3 = imgDernierReach2;

                                                                                                                dernierReach2 = dernierReach1;
                                                                                                                numDernierReach2 = numDernierReach1;
                                                                                                                clicDernierReach2 = clicDernierReach1;
                                                                                                                tauxDernierReach2 = tauxDernierReach1;
                                                                                                                maDateDernierReach2 = maDateDernierReach1;
                                                                                                                imgDernierReach2 = imgDernierReach1

                                                                                                                dernierReach1 = impressionUnique;
                                                                                                                numDernierReach1 = g;
                                                                                                                clicDernierReach1 = postClicks;
                                                                                                                tauxDernierReach1 = (engagedUsers/impressionUnique*100);
                                                                                                                imgDernierReach1 = listpost.posts.data[g].full_picture;
                                                                                                                maDateDernierReach1 = ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '/' + ((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '/' + date.getFullYear() + ' ' + date.getHours() + 'h' +  ((date.getMinutes() > 9) ? date.getMinutes() : ('0' + date.getMinutes()));
                                                                                                            }else if(impressionUnique < dernierReach2){
                                                                                                                dernierReach3 = dernierReach2;
                                                                                                                numDernierReach3 = numDernierReach2;
                                                                                                                clicDernierReach3 = clicDernierReach2;
                                                                                                                tauxDernierReach3 = tauxDernierReach2;
                                                                                                                maDateDernierReach3 = maDateDernierReach2;
                                                                                                                imgDernierReach3 = imgDernierReach2;

                                                                                                                dernierReach2 = impressionUnique;
                                                                                                                numDernierReach2 = g;
                                                                                                                clicDernierReach2 = postClicks;
                                                                                                                tauxDernierReach2 = (engagedUsers/impressionUnique*100);
                                                                                                                imgDernierReach2 = listpost.posts.data[g].full_picture;
                                                                                                                maDateDernierReach2 = ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '/' + ((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '/' + date.getFullYear() + ' ' + date.getHours() + 'h' +  ((date.getMinutes() > 9) ? date.getMinutes() : ('0' + date.getMinutes()));
                                                                                                            }else if(impressionUnique < dernierReach3){
                                                                                                                dernierReach3 = impressionUnique;
                                                                                                                numDernierReach3 = g;
                                                                                                                clicDernierReach3 = postClicks;
                                                                                                                tauxDernierReach3 = (engagedUsers/impressionUnique*100);
                                                                                                                imgDernierReach3 = listpost.posts.data[g].full_picture;
                                                                                                                
                                                                                                                maDateDernierReach3 = ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '/' + ((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '/' + date.getFullYear() + ' ' + date.getHours() + 'h' +  ((date.getMinutes() > 9) ? date.getMinutes() : ('0' + date.getMinutes()));
                                                                                                            }

                                                                                                            //si le meilleur reach qu'on ait trouvé est inférieur au reach du post de la boucle, on récupère les valeurs
                                                                                                            if(meilleurReach < impressionUnique){
                                                                                                                idDuPost = listpost.posts.data[g].id;
                                                                                                                meilleurReach = impressionUnique;
                                                                                                                clicsDuPost = postClicks;
                                                                                                                numPost = g;
                                                                                                                tauxReaction = (engagedUsers/impressionUnique*100).toFixed(2);
                                                                                                                imageMeilleurPost = listpost.posts.data[g].full_picture;
                                                                                                                
                                                                                                            }
                                                                                                            //si le mois n'a pas changé dans la boucle, on incrémente les valeurs
                                                                                                            //sinon on push notre array correspondant à la totalité des posts, interactions et reach par mois
                                                                                                            if(moisVerif == lesDates[g].substr(3,2)){
                                                                                                                cumulPosts += 1;
                                                                                                                cumulInterac += engagedUsers;
                                                                                                                cumulReach += impressionUnique;
                                                                                                            }else{
                                                                                                                switch (moisVerif) {
                                                                                                                    case '01':
                                                                                                                        lesMois.push("Janvier");
                                                                                                                        break;
                                                                                                                    case '02':
                                                                                                                        lesMois.push("Fevrier");
                                                                                                                        break;
                                                                                                                    case '03':
                                                                                                                        lesMois.push("Mars");
                                                                                                                        break;
                                                                                                                    case '04':
                                                                                                                        lesMois.push("Avril");
                                                                                                                        break;
                                                                                                                    case '05':
                                                                                                                        lesMois.push("Mai");
                                                                                                                        break;
                                                                                                                    case '06':
                                                                                                                        lesMois.push("Juin");
                                                                                                                        break;
                                                                                                                    case '07':
                                                                                                                        lesMois.push("Juillet");
                                                                                                                        break;
                                                                                                                    case '08':
                                                                                                                        lesMois.push("Août");
                                                                                                                        break;
                                                                                                                    case '09':
                                                                                                                        lesMois.push("Septembre");
                                                                                                                        break;
                                                                                                                    case '10':
                                                                                                                        lesMois.push("Octobre");
                                                                                                                        break;
                                                                                                                    case '11':
                                                                                                                        lesMois.push("Novembre");
                                                                                                                        break;
                                                                                                                    case '12':
                                                                                                                        lesMois.push("Decembre");
                                                                                                                        break;
                                                                                                                    default:
                                                                                                                        lesMois.push("Mois");
                                                                                                                }

                                                                                                                postsParMois.push(cumulPosts);
                                                                                                                interacParMois.push(cumulInterac);
                                                                                                                reachParMois.push(cumulReach);
                                                                                                                cumulPosts = 1;
                                                                                                                cumulInterac = engagedUsers;
                                                                                                                cumulReach = impressionUnique;
                                                                                                                moisVerif = lesDates[g].substr(3,2);
                                                                                                            }

                                                                                                            mesReach += impressionUnique;
                                                                                                            mesReachOrga += impressionOrganic;
                                                                                                            mesInteractions += engagedUsers;
                                                                                                            
                                                                                                            //si on arrive en fin de boucle, on push les dernières données dans nos array
                                                                                                            if(g == (listpost.posts.data.length - 1)){
                                                                                                                
                                                                                                                postsParMois.push(cumulPosts);
                                                                                                                interacParMois.push(cumulInterac);
                                                                                                                reachParMois.push(cumulReach);
                                                                                                                if(moisVerif == lesDates[g].substr(3,2)){
                                                                                                                    switch (moisVerif) {
                                                                                                                        case '01':
                                                                                                                            lesMois.push("Janvier");
                                                                                                                            break;
                                                                                                                        case '02':
                                                                                                                            lesMois.push("Fevrier");
                                                                                                                            break;
                                                                                                                        case '03':
                                                                                                                            lesMois.push("Mars");
                                                                                                                            break;
                                                                                                                        case '04':
                                                                                                                            lesMois.push("Avril");
                                                                                                                            break;
                                                                                                                        case '05':
                                                                                                                            lesMois.push("Mai");
                                                                                                                            break;
                                                                                                                        case '06':
                                                                                                                            lesMois.push("Juin");
                                                                                                                            break;
                                                                                                                        case '07':
                                                                                                                            lesMois.push("Juillet");
                                                                                                                            break;
                                                                                                                        case '08':
                                                                                                                            lesMois.push("Août");
                                                                                                                            break;
                                                                                                                        case '09':
                                                                                                                            lesMois.push("Septembre");
                                                                                                                            break;
                                                                                                                        case '10':
                                                                                                                            lesMois.push("Octobre");
                                                                                                                            break;
                                                                                                                        case '11':
                                                                                                                            lesMois.push("Novembre");
                                                                                                                            break;
                                                                                                                        case '12':
                                                                                                                            lesMois.push("Decembre");
                                                                                                                            break;
                                                                                                                        default:
                                                                                                                            lesMois.push("Mois");
                                                                                                                    }
                                                                                                                }

                                                                                                                if(postsParMois.length < 3){
                                                                                                                    for(var i = 0; i <= 3 - postsParMois.length; i++){
                                                                                                                    
                                                                                                                        postsParMois.push(0);
                                                                                                                        interacParMois.push(0);
                                                                                                                        reachParMois.push(0);
                                                                                                                        fanMois.push(0);
                                                                                                                        lesMois.push("Mois");
                                                                                                                    }
                                                                                                                }

                                                                                                                var date = new Date(listpost.posts.data[numPost].created_time);
                                                                                                                var maDate = ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '/' + ((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '/' + date.getFullYear() + ' ' + date.getHours() + 'h' +  ((date.getMinutes() > 9) ? date.getMinutes() : ('0' + date.getMinutes()));


                                                                                                                var taux = (mesInteractions / mesReach) * 100;
                                                                                                                var intParPost = Math.round(mesInteractions / nbPosts);
                                                                                                                var tauxReachOrganique = (mesReachOrga / mesReach) * 100;

                                                                                                                //on vérifie que les données existent, si elle n'existe pas, la variable prend la valeur 0

                                                                                                                if (typeof listpost.posts.data[numPost].shares != "undefined") {
                                                                                                                    var sharesPost = listpost.posts.data[numPost].shares.count;
                                                                                                                }else{
                                                                                                                    var sharesPost = 0;
                                                                                                                }

                                                                                                                if (typeof listpost.posts.data[numTaux1].shares != "undefined") {
                                                                                                                    var sharesPostTaux1 = listpost.posts.data[numTaux1].shares.count;
                                                                                                                }else{
                                                                                                                    var sharesPostTaux1 = 0;
                                                                                                                }
                                                                                                                if (typeof listpost.posts.data[numTaux2].shares != "undefined") {
                                                                                                                    var sharesPostTaux2 = listpost.posts.data[numTaux2].shares.count;
                                                                                                                }else{
                                                                                                                    var sharesPostTaux2 = 0;
                                                                                                                }
                                                                                                                if (typeof listpost.posts.data[numTaux3].shares != "undefined") {
                                                                                                                    var sharesPostTaux3 = listpost.posts.data[numTaux3].shares.count;
                                                                                                                }else{
                                                                                                                    var sharesPostTaux3 = 0;
                                                                                                                }
                                                                                                                if (typeof listpost.posts.data[numReach1].shares != "undefined") {
                                                                                                                    var sharesPostReach1 = listpost.posts.data[numReach1].shares.count;
                                                                                                                }else{
                                                                                                                    var sharesPostReach1 = 0;
                                                                                                                }
                                                                                                                if (typeof listpost.posts.data[numReach2].shares != "undefined") {
                                                                                                                    var sharesPostReach2 = listpost.posts.data[numReach2].shares.count;
                                                                                                                }else{
                                                                                                                    var sharesPostReach2 = 0;
                                                                                                                }
                                                                                                                if (typeof listpost.posts.data[numReach3].shares != "undefined") {
                                                                                                                    var sharesPostReach3 = listpost.posts.data[numReach3].shares.count;
                                                                                                                }else{
                                                                                                                    var sharesPostReach3 = 0;
                                                                                                                }
                                                                                                                if (typeof listpost.posts.data[numDernierReach1].shares != "undefined") {
                                                                                                                    var sharesPostDernierReach1 = listpost.posts.data[numDernierReach1].shares.count;
                                                                                                                }else{
                                                                                                                    var sharesPostDernierReach1 = 0;
                                                                                                                }
                                                                                                                if (typeof listpost.posts.data[numDernierReach2].shares != "undefined") {
                                                                                                                    var sharesPostDernierReach2 = listpost.posts.data[numDernierReach2].shares.count;
                                                                                                                }else{
                                                                                                                    var sharesPostDernierReach2 = 0;
                                                                                                                }
                                                                                                                if (typeof listpost.posts.data[numDernierReach3].shares != "undefined") {
                                                                                                                    var sharesPostDernierReach3 = listpost.posts.data[numDernierReach3].shares.count;
                                                                                                                }else{
                                                                                                                    var sharesPostDernierReach3 = 0;
                                                                                                                }

                                                                                                                //fonction qui va permettre de convertir une image via url en image base 64
                                                                                                                function toDataURL(url, callback) {
                                                                                                                    var xhr = new XMLHttpRequest();
                                                                                                                    xhr.onload = function() {
                                                                                                                        var reader = new FileReader();
                                                                                                                        reader.onloadend = function() {
                                                                                                                        callback(reader.result);
                                                                                                                        }
                                                                                                                        reader.readAsDataURL(xhr.response);
                                                                                                                    };
                                                                                                                    xhr.open('GET', url);
                                                                                                                    xhr.responseType = 'blob';
                                                                                                                    xhr.send();
                                                                                                                }
                                                                                                                //on converti toutes nos images en base64 afin de pouvoir les exploiter dans pptxgenjs
                                                                                                                toDataURL(imageMeilleurPost, function(dataUrl1) {
                                                                                                                    toDataURL(imgTaux1, function(dataUrl12) {
                                                                                                                        toDataURL(imgTaux2, function(dataUrl3) {
                                                                                                                            toDataURL(imgTaux3, function(dataUrl4) {
                                                                                                                                toDataURL(imgReach1, function(dataUrl5) {
                                                                                                                                    toDataURL(imgReach2, function(dataUrl6) {
                                                                                                                                        toDataURL(imgReach3, function(dataUrl7) {
                                                                                                                                            toDataURL(imgDernierReach1, function(dataUrl8) {
                                                                                                                                                toDataURL(imgDernierReach2, function(dataUrl9) {
                                                                                                                                                    toDataURL(imgDernierReach3, function(dataUrl10) {
                                                                                                                                                        //on initialise notre Powerpoint
                                                                                                                                                        var pptx = new PptxGenJS();
                                                                                                                                                        var slide = pptx.addSlide();
                                                                                                                                                        
                                                                                                                                                        html2canvas(document.body).then(function(canvas) {
                                                                                                                                                            //on récupère les graphiques de la page et les images dans notre dossier
                                                                                                                                                            var node = document.getElementById('myAreaChart2');
                                                                                                                                                            var node2 = document.getElementById('chartdiv');
                                                                                                                                                            //domtoimage va servir a faire une capture de nos canvas (graphiques) et des les convertir en image base64
                                                                                                                                                            domtoimage.toPng(node).then(function (dataUrl) {
                                                                                                                                                                domtoimage.toPng(node2).then(function (dataUrl2) {
                                                                                                                                                                    var img = new Image();
                                                                                                                                                                    img.src = dataUrl;
                                                                                                                                                                    var img5 = new Image();
                                                                                                                                                                    img5.src = dataUrl2;
                                                                                                                                                                    var img2 = new Image();
                                                                                                                                                                    img2.src = "images/capture3.png";
                                                                                                                                                                    var img3 = new Image();
                                                                                                                                                                    img3.src = "images/bandeau1.png";
                                                                                                                                                                    var img4 = new Image();
                                                                                                                                                                    img4.src = "images/fin.png";
                                                                                                                                                                    var img6 = new Image();
                                                                                                                                                                    img6.src = "images/screen-page.png";
                                                                                                                                                                    var img7 = new Image();
                                                                                                                                                                    img7.src = "images/screen-post1.png";

                                                                                                                                                                    //page de garde
                                                                                                                                                                    slide.addImage({ path:img2.src, x:0, y:0, w:10, h:5.6 });

                                                                                                                                                                    //page de garde
                                                                                                                                                                    slide = pptx.addSlide();
                                                                                                                                                                    slide.bkgd = 'f1bf00';
                                                                                                                                                                    slide.addText(selected.data('nom') ,  { x:'30%', y:'25%', w:4, color:'FFFFFF', fontFace:'Avenir 85 Heavy', align: 'center', fontSize:45 });
                                                                                                                                                                    slide.addText('PAGE FACEBOOK',  { x:'35%', y:'40%', w:3, color:'FFFFFF', fontFace:'Avenir 85 Heavy', align: 'center', fontSize:22 });
                                                                                                                                                                    slide.addText('BILAN Trimestriel',  { x:'30%', y:'57%', w:4, color:'FFFFFF', align: 'center', fontFace:'Avenir 85 Heavy', fontSize:30 });
                                                                                                                                                                    slide.addText('(' + lesMois[0] + ' / ' + lesMois[1] + ' / ' + lesMois[2] + ') 2020',  { x:'25%', y:'72%', w:5, color:'FFFFFF', fontFace:'Avenir 85 Heavy', align: 'center', fontSize:22 });


                                                                                                                                                                    $("#progress_selectionne").val("85");
                                                                                                                                                                    
                                                                                                                                                                    //seconde page "LA PAGE FACEBOOK"
                                                                                                                                                                    slide = pptx.addSlide();
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: taux.toFixed(2) + ' %', options: {bold:true, fontSize:12}},
                                                                                                                                                                            { text: ' Taux d\'interaction', options: {}}
                                                                                                                                                                        ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'10%', y:'80%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: fans.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " "), options: {bold:true, fontSize:12}},
                                                                                                                                                                            { text: ' fans', options: {}}
                                                                                                                                                                        ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'25%', y:'80%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: nbPosts, options: {bold:true, fontSize:12}},
                                                                                                                                                                            { text: ' posts', options: {}}
                                                                                                                                                                        ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'40%', y:'80%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: mesInteractions.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " "), options: {bold:true, fontSize:12}},
                                                                                                                                                                            { text: ' interactions soit une moyenne de ', options: {}},
                                                                                                                                                                            { text: intParPost.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ") + '/post', options: {bold:true}}
                                                                                                                                                                        ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'55%', y:'80%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: mesReach.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " "), options: {bold:true, fontSize:12}},
                                                                                                                                                                            { text: ' reach total posts', options: {}}
                                                                                                                                                                        ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'70%', y:'80%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: mesReachOrga.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " "), options: {bold:true, fontSize:12}},
                                                                                                                                                                            { text: ' reach organique soit ' + tauxReachOrganique.toFixed(2) + '%', options: {}}
                                                                                                                                                                        ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'85%', y:'80%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                                                                                                                                    slide.addImage({ path:img3.src, x:0, y:0, w:10, h:0.8 });
                                                                                                                                                                    slide.addText('LA PAGE FACEBOOK',  { x:'9%', y:'7%', w:'100%', color:'FFFFFF', fontFace:'Avenir 85 Heavy', fontSize:25 });
                                                                                                                                                                    slide.addImage({ path:img6.src, x:"18%", y:"18%", w:"64%", h:"55%" });
                                                                                                                                                                    
                                                                                                                                                                    //troisième page CHIFFRES CLES
                                                                                                                                                                    slide = pptx.addSlide();
                                                                                                                                                                    slide.addImage({ path:img3.src, x:0, y:0, w:10, h:0.8 });
                                                                                                                                                                    slide.addText('CHIFFRES CLES',  { x:'9%', y:'7%', w:'100%', color:'FFFFFF', fontFace:'Avenir 85 Heavy', fontSize:25 });

                                                                                                                                                                    slide.addText(lesMois[0],  { x:'5%', y:'18%', w:'100%', color:'000000', fontSize:18 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (interacParMois[0]/reachParMois[0]*100).toFixed(2) + ' %', options: {bold:true, fontSize:12}},
                                                                                                                                                                            { text: ' Taux d\'interaction', options: {}}
                                                                                                                                                                        ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'15%', y:'25%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: fanMois[0].toString().replace(/\B(?=(\d{3})+(?!\d))/g, " "), options: {bold:true, fontSize:12}},
                                                                                                                                                                            { text: ' fans', options: {}}
                                                                                                                                                                        ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'30%', y:'25%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: postsParMois[0], options: {bold:true, fontSize:12}},
                                                                                                                                                                            { text: ' posts', options: {}}
                                                                                                                                                                        ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'45%', y:'25%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: interacParMois[0].toString().replace(/\B(?=(\d{3})+(?!\d))/g, " "), options: {bold:true, fontSize:12}},
                                                                                                                                                                            { text: ' interactions soit une moyenne de ', options: {}},
                                                                                                                                                                            { text: Math.round(interacParMois[0] / postsParMois[0]).toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ") + '/post', options: {bold:true}}
                                                                                                                                                                        ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'60%', y:'25%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: reachParMois[0].toString().replace(/\B(?=(\d{3})+(?!\d))/g, " "), options: {bold:true, fontSize:12}},
                                                                                                                                                                            { text: ' reach total posts', options: {}}
                                                                                                                                                                        ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'75%', y:'25%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                                                                                                                                    

                                                                                                                                                                    slide.addText(lesMois[1],  { x:'5%', y:'45%', w:'100%', color:'000000', fontSize:18 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (interacParMois[1]/reachParMois[1]*100).toFixed(2) + ' %', options: {bold:true, fontSize:12}},
                                                                                                                                                                            { text: ' Taux d\'interaction', options: {}}
                                                                                                                                                                        ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'15%', y:'52%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: fanMois[1].toString().replace(/\B(?=(\d{3})+(?!\d))/g, " "), options: {bold:true, fontSize:12}},
                                                                                                                                                                            { text: ' fans', options: {}}
                                                                                                                                                                        ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'30%', y:'52%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: postsParMois[1], options: {bold:true, fontSize:12}},
                                                                                                                                                                            { text: ' posts', options: {}}
                                                                                                                                                                        ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'45%', y:'52%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: interacParMois[1].toString().replace(/\B(?=(\d{3})+(?!\d))/g, " "), options: {bold:true, fontSize:12}},
                                                                                                                                                                            { text: ' interactions soit une moyenne de ', options: {}},
                                                                                                                                                                            { text: Math.round(interacParMois[1] / postsParMois[1]).toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ") + '/post', options: {bold:true}}
                                                                                                                                                                        ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'60%', y:'52%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: reachParMois[1].toString().replace(/\B(?=(\d{3})+(?!\d))/g, " "), options: {bold:true, fontSize:12}},
                                                                                                                                                                            { text: ' reach total posts', options: {}}
                                                                                                                                                                        ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'75%', y:'52%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});

                                                                                                                                                                    slide.addText(lesMois[2],  { x:'5%', y:'72%', w:'100%', color:'000000', fontSize:18 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (interacParMois[2]/reachParMois[2]*100).toFixed(2) + ' %', options: {bold:true, fontSize:12}},
                                                                                                                                                                            { text: ' Taux d\'interaction', options: {}}
                                                                                                                                                                        ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'15%', y:'79%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: fanMois[2].toString().replace(/\B(?=(\d{3})+(?!\d))/g, " "), options: {bold:true, fontSize:12}},
                                                                                                                                                                            { text: ' fans', options: {}}
                                                                                                                                                                        ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'30%', y:'79%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: postsParMois[2], options: {bold:true, fontSize:12}},
                                                                                                                                                                            { text: ' posts', options: {}}
                                                                                                                                                                        ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'45%', y:'79%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: interacParMois[2].toString().replace(/\B(?=(\d{3})+(?!\d))/g, " "), options: {bold:true, fontSize:12}},
                                                                                                                                                                            { text: ' interactions soit une moyenne de ', options: {}},
                                                                                                                                                                            { text: Math.round(interacParMois[2] / postsParMois[2]).toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ") + '/post', options: {bold:true}}
                                                                                                                                                                        ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'60%', y:'79%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: reachParMois[2].toString().replace(/\B(?=(\d{3})+(?!\d))/g, " "), options: {bold:true, fontSize:12}},
                                                                                                                                                                            { text: ' reach total posts', options: {}}
                                                                                                                                                                        ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'75%', y:'79%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                                                                                                                                    

                                                                                                                                                                    //quatrième page FOCUS FANS
                                                                                                                                                                    slide = pptx.addSlide();
                                                                                                                                                                    slide.addImage({ path:img3.src, x:0, y:0, w:10, h:0.8 });
                                                                                                                                                                    slide.addText('FOCUS FANS',  { x:'9%', y:'7%', w:'100%', color:'FFFFFF', fontFace:'Avenir 85 Heavy', fontSize:25 });
                                                                                                                                                                    slide.addImage({ data:img5.src, x:1, y:1, w:8, h:3 });

                                                                                                                                                                    //cinquième page FOCUS LIKE
                                                                                                                                                                    slide = pptx.addSlide();
                                                                                                                                                                    slide.addImage({ path:img3.src, x:0, y:0, w:10, h:0.8 });
                                                                                                                                                                    slide.addText('FOCUS LIKE',  { x:'9%', y:'7%', w:'100%', color:'FFFFFF', fontFace:'Avenir 85 Heavy', fontSize:25 });
                                                                                                                                                                    slide.addImage({ data:img.src, x:0.2, y:1, w:6.1, h:2.5 });
                                                                                                                                                                    slide.addImage({ path:img7.src, x:"67%", y:"18%", w:"28%", h:"42%" });

                                                                                                                                                                    //sixième page TOP POST
                                                                                                                                                                    slide = pptx.addSlide();
                                                                                                                                                                    slide.addImage({ path:img3.src, x:0, y:0, w:10, h:0.8 });
                                                                                                                                                                    slide.addText('TOP POST',  { x:'9%', y:'7%', w:'100%', color:'FFFFFF', fontFace:'Avenir 85 Heavy', fontSize:25 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: 'TOP REACH', options: {}}
                                                                                                                                                                        ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'55%', y:'17%', w:2.2, h:0.4, fill:'0088CC', line:'006699', lineSize:2 , fontSize:13, color:'FFFFFF'});
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: 'TOP INTERACTION*', options: {}}
                                                                                                                                                                        ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'55%', y:'25%', w:2.2, h:0.4, fill:'0088CC', line:'006699', lineSize:2 , fontSize:13, color:'FFFFFF'});
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: 'Date du post : ', options: {bold:true}},
                                                                                                                                                                            { text: maDate, options: {}}
                                                                                                                                                                        ],  { x:'55%', y:'35%', w:'100%', color:'000000', fontSize:15 });
                                                                                                                                                                    slide.addText('Thème : ',  { x:'55%', y:'40%', w:'100%', color:'000000', fontSize:15 });
                                                                                                                                                                    slide.addText('Format : ',  { x:'55%', y:'45%', w:'100%', color:'000000', fontSize:15 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (listpost.posts.data[numPost].reactions.summary.total_count == "" ? '0' : listpost.posts.data[numPost].reactions.summary.total_count), options: {}},
                                                                                                                                                                            { text: ' Réactions', options: {bold:true}}
                                                                                                                                                                        ],  { x:'55%', y:'50%', w:'100%', color:'000000', fontSize:15 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (listpost.posts.data[numPost].comments.summary.total_count == "" ? '0' : listpost.posts.data[numPost].comments.summary.total_count), options: {}},
                                                                                                                                                                            { text: ' Commentaires', options: {bold:true}}
                                                                                                                                                                        ],  { x:'55%', y:'55%', w:'100%', color:'000000', fontSize:15 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (sharesPost == "" ? '0' : sharesPost), options: {}},
                                                                                                                                                                            { text: ' Partages', options: {bold:true}}
                                                                                                                                                                        ],  { x:'55%', y:'60%', w:'100%', color:'000000', fontSize:15 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (clicsDuPost == "" ? '0' : clicsDuPost.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")), options: {}},
                                                                                                                                                                            { text: ' Clics', options: {bold:true}}
                                                                                                                                                                        ],  { x:'55%', y:'65%', w:'100%', color:'000000', fontSize:15 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (meilleurReach == "" ? '0' : meilleurReach.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")), options: {}},
                                                                                                                                                                            { text: ' Personnes atteintes', options: {bold:true}}
                                                                                                                                                                        ],  { x:'55%', y:'70%', w:'100%', color:'0088CC', fontSize:15 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: tauxReaction, options: {}},
                                                                                                                                                                            { text: '% Taux d\'interaction', options: {bold:true}}
                                                                                                                                                                        ],  { x:'55%', y:'75%', w:'100%', color:'000000', fontSize:15 });

                                                                                                                                                                    slide.addImage({ data:dataUrl1, x:"10%", y:"18%", w:"40%", h:"65%" });

                                                                                                                                                                    //septième page TOP 3 (taux d'interaction)
                                                                                                                                                                    slide = pptx.addSlide();
                                                                                                                                                                    slide.addImage({ path:img3.src, x:0, y:0, w:10, h:0.8 });
                                                                                                                                                                    slide.addText('TOP 3',  { x:'9%', y:'7%', w:'100%', color:'FFFFFF', fontFace:'Avenir 85 Heavy', fontSize:25 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: 'Top intéraction', options: {}}
                                                                                                                                                                        ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'25%', y:'4%', w:2.5, h:0.3, fill:'0088CC', line:'006699', lineSize:2 , fontSize:15, color:'FFFFFF'});
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: 'Date du post : ', options: {bold:true}},
                                                                                                                                                                            { text: maDateTaux1, options: {}}
                                                                                                                                                                        ],  { x:'5%', y:'60%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText('Thème : ',  { x:'5%', y:'64%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText('Format : ',  { x:'5%', y:'68%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (listpost.posts.data[numTaux1].reactions.summary.total_count == "" ? '0' : listpost.posts.data[numTaux1].reactions.summary.total_count), options: {}},
                                                                                                                                                                            { text: ' Réactions', options: {bold:true}}
                                                                                                                                                                        ],  { x:'5%', y:'72%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (listpost.posts.data[numTaux1].comments.summary.total_count == "" ? '0' : listpost.posts.data[numTaux1].comments.summary.total_count), options: {}},
                                                                                                                                                                            { text: ' Commentaires', options: {bold:true}}
                                                                                                                                                                        ],  { x:'5%', y:'76%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (sharesPostTaux1 == "" ? '0' : sharesPostTaux1), options: {}},
                                                                                                                                                                            { text: ' Partages', options: {bold:true}}
                                                                                                                                                                        ],  { x:'5%', y:'80%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (clicTaux1 == "" ? '0' : clicTaux1.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")), options: {}},
                                                                                                                                                                            { text: ' Clics', options: {bold:true}}
                                                                                                                                                                        ],  { x:'5%', y:'84%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (reachTaux1 == "" ? '0' : reachTaux1.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")), options: {}},
                                                                                                                                                                            { text: ' Personnes atteintes', options: {bold:true}}
                                                                                                                                                                        ],  { x:'5%', y:'88%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: taux1.toFixed(2), options: {}},
                                                                                                                                                                            { text: '% Taux d\'interaction', options: {bold:true}}
                                                                                                                                                                        ],  { x:'5%', y:'92%', w:'100%', color:'0088CC', fontSize:10 });

                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: 'Date du post : ', options: {bold:true}},
                                                                                                                                                                            { text: maDateTaux2, options: {}}
                                                                                                                                                                        ],  { x:'40%', y:'60%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText('Thème : ',  { x:'40%', y:'64%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText('Format : ',  { x:'40%', y:'68%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (listpost.posts.data[numTaux2].reactions.summary.total_count == "" ? '0' : listpost.posts.data[numTaux2].reactions.summary.total_count), options: {}},
                                                                                                                                                                            { text: ' Réactions', options: {bold:true}}
                                                                                                                                                                        ],  { x:'40%', y:'72%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (listpost.posts.data[numTaux2].comments.summary.total_count == "" ? '0' : listpost.posts.data[numTaux2].comments.summary.total_count), options: {}},
                                                                                                                                                                            { text: ' Commentaires', options: {bold:true}}
                                                                                                                                                                        ],  { x:'40%', y:'76%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (sharesPostTaux2 == "" ? '0' : sharesPostTaux2), options: {}},
                                                                                                                                                                            { text: ' Partages', options: {bold:true}}
                                                                                                                                                                        ],  { x:'40%', y:'80%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (clicTaux2 == "" ? '0' : clicTaux2.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")), options: {}},
                                                                                                                                                                            { text: ' Clics', options: {bold:true}}
                                                                                                                                                                        ],  { x:'40%', y:'84%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (reachTaux2 == "" ? '0' : reachTaux2.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")), options: {}},
                                                                                                                                                                            { text: ' Personnes atteintes', options: {bold:true}}
                                                                                                                                                                        ],  { x:'40%', y:'88%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: taux2.toFixed(2), options: {}},
                                                                                                                                                                            { text: '% Taux d\'interaction', options: {bold:true}}
                                                                                                                                                                        ],  { x:'40%', y:'92%', w:'100%', color:'0088CC', fontSize:10 });

                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: 'Date du post : ', options: {bold:true}},
                                                                                                                                                                            { text: maDateTaux3, options: {}}
                                                                                                                                                                        ],  { x:'75%', y:'60%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText('Thème : ',  { x:'75%', y:'64%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText('Format : ',  { x:'75%', y:'68%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (listpost.posts.data[numTaux3].reactions.summary.total_count == "" ? '0' : listpost.posts.data[numTaux3].reactions.summary.total_count), options: {}},
                                                                                                                                                                            { text: ' Réactions', options: {bold:true}}
                                                                                                                                                                        ],  { x:'75%', y:'72%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (listpost.posts.data[numTaux3].comments.summary.total_count == "" ? '0' : listpost.posts.data[numTaux3].comments.summary.total_count), options: {}},
                                                                                                                                                                            { text: ' Commentaires', options: {bold:true}}
                                                                                                                                                                        ],  { x:'75%', y:'76%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (sharesPostTaux3 == "" ? '0' : sharesPostTaux3), options: {}},
                                                                                                                                                                            { text: ' Partages', options: {bold:true}}
                                                                                                                                                                        ],  { x:'75%', y:'80%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (clicTaux3 == "" ? '0' : clicTaux3.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")), options: {}},
                                                                                                                                                                            { text: ' Clics', options: {bold:true}}
                                                                                                                                                                        ],  { x:'75%', y:'84%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (reachTaux3 == "" ? '0' : reachTaux3.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")), options: {}},
                                                                                                                                                                            { text: ' Personnes atteintes', options: {bold:true}}
                                                                                                                                                                        ],  { x:'75%', y:'88%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: taux3.toFixed(2), options: {}},
                                                                                                                                                                            { text: '% Taux d\'interaction', options: {bold:true}}
                                                                                                                                                                        ],  { x:'75%', y:'92%', w:'100%', color:'0088CC', fontSize:10 });

                                                                                                                                                                    slide.addImage({ data:dataUrl12, x:"5%", y:"18%", w:"22%", h:"39%" });
                                                                                                                                                                    slide.addImage({ data:dataUrl3, x:"40%", y:"18%", w:"22%", h:"39%" });
                                                                                                                                                                    slide.addImage({ data:dataUrl4, x:"75%", y:"18%", w:"22%", h:"39%" });
                                                                                                                                                                    
                                                                                                                                                                    
                                                                                                                                                                    //huitième page TOP 3 (personnes atteintes)
                                                                                                                                                                    slide = pptx.addSlide();
                                                                                                                                                                    slide.addImage({ path:img3.src, x:0, y:0, w:10, h:0.8 });
                                                                                                                                                                    slide.addText('TOP 3',  { x:'9%', y:'7%', w:'100%', color:'FFFFFF', fontFace:'Avenir 85 Heavy', fontSize:25 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: 'Top reach', options: {}}
                                                                                                                                                                        ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'25%', y:'4%', w:2.5, h:0.3, fill:'0088CC', line:'006699', lineSize:2 , fontSize:15, color:'FFFFFF'});
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: 'Date du post : ', options: {bold:true}},
                                                                                                                                                                            { text: maDateReach1, options: {}}
                                                                                                                                                                        ],  { x:'5%', y:'60%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText('Thème : ',  { x:'5%', y:'64%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText('Format : ',  { x:'5%', y:'68%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (listpost.posts.data[numReach1].reactions.summary.total_count == "" ? '0' : listpost.posts.data[numReach1].reactions.summary.total_count), options: {}},
                                                                                                                                                                            { text: ' Réactions', options: {bold:true}}
                                                                                                                                                                        ],  { x:'5%', y:'72%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (listpost.posts.data[numReach1].comments.summary.total_count == "" ? '0' : listpost.posts.data[numReach1].comments.summary.total_count), options: {}},
                                                                                                                                                                            { text: ' Commentaires', options: {bold:true}}
                                                                                                                                                                        ],  { x:'5%', y:'76%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (sharesPostReach1 == "" ? '0' : sharesPostReach1), options: {}},
                                                                                                                                                                            { text: ' Partages', options: {bold:true}}
                                                                                                                                                                        ],  { x:'5%', y:'80%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (clicReach1 == "" ? '0' : clicReach1.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")), options: {}},
                                                                                                                                                                            { text: ' Clics', options: {bold:true}}
                                                                                                                                                                        ],  { x:'5%', y:'84%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (reach1 == "" ? '0' : reach1.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")), options: {}},
                                                                                                                                                                            { text: ' Personnes atteintes', options: {bold:true}}
                                                                                                                                                                        ],  { x:'5%', y:'88%', w:'100%', color:'0088CC', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: tauxReach1.toFixed(2), options: {}},
                                                                                                                                                                            { text: '% Taux d\'interaction', options: {bold:true}}
                                                                                                                                                                        ],  { x:'5%', y:'92%', w:'100%', color:'000000', fontSize:10 });

                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: 'Date du post : ', options: {bold:true}},
                                                                                                                                                                            { text: maDateReach2, options: {}}
                                                                                                                                                                        ],  { x:'40%', y:'60%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText('Thème : ',  { x:'40%', y:'64%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText('Format : ',  { x:'40%', y:'68%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (listpost.posts.data[numReach2].reactions.summary.total_count == "" ? '0' : listpost.posts.data[numReach2].reactions.summary.total_count), options: {}},
                                                                                                                                                                            { text: ' Réactions', options: {bold:true}}
                                                                                                                                                                        ],  { x:'40%', y:'72%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (listpost.posts.data[numReach2].comments.summary.total_count == "" ? '0' : listpost.posts.data[numReach2].comments.summary.total_count), options: {}},
                                                                                                                                                                            { text: ' Commentaires', options: {bold:true}}
                                                                                                                                                                        ],  { x:'40%', y:'76%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (sharesPostReach2 == "" ? '0' : sharesPostReach2), options: {}},
                                                                                                                                                                            { text: ' Partages', options: {bold:true}}
                                                                                                                                                                        ],  { x:'40%', y:'80%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (clicReach2 == "" ? '0' : clicReach2.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")), options: {}},
                                                                                                                                                                            { text: ' Clics', options: {bold:true}}
                                                                                                                                                                        ],  { x:'40%', y:'84%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (reach2 == "" ? '0' : reach2.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")), options: {}},
                                                                                                                                                                            { text: ' Personnes atteintes', options: {bold:true}}
                                                                                                                                                                        ],  { x:'40%', y:'88%', w:'100%', color:'0088CC', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: tauxReach2.toFixed(2), options: {}},
                                                                                                                                                                            { text: '% Taux d\'interaction', options: {bold:true}}
                                                                                                                                                                        ],  { x:'40%', y:'92%', w:'100%', color:'000000', fontSize:10 });

                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: 'Date du post : ', options: {bold:true}},
                                                                                                                                                                            { text: maDateReach3, options: {}}
                                                                                                                                                                        ],  { x:'75%', y:'60%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText('Thème : ',  { x:'75%', y:'64%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText('Format : ',  { x:'75%', y:'68%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (listpost.posts.data[numReach3].reactions.summary.total_count == "" ? '0' : listpost.posts.data[numReach3].reactions.summary.total_count), options: {}},
                                                                                                                                                                            { text: ' Réactions', options: {bold:true}}
                                                                                                                                                                        ],  { x:'75%', y:'72%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (listpost.posts.data[numReach3].comments.summary.total_count == "" ? '0' : listpost.posts.data[numReach3].comments.summary.total_count), options: {}},
                                                                                                                                                                            { text: ' Commentaires', options: {bold:true}}
                                                                                                                                                                        ],  { x:'75%', y:'76%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (sharesPostReach3 == "" ? '0' : sharesPostReach3), options: {}},
                                                                                                                                                                            { text: ' Partages', options: {bold:true}}
                                                                                                                                                                        ],  { x:'75%', y:'80%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (clicReach3 == "" ? '0' : clicReach3.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")), options: {}},
                                                                                                                                                                            { text: ' Clics', options: {bold:true}}
                                                                                                                                                                        ],  { x:'75%', y:'84%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (reach3 == "" ? '0' : reach3.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")), options: {}},
                                                                                                                                                                            { text: ' Personnes atteintes', options: {bold:true}}
                                                                                                                                                                        ],  { x:'75%', y:'88%', w:'100%', color:'0088CC', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: tauxReach3.toFixed(2), options: {}},
                                                                                                                                                                            { text: '% Taux d\'interaction', options: {bold:true}}
                                                                                                                                                                        ],  { x:'75%', y:'92%', w:'100%', color:'000000', fontSize:10 });

                                                                                                                                                                    slide.addImage({ data:dataUrl5, x:"5%", y:"18%", w:"22%", h:"39%" });
                                                                                                                                                                    slide.addImage({ data:dataUrl6, x:"40%", y:"18%", w:"22%", h:"39%" });
                                                                                                                                                                    slide.addImage({ data:dataUrl7, x:"75%", y:"18%", w:"22%", h:"39%" });


                                                                                                                                                                    //neuvième page FLOP POST
                                                                                                                                                                    slide = pptx.addSlide();
                                                                                                                                                                    slide.addImage({ path:img3.src, x:0, y:0, w:10, h:0.8 });
                                                                                                                                                                    slide.addText('FLOP POST',  { x:'9%', y:'7%', w:'100%', color:'FFFFFF', fontFace:'Avenir 85 Heavy', fontSize:25 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: 'Flop reach', options: {}}
                                                                                                                                                                        ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'35%', y:'4%', w:2.5, h:0.3, fill:'0088CC', line:'006699', lineSize:2 , fontSize:15, color:'FFFFFF'});
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: 'Date du post : ', options: {bold:true}},
                                                                                                                                                                            { text: maDateDernierReach1, options: {}}
                                                                                                                                                                        ],  { x:'5%', y:'60%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText('Thème : ',  { x:'5%', y:'64%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText('Format : ',  { x:'5%', y:'68%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (listpost.posts.data[numDernierReach1].reactions.summary.total_count == "" ? '0' : listpost.posts.data[numDernierReach1].reactions.summary.total_count), options: {}},
                                                                                                                                                                            { text: ' Réactions', options: {bold:true}}
                                                                                                                                                                        ],  { x:'5%', y:'72%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (listpost.posts.data[numDernierReach1].comments.summary.total_count == "" ? '0' : listpost.posts.data[numDernierReach1].comments.summary.total_count), options: {}},
                                                                                                                                                                            { text: ' Commentaires', options: {bold:true}}
                                                                                                                                                                        ],  { x:'5%', y:'76%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (sharesPostDernierReach1 == "" ? '0' : sharesPostDernierReach1), options: {}},
                                                                                                                                                                            { text: ' Partages', options: {bold:true}}
                                                                                                                                                                        ],  { x:'5%', y:'80%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (clicDernierReach1 == "" ? '0' : clicDernierReach1), options: {}},
                                                                                                                                                                            { text: ' Clics', options: {bold:true}}
                                                                                                                                                                        ],  { x:'5%', y:'84%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (dernierReach1 == "" ? '0' : dernierReach1.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")), options: {}},
                                                                                                                                                                            { text: ' Personnes atteintes', options: {bold:true}}
                                                                                                                                                                        ],  { x:'5%', y:'88%', w:'100%', color:'0088CC', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: tauxDernierReach1.toFixed(2), options: {}},
                                                                                                                                                                            { text: '% Taux d\'interaction', options: {bold:true}}
                                                                                                                                                                        ],  { x:'5%', y:'92%', w:'100%', color:'000000', fontSize:10 });

                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: 'Date du post : ', options: {bold:true}},
                                                                                                                                                                            { text: maDateDernierReach2, options: {}}
                                                                                                                                                                        ],  { x:'40%', y:'60%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText('Thème : ',  { x:'40%', y:'64%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText('Format : ',  { x:'40%', y:'68%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (listpost.posts.data[numDernierReach2].reactions.summary.total_count == "" ? '0' : listpost.posts.data[numDernierReach2].reactions.summary.total_count), options: {}},
                                                                                                                                                                            { text: ' Réactions', options: {bold:true}}
                                                                                                                                                                        ],  { x:'40%', y:'72%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (listpost.posts.data[numDernierReach2].comments.summary.total_count == "" ? '0' : listpost.posts.data[numDernierReach2].comments.summary.total_count), options: {}},
                                                                                                                                                                            { text: ' Commentaires', options: {bold:true}}
                                                                                                                                                                        ],  { x:'40%', y:'76%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (sharesPostDernierReach2 == "" ? '0' : sharesPostDernierReach2), options: {}},
                                                                                                                                                                            { text: ' Partages', options: {bold:true}}
                                                                                                                                                                        ],  { x:'40%', y:'80%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (clicDernierReach2 == "" ? '0' : clicDernierReach2), options: {}},
                                                                                                                                                                            { text: ' Clics', options: {bold:true}}
                                                                                                                                                                        ],  { x:'40%', y:'84%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (dernierReach2 == "" ? '0' : dernierReach2.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")), options: {}},
                                                                                                                                                                            { text: ' Personnes atteintes', options: {bold:true}}
                                                                                                                                                                        ],  { x:'40%', y:'88%', w:'100%', color:'0088CC', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: tauxDernierReach2.toFixed(2), options: {}},
                                                                                                                                                                            { text: '% Taux d\'interaction', options: {bold:true}}
                                                                                                                                                                        ],  { x:'40%', y:'92%', w:'100%', color:'000000', fontSize:10 });

                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: 'Date du post : ', options: {bold:true}},
                                                                                                                                                                            { text: maDateDernierReach3, options: {}}
                                                                                                                                                                        ],  { x:'75%', y:'60%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText('Thème : ',  { x:'75%', y:'64%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText('Format : ',  { x:'75%', y:'68%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (listpost.posts.data[numDernierReach3].reactions.summary.total_count == "" ? '0' : listpost.posts.data[numDernierReach3].reactions.summary.total_count), options: {}},
                                                                                                                                                                            { text: ' Réactions', options: {bold:true}}
                                                                                                                                                                        ],  { x:'75%', y:'72%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (listpost.posts.data[numDernierReach3].comments.summary.total_count == "" ? '0' : listpost.posts.data[numDernierReach3].comments.summary.total_count), options: {}},
                                                                                                                                                                            { text: ' Commentaires', options: {bold:true}}
                                                                                                                                                                        ],  { x:'75%', y:'76%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (sharesPostDernierReach3 == "" ? '0' : sharesPostDernierReach3), options: {}},
                                                                                                                                                                            { text: ' Partages', options: {bold:true}}
                                                                                                                                                                        ],  { x:'75%', y:'80%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (clicDernierReach3 == "" ? '0' : clicDernierReach3), options: {}},
                                                                                                                                                                            { text: ' Clics', options: {bold:true}}
                                                                                                                                                                        ],  { x:'75%', y:'84%', w:'100%', color:'000000', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: (dernierReach3 == "" ? '0' : dernierReach3.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")), options: {}},
                                                                                                                                                                            { text: ' Personnes atteintes', options: {bold:true}}
                                                                                                                                                                        ],  { x:'75%', y:'88%', w:'100%', color:'0088CC', fontSize:10 });
                                                                                                                                                                    slide.addText([
                                                                                                                                                                            { text: tauxDernierReach3.toFixed(2), options: {}},
                                                                                                                                                                            { text: '% Taux d\'interaction', options: {bold:true}}
                                                                                                                                                                        ],  { x:'75%', y:'92%', w:'100%', color:'000000', fontSize:10 });

                                                                                                                                                                    slide.addImage({ data:dataUrl8, x:"5%", y:"18%", w:"22%", h:"39%" });
                                                                                                                                                                    slide.addImage({ data:dataUrl9, x:"40%", y:"18%", w:"22%", h:"39%" });
                                                                                                                                                                    slide.addImage({ data:dataUrl10, x:"75%", y:"18%", w:"22%", h:"39%" });

                                                                                                                                                                    //dixième page CONCLUSION
                                                                                                                                                                    slide = pptx.addSlide();
                                                                                                                                                                    slide.addImage({ path:img3.src, x:0, y:0, w:10, h:0.8 });
                                                                                                                                                                    slide.addText('CONCLUSION',  { x:'9%', y:'7%', w:'100%', color:'FFFFFF', fontFace:'Avenir 85 Heavy', fontSize:25 });

                                                                                                                                                                    //onxième page CONCLUSION ET RECOMMANDATIONS
                                                                                                                                                                    slide = pptx.addSlide();
                                                                                                                                                                    slide.addImage({ path:img3.src, x:0, y:0, w:10, h:0.8 });
                                                                                                                                                                    slide.addText('CONCLUSION ET RECOMMANDATIONS',  { x:'9%', y:'7%', w:'100%', color:'FFFFFF', fontFace:'Avenir 85 Heavy', fontSize:25 });

                                                                                                                                                                    //douzième page FIN
                                                                                                                                                                    slide = pptx.addSlide();
                                                                                                                                                                    slide.addImage({ path:img4.src, x:0, y:0, w:'100%', h:'100%' });
                                                                                                                                                                    slide.addText('Merci',  { x:'35%', y:'40%', w:3, color:'FFFFFF', align: 'center', fontFace:'Avenir 85 Heavy', fontSize:35 });
                                                                                                                                                                    
                                                                                                                                                                    $("#progress_selectionne").val("100");

                                                                                                                                                                    //on enregistre le powerpoint
                                                                                                                                                                    pptx.writeFile('bilan-reporting');
                                                                                                                                                                }).catch(function (error) {
                                                                                                                                                                    console.error('oops, something went wrong!', error);
                                                                                                                                                                });
                                                                                                                                                                //fin du 2eme domtoimage
                                                                                                                                                                
                                                                                                                                                            }).catch(function (error) {
                                                                                                                                                                console.error('oops, something went wrong!', error);
                                                                                                                                                            });
                                                                                                                                                            //fin du 1er domtoimage
                                                                                                                                                        });
                                                                                                                                                        //fin de html2canvas
                                                                                                                                                        
                                                                                                                                                    //debut convertion image
                                                                                                                                                    });
                                                                                                                                                });
                                                                                                                                            });
                                                                                                                                        });
                                                                                                                                    });
                                                                                                                                });
                                                                                                                            });
                                                                                                                            
                                                                                                                        });
                                                                                                                    });
                                                                                                                });
                                                                                                                //fin convertion image

                                                                                                                
                                                                                                                
                                                                                                                
                                                                                                            }
                                                                                                            //fin du if de dernière boucle


                                                                                                        }
                                                                                                    }
                                                                                                );
                                                                                                //fin de l'ajax récupérant les reach etc

                                                                                            }
                                                                                            //fin boucle for
                                                                                                        



                                                                                        }
                                                                                        //fin function
                                                                                    }
                                                                                );
                                                                                //fin de l'ajax de récupération de fans par page

                                                                            }else{
                                                                                $("#progress_selectionne").val("0");
                                                                                $( "#erreur" ).addClass( "erreur" );
                                                                                $('#erreur').html("Aucun post a été retrouvé entre ces deux dates !");
                                                                            }
                                                                        }
                                                                        //fin function
                                                                    }
                                                                );
                                                                //fin de l'ajax de récupération de commentaire etc

                                                            }else{
                                                                $("#progress_selectionne").val("0");
                                                                $( "#erreur" ).addClass( "erreur" );
                                                                $('#erreur').html("Aucun activité a été détecté entre ces deux dates !");
                                                            }
                                                        }else{
                                                            $("#progress_selectionne").val("0");
                                                            $( "#erreur" ).addClass( "erreur" );
                                                            $('#erreur').html("Serveur indisponible ! Veuillez réessayer plus tard ou reliez votre compte à l'application");
                                                        }

                                                    }
                                                    //fin function
                                                }
                                            );
                                            //fin de l'ajax de récupération des fans de pages par mois

                                        }else{
                                            $("#progress_selectionne").val("0");
                                            $( "#erreur" ).addClass( "erreur" );
                                            $('#erreur').html("Serveur indisponible ! Veuillez réessayer plus tard ou reliez votre compte à l'application");
                                        }
                                    }
                                    //fin function
                                }
                            );
                            //fin de l'ajax de récupération du token

                        }else{
                            $("#progress_selectionne").val("0");
                            $( "#erreur" ).addClass( "erreur" );
                            if(Difference_In_Days <= 30){
                                $("#erreur").html("La différence entre les dates n'est pas assez élevé, la différence doit être de 1 mois minimum");
                            }else{
                                $("#erreur").html("La différence entre les dates est trop élevé, la différence ne doit pas dépasser 3 mois");
                            }
                        }

                    });
                    //fin du .click()
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