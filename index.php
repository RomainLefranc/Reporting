<?php

session_start();

require_once __DIR__ . '/Facebook/autoload.php';

$navigations = array (
    ['action' => "c",    "NiveauAcces" => 0,  "controller" => "c_connexion",                      "view" => "v_connexion"            ],
    ['action' => "a",    "NiveauAcces" => 1,  "controller" => "c_admin",                          "view" => "v_admin"                ],
    ['action' => "l",    "NiveauAcces" => 1,  "controller" => "c_lier",                           "view" => "v_lier"                 ],
    ['action' => "d",    "NiveauAcces" => 1,  "controller" => "c_deconnexion",                    "view" => ""                       ],
    /* Instagram */
    ['action' => "ib",   "NiveauAcces" => 1,  "controller" => "instagram/c_instagram_bilan",      "view" => "instagram/v_bilan"      ],
    ['action' => "icsv", "NiveauAcces" => 1,  "controller" => "instagram/c_instagram_csv",        "view" => "instagram/v_csv"        ],
    ['action' => "ie",   "NiveauAcces" => 1,  "controller" => "instagram/c_instagram_exporter",   "view" => "instagram/v_exporter"   ],
    ['action' => "if",   "NiveauAcces" => 1,  "controller" => "instagram/c_instagram_comparatif", "view" => "instagram/v_comparatif" ],
    ['action' => "ir",   "NiveauAcces" => 1,  "controller" => "instagram/c_instagram_rapport",    "view" => "instagram/v_rapport"    ],
    /* Facebook */
    ['action' => "fb",   "NiveauAcces" => 1,  "controller" => "facebook/c_facebook_bilan",        "view" => "facebook/v_bilan"       ],
    ['action' => "fcsv", "NiveauAcces" => 1,  "controller" => "facebook/c_facebook_csv" ,         "view" => "facebook/v_csv"         ],
    ['action' => "fe",   "NiveauAcces" => 1,  "controller" => "facebook/c_facebook_exporter" ,    "view" => "facebook/v_exporter"    ],
    ['action' => "ff",   "NiveauAcces" => 1,  "controller" => "facebook/c_facebook_comparatif" ,  "view" => "facebook/v_comparatif"  ],
    ['action' => "fr",   "NiveauAcces" => 1,  "controller" => "facebook/c_facebook_rapport" ,     "view" => "facebook/v_rapport"     ]
);


if (isset($_GET["a"])) {
    $actionEstValide = false;

    $action = htmlspecialchars($_GET["a"]);
    $action = strtolower($action);

    foreach ($navigations as $navigation) {
        if ($navigation["action"] == $action) {
            $actionEstValide = true;
            switch ($navigation['NiveauAcces']) {
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
    header("location: index.php?a=c");
}
?>