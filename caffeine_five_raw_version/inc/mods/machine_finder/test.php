<?php

session_start();
include('siteFunctions.php');
$info = new site();
$url = $_SERVER['REQUEST_URI'];


$page = substr($url, strrpos($url, '/') + 1);


//URL PAR PATCH///
$trueParems = explode('?',$page);
if($trueParems[0] != null){
    $page = $trueParems[0];
}else{
    $page = $page;
}
$url = explode('?',$url);
$url = $url[0];
$parameters = $url[1];
//$_SERVER['REQUEST_URI'] = $url;
if(isset($page) && $page != 'index.php' && $page != '' && $url != '/'){
    $page =  $page;
    //$page = substr($url, strrpos($page, '/') + 1);
}else{
    $page = 'Home';
}




$pageDetails = $info->getpageDetails($page);

$dependants = json_decode($pageDetails[0]["dependants"],true);



if(!(empty($pageDetails))){
///OUTPUT THE PAGE DATA//
}else{
    header('Location: Home');
//include('404.html');
    exit();
    echo $_SERVER['REQUEST_URI'];
}

//echo "THis is ".$_REQUEST["parems"];


//echo $_SERVER['REQUEST_URI'];
///DO NOT REMOVE SITE TRACKER CODE BELOW - BECAUSE IT HELP THE DASHBOARD WORK ;)///
//include('site_tracker.php');
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">

        <?php
        ///CORE CAFFEINE TITLE & SITE DESCRIPTION GRAB DO NOT REMOVE///
        $pagename = $pageDetails[0]["title"];
        if($pagename == 'index.php'){
            $pagename = 'Home';
        }else{
            $pagename = $page;
        }

        $title = $info->getPageTitle($pagename);
        $pageDesc = $info->getPageDesc($pagename);
        $cores = $info->coreItems();
        if($title != ''){
            $title = $title;
        }else{
            $title = $pagename;
        }

        if($pageDesc != ''){
            $site_description = $pageDesc;
        }else {
            if ($cores["site_description"] != '') {
                $site_description = $cores["site_description"];
            } else {
                $site_description = '';
            }
        }

        if($cores["site_keywords"] != '' && $pagename == 'Home'){
            $keywordsOut = '<meta name="keywords" content="'.$cores["site_keywords"].'">';
        }
        ?>

        <!--    <base href="http://192.168.100.153/Caff5.0/" />-->
        <base href="http://sunsouth.caffeinerde.com/" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $title; ?></title>
        <meta name="description" content="<?php echo $site_description; ?>">
        <?php echo $keywordsOut; ?>

        <link rel="preload" as="style" href="https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css" onload="this.onload=null;this.rel='stylesheet'">
        <link rel="preload" as="style" href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" onload="this.onload=null;this.rel='stylesheet'">
        <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.0/css/ion.rangeSlider.min.css" onload="this.onload=null;this.rel='stylesheet'">
        <link href="https://fonts.googleapis.com/css?family=Kaushan+Script&display=swap" rel="preload" as="style"onload="this.onload=null;this.rel='stylesheet'">
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css" rel="stylesheet">


        <?php
        ///CORE CAFFEINE ELEMENTS DO NOT REMOVE THIS///
        $dependenciescss = $info->loadBeanDepscss();
        for($i=0;$i<count($dependenciescss);$i++) {
            echo '<link href="'.$dependenciescss[$i]["file"] .'" rel="stylesheet">' . PHP_EOL ;
        }
        ?>

        <?php
        $depCss = $dependants["css"];

        foreach($depCss as $cssKey){
            echo '<link rel="stylesheet" href="'.$cssKey.'">' . PHP_EOL ;
        }
        ?>
        <link rel="stylesheet" href="css/styles.css">


        <?php
        ///HAD TO DO THIS BECAUSE SOME SERVERS HATE ME AND HAVE INSTALLED MOD_SECURITY ON THEIR APACHE///
        include('htmlshivrequest.php');
        ?>


        <?php
        ///CAFFEINE GOOGLE ANALYTICS OUTPUT FUNCTION DO NOT REMOVE///
        if($cores["google_analytics"] != ''){
            echo $cores["google_analytics"];
        }
        ?>
    </head>

<body>

