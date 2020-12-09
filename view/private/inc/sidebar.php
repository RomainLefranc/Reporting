<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php?a=a">
        <div class="sidebar-brand-icon">
            <img src="images\44767108_2196185164002161_3379978518505979904_n.jpg" class="rounded img-fluid" width='45' height='45' >
        </div>
        <div class="sidebar-brand-text mx-3">Nautilus</div>
    </a>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="index.php?a=a">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Tableau de bord</span>
        </a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fab fa-facebook-square"></i>
            <span>Facebook</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Facebook :</h6>
                <a class="collapse-item" href="index.php?a=fr">Rapport</a>
                <a class="collapse-item" href="index.php?a=ff">Fan et Followers</a>
                <a class="collapse-item" href="index.php?a=fb">Bilan</a>
                <a class="collapse-item" href="index.php?a=fe">Export PPTX</a>
                <a class="collapse-item" href="index.php?a=fcsv">Export CSV</a>
            </div>
        </div>
    </li>
    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fab fa-instagram"></i>
            <span>Instagram</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Instagram :</h6>
                <a class="collapse-item" href="index.php?a=ir">Rapport</a>
                <a class="collapse-item" href="index.php?a=if">Fan et Followers</a>
                <a class="collapse-item" href="index.php?a=ib">Bilan</a>
                <a class="collapse-item" href="index.php?a=ie">Export PPTX</a>
                <a class="collapse-item" href="index.php?a=icsv">Export CSV</a>
            </div>
        </div>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">Options</div>
    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="index.php?a=l"><i class="fas fa-fw fa-chart-area"></i><span>Lier un compte</span></a>
    </li>
    <?php
    if ($username == "admin") {
        echo '
            <li class="nav-item">
                <a class="nav-link" href="index.php?a=ga"><i class="fas fa-fw fa-chart-area"></i><span>Administration</span></a>
            </li>
        ';
    }
    ?>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>