<?php

session_start();
include('siteFunctions.php');
$info = new site();
$url = $_SERVER['REQUEST_URI'];


$page = substr($url, strrpos($url, '/') + 1);


//URL PAR PATCH///
$trueParems = explode('?', $page);
if ($trueParems[0] != null) {
    $page = $trueParems[0];
} else {
    $page = $page;
}
$url = explode('?', $url);
$url = $url[0];
$parameters = $url[1];
//$_SERVER['REQUEST_URI'] = $url;
if (isset($page) && $page != 'index.php' && $page != '' && $url != '/') {
    $page =  $page;
    //$page = substr($url, strrpos($page, '/') + 1);
} else {
    $page = 'Home';
}




$pageDetails = $info->getpageDetails($page);


$dependants = json_decode($pageDetails[0]["dependants"], true);



if (!(empty($pageDetails))) {
    ///OUTPUT THE PAGE DATA//
} else {
    header('Location: Home');
    //include('404.html');
    exit();
    echo $_SERVER['REQUEST_URI'];
}

//echo "THis is ".$_REQUEST["parems"];


//echo $_SERVER['REQUEST_URI'];
///DO NOT REMOVE SITE TRACKER CODE BELOW - BECAUSE IT HELP THE DASHBOARD WORK ;)///
//include('site_tracker.php');


////Your access to and use of BrightEdge AutoPilot - Self Connecting Pages is governed by the
////Infrastructure Product Terms located at: www.brightedge.com/infrastructure-product-terms.
////Customer acknowledges and agrees it has read, understands and agrees to be bound by the
////Infrastructure Product Terms.
//
////BE IXF: save the be_ixf_client.php file to your server, then use "require" to include it in your template.
//require 'be_ixf_client.php';
//
//use BrightEdgeBEIXFClient;
//
////BE IXF: the following array and constructor must be placed before any HTML is written to the page.
//$be_ixf_config = array(
//    BEIXFClient::$CAPSULE_MODE_CONFIG => BEIXFClient::$REMOTE_PROD_CAPSULE_MODE,
//    BEIXFClient::$ACCOUNT_ID_CONFIG => "f00000000289970",
//
//    BEIXFClient::$API_ENDPOINT_CONFIG => "https://ixfd1-api.bc0a.com",
//    //BEIXFClient::$CANONICAL_HOST_CONFIG => "www.domain.com",
//    //BEIXFClient::$CANONICAL_PROTOCOL_CONFIG  => "https",
//
//    // BE IXF: By default, all URL parameters are ignored. If you have URL parameters that add value to
//    // page content.  Add them to this config value, separated by the pipe character (|).
//    BEIXFClient::$WHITELIST_PARAMETER_LIST_CONFIG => "ixf",
//
//);
//$be_ixf = new BEIXFClient($be_ixf_config);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <script async src='https://tag.simpli.fi/sifitag/c96ef880-28a5-013b-5aad-0cc47a8ffaac'></script>
    <meta charset="utf-8">
    <?php
    include('inc/tracking.php');
    ?>

    <?php
    ///CORE CAFFEINE TITLE & SITE DESCRIPTION GRAB DO NOT REMOVE///
    $pagename = $pageDetails[0]["title"];
    if ($pagename == 'index.php') {
        $pagename = 'Home';
    } else {
        $pagename = $page;
    }

    $title = $info->getPageTitle($pagename);
    $pageDesc = $info->getPageDesc($pagename);
    $cores = $info->coreItems();

    if ($pageDetails[0]["page_title"] != '') {
        $title = $pageDetails[0]["page_title"];
    } else {
        if ($title != '') {
            $title = $title;
        } else {
            $title = $pagename;
        }
    }

    if ($pageDetails[0]["page_desc"] != '') {
        $site_description = $pageDetails[0]["page_desc"];
    } else {
        if ($pageDesc != '') {
            $site_description = $pageDesc;
        } else {
            if ($cores["site_description"] != '') {
                $site_description = $cores["site_description"];
            } else {
                $site_description = '';
            }
        }
    }




    if ($cores["site_keywords"] != '' && $pagename == 'Home') {
        $keywordsOut = '<meta name="keywords" content="' . $cores["site_keywords"] . '">';
    }
    //create canonical link
    $canonical = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    ?>

    <!--    <base href="http://192.168.100.153/Caff5.0/" />-->
    <base href="https://sunsouth.com/" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
    //BE Head: place getHeadOpen just inside of the HTML head, used for to append SEO-related header elements.
    // print $be_ixf->getHeadOpen();
    ?>
    <title><?php echo str_replace('-', ' ', $title); ?></title>
    <meta name="description" content="<?php echo $site_description; ?>">
    <?php echo $keywordsOut; ?>
    <link rel="canonical" href="<?php echo $canonical; ?>" />
    <link rel="preload" as="style" href="https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" as="style" href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.0/css/ion.rangeSlider.min.css" onload="this.onload=null;this.rel='stylesheet'">
    <link href="https://fonts.googleapis.com/css?family=Kaushan+Script&display=swap" rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css" rel="stylesheet">
    <!-- Adobe Font -->
    <link rel="stylesheet" href="https://use.typekit.net/bjm3uul.css">
    <link rel="stylesheet" href="css/navigation.css">


    <?php
    ///CORE CAFFEINE ELEMENTS DO NOT REMOVE THIS///
    $dependenciescss = $info->loadBeanDepscss();
    for ($i = 0; $i < count($dependenciescss); $i++) {
        echo '<link href="' . $dependenciescss[$i]["file"] . '" rel="stylesheet">' . PHP_EOL;
    }
    ?>

    <?php
    $depCss = $dependants["css"];

    foreach ($depCss as $cssKey) {
        echo '<link rel="stylesheet" href="' . $cssKey . '">' . PHP_EOL;
    }
    ?>
    <link rel="stylesheet" href="css/styles.css">


    <?php
    ///HAD TO DO THIS BECAUSE SOME SERVERS HATE ME AND HAVE INSTALLED MOD_SECURITY ON THEIR APACHE///
    include('htmlshivrequest.php');
    ?>


    <?php
    ///CAFFEINE GOOGLE ANALYTICS OUTPUT FUNCTION DO NOT REMOVE///
    if ($cores["google_analytics"] != '') {
        echo $cores["google_analytics"];
    }
    ?>

    <style>
        
    </style>

