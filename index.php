<?php

session_start();

require_once __DIR__ . '/vendor/Facebook/autoload.php';

/* Tableau de parametrage des route */
$navigations = array (
    ['action' => "c",    "acces" => 'private',  "controller" => "c_connexion",                      "view" => "v_connexion"            ],
    ['action' => "a",    "acces" => 'private',  "controller" => "c_admin",                          "view" => "v_admin"                ],
    ['action' => "l",    "acces" => 'private',  "controller" => "c_lier",                           "view" => "v_lier"                 ],
    ['action' => "d",    "acces" => 'private',  "controller" => "c_deconnexion",                    "view" => ""                       ],
    /* Instagram */
    ['action' => "ib",   "acces" => 'private',  "controller" => "instagram/c_instagram_bilan",      "view" => "instagram/v_bilan"      ],
    ['action' => "icsv", "acces" => 'private',  "controller" => "instagram/c_instagram_csv",        "view" => "instagram/v_csv"        ],
    ['action' => "ie",   "acces" => 'private',  "controller" => "instagram/c_instagram_exporter",   "view" => "instagram/v_exporter"   ],
    ['action' => "if",   "acces" => 'private',  "controller" => "instagram/c_instagram_comparatif", "view" => "instagram/v_comparatif" ],
    ['action' => "ir",   "acces" => 'private',  "controller" => "instagram/c_instagram_rapport",    "view" => "instagram/v_rapport"    ],
    /* Facebook */
    ['action' => "fb",   "acces" => 'private',  "controller" => "facebook/c_facebook_bilan",        "view" => "facebook/v_bilan"       ],
    ['action' => "fcsv", "acces" => 'private',  "controller" => "facebook/c_facebook_csv" ,         "view" => "facebook/v_csv"         ],
    ['action' => "fe",   "acces" => 'private',  "controller" => "facebook/c_facebook_exporter" ,    "view" => "facebook/v_exporter"    ],
    ['action' => "ff",   "acces" => 'private',  "controller" => "facebook/c_facebook_comparatif" ,  "view" => "facebook/v_comparatif"  ],
    ['action' => "fr",   "acces" => 'private',  "controller" => "facebook/c_facebook_rapport" ,     "view" => "facebook/v_rapport"     ],
    /* API */
    ['action' => "api",   "acces" => 'public', "controller" => "c_api",                            "view" => "v_api"                  ]
);

if (isset($_GET["a"])) {
    $actionEstValide = false;

    $action = htmlspecialchars($_GET["a"]);
    $action = strtolower($action);

    foreach ($navigations as $navigation) {
        if ($navigation["action"] == $action) {
            $actionEstValide = true;
            $acces = $navigation['acces'];
            $controller = $navigation['controller'];
            $view = $navigation['view'];
            include 'controller/controller_'.$acces.'.php';
            include 'view/view_'.$acces.'.php';
        }
    }
    if (!$actionEstValide) {
        include "view/public/v_404.php";
    }
} else {
    header("location: index.php?a=c");
}
?>