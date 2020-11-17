<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Nautilus Social Manager - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php
            include 'sidebar.php'
        ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php
                    include 'navbar.php'
                ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>
                    <?php
                        if (empty($listePagesFB)) {
                            echo `
                            <div class="alert alert-danger" role="alert">
                                Veuillez lier votre compte Facebook <a href="index.php?a=l">ici</a>
                            </div>`;
                        }
                    ?>
                    
                    <!-- Content Row -->
                    <div class="row">
                        <!-- Facebook -->
                        <div class="col-md-6 mb-4">
                            <div class="card border-left-primary shadow py-2 ">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Liste page Facebook</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fab fa-facebook-square fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                    <?php
                                    if (empty($listePagesFB)) {
                                        echo 'Aucune page Facebook trouvé';
                                    } else {
                                        echo '<ul class="list">';
                                        foreach ($listePagesFB as $pageFB) {
                                            echo '<li class="list-item">'.$pageFB['nom'].'</li>';
                                        }
                                        echo '</ul>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <!-- Instagram -->
                        <div class="col-md-6 mb-4">
                            <div class="card border-left-warning shadow py-2 ">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Liste page Instagram</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fab fa-instagram fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                    <?php
                                        if (empty($listePagesInsta)) {
                                            echo 'Aucune page instagram trouvé';
                                        } else {
                                            echo '<ul class="list">';
                                            foreach ($listePagesInsta as $pageInsta) {
                                                echo '<li class="list-item">'.$pageInsta['nom'].'</li>';
                                            }
                                            echo '</ul>';
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
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
        include 'footer.php';
    ?>
    <!-- Logout Modal-->
    <?php
        include 'modalDeconnexion.php'
    ?>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>
</html>