</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W9DZGX4" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <?php
    $savers = $info->getSaves();
    ?>
    <div class="wrapper" id="main">
        <header>
            <nav class="navbar top-nav justify-content-end align-items-center">
                <ul class="nav-group p-0 m-0 d-flex align-items-center list-unstyled">
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="Locations">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="bi bi-geo-alt-fill filled-with-love d-block" viewBox="0 0 16 16">
                                <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" />
                            </svg>
                            <span class="d-block ml-1 ml-md-2">LOCATIONS</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="https://sunsouth.dealercustomerportal.com/customers/specials">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="bi bi-person-fill filled-with-love d-block" viewBox="0 0 16 16">
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                            </svg>
                            <span class="d-block ml-1 ml-md-2">PORTAL</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center search-toggle" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="bi bi-search filled-with-love d-block" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                            </svg>
                            <span class="d-block ml-1 ml-md-2">SEARCH</span>
                        </a>
                    </li>
                </ul>
                <ul class="nav-group p-0 my-0 ml-5 mr-0 d-none d-md-flex align-items-center list-unstyled">
                    <li class="nav-item mx-2">
                        <a class="nav-link d-flex align-items-center" href="https://www.facebook.com/SunSouthllc">
                            <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-facebook filled-with-love">
                                <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z" />
                            </svg>
                        </a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link d-flex align-items-center" href="https://twitter.com/SunSouthJD">
                            <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-twitter filled-with-love">
                                <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z" />
                            </svg>
                        </a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link d-flex align-items-center" href="https://www.instagram.com/sunsouthjohndeere/">
                            <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-instagram filled-with-love">
                                <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z" />
                            </svg>
                        </a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link d-flex align-items-center" href="https://www.youtube.com/channel/UCcjUp82t6E5tnZVhQfA8X_w">
                            <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-youtube filled-with-love">
                                <path d="M8.051 1.999h.089c.822.003 4.987.033 6.11.335a2.01 2.01 0 0 1 1.415 1.42c.101.38.172.883.22 1.402l.01.104.022.26.008.104c.065.914.073 1.77.074 1.957v.075c-.001.194-.01 1.108-.082 2.06l-.008.105-.009.104c-.05.572-.124 1.14-.235 1.558a2.007 2.007 0 0 1-1.415 1.42c-1.16.312-5.569.334-6.18.335h-.142c-.309 0-1.587-.006-2.927-.052l-.17-.006-.087-.004-.171-.007-.171-.007c-1.11-.049-2.167-.128-2.654-.26a2.007 2.007 0 0 1-1.415-1.419c-.111-.417-.185-.986-.235-1.558L.09 9.82l-.008-.104A31.4 31.4 0 0 1 0 7.68v-.123c.002-.215.01-.958.064-1.778l.007-.103.003-.052.008-.104.022-.26.01-.104c.048-.519.119-1.023.22-1.402a2.007 2.007 0 0 1 1.415-1.42c.487-.13 1.544-.21 2.654-.26l.17-.007.172-.006.086-.003.171-.007A99.788 99.788 0 0 1 7.858 2h.193zM6.4 5.209v4.818l4.157-2.408L6.4 5.209z" />
                            </svg>
                        </a>
                    </li>
                </ul>
            </nav>
            <form id="site-search" name="site-search" action="Search-Results" method="post" style="display: none;">
                <div class="">
                    <input style="width: 100%; padding: 10px; background: #333; border: none; color: #a7a7a7; font-size: 30px; text-align: center; outline: none;" type="text" name="serterm" id="serterm" pattern=".{3,}" title="At least 3 characters" required="" autocomplete="off" placeholder="Search Site..." />
                </div>
                <div style="clear: both;"></div>
            </form>
            <nav class="navbar navbar-expand-xl bottom-nav">
                <a class="navbar-brand desktop" href="#">
                    <img class="img-responsive" src="img/NewDesign/Group 270.png" alt="SunSouth Equipment" style="max-width: 208px;">
                </a>
                <button class="navbar-toggler hamburger hamburger--collapse" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <!--<span class="navbar-toggler-icon"></span>-->
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
                    <ul class="navbar-nav align-items-center list-unstyled">
                        <li class="nav-item active mr-2">
                            <a class="nav-link px-4 bg-secondary" href="Specials">SPECIALS</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-center" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                                NEW EQUIPMENT
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="new-equipment/tractors">TRACTORS</a>
                                <a class="dropdown-item" href="new-equipment/implements">IMPLEMENTS</a>
                                <a class="dropdown-item" href="new-equipment/mowers">MOWERS</a>
                                <a class="dropdown-item" href="new-equipment/gator-utility-vehicles">GATORS</a>
                                <a class="dropdown-item" href="new-equipment/construction">COMPACT CONSTRUCTION</a>
                                <a class="dropdown-item" href="Stihl-Equipment"">STIHL</a>
                        </div>
                    </li>
                    <li class=" nav-item mr-2">
                                    <a class="nav-link" href="Used-Equipment">USED EQUIPMENT</a>
                        </li>
                        <li class="nav-item dropdown mr-2">
                            <a class="nav-link dropdown-toggle text-center" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                                RESOURCES
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="Videos">VIDEOS</a>
                                <a class="dropdown-item" href="Blog">BLOG</a>
                                <a class="dropdown-item" href="Testimonials">TESTIMONIALS</a>
                                <a class="dropdown-item" href="Careers">CAREERS</a>
                                <a class="dropdown-item" href="dealer-transfer-request">TRANSFER</a>

                            </div>
                        </li>
                        <li class="nav-item dropdown mr-2">
                            <a class="nav-link dropdown-toggle text-center" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                                PARTS & SERVICE
                            </a>
                            <div class="dropdown-menu mr-2">
                                <a class="dropdown-item" href="Order-Parts" target="_blank">ORDER PARTS</a>
                                <a class="dropdown-item" href="Schedule-Service">SCHEDULE SERVICE</a>
                            </div>
                        </li>
                        <li class="nav-item mr-2">
                            <a class="nav-link" href="Contact">CONTACT</a>
                        </li>
                        <li class="nav-item d-none d-xl-inline">
                            <a class="nav-link" href="mailto:info@sunsouth.com">
                                <div class="rounded-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-envelope-fill filled-with-love d-block">
                                        <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z" />
                                    </svg>
                                </div>
                            </a>
                        </li>
                        <div class="row justify-content-center d-flex d-xl-none">
                            <a class="nav-link" href="mailto:info@sunsouth.com">
                                <div class="rounded-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-envelope-fill filled-with-love d-block">
                                        <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z" />
                                    </svg>
                                </div>
                            </a>
                        </div>
                    </ul>
                </div>
            </nav>
        </header>

        <?php
        if ($page == 'Home') {
        } else {
            $breakDown = $_SERVER["REQUEST_URI"];
            $url_without_last_part = substr($breakDown, 0, strrpos($breakDown, "/"));
            $breakDown = explode('/', $breakDown);
        ?>

            <nav aria-label="breadcrumb" style="display: none;">
                <ol class="breadcrumb">

                    <?php
                    $theCount = count($breakDown);
                    $p = 1;
                    foreach ($breakDown as $nc) {

                        $chr_pos = strpos($_SERVER["REQUEST_URI"], $nc);
                        $final_chain = substr($_SERVER["REQUEST_URI"], 0, $chr_pos);
                        if ($p == $theCount) {
                            echo '<li class="breadcrumb-item">' . str_replace('_', ' ', $nc) . '</li>';
                        } else {
                            echo '<li class="breadcrumb-item"><a href="' . $final_chain . '' . $nc . '">' . str_replace('_', ' ', $nc) . '</a></li>';
                        }

                        $p++;
                    }
                    ?>
                </ol>
            </nav>
        <?php } ?>

        <?php include('mods/chameleon/tracker.php'); ?>