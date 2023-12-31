<?php
class stihl_equipment
{
    function page($page)
    {
        include('inc/config.php');
        $a = $data->query("SELECT * FROM stihl_equipment WHERE title = '$page'") or die($data->error);
        if ($a->num_rows > 0) {

            $obj = $a->fetch_array();
            $title = str_replace('_', ' ', $obj["title"]);
            $outTitleSub = $obj["sub_title"];

            $bullets = $obj["bullet_points"];

            $html .= '<!--modal begin-->
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Request a Quote</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    {form}Request_Quote{/form}
                </div>
                
            </div>
        </div>
    </div>
    <!--end modal nothing to see here-->';

            $html .= '<!-- Modal -->
    <div class="modal fade" id="myModalEqRV" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Review For ' . $title . '</h4>
                </div>
                <div class="modal-body">
                
                    <form class="review-form" id="revieweq" name="revieweq" onsubmit="return false">
                    <div class="alert alert-success">
                <p><strong>Writing guidelines</strong><br>
<p>We want to publish your review, so please:</p>


<p>Keep your review focused on the product -
Avoid writing about customer service; contact us instead if you have issues requiring immediate attention -
Refrain from mentioning competitors or the specific price you paid for the product -
Do not allow children to operate, ride on or play near equipment</p>
</div>
                    <label>Rating</label><br>
                        <input class="form-control" type="text" name="rating_rv" id="rating_rv" class="rating" data-size="sm" data-step="1" data-theme="krajee-fa" value="1"><br>
                       <label>Full Name</label><br>
                        <input class="form-control" type="text" name="full_name_rv" id="full_name_rv" value="" required><br>
                        <label>Review Title</label><br>
                        <input class="form-control" type="text" name="title_rv" id="title_rv" value="" required><br>

                        <label>Email</label><br>
                        
                        <input class="form-control" type="text" name="email_rv" id="email_rv" value="" required><br>
<label>Your Review</label><br>
                        <textarea class="form-control" name="review_rv" id="review_rv"></textarea><br>
                        <input type="hidden" name="eqid_review" id="eqid_review" value="' . $obj["id"] . '">
                        <input type="hidden" name="eqiptype" id="eqiptype" value="stihl">
                        
                        <button class="btn btn-success">Submit Review</button>
                    </form>
                </div>
                
            </div>
        </div>
    </div>';


            $price = str_replace('*', '', $obj["price"]);

            if ($obj["quick_links_active"] == 'true') {

                $optLinks = json_decode($obj["opt_links"], true);


                for ($l = 0; $l <= count($optLinks); $l++) {
                    if ($l == 0) {
                    } else {
                        if ($optLinks[$l]["LinkUrl"] != '' && $optLinks[$l]["LinkText"] != 'Request a Demo') {
                            $optLinksOut .= '<a class="optlinks" href="' . $optLinks[$l]["LinkUrl"] . '">' . $optLinks[$l]["LinkText"] . ' <i class="fa fa-angle-right" aria-hidden="true"></i></a>';
                        }
                    }
                }

            } else {
                $optLinksOut = '';
            }


            ///$image = 'img/' . $obj["eq_image"];
            $imageMain = json_decode($obj["eq_image"],true);
            $image = $imageMain[0];

            //$features = $obj["features"];

            $bulletsOut = json_decode($bullets, true);

            $bullethtml .= '<ul>';

            foreach ($bulletsOut as $bull) {
                $bullethtml .= '<li>' . $bull . '</li>';
            }

            $bullethtml .= '</ul>';

            $html .= '<div class="row" style="margin-top:147px;">';


            $html .= '<div class="col-md-8" style="padding:0"><img style="width:40%;display:block; margin:0px auto;" src="img/Stihl/' . $image . '"></div>';

            if ($obj["msrp"] != null) {
                $msrp = "M.S.R.P Pricing <br><strong style=\"font-size: 24px\">$" . $obj["msrp"] . '</strong><br><br>';
            } else {
                $msrp = '';
            }


            if ($price != null) {
                $priceOut = '<span>SELLING PRICE:<br><strong style="font-size: 24px">$' . $price . '</strong></span><br>';
            } else {
                $priceOut = '';
            }

            $url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

            $page = substr($url, strrpos($url, '/') + 1);

            if (isset($_COOKIE["savedData"])) {
                $theSessionOut = json_decode($_COOKIE["savedData"], true);
                for ($i = 0; $i < count($theSessionOut); $i++) {
                    if ($title == $theSessionOut[$i]["machine"]["name"]) {
                        $saveFlag = true;
                    }
                }

            }

            if ($price != null) {
                if (isset($saveFlag)) {
                    $saveButton = '<!--<button class="btn btn-default" disabled>Added To Cart!</button>-->';
                } else {
                    $saveButton = '<!--<button class="btn btn-default save-later" data-eqid="' . $obj["id"] . '" data-eqname="' . $page . '" data-eqtype="stihl" data-price="' . str_replace(",", "", $price) . '" data-url="' . $url . '"><i class="fa fa-shopping-cart"></i> Add To Cart</button>-->';
                }
            } else {
                $saveButton = '';
            }

            $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";


            $tt = str_replace('-', ' ', $title);
            $html .= '<div class="col-md-4"><h1 class="big-stihl-title eq_title">' . $tt . '<br><span class="sub-h1">' . $outTitleSub . '</span></h1><br> <button class="btn btn-success moreinfo parts-button" style="background-color:#FF7900; border-color: #FF7900; "data-url="'.$actual_link.'" data-equipment="Stihl - '.$title.'" data-toggle="modal" data-target="#exampleModal">Request A Quote</button>' . $saveButton . '<br><br>
<!-- AddToAny BEGIN -->
<div class="a2a_kit a2a_kit_size_32 a2a_default_style">
<a class="a2a_dd" href="https://www.addtoany.com/share"></a>
<a class="a2a_button_facebook"></a>
<a class="a2a_button_twitter"></a>
<a class="a2a_button_google_plus"></a>
<a class="a2a_button_email"></a>
</div>

<script async src="https://static.addtoany.com/menu/page.js"></script>
<!-- AddToAny END --><br><br><div style="font-size:30px">' . $starsNow . ' <br>' . $readRevs . ' <a style="font-size: 12px" href="javascript:void(0)" class="reviewit" data-neweqids="' . $obj["id"] . '"></a></div><br><br>' . $optLinksOut . '<br><br><div class="offer-titles-set"></div></div>';

            $html .= '<div class="clearfix"></div><br>';

            $html .= '<div class="container spec-contain">';

            $html .= '<h1 style="background: #F26729; padding: 10px; color: #fff; display: block">Features</h1>';


            $html .= str_replace('description hidden','description',preg_replace('#<a.*?>.*?</a>#i', '', $obj["features"]));

            $html .= '</div>';

            $html .= '<div class="clearfix"></div>';

            if ($obj["extra_content"] != '') {
                $html .= '<div class="col-md-12 extra-content">' . $obj["extra_content"] . '</div>';
                $html .= '<div class="clearfix"></div><br>';
            }

            //$html .= $features;

            if ($obj["videos_active"] == 'true') {

                //YOUTUBE VIDEOS OUTPUT//

                $videosTitle = '';
                $videos = json_decode($obj["videos"], true);

                ///var_dump($videos);


                if (!empty($videos)) {

                    if (count($videos) > 1) {

                        $firstVid = str_replace(' ', '', $videos[0]["Youtube"]["Id"]);


                        $html .= '<div class="video-container" style="background: #333;">';
                        ///$html .= '<h2 style="color: #fff; padding: 25px">' . $videosTitle . '</h2>';
                        $html .= '<div class="col-md-12" style="padding: 0">';
                        $html .= '<div class="vidoverall" style="padding:20px; display:none;"><button type="btn" class="close close-vids" style="padding:10px"><i class="fa fa-times"></i> Close</button><div class="clearfix"></div><div class="embed-responsive embed-responsive-16by9"><iframe id="stihlvids" class="embed-responsive-item" src="https://www.youtube.com/embed/' . $firstVid . '?rel=0" allowfullscreen></iframe></div></div>';
                        $html .= '</div>';
                        $html .= '<div class="col-md-12" style="padding: 0; text-align: center">';
                        $html .= '<div class="vid-list-header" style="font-size: 30px; font-weight:bold">Videos</div>';
                        $html .= '<div style="width:100%; overflow-x:scroll">';


                        for ($vd = 0; $vd <= count($videos); $vd++) {
                            $lastTime = $this->getDaysUpdate($obj["last_updated"]);
                            $videoOuput = trim(preg_replace('/[\x00-\x1F\x7F\xA0]/u', "", $videos[$vd]["Youtube"]["Id"]));
                            $lastTime = $this->getDaysUpdate($obj["last_updated"]);
                            if ($lastTime > 10) {
                                $headers = $this->get_headers_curl('https://www.youtube.com/oembed?format=json&url=http://www.youtube.com/watch?v=' . str_replace(' ', '', $videoOuput));


                                if ($headers == true) {
                                    $validVid = true;
                                } else {
                                    $validVid = false;
                                }
                                if (str_replace(' ', '', $videoOuput) != null && $validVid == true) {

                                    $html .= '<div class="vid-thumb vidshow" data-vidlink="' . str_replace(' ', '', $videoOuput) . '"><img style="width:100%; padding: 5px; border:solid thin yellow" src="https://img.youtube.com/vi/' . $videoOuput . '/hqdefault.jpg"></div>';
                                    $vidOut[] = str_replace(' ', '', $videoOuput);


                                }
                            } else {
                                $vidOut = '';
                            }
                        }


                        if (!empty($vidOut)) {
                            $vids = json_encode($vidOut);
                            ///echo "This is ". $vids;
                            $data->query("UPDATE stihl_equipment SET video_storage = '" . $data->real_escape_string($vids) . "' WHERE id = '" . $obj["id"] . "'") or die($data->error) or die($data->error);
                        } else {
                            $spillVid = json_decode($obj["video_storage"], true);
                            foreach ($spillVid as $vidout) {
                                $html .= '<div class="vid-thumb vidshow" data-vidlink="' . str_replace(' ', '', $vidout) . '"><img style="width:100%; padding: 5px; border:solid thin yellow" src="https://img.youtube.com/vi/' . $vidout . '/hqdefault.jpg"></div>';
                            }
                        }

                    } else {
                        $firstVid = $videos["Youtube"]["Id"];

                        $html .= '<div class="video-container" style="background: #333;">';
                        $html .= '<h2 style="color: #fff; padding: 25px">' . $videosTitle . '</h2>';
                        $html .= '<div class="col-md-12" style="padding: 0">';
                        $html .= '<div class="embed-responsive embed-responsive-16by9"><iframe id="stihlvids" class="embed-responsive-item" src="https://www.youtube.com/embed/' . $firstVid . '?rel=0" allowfullscreen></iframe></div>';
                        $html .= '</div>';
                        $html .= '<div class="col-md-12" style="padding: 0; text-align: center">';
                        $html .= '<div class="vid-list-header">More Videos</div>';
                        $html .= '<div style="width:100%; overflow-x:scroll">';
                        $html .= '<div class="vid-thumb vidshow" data-vidlink="' . str_replace(' ', '', $firstVid) . '"><img style="width:100%; padding: 5px; border:solid thin yellow" src="https://img.youtube.com/vi/' . $firstVid . '/hqdefault.jpg"></div>';
                    }
                    $html .= '</div>';
                    $html .= '</div>';
                    $html .= '<div class="clearfix"></div>';
                    $html .= '</div>';

                }
                //END VIDEOS//
            }


            $specLink = $obj["specs"];

if($specLink!= NULL) {
    $html .= '<div class="col-md-12 spec-contain">';

    //$html .= '<h1>Specs</h1>';

    $html .= '<div class="table-responsive table table-striped">';
    //$html .= $specLink;

    $html .= '</div>';
    $html .= '</div>';
}

           /// $html .= '<div style="text-align: center"><button class="btn btn-default open-spec" style="margin: 20px"><i class="fa fa-align-left" aria-hidden="true"></i> Show More</button></div>';

            if ($obj["offers_active"] == 'true') {
                //OFFERS START//

                ///get last updated//

                $lastTime = $this->getDaysUpdate($obj["last_updated"]);

                if ($lastTime > 10) {

                    $offers = $this->file_get_contents_curl($obj["offers_link"]);


                    $offerstags = str_replace('<esi:assign name="jsonincludedata">', '', $offers);
                    $offerstags = str_replace('</esi:assign>', '', $offerstags);


                    $offerstags = str_replace('\'', '"', $offerstags);

                    $offersOut = json_decode($offerstags, true);

                    $finnalyOfffers = $offersOut["values"][0]["offers"];

                    $q = 0;
                    foreach ($finnalyOfffers as $offerlink) {

                        $offerLinkClean = str_replace('/html/stihl/us/en/website/', 'en/', $offerlink);
                        $offersLinkNow = 'https://www.stihl.com/' . $offerLinkClean . '/index.json';
                        //echo $offersLinkNow . '<br>';
                        $jsonOffer = $this->file_get_contents_curl($offersLinkNow);
                        $objOffers = json_decode($jsonOffer, true);

                        if (is_array($objOffers) && $objOffers["Page"]["special-offers"]["ESIFragments"] != null) {
                            if (strpos($objOffers["Page"]["special-offers"]["ESIFragments"], 'https://www.stihl.com') !== false) {
                                $jsonOfferOut = $this->file_get_contents_curl($objOffers["Page"]["special-offers"]["ESIFragments"]);
                            } else {
                                $jsonOfferOut = $this->file_get_contents_curl('https://www.stihl.com' . $objOffers["Page"]["special-offers"]["ESIFragments"]);
                            }

                            //var_dump($objOffers["Page"]["special-offers"]["ESIFragments"]);
                            $content = str_replace('srcset="', 'srcset="https://stihl.com', $jsonOfferOut);
                            $content = str_replace('img', 'img style="width:100%"', $content);
                            $offerZ = $content . '<div class="clearfix"></div>';


                            if (strpos($offerZ, 'EXPIRED') !== false) {

                            } else {
                                $offerZZ .= $offerZ . '<div class="clearfix"></div>';
                            }
                        } else {
                            $offerZZ .= '';
                        }
                        $q = 1;

                    }


                    if ($offerZZ != null) {
                        $offerZZa .= '<div class="col-md-12" style="background: #fff">';

                        $offerZZa .= '<h1 class="offers-header">Offers and Discounts</h1>';


                        $offerZZa .= '<div class="offers-holder">';
                        $offerZZa .= $offerZZ;
                        $offerZZa .= '</div>';

                        $offerZZa .= '</div>';

                        ///Store offers in db///

                        $data->query("UPDATE stihl_equipment SET offers_storage = '" . $data->real_escape_string($offerZZa) . "', last_updated = '" . time() . "' WHERE id = '" . $obj["id"] . "'") or die($data->error);

                        $html .= $offerZZa;
                    }
                } else {
                    $html .= $obj["offers_storage"];

                }

                ///OFFERS END///
            }


            if ($obj["access_active"] == 'true') {

                ///START ACCESSORIES//


                $lastTime = $this->getDaysUpdate($obj["last_updated"]);

                if ($lastTime > 30) {
                    if ($obj["accessories"] != 'https://www.stihl.com') {
                        $accessories = $this->file_get_contents_curl($obj["accessories"]);
                        $headers = $this->get_headers_curl($obj["accessories"]);
                        if (strpos($accessories, '404 Error Page') !== false) {
                            $asscor = false;
                        } else {
                            $asscor = true;
                        }
                        if ($asscor == true) {
                            $assOut .= '<div class="clearfix"></div>';
                            $assOut .= '<div class="col-md-12">';
                            $assOut .= '<h2 class="accheader">Accessories and Attachments</h2>';
                            $assOut .= '</div>';
                            $assOut .= '<div class="col-md-12 access-cotainer">';


                            if (is_array($headers) ? preg_match('/^HTTP\\/\\d+\\.\\d+\\s+2\\d\\d\\s+.*$/', $headers[0]) : false) {
                                $validAcc = true;
                            } else {
                                $validAcc = true;
                            }

                            if ($validAcc == true) {
                                $assOut .= $accessories;
                            }

                            $assOut .= '</div>';

                            $assOut .= '<div style="text-align: center"><button class="btn btn-default open-attach" style="margin: 20px"><i class="fa fa-align-left" aria-hidden="true"></i> Show More</button></div>';
                        }
                        // $html .= $obj["Page"]["ESI Include Accessories-Attachments"]["ESIFragments"] . '<br>';

                        //$html .= $obj["Page"]["expandcollapse"]["Section"]["SectionData"]["ESIData"]["ESICategoryData"];

                        $assOut .= '<hr>';

                        $data->query("UPDATE stihl_equipment SET accessories_storage = '" . $data->real_escape_string($assOut) . "', last_updated = '" . time() . "' WHERE id = '" . $obj["id"] . "'") or die($data->error);

                        $html .= $assOut;
                    }
                } else {
                    $html .= $obj["accessories_storage"];
                }


            }



            $html .= '<div class="clearfix"></div>';

//            $html .= '<div class="review-panel" style="padding: 10px; text-align: center; background: #FEDC33; color:#333; margin: 20px"><h2>CUSTOMER REVIEWS</h2></div>';
//
//
//            $fullReviews = $reviewOutty["allreviews"];
//
//            if (!(empty($fullReviews))) {
//
//                for ($rvs = 0; $rvs < count($fullReviews); $rvs++) {
//                    $rating = $fullReviews[$rvs]["rating"];
//                    $comment = $fullReviews[$rvs]["comment"];
//                    $nickname = $fullReviews[$rvs]["nickname"];
//                    $datesub = ucwords(date('M d, Y', $fullReviews[$rvs]["datesub"]));
//
//                    for ($z = 0; $z < $rating; $z++) {
//                        $starsFilledPer .= '<i class="fa fa-star" style="color: #fdda1f"></i>';
//                    }
//
//                    if ($rating < 5) {
//                        $grayPer .= 5 - $rating;
//                    } else {
//                        $grayPer = '0';
//                    }
//
//                    for ($e = 0; $e < $grayPer; $e++) {
//                        $grayStarsPer .= '<i class="fa fa-star" style="color: #e6e6e6"></i>';
//                    }
//
//                    $starsNowPer = $starsFilledPer . $grayStarsPer;
//
//                    $html .= '<div class="" style="padding: 20px; margin: 20px; background: #efefef;"><small style="font-weight: bold;">' . $datesub . '</small><br><h4 style="font-weight: bold;">' . $fullReviews[$rvs]["review_title"] . '</h4><br>' . $starsNowPer . '<br><p>' . $comment . '</p><small style="font-style: italic">' . $nickname . '</small></div>';
//                    $grayPer = 0;
//                    $rating = 0;
//                    $starsFilledPer = '';
//                    $grayStarsPer = '';
//                }
//            } else {
//                $html .= '<div class="" style="padding: 20px; margin: 20px; background: #efefef; text-align: center; font-style: italic">No reviews have been created.</div>';
//            }

            $html .= '</div>';


            $html = '<div class="headermargin marginsept"></div><div class="">' . $html . '</div>';

            //<--END PAGE PROCESS-->//
            $content = array();
            $content[] = array("page_name" => $page, "page_title" => '', "page_content" => $html, "active" => true, "created" => time(), "last_edit" => '', "last_user" => '', "page_lock" => 'none', "page_type" => '', "page_desc" => '', "check_out" => false, "check_out_date" => '', "page_js" => '');

            return $content;
        } else {

            ///HANDLE PRODUCT CATEGORY OUTPUT HERE///

            $a = $data->query("SELECT * FROM stihl_pages WHERE page_name = '$page' AND active = 'true'");


            if($a->num_rows > 0){
                $b = $a->fetch_array();
                $pageTemplate = $b["page_content"];

                $matach = 'equipment_get';

                $categoryOut = preg_replace_callback('#{prodcat}data{/prodcat}#', function($match) use($page){

                    ////RETURN THE CATEGORIES HERE////
                    include('inc/config.php');
                    $a = $data->query("SELECT * FROM stihl_pages WHERE page_name = '$page'");
                    $b = $a->fetch_array();

                    $equip_content = json_decode($b["equipment_content"],true);

                    if($b["page_name"] == "Stihl-Equipment"){
                        $greenText = "Stihl-Equipment";
                    }else{
                        $segments = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
                        $numSegments = count($segments);
                        $greenText = str_replace("-", " ", $segments[$numSegments - 2]);
                    }

                    if($b["page_name"] == "Stihl-Equipment"){
                        $yellowText = "";
                    }else{
                        $yellowText = str_replace("-", " ", $b["page_name"]);
                    }

                    $shareLink = 'mailto:?subject=' . $d['model_number'] . '&body=http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '/' . $itemData[$i]["title"] . '';

                    $catOut .= '<style>
                                        .top-spacer{
                                            height: 56px;
                                            background-color: #fff;
                                            opacity: 0.2;
                                            background: repeating-linear-gradient( -45deg, #efefef, #efefef 10px, #fff 3px, #fff 15px );
                                        }
                                        .green-head{
                                            background: #EB7C16;
                                            color: #fff;
                                            font-size: 1.4rem;
                                            line-height: 1.4rem;
                                            font-weight: 700;
                                        }
                                        .yellow-head{
                                            background: #F2F2F2;
                                            color: #EB7C16;
                                        }
                                        .yellow-head h1{
                                            font-size: 1.4rem;
                                            line-height: 1.4rem;
                                            font-weight: 700;
                                            padding: 0;
                                            margin: 0 0 0 0;
                                            display: inline;
                                            text-transform: capitalize;
                                        }
                                        .element-line:nth-child(odd){
                                            background: #F2F2F2;
                                        }
                                        .text-link{
                                            color: var(--bcss-primary);
                                        }
                                        .title-button{
                                            background: #EB7C16;
                                            font-size: 1.2rem;
                                            display: inline-block;
                                            margin: 0 0 0 0;
                                            border-radius: 10px;
                                            padding: 10px 30px;
                                        }
                                        .view-all{
                                            display: inline-block;
                                            font-size: 1.5rem;
                                            padding: 3px 0;
                                            border-bottom: 2px solid var(--bcss-primary);
                                        }
                                      </style>
                                      <div class="row top-spacer"></div>
                                      <div class="row">
                                        <div class="col-12 col-md-6 col-lg-3 py-3 text-right green-head">
                                            '. $greenText .'
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-9 py-3 yellow-head">
                                            <h1>'. $yellowText .'</h1>
                                        </div>
                                      </div>';


                    for($i=0; $i<count($equip_content); $i++){
                        if($equip_content[$i]["type"] == 'category'){
                            $c = $data->query("SELECT * FROM stihl_pages WHERE page_name = '".$equip_content[$i]["title"]."'");
                            $d = $c->fetch_array();

                            //$prodct = json_decode($d["equipment_content"],true);
                            //$prodct = count($prodct);
                            //$catOut .= '<div class="image-cont col-md-4"><img style="width: 100%" title="'.$page.'" src=" '.$d["cat_img"].'"><br><span>'.str_replace('-',' ', $d["page_name"]).'</span></div>';



                            $catOut .= '<div class="row element-line">
                                                  <div class="col-12 col-md-6 col-lg-3 border-right p-3 d-flex flex-column justify-content-center align-items-center">
                                                    <a class="text-center" href="' . $_SERVER['REQUEST_URI'] . '/' . $equip_content[$i]["title"] . '">
                                                        <img class="img-responsive w-100" src="' . $d["cat_img"] . '" >
                                                    </a>
                                                    <a class="mt-2 mx-auto text-center text-white" href="' . $_SERVER['REQUEST_URI'] . '/' . $equip_content[$i]["title"] . '"><h2 class="title-button text-capitalize">' . str_replace("-", " ", $equip_content[$i]["title"]) . '</h2></a>
                                                  </div>
                                                  <div class="col-12 col-md-6 col-lg-3 border-right p-3 d-flex justify-content-center align-items-center">
                                                    <p class="py-0 my-0">' . $d["page_desc"] . '</p>
                                                  </div>
                                                  <div class="col-12 col-md-6 col-lg-3 border-right p-3 d-flex justify-content-center align-items-center"><div>';
                            $subLinks = json_decode($d["equipment_content"],true);

                            foreach ($subLinks as $el) {
                                if (in_array("product", $el)) {
                                    foreach ($el as $key => $value) {
                                        if ($value != "product" && $value != "category") {
                                            $catOut .= '<a href="' . $_SERVER['REQUEST_URI']. '/' . $equip_content[$i]["title"] . '/' . $value . '" style="text-decoration: none; color: #EB7C16;">' . str_replace("_", " ", $value) . '</a>, ';
                                        }
                                    }
                                }else{
                                    foreach ($el as $key => $value) {
                                        if ($value != "product" && $value != "category") {
                                            $catOut .= '<a href="' . $_SERVER['REQUEST_URI']. '/' . $equip_content[$i]["title"] . '/' . $value . '" class="text-link text-capitalize">' . str_replace("-", " ", $value) . '</a>, ';
                                        }
                                    }
                                }
                            }

                            $catOut .= '</div></div>
                                                  <div class="col-12 col-md-6 col-lg-3 p-3 d-flex flex-column justify-content-center align-items-center">
                                                      <div class="d-inline-block">
                                                        <a href="' . $_SERVER['REQUEST_URI'] . '/' . $equip_content[$i]["title"] . '" class="d-block text-link">
                                                            <h3 class="view-all">VIEW ALL <i class="fa fa-angle-double-right" aria-hidden="true"></i></h3>
                                                        </a>
                                                        <a href="" class="d-block">
                                                            <span class="text-link"><?xml version="1.0" encoding="UTF-8"?><svg id="Layer_2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 12.31" style="width: 1rem; height: 1rem; transform: scale(1.1); margin: 0 3px -0.125rem; fill: var(--bcss-primary);"><g id="Layer_1-2"><path class="cls-1" d="m9.94,9.72c-.58.34-1.33-.07-1.33-.76v-1.58S3.08,6.77,0,12.31C1.23,2.46,6.77,2.46,8.62,2.46V.88c0-.16.04-.31.12-.45.25-.42.79-.56,1.21-.31l5.62,4.04c.13.08.24.18.31.31.25.42.11.96-.31,1.21l-5.62,4.04h0Z"/></g></svg></span>
                                                            <span class="text-link">SHARE</span>
                                                        </a>
                                                    </div>
                                                  </div>
                                              </div>';


                        } else {

                                //HANDLE EQUIPMENT INFO HERE//
                                if ($equip_content[$i]["title"] != null) {
                                    include('inc/config.php');
                                    $c = $data->query("SELECT * FROM stihl_equipment WHERE title = '" . $equip_content[$i]["title"] . "'");
                                    $d = $c->fetch_array();
                                    $imageThumb = json_decode($d["eq_image"], true);
                                    $textCat = $d["title"];
                                    $mainImg = 'https://deere.com' . $imageThumb["ImageThumbnail"];

                                    if ($imageThumb["ImageThumbnail"] != null) {
                                        $mainImg = 'https://deere.com' . $imageThumb["ImageThumbnail"];
                                    } else {
                                        $mainImg = 'https://deere.com' . $imageThumb[0]["ImageThumbnail"];
                                    }
                                    $catOut .= '  <div class="row element-line">
                                                      <div class="col-12 col-md-6 col-lg-3 border-right p-3 d-flex flex-column justify-content-center align-items-center">
                                                        <a class="text-center" href="' . $_SERVER['REQUEST_URI'] . '/' . $equip_content[$i]["title"] . '">
                                                            <img class="img-responsive w-100" src="/img/Stihl/' . $imageThumb[0] . '" >
                                                        </a>
                                                        <a class="mt-2 mx-auto text-center text-white" href="' . $_SERVER['REQUEST_URI'] . '/' . $equip_content[$i]["title"] . '"><h2 class="title-button text-capitalize">' . str_replace("_", " ", $textCat) . '</h2></a>
                                                      </div>
                                                      <div class="col-12 col-md-6 border-right p-3 d-flex justify-content-center align-items-center">
                                                        <p class="py-0 my-0">' . $d["product_overview"] . '</p>
                                                      </div>
                                                      <!--<div class="col-12 col-md-6 col-lg-3 border-right p-3 d-flex justify-content-center align-items-center">
                                                      
                                                      </div>-->
                                                      <div class="col-12 col-md-6 col-lg-3 p-3 d-flex flex-column justify-content-center align-items-center">
                                                          <div class="d-inline-block">
                                                            <a href="' . $_SERVER['REQUEST_URI'] . '/' . $equip_content[$i]["title"] . '" class="d-block text-link">
                                                                <h3 class="view-all">VIEW ALL <i class="fa fa-angle-double-right" aria-hidden="true"></i></h3>
                                                            </a>
                                                            <a href="'.$shareLink.'" class="d-block">
                                                                <span class="text-link"><?xml version="1.0" encoding="UTF-8"?><svg id="Layer_2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 12.31" style="width: 1rem; height: 1rem; transform: scale(1.1); margin: 0 3px -0.125rem; fill: var(--bcss-primary);"><g id="Layer_1-2"><path class="cls-1" d="m9.94,9.72c-.58.34-1.33-.07-1.33-.76v-1.58S3.08,6.77,0,12.31C1.23,2.46,6.77,2.46,8.62,2.46V.88c0-.16.04-.31.12-.45.25-.42.79-.56,1.21-.31l5.62,4.04c.13.08.24.18.31.31.25.42.11.96-.31,1.21l-5.62,4.04h0Z"/></g></svg></span>
                                                                <span class="text-link">SHARE</span>
                                                            </a>
                                                            <a href="" class="d-none">
                                                                <span class="text-link"><?xml version="1.0" encoding="UTF-8"?><svg id="Layer_2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 13.75" style="width: 1rem; height: 1rem; transform: scale(1.1); margin: 0 3px -0.125rem; fill: var(--bcss-primary);"><g id="Layer_1-2"><path class="cls-1" d="m10,0c-1.65,0-3.24.6-4.49,1.68-.96.82-1.65,1.9-1.83,2.98-2.1.46-3.68,2.29-3.68,4.49,0,2.56,2.13,4.6,4.73,4.6h11.13c2.27,0,4.14-1.79,4.14-4.03,0-2.04-1.55-3.71-3.54-3.99-.3-3.22-3.1-5.72-6.46-5.72Zm2.94,8.57l-2.5,2.5c-.24.24-.64.24-.88,0,0,0,0,0,0,0l-2.5-2.5c-.24-.24-.24-.64,0-.89s.64-.24.89,0l1.43,1.43v-4.74c0-.35.28-.62.62-.62s.62.28.62.62v4.74l1.43-1.43c.24-.24.64-.24.89,0s.24.64,0,.89Z"/></g></svg></span>
                                                                <span class="text-link">DOWNLOAD BROCHURE</span>
                                                            </a>
                                                           
                                                          </div>
                                                      </div>
                                                  </div>';
                            }
                        }
                    }

                    return $catOut;
                }, $pageTemplate);

                //$categoryOut = preg_replace_callback('#{prodcat}data{/prodcat}#',"equipment_get", $pageTemplate);

                if (strpos($_SERVER['REQUEST_URI'], 'Used-Equipment') != true) {

                    $css[] = 'inc/mods/stihl_equipment/stihl-output/css/lightslider.css';
                    $css[] = 'inc/mods/stihl_equipment/stihl-output/css/main.css';
                    $css[] = 'inc/mods/stihl_equipment/stihl-output/css/jquery.paginate.css';

                    $js[] = 'inc/mods/stihl_equipment/stihl-output/js/lightslider.js';
                    $js[] = 'inc/mods/stihl_equipment/stihl-output/js/jquery.paginate.js';
                    $js[] = 'inc/mods/stihl_equipment/stihl-output/js/new-output.js';
                    $js[] = 'inc/mods/stihl_equipment/stihl_functions.js';

                    $ars = array("css"=>$css, "js"=>$js);


                    $arsOut = json_encode($ars);

                    //$content[] = array("page_name" => 'CATEGORY PAGE', "page_title" => 'CATEGORY PAGE', "page_content" => $categoryOut, "active" => true, "created" => time(), "last_edit" => '', "last_user" => '', "page_lock" => 'none', "page_type" => '', "page_desc" => '', "check_out" => false, "check_out_date" => '', "page_js" => '', "dependants" => $arsOut);
                    $content[] = array("page_name" => 'CATEGORY PAGE', "page_title" => $b["page_title"], "page_content" => $categoryOut, "active" => true, "created" => time(), "last_edit" => '', "last_user" => '', "page_lock" => 'none', "page_type" => '', "page_desc" => '', "check_out" => false, "check_out_date" => '', "page_js" => '', "dependants" => $arsOut);
                    return $content;
                }
            }else{
                ////DO NOTHING TO RETURN 404////
            }




        }
    }

    function file_get_contents_curl($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    function get_headers_curl($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $data = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($data);
        if (json_last_error() === JSON_ERROR_NONE) {
            return true;
        } else {
            return false;
        }

    }

    function getDaysUpdate($timeout)
    {

        $now = time(); // or your date as well
        $your_date = $timeout;
        $datediff = $now - $your_date;

        return round($datediff / (60 * 60 * 24));

    }

    function getReviews($eqid)
    {

        include('inc/config.php');
        $a = $data->query("SELECT * FROM reveiws WHERE eqipment_link = '$eqid' AND active = 'true' AND approved = 'true'");
        while ($b = $a->fetch_array()) {
            $nickName = explode(' ', $b["name"]);
            $nickName = $nickName[0] . substr($nickName[1], 0, 1);
            $rate[] = array("rating" => $b["reveiw_stars"], "review_title" => $b["review_title"], "comment" => $b["review_text"], "nickname" => $nickName, "datesub" => $b["date_submited"]);
        }

        for ($i = 0; $i <= count($rate); $i++) {
            if ($rate[$i]["rating"] == 1) {
                $one[] = 1;
            }
            if ($rate[$i]["rating"] == 2) {
                $two[] = 1;
            }
            if ($rate[$i]["rating"] == 3) {
                $three[] = 1;
            }
            if ($rate[$i]["rating"] == 4) {
                $four[] = 1;
            }
            if ($rate[$i]["rating"] == 5) {
                $five[] = 1;
            }
        }


        $theRatings = (count($one) + count($two) * 2 + count($three) * 3 + count($four) * 4 + count($five) * 5) / count($rate);
        return array("overallrating" => round($theRatings), "allreviews" => $rate);
    }

}