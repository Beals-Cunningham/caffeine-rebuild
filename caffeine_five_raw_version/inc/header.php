
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
if ($url[1] != null && $url[1] != "") {
    $url = $url[0];
    $parameters = $url[1];
}
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
}


?>


<!DOCTYPE html>
<html lang="en">

<head>

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
    <base href="http://locahost/caffeine_five_raw_version/" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

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
    <link rel="stylesheet" href="css/hamburgers.css">


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