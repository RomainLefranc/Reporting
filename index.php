<?php

session_start();

require_once __DIR__ . '/Facebook/autoload.php';

$navigations = array (
    [          'action' => "c",       "acces" => 0,     "controller" => "c_connexion",                        "view" => "v_connexion"            ],
    [          'action' => "a",       "acces" => 1,     "controller" => "c_admin",                            "view" => "v_admin"                ],
    [          'action' => "l",       "acces" => 1,     "controller" => "c_lier",                             "view" => "v_lier"                 ],
    [          'action' => "d",       "acces" => 1,     "controller" => "c_deconnexion",                      "view" => ""                       ],
    /* Instagram */
    [          'action' => "ib",      "acces" => 1,     "controller" => "instagram/c_instagram_bilan",        "view" => "instagram/v_bilan"      ],
    [          'action' => "icsv",    "acces" => 1,     "controller" => "instagram/c_instagram_csv",          "view" => "instagram/v_csv"        ],
    [          'action' => "ie",      "acces" => 1,     "controller" => "instagram/c_instagram_exporter",     "view" => "instagram/v_exporter"   ],
    [          'action' => "if",      "acces" => 1,     "controller" => "instagram/c_instagram_comparatif",   "view" => "instagram/v_comparatif" ],
    /* Facebook */
    [          'action' => "fb",      "acces" => 1,     "controller" => "facebook/c_facebook_bilan",          "view" => "facebook/v_bilan"       ],
    [          'action' => "fcsv",    "acces" => 1,     "controller" => "facebook/c_facebook_csv" ,           "view" => "facebook/v_csv"         ],
    [          'action' => "fe",      "acces" => 1,     "controller" => "facebook/c_facebook_exporter" ,      "view" => "facebook/v_exporter"    ],
    [          'action' => "ff",      "acces" => 1,     "controller" => "facebook/c_facebook_comparatif" ,    "view" => "facebook/v_comparatif"  ]
);

$actionEstValide = false;
if (isset($_GET["a"])) {
    $action = htmlspecialchars($_GET["a"]);
    $action = strtolower($action);

    foreach ($navigations as $navigation) {
        if ($navigation["action"] == $action) {
            $actionEstValide = true;
            switch ($navigation['acces']) {
                case 0:
                    $acces = 'Public';
                    break;
                case 1:
                    $acces = 'Admin';
                    break;
            }
            $controller = $navigation['controller'];
            $view = $navigation['view'];
            include 'controller/controller'.$acces.'.php';
            include 'view/view'.$acces.'.php';
            
        }
    }
    if (!$actionEstValide) {
        include "view/public/v_404.php";
    }
} else {
    header("location: index.php?a=C");
}
?>