<?php
$savers = $info->getSaves();
?>
<div class="wrapper" id="main">
    <header>
        <div class="containter-fluid upper-nav">
            <div class="row">
                <a class="navbar-brand desktop" href="#" style="position: absolute; z-index: 9999;"><img style="max-width: 300px" src="img/logo.png"></a>
                <div class="col-md-8 col-12 upper-right">

                    <ul class="location-nav">
                        <li><a id="find-loc" class="find-prefer show-location">FIND YOUR PREFERRED LOCATION <i class="fa fa-caret-right"></i></a></li>
                        <li id="location-det" ><?php
                            session_start();
                            if(isset($_SESSION['location'])) {
                                echo $_SESSION['location'];
                            }
                            ?></li>



                    </ul>
                </div>
                <div class="col-md-4 col-6 upper-right">
                    <ul class="upper-right-items hide-social-icons">
                        <li><a class="cust-port-btn" href="https://sunsouth.dealercustomerportal.com/" target="_blank"><img src="img/nav/Customer-Portal-button-604x100.png" style="max-width:150px;"/></a></li>
                        <li><a class="header-link-text" href="Videos" target="_blank">VIDEOS</a></li>
                        <li><a class="header-link-text" href="https://www.instagram.com/sunsouthjohndeere/" target="_blank" style="margin-top: 15px;"><i class="fab fa-instagram"></i></a></li>
                        <li><a class="header-link-text" href="https://www.youtube.com/channel/UCcjUp82t6E5tnZVhQfA8X_w" target="_blank" style="margin-top: 15px;"><i class="fab fa-youtube"></i></a></li>
                        <li><a class="header-link-text" href="https://twitter.com/SunSouthJD" style="margin-top: 15px;"><i class="fab fa-twitter" target="_blank"></i></a></li>
                        <li><a class="header-link-text" href="https://www.facebook.com/SunSouthllc" target="_blank"  style="margin-top: 15px;"><i class="fab fa-facebook"></i></a></li>

                    </ul>
                </div>
            </div>
        </div>

        <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <?php include('inc/usedglobfiliter.php'); ?>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand mobile" href="#" ><img style="max-width: 150px" src="img/logo.png"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                {nav}main{/nav}
            </div>
        </nav>
        <form id="site-search" name="site-search" action="Search-Results" method="post" style="display: none">
            <div class=""><input style="width: 100%;padding: 10px;background: #333;border: none;color: #a7a7a7;font-size: 30px;text-align: center; outline: none;" type="text" name="serterm" id="serterm" pattern=".{3,}" title="At least 3 characters" required autocomplete="off" placeholder="Search Site..."></div>
            <div style="clear: both;"></div>
        </form>

    </header>
    <div id="newsletter"><a target="_blank" href="http://sunsouthconnections.com/subscribe/" rel="noopener"><i class="fas fa-envelope"></i> Subscribe To Newsletter</a></div>

    <!--location modal-->
    <div id="location-finder" class="initiallyHidden">
        <div class="user">
            <label class="visuallyhidden" for="search">Zip Code</label>
            <input name="locationzip" type="text" id="locationzip" value="" placeholder="Zip Code" />
            <input type="submit" onclick="getMylatlong()" class="btn" style="background: #878785; border-radius: 4px; padding-top: 5px; padding-bottom: 5px;" /></div>
        <ul id="locationLocatorDetail">
            <div id="location-detail">

            </div>

        </ul>
        <p class="text-center"><a href="locations" class="btn btn-success">See All Locations</a></p>

    </div>

    <!--modal begin-->
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>



<?php
if($page == 'Home'){

}else{
    $breakDown = $_SERVER["REQUEST_URI"];
    $url_without_last_part = substr($breakDown, 0, strrpos($breakDown, "/"));
    $breakDown = explode('/',$breakDown);
    ?>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">

            <?php
            $theCount = count($breakDown);
            $p=1;
            foreach($breakDown as $nc){

                $chr_pos=strpos($_SERVER["REQUEST_URI"],$nc);
                $final_chain=substr($_SERVER["REQUEST_URI"],0,$chr_pos);
                if($p==$theCount){
                    echo '<li class="breadcrumb-item">'.str_replace('_',' ',$nc).'</li>';
                }else{
                    echo '<li class="breadcrumb-item"><a href="'.$final_chain.''.$nc.'">'.str_replace('_',' ',$nc).'</a></li>';
                }

                $p++;
            }
            ?>
        </ol>
    </nav>
<?php } ?>

<?php include('mods/chameleon/tracker.php'); ?>