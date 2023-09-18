<?php
class deere_equipment
{


    function page($page)
    {

        include('inc/config.php');

        $a = $data->query("SELECT * FROM deere_equipment WHERE title = '$page'");
        if ($a->num_rows > 0) {
            $b = $a->fetch_array();
            $mainLink = $b["equip_link"];
            $equiplink = $mainLink;


            if ($b["last_updated"] == 0) {
                //UPDATE THE EQUIPMENT DATABASE HERE//
                $arrContextOptions = array(
                    "ssl" => array(
                        "verify_peer" => false,
                        "verify_peer_name" => false,
                    ),
                );

                $originallinkjson = file_get_contents($equiplink, false, stream_context_create($arrContextOptions));

                $decodeprod = json_decode($originallinkjson, true);


                //======META DATA======//
                $metaTitle = $decodeprod["Page"]["MetaData"]["Title"];
                $metaDescription = $decodeprod["Page"]["MetaData"]["Description"];
                $metaKeywords = $decodeprod["Page"]["MetaData"]["Keywords"];
                //======END META DATA======//

                //======OVERVIEW DATA======//
                $overView = $decodeprod["Page"]["product-summary"]["ProductOverview"];
                $productLinks = $decodeprod["Page"]["product-summary"]["OptionalLinks"];
                $productLinksDB = json_encode($productLinks);

                $productCatName = $decodeprod["Page"]["product-summary"]["ProductModelName"];
                $modelNumber = $decodeprod["Page"]["product-summary"]["ProductModelNumber"];
                $price = $decodeprod["Page"]["product-summary"]["ProductPrice"];
                $imageGallery = $decodeprod["Page"]["product-summary"]["ImageGalleryContainer"];
                $imageGalleryDB = json_encode($imageGallery);
                //======END OVERVIEW DATA======//

                //======FEATURES======//
                $featuresLinks = str_replace('.html', '.json', 'https://www.deere.com' . $decodeprod["Page"]["ESI Include Features"]["ESIFragments"]);
                $featuresJSON = file_get_contents($featuresLinks, false, stream_context_create($arrContextOptions));


                //======END FEATURES======//

                //======SPECS======//
                $specLinks = str_replace('.html', '.json', 'https://www.deere.com' . $decodeprod["Page"]["ESI Include Specifications"]["ESIFragments"]);
                $specJSON = file_get_contents($specLinks, false, stream_context_create($arrContextOptions));


                //======END SPECS======//

                //======OFFERS DATA=======//
                $offerlinkform = preg_replace('#[^/]*$#', '', $mainLink) . 'offers-json.html';

                $offers = file_get_contents($offerlinkform, false, stream_context_create($arrContextOptions));



                $offerstags = str_replace('<esi:assign name="jsonincludedata">', '', $offers);
                $offerstags = str_replace('</esi:assign>', '', $offerstags);
                $offerstags = str_replace('\'', '"', $offerstags);
                $offersOut = json_decode($offerstags, true);

                $finnalyOfffers = $offersOut["values"][0]["offers"];
                //======OFFERS DATA END=======//

                //======ACCESSORIES======//
                $accesslink = $decodeprod["Page"]["ESI Include Accessories-Attachments"]["ESIFragments"];
                $accLinkClean = str_replace('/html/deere/us/', '', $accesslink);
                $accLinkCleaner = str_replace('.html', '', $accLinkClean);

                $accLinkNow = 'https://www.deere.com/' . $accLinkCleaner . '.json';
                $accessobj = file_get_contents($accLinkNow, false, stream_context_create($arrContextOptions));



                $accessobjDec = json_decode($accessobj, true);
                //======END ACCESSORIES======//

                //======REVIEWS START========//
                $reviews = $decodeprod["Page"]["reviews-ratings"]["Review"];
                $reviewsDB = json_encode($reviews);
                //======END REVIEWS========//

                //======REVIEWS START========//
                $videos = $decodeprod["Page"]["video-gallery"]["Videos"];

                $videoDB = json_encode($videos);
                //======END REVIEWS========//

                //INSERT INTO DATABASE//
                $data->query("UPDATE deere_equipment SET model_number = '" . $data->real_escape_string($modelNumber) . "', eq_image = '" . $data->real_escape_string($imageGalleryDB) . "', product_overview = '" . $data->real_escape_string($overView) . "', features = '" . $data->real_escape_string($featuresJSON) . "', specs = '" . $data->real_escape_string($specJSON) . "', offers_storage = '" . $data->real_escape_string($offers) . "',accessories_storage = '" . $data->real_escape_string($accessobj) . "', review_rating_storage = '" . $data->real_escape_string($reviewsDB) . "', video_storage = '" . $data->real_escape_string($videoDB) . "', price = '" . $data->real_escape_string($price) . "', meta_title = '" . $data->real_escape_string($metaTitle) . "', meta_description = '" . $data->real_escape_string($metaDescription) . "', meta_keywords = '" . $data->real_escape_string($metaKeywords) . "', product_links = '" . $data->real_escape_string($productLinksDB) . "', last_updated = '" . time() . "' WHERE title = '$page'");
            } else {
                //PULL EQUIPMENT INFO DIRECTLY FROM DB//

                $metaTitle = $b["meta_title"];
                $metaDescription = $b["meta_description"];
                $metaKeywords = $b["meta_keywords"];

                $overView = $b["product_overview"];
                $productLinks = json_decode($b["product_links"], true);
                $productCatName = $b["sub_title"];
                $modelNumber = $b["model_number"];
                $price = $b["price"];
                $imageGallery = $b["eq_image"];
                $extra = $b["extra_content"];

                $featuresJSON = $b["features"];
                $specJSON = $b["specs"];

                $offers = $b["offers_storage"];
                $offerstags = str_replace('<esi:assign name="jsonincludedata">', '', $offers);
                $offerstags = str_replace('</esi:assign>', '', $offerstags);
                $offerstags = str_replace('\'', '"', $offerstags);
                $offersOut = json_decode($offerstags, true);

                $finnalyOfffers = $offersOut["values"][0]["offers"];

                $accessobj = $b["accessories_storage"];
                $accessobjDec = json_decode($accessobj, true);

                $reviews = json_decode($b["review_rating_storage"], true);

                if ($b["video_storage"] != null) {
                    $videos = json_decode($b["video_storage"], true);
                }
            }

            //DO IMAGE THINGS//

            function isJSON($string)
            {
                return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
            }


            if (isJSON($imageGallery)) {
                $imageGallery = json_decode($imageGallery, true);
            } else {
                $imageGallery = $imageGallery;
            }


            if ($imageGallery[0]["ImageLarge"] != null && isset($imageGallery[0]["ImageLarge"])) {
                for ($i = 0; $i < count($imageGallery); $i++) {
                    $eqImage[] = 'https://deere.com' . $imageGallery[$i]["ImageLarge"];
                }
            } else {
                if (isset($imageGallery["ImageLarge"])) {
                    $eqImage[] = 'https://deere.com' . $imageGallery["ImageLarge"];
                } else {
                    $eqImage[] = 'img/' . $imageGallery[0];
                }
            }


            $html .= $metaTitle . '<br>';
            $html .= $metaDescription . '<br>';
            $html .= $metaKeywords . '<br>';

            $html .= $productCatName . '<br>';
            $html .= $modelNumber . '<br>';
            $html .= $overView . '<br>';
            $html .= $price . '<br>';


            $html .= '<h1>FEATURES-SYSTEM</h1>' . $featuresLink . '<br>';

            $html .= '<h1>SPECS-SYSTEM</h1>' . $specLink . '<br>';


            //====START DEERE EQUIPMENT CONTAINER====//
            $htmlOut .= '<div class="deere_equipment_container container-fluid mb-5" style="position: relative; margin-top: 40px;">';

            //====== New Schema.org generator for single product in Deere Equipment ======//
            //* Insert that code under "START DEERE EQUIPMENT CONTAINER" inside first div with class "deere_equipment_container"

            if ($b["price"] != null || $b["dealer_price"] != null) {
                $htmlOut .= '<script type="application/ld+json">{';
                $htmlOut .= '"@context": "https://schema.org",';
                $htmlOut .= '"@type": "Product",';
                $htmlOut .= '"brand": "John Deere",';
                $htmlOut .= '"model": "' . $modelNumber . '",';
                $htmlOut .= '"name": "John Deere ' . $modelNumber . ' ' . $productCatName . '",';
                $htmlOut .= '"category": "' . $productCatName . '",';
                $htmlOut .= '"image": "' . $eqImage[0] . '",';
                $htmlOut .= '"description": "' . str_replace(array('<ul>', '</ul>', '<li>', '</li>', '&dagger;', '"'), array('', '', '', '. ', '', 'inch'), preg_replace('#<a.*?>.*?</a>#i', '', $overView)) . '",';

                if (!empty($reviews)) {
                    $htmlOut .= '"review": [';
                    for ($r = 0; $r < count($reviews); $r++) {
                        $authorName = $reviews[$r]["AuthorName"];
                        $rating = $reviews[$r]["Rating"];
                        $title = $reviews[$r]["Title"];
                        $pros = $reviews[$r]["ProsText"];
                        $cons = $reviews[$r]["ConsText"];

                        $htmlOut .= '{"@type": "Review",';
                        if ($rating != null) {
                            $htmlOut .= '"reviewRating": {"@type": "Rating", "ratingValue": "' . $rating . '", "bestRating": "5"},';
                        }
                        $htmlOut .= '"name": "' . str_replace('"', "'", $title) . '"';
                        if ($authorName != null) {
                            $htmlOut .= ',"author": {"@type": "Person","name": "' . str_replace('"', "'", $authorName) . '"}';
                        } else {
                            $htmlOut .= ',"author": {"@type": "Person","name": "Unnamed Author"}';
                        }
                        if ($pros != null) {
                            $htmlOut .= ',"positiveNotes": {"@type": "ItemList","itemListElement": [';
                            $prosVal = str_replace(array('<ul>', '</ul>', '<li>', '"'), array('', '', '', "'"), $pros);
                            $prosArr = explode("</li>", $prosVal);
                            array_pop($prosArr);
                            //var_dump($prosArr);
                            $countPro = 0;
                            for ($pro = 0; $pro < count($prosArr); $pro++) {
                                if ($pro == count($prosArr) - 1) {
                                    $htmlOut .= '{"@type": "ListItem","position": ' . ++$countPro . ',"name": "' . $prosArr[$pro] . '"}';
                                    //var_dump('{"@type": "ListItem","position": '. $countPro .',"name": "'. $prosArr[$pro] .'"}');
                                } else {
                                    $htmlOut .= '{"@type": "ListItem","position": ' . ++$countPro . ',"name": "' . $prosArr[$pro] . '"},';
                                    //var_dump('{"@type": "ListItem","position": '. $countPro .',"name": "'. $prosArr[$pro] .'"},');
                                }
                            }
                            $htmlOut .= ']}';
                        }
                        if ($cons != null) {
                            $htmlOut .= ',"negativeNotes": {"@type": "ItemList","itemListElement": [';
                            $consVal = str_replace(array('<ul>', '</ul>', '<li>', '"'), array('', '', '', "'"), $cons);
                            $consArr = explode("</li>", $consVal);
                            array_pop($consArr);
                            //var_dump($consArr);
                            $countCon = 0;
                            for ($con = 0; $con < count($consArr); $con++) {
                                if ($con == count($consArr) - 1) {
                                    $htmlOut .= '{"@type": "ListItem","position": ' . ++$countCon . ',"name": "' . $consArr[$con] . '"}';
                                    //var_dump('{"@type": "ListItem","position": '. $countCon .',"name": "'. $consArr[$con] .'"}');
                                } else {
                                    $htmlOut .= '{"@type": "ListItem","position": ' . ++$countCon . ',"name": "' . $consArr[$con] . '"},';
                                    //var_dump('{"@type": "ListItem","position": '. $countCon .',"name": "'. $consArr[$con] .'"},');
                                }
                            }
                            $htmlOut .= ']}';
                        }
                        if ($r == count($reviews) - 1) {
                            $htmlOut .= '}';
                        } else {
                            $htmlOut .= '},';
                        }
                    }
                    $htmlOut .= '],';
                    $agregateTable = [];
                    for ($ag = 0; $ag < count($reviews); $ag++) {
                        if ($reviews[$ag]["Rating"] != '') {
                            array_push($agregateTable, $reviews[$ag]["Rating"]);
                        }
                    }
                    $agregateRating = array_sum($agregateTable) / count($agregateTable);

                    $htmlOut .= '"aggregateRating": {"@type": "AggregateRating","ratingValue": "' . $agregateRating . '","reviewCount": "' . count($agregateTable) . '"},';
                }

                $htmlOut .= '"offers": {"@type": "Offer",';
                if ($b["price"] != null) {
                    $htmlOut .= '"priceCurrency": "USD", "price": "' . str_replace(',', '', $b["price"]) . '",';
                } else if ($b["dealer_price"] != null) {
                    $htmlOut .= '"priceCurrency": "USD", "price": "' . str_replace(',', '', $b["dealer_price"]) . '",';
                } else {
                    $htmlOut .= '';
                }
                $htmlOut .= '"itemCondition": "http://schema.org/NewCondition","availability": "http://schema.org/InStock"}';
                $htmlOut .= '}</script>';
            }
            // ======End of Schema.org generator for single product in Deere Equipment ======//

            $htmlOut .= '<div class="modal" id="exampleModal" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-lg" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title">Request More Info</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">x</span>
                                  </button>
                                </div>
                                <div class="modal-body">';
            if ($b["cat_two"] == 'lawn-tractors') {
                $htmlOut .= '{form}Request_Quote_Lawn_Tractors{/form}';
            } elseif ($b["cat_three"] == 'commercial-zero-turn-ztrak-mowers') {
                $htmlOut .= '{form}Request_Quote_Z900_Series_Mowers{/form}';
            } else {
                $htmlOut .= '{form}New_Equipment_Request{/form}';
            }
            //$htmlOut .= '{form}New_Equipment_Request{/form}';
            $htmlOut .= '</div>
                                <div class="modal-footer">
                                
                                </div>
                              </div>
                            </div>
                          </div>';

            //======START ROW FOR TOP======//
            $htmlOut .= '<div class="row" style="margin: 0 0 20px">';

            //======PROCESS EQ IMAGES======//
            $htmlOut .= '<div class="col-lg-6 col-xl-7">';


            $img = 0;
            foreach ($eqImage as $eqimage) {
                if ($img == 0) {
                    $htmlOut .= '<img style="width:100%; margin-bottom:5px" src="' . $eqimage . '">';
                }
                $img++;
            }

            $htmlOut .= '</div>';
            //====END EQ IMAGES====//

            //======RIGHT COLUMN DETAILS======//

            if ($price != null) {
                //$priceOut = '<br><p class="price_area">Starting At:</p><h5><span class="thedeereprice" style="font-weight: bold; font-size: 22px; font-style: italic;">$' . $price . '</span></h5>';
                $priceOut = '<p class="price_area" style="font-size: 26px;">Starting At:<br><span class="thedeereprice" style="font-size: 36px; font-weight: bold; font-style: italic; color: var(--bcss-secondary);">$' . $price . '</span></p>';
            }


            //attempt brochure equipment link stuff//
            if ($productLinks[1]["LinkText"] != "Find a Dealer" && $productLinks[1]["LinkText"] != "Find Your Dealer") {
                $productLinks = '<a class="mt-3 lmnopqrstuvwxyz" style="font-weight: bold; color: var(--bcss-secondary);" href="' . $productLinks[1]["LinkUrl"] . '" target="_blank">' . $productLinks[1]["LinkText"] . '</a>';
            } else {
                $productLinks = '';
            }
            //$productLinks = '<a class="mt-3 lmnopqrstuvwxyz" style="font-weight: bold; color: var(--bcss-secondary);" href="' . $productLinks[1]["LinkUrl"] . '" target="_blank">' . $productLinks[1]["LinkText"] . '</a>';

            $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

            $financeURL .= ($b["finance_url"] != NULL) ? '<div class="col-md-6"><a id="Apply-For-Financing" href="' . $b["finance_url"] . '" target="_blank" rel="noopener"><button class="btn btn-success w-100 mt-2">APPLY FOR FINANCING <span style="color: var(--bcss-active); font-weight: bold;">>>></span></button></a></div>' : '';

            $builderModels = ["1023E", "1025R", "2025R", "2023R", "3025E", "3038E", "4044M", "4044R", "4052M", "4052R", "4066M", "4066R"];
            for ($i = 0; $i < count($builderModels); $i++) {
                $builderButton .= ($modelNumber == $builderModels[$i]) ? '<div class="col-md-6"><a href="Tractor-Package-Builder"><button class="btn btn-success w-100 mt-2">EQUIPMENT BUILDER <span style="color: var(--bcss-active); font-weight: bold;">>>></span></button></a></div>' : '';
            }


            $htmlOut .= '<div class="col-lg-6 col-xl-5 my-auto">
                            <div class="jumbotron">
                                <h1 class="model_header" style="line-height: .85;">John Deere ' . $modelNumber . '<br><span class="category_type" style="font-size: 26px;"><i>' . $productCatName . '</i></span></h1>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6 my-auto">
                                        <div class="deere_overview">' . preg_replace('#<a.*?>.*?</a>#i', '', $overView) . '</div>
                                    </div>
                                    <div class="col-md-6 my-auto" align="center">
                                        ' . $priceOut . '
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <button id="Request-a-Quote" class="btn btn-success moreinfo w-100 mt-2" data-url="' . $actual_link . '" data-equipment="John Deere - ' . $modelNumber . '" data-toggle="modal" data-target="#exampleModal">REQUEST A QUOTE <span style="color: var(--bcss-active); font-weight: bold;">>>></span></button>
                                    </div>
                                    <div class="col-md-6"><a href="Specials"><button class="btn btn-success w-100 mt-2">CURRENT SPECIALS <span style="color: var(--bcss-active); font-weight: bold;">>>></span></button></a></div>
                                    ' . $builderButton . '
                                </div>
                                <hr>
                                ' . $productLinks . '<br>' . $extra . ' ';

            $htmlOut .= '</div>
                        </div>';

            $htmlOut .= '<div class="col-lg-5 col-xl-5 my-auto d-none">
                            <div class="jumbotron">
                                <h1 class="model_header">John Deere ' . $modelNumber . '</h1>
                                <h4 class="category_type">' . $productCatName . '</h4><br>
                                <div class="deere_overview">' . preg_replace('#<a.*?>.*?</a>#i', '', $overView) . '</div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6 mt-2">
                                        <button id="Request-a-Quote" style="background-color: var(--bcss-secondary);font-family: Roboto, sans-serif; width: 100%; border-color: #367c2b; color: #ffffff; border-width: 3px;" class="btn btn-primary" data-url="' . $actual_link . '" data-equipment="John Deere - ' . $modelNumber . '" data-toggle="modal" data-target="#exampleModal">REQUEST A QUOTE <span style="color: var(--bcss-active);">>>></span></button>
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <a id="Specials" rel="noopener"><button class="btn btn-primary px-3" style="width: 100%; background-color: var(--bcss-secondary); border-color: #367c2b; color: #ffffff; border-width: 3px;">CURRENT SPECIALS <span style="color: var(--bcss-active);">>>></span></button></a>
                                    </div>
                                </div>
                                <div class="row">';
            $builderModels = ["1023E", "1025R", "2025R", "2023R", "3025E", "3038E", "4044M", "4044R", "4052M", "4052R", "4066M", "4066R"];
            foreach ($builderModels as $builderModel) {
                if ($modelNumber = $builderModel) {
                    $htmlOut .= '<div class="col-md-6 mt-2"><a id="Build-Your-Own" href="Equipment-Builder" class="btn btn-primary" style="width: 100%; background-color: var(--bcss-secondary); color: #ffffff; border-width: 3px; border-color: #367c2b;" rel="noopener">BUILD YOUR OWN <span style="color: var(--bcss-active);">>>></span></a></div>';
                }
            }
            if ($b["finance_url"] != NULL) {
                $htmlOut .= '<div class="col-md-6 mt-2"> <a id="Apply-For-Financing" href="' . $b["finance_url"] . '" class="btn btn-primary" style="width: 100%; background-color: var(--bcss-secondary); color: #ffffff; border-width: 3px; border-color: #367c2b;" target="_blank" rel="noopener">APPLY FOR FINANCING <span style="color: var(--bcss-active);">>>></span></a></div>';
            }
            $htmlOut .= '</div>' . $priceOut . ' ' . $extra . ' ' . $productLinks . '</div>
                            <button id="Request-Quote" style="margin-right: 20px; display: none;"class="btn btn-success moreinfo xyz" data-url="' . $actual_link . '" data-equipment="John Deere - ' . $modelNumber . '" data-toggle="modal" data-target="#exampleModal">Request A Quote</button><br>
                            <div class="modal" id="exampleModal" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-lg" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title">Request More Info</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">x</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                </div>
                                <div class="modal-footer">
                                
                                </div>
                              </div>
                            </div>
                          </div></div>';


            //======END RIGHT COLUMN DETAILS======//

            $htmlOut .= '</div>';
            //====END TOP ROW==//

            $accArs = $accessobjDec["Page"]["expandcollapse"]["Section"]["SectionData"];

            $htmlOut .= '<div id="stick-here" style="background: #fff"></div>
                         <div id="stickThis" class="deere_section" style="background: #fff">';
            $htmlOut .= '<div class="container">';
            $htmlOut .= '<ul class="nav nav-pills" style="width: 100%; border-bottom: solid thin #efefef;">';
            $htmlOut .= '<li class="nav-item col-sm-auto"><a class="nav-link active" data-toggle="pill" href="#features" style="width: max-content;height: 100%;">FEATURES</a></li>';
            $htmlOut .= '<li class="nav-item col-sm-auto"><a class="nav-link" data-toggle="pill" href="#specs">SPEC & COMPARE</a></li>';
            //if (!empty($finnalyOfffers)) {$htmlOut .= '<li class="nav-item col-sm-auto"><a class="nav-link" data-toggle="pill" href="#offers">OFFERS & DISCOUNTS</a></li>';}
            $htmlOut .= !empty($finnalyOfffers) ? '<li class="nav-item col-sm-auto"><a class="nav-link" data-toggle="pill" href="#offers">OFFERS & DISCOUNTS</a></li>' : '';
            //$accArs = $accessobjDec["Page"]["expandcollapse"]["Section"]["SectionData"];
            $htmlOut .= !empty($accArs) ? '<li class="nav-item col-sm-auto"><a class="nav-link" data-toggle="pill" href="#accessories">ACCESSORIES & ATTACHMENTS</a></li>' : '';
            //if (!empty($accArs)) {$htmlOut .= '<li class="nav-item col-sm-auto"><a class="nav-link" data-toggle="pill" href="#accessories">ACCESSORIES & ATTACHMENTS</a></li>';}
            $htmlOut .= !empty($reviews) ? '<li class="nav-item col-sm-auto"> <a class="nav-link" data-toggle="pill" href="#reviews" style="width: max-content;height: 100%;">REVIEWS</a></li>' : '';
            //if (!empty($reviews)) {$htmlOut .= '<li class="nav-item col-sm-auto"> <a class="nav-link" data-toggle="pill" href="#reviews" style="width: max-content;height: 100%;">REVIEWS</a></li>';}
            $htmlOut .= !empty($videos) ? '<li class="nav-item col-sm-auto"><a class="nav-link" data-toggle="pill" href="#videos">VIDEOS</a></li>' : '';
            //if (!empty($videos)) {$htmlOut .= '<li class="nav-item col-sm-auto"><a class="nav-link" data-toggle="pill" href="#videos">VIDEOS</a></li>';}
            $htmlOut .= '</ul>';
            $htmlOut .= '</div>';
            $htmlOut .= '</div>';

            //$htmlOut .= '<div class="container">';
            $htmlOut .= '<div class="tab-content">';
            $htmlOut .= '<div class="tab-pane active" id="features">';
            //======START FEATURES AREA ROW======//
            $htmlOut .= '<div class="row " style="margin: 0; padding-top: 20px">';
            $htmlOut .= '<div class="col-md-12">';
            $htmlOut .= '<h2 class="mt-1 mb-1">Features</h2>';
            $htmlOut .= '</div><!--end col-->';
            $htmlOut .= '<div id="accordion" class="w-100">'; //START TAB FEATURES//
            $DeereFeatures = json_decode($featuresJSON, true);
            $deereFetSecs = $DeereFeatures["Page"]["expandcollapse"]["Section"]["SectionData"]["Data"];
            if (count($deereFetSecs) > 2) {
                for ($i = 0; $i < count($deereFetSecs); $i++) {
                    $htmlOut .= '<div class="fetheads" data-toggle="collapse" data-target="#collapse' . $i . '" aria-expanded="true" aria-controls="collapse' . $i . '" style="padding: 10px; background:#efefef"><i class="fas fa-plus"></i> ' . $deereFetSecs[$i]["TitleQuestion"] . '</div>';
                    $htmlOut .= '<div id="collapse' . $i . '" class="collapse fetdets" aria-labelledby="heading' . $i . '" data-parent="#accordion">' . $deereFetSecs[$i]["Description"] . '</div>';
                }
            } else {
                $htmlOut .= '<div class="fetheads" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1" style="padding: 10px; background:#efefef"><i class="fas fa-plus"></i> ' . $deereFetSecs["TitleQuestion"] . '</div>';
                $htmlOut .= '<div id="collapse1" class="collapse fetdets" aria-labelledby="heading1" data-parent="#accordion">' . $deereFetSecs["Description"] . '</div>';
            }
            $htmlOut .= '</div><!--end accord-->';
            $htmlOut .= '</div><!--end row-->';
            //=====END FEATURES AREA ROW=====//
            $specJSONs = json_decode($specJSON, true);
            $htmlOut .= '</div><!--end feature tab-->';
            $htmlOut .= '<div class="tab-pane" id="specs"><!--start spec tab-->';

            ////START TABLE////
            $htmlOut .= '<div class="row " style="margin: 0; padding-top: 20px">';

            $DeereSpecsRelated = $specJSONs["Page"]["specifications"]["RelatedModels"];

            if (!empty($DeereSpecsRelated)) {
                $specSele .= '<small>ADD MODEL</small><select class="form-control" name="compare_select" id="compare_select" style="margin: 0 0 0 auto;">';

                $specSele .= '<option>--Select to Compare--</option>';

                for ($o = 0; $o < count($DeereSpecsRelated); $o++) {
                    if ($DeereSpecsRelated[$o]["Name"]  != null) {
                        $specSele .= '<option value="' . $o . '" data-seleq="' . $page . '">' . $DeereSpecsRelated[$o]["Name"] . '</option>';
                    }
                }

                $specSele .= '</select>';
            }

            $htmlOut .= '<div class="col-sm-6 col-lg-8" style="padding: 0"><h2>Specs & Compare</h2></div><div class="col-sm-6 col-lg-4" style="text-align: right;width: 100%; padding: 0;">' . $specSele . '<br></div>';


            $htmlOut .= '<table class="table specstab">';

            $DeereSpecs = $specJSONs["Page"]["specifications"]["Category"];


            for ($j = 0; $j < count($DeereSpecs); $j++) {
                if ($j == 0) {
                    $htmlOut .= '<tr class="deerets" style="background: #efefef"><td><h4>' . $DeereSpecs[$j]["Name"] . '</h4></td><td><b>' . $modelNumber . '</b><br><small>Current Model</small></td></tr>';
                } else {
                    $htmlOut .= '<tr class="table_head" style="background: #efefef"><td><h4>' . $DeereSpecs[$j]["Name"] . '</h4></td><td></td></tr>';
                }
                $specInside = $DeereSpecs[$j]["Specs"];
                for ($k = 0; $k < count($specInside); $k++) {
                    $htmlOut .= '<tr class="deerets"><td><b>' . $specInside[$k]["Name"] . '</b></td><td>' . $specInside[$k]["CurrentModelDescription"] . '</td></tr>';
                }
            }
            $htmlOut .= '</table>';

            $htmlOut .= '</div>';


            $htmlOut .= '</div><!--end spec tab-->';

            $htmlOut .= '<div class="tab-pane" id="offers"><!--start offers tab-->';

            $htmlOut .= '<h2 style="margin: 20px">Offers & Discounts</h2>';


            $q = 0;
            foreach ($finnalyOfffers as $offerlink) {
                $offerLinkClean = str_replace('/html/deere/us/', '', $offerlink);
                $offersLinkNow = 'https://www.deere.com/' . $offerLinkClean . '/index.json';

                $jsonOffer = file_get_contents($offersLinkNow, false, stream_context_create($arrContextOptions));
                $objOffers = json_decode($jsonOffer, true);

                $today = strtotime("today midnight");

                if (is_null($objOffers["Page"]["special-offers"]["OfferEndDate"])) {
                    $enddate = $objOffers["Page"]["special-offers"]["special-offers"][1]["OfferEndDate"];
                } else {
                    $enddate = $objOffers["Page"]["special-offers"]["OfferEndDate"];
                }

                if ($today >= strtotime($enddate)) {
                    //echo "expired";
                } else {
                    //echo "active";
                    if (is_array($objOffers["Page"]["special-offers"])) {
                        if (is_array($objOffers["Page"]["special-offers"]["special-offers"])) {
                            $jsonOfferOut = file_get_contents('https://www.deere.com' . $objOffers["Page"]["special-offers"]["special-offers"][1]["ESIFragments"], false, stream_context_create($arrContextOptions));
                        } else {
                            $jsonOfferOut = file_get_contents('https://www.deere.com' . $objOffers["Page"]["special-offers"]["ESIFragments"], false, stream_context_create($arrContextOptions));
                        }


                        $disclaimer .= $objOffers["Page"]["disclaimer"]["DisclaimerContainer"]["Description"];

                        $content = str_replace('srcset="', 'srcset="https://deere.com', $jsonOfferOut);
                        $content = str_replace('/en/', 'https://www.deere.com/en/', $content);
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
            }


            if ($offerZZ != null) {
                $offerZZa .= '<div class="col-md-12" style="background: #fff">';

                $offerZZa .= '<div class="offers-holder">';
                $offerZZa .= $offerZZ;
                $offerZZa .= '</div>';

                $offerZZa .= '</div>';
                $offerZZa .= '<div class="disclaimers" style="font-size: .7rem; padding: 20px;">' . $disclaimer . '</div>';

                ///Store offers in db///
                //$data->query("UPDATE deere_equipment SET offers_storage = '".$data->real_escape_string($offerZZa)."' WHERE id = '".$id."'");
                $offershtml .= $offerZZa;
            } else {
                $offershtml = '<div class="col-6"><div class="alert alert-warning">No current offers.</div></div>';
            }

            $htmlOut .= preg_replace('#<a.*?>.*?</a>#i', '', $offershtml);

            $htmlOut .= '</div><!--end offers tab-->';


            $accArs = $accessobjDec["Page"]["expandcollapse"]["Section"]["SectionData"];
            if (!empty($accArs)) {

                $htmlOut .= '<div class="tab-pane" id="accessories" style="padding: 20px"><!--start accessories tab-->';

                $htmlOut .= '<h2>Accessories & Attachments</h2><br><br>';


                $htmlOut .= '<div id="accordion col-12">';

                for ($i = 0; $i < count($accArs); $i++) {

                    $accData = $accArs[$i]["Data"];
                    // loop through the data for each item //
                    if (count($accArs[$i]["Data"]) > 2) {
                        $htmlOut .= '<h4 style="margin: 14px 0px; padding: 10px; background:#efefef">' . $accArs[$i]["SubTitle"] . '</h4>';

                        for ($j = 0; $j < count($accData); $j++) {
                            if ($accData[$j]["TitleQuestion"] != null) {
                                $htmlOut .= '<div class="fetheads" data-toggle="collapse" data-target="#collapse' . $i . '' . $j . '" aria-expanded="true" aria-controls="collapse' . $i . '' . $j . '">' . $accData[$j]["TitleQuestion"] . '</div>';
                                if ($accData[$j]["Description"] != null) {
                                    $htmlOut .= '<div id="collapse' . $i . '' . $j . '" class="collapse fetdets" aria-labelledby="heading' . $i . '' . $j . '" data-parent="#accordion">' . $accData[$j]["Description"] . '</div>';
                                }
                            }
                        }
                    }
                }

                $htmlOut .= '</div>';


                $htmlOut .= '</div><!--end accessories tab-->';
            }

            if (!empty($reviews)) {
                $htmlOut .= '<div class="tab-pane" id="reviews" style="padding-top: 20px"><!--start accessories tab-->';

                $htmlOut .= '<h2>Reviews</h2><br><br>';

                for ($r = 0; $r < 10; $r++) {
                    $authorName = $reviews[$r]["AuthorName"];

                    $rating = $reviews[$r]["Rating"];
                    //do rating stuff//
                    $stars = '';
                    $cts = array();
                    $starsFull = '';
                    $starsEmpty = '';
                    for ($st = 0; $st < $rating; $st++) {
                        $starsFull .= '<i class="fa fa-star" style="color: green"></i>';
                        $cts[] = '';
                    }
                    if (count($cts) == 5) {
                        //DO NOTHING
                    } else {
                        $getBlankStars = 5 - count($cts);

                        for ($bnk = 0; $bnk < $getBlankStars; $bnk++) {
                            $starsEmpty .= '<i class="fa fa-star" style="color: #efefef"></i>';
                        }
                    }


                    $theReview = $reviews[$r]["ReviewText"];
                    $title = $reviews[$r]["Title"];
                    $usage = $reviews[$r]["UsageFrequency"];
                    $expert = $reviews[$r]["LevelOfExpertise"];
                    $lengthOwner = $reviews[$r]["LengthOfOwnership"];
                    $locationUser = $reviews[$r]["ReviewerLocation"];

                    $pros = $reviews[$r]["ProsText"];
                    $cons = $reviews[$r]["ConsText"];
                    if ($pros != null) {
                        $pros = '<b>Pros:</b> ' . $reviews[$r]["ProsText"];
                    }

                    if ($cons != null) {
                        $cons = '<b>Cons:</b> ' . $reviews[$r]["ConsText"];
                    }

                    if ($authorName != null) {
                        $htmlOut .= '<div class="row" style="padding: 5px; border-bottom: solid thin #efefef"><div class="col-md-3" style="font-style: italic"><b>' . $authorName . '</b><br><b>Location:</b> ' . $locationUser . '<br><b>Length of Ownership:</b> ' . $lengthOwner . '<br><b>Usage:</b> ' . $usage . '<br></div><div class="col-md-9"><b>' . $title . '</b><br>' . $starsFull . '' . $starsEmpty . '<br><p>' . $theReview . '</p><p>' . $pros . '<br>' . $cons . '</p></div></div>';
                    }
                }


                $htmlOut .= '</div><!--end review tab-->';
            }

            $htmlOut .= '<div class="tab-pane" id="videos" style="padding-top: 20px"><!--start accessories tab-->';

            $htmlOut .= '<h2>Videos</h2><br><br>';
            $htmlOut .= '<div class="row">';
            $htmlOut .= '<div class="col-lg-8">';
            $htmlOut .= '<div class="embed-responsive embed-responsive-16by9">
  <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/' . $videos[0]["Youtube"]["Id"] . '" allowfullscreen></iframe>
</div>';
            $htmlOut .= '</div>';
            $htmlOut .= '<div class="col-lg-4">';

            $htmlOut .= '<div class="row">';
            for ($v = 0; $v < count($videos); $v++) {
                $htmlOut .= '<div class="col-xl-6"><img style="width:100%" src="https://img.youtube.com/vi/' . $videos[$v]["Youtube"]["Id"] . '/0.jpg"></div>';
            }
            $htmlOut .= '</div>';


            $htmlOut .= '</div>';
            $htmlOut .= '</div>';
            $htmlOut .= '</div><!--end videos tab-->';
            //========END TAB AREA=======//
            $htmlOut .= '</div><!--end tab content-->';

            $htmlOut .= '</div>';
            //====END DEERE EQUIPMENT CONTAINER====//

            //DEPENDENCIES///

            //            $css[] = 'inc/mods/deere_equipment/deere-output/css/lightslider.css';
            //            $css[] = 'inc/mods/deere_equipment/deere-output/css/main.css';
            //            $css[] = 'inc/mods/deere_equipment/deere-output/css/jquery.paginate.css';
            //
            //            $js[] = 'inc/mods/deere_equipment/deere-output/js/lightslider.js';
            //            $js[] = 'inc/mods/deere_equipment/deere-output/js/jquery.paginate.js';
            //            $js[] = 'inc/mods/deere_equipment/deere-output/js/new-output.js';
            $js = 'inc/mods/deere_equipment/deere_functions.js';

            // $ars = array("css"=>$css, "js"=>$js);
            //======OUTPUT EQUIPMENT DATA======//
            if ($b["cat_two"] == "zero-turn-mowers" || $b["sub_title"] == "ZTrak™ Zero-Turn Mower") {
                $metaTit = 'John Deere ' . $modelNumber . ' Zero Turn Mower';
            } else {
                $metaTit = 'John Deere ' . $modelNumber . ' ' . $productCatName;
            }

            if (substr($metaTit, -1) == 's') {
                $metaTit = substr($metaTit, -1);
            }
            $metaDescription = str_replace(array('<ul>', '</ul>', '<li>', '</li>', '&dagger;', '"'), array('', '', '', '. ', '', 'inch'), preg_replace('#<a.*?>.*?</a>#i', '', $metaDescription));
            $metaDescription = substr($metaDescription, 0, -2);
            $metaDescription .= ' | SunSouth';
            $metaTit = ucwords('John Deere ' . strtoupper($b['title']));
            $metaTit = str_replace('SERIES', 'Series', $metaTit);
            //$metaTit .= '| SunSouth';

            $content = array();
            $content[] = array("page_name" => $metaTit, "page_title" => $metaTit . " | SunSouth", "page_content" => $htmlOut, "active" => true, "created" => time(), "last_edit" => '', "last_user" => '', "page_lock" => 'none', "page_type" => '', "page_desc" => $metaDescription, "check_out" => false, "check_out_date" => '', "page_js" => $js, "dependants" => '');
            return $content;
            die();
        } else {
            //======TRY TO GET CATEGORY LISTING======//
            include('inc/config.php');
            $a = $data->query("SELECT * FROM deere_pages WHERE page_name = '$page' AND active = 'true'");
            if ($a->num_rows > 0) {
                $b = $a->fetch_array();
                $pageTemplate = $b["page_content"];


                $categoryOut = preg_replace_callback('#{prodcat}data{/prodcat}#', function ($match) use ($page) {
                    //SETUP CATEGORY OUTPUT UI//
                    include('inc/config.php');

                    $a = $data->query("SELECT * FROM deere_pages WHERE page_name = '$page' AND active = 'true'") or die($data->error);
                    $b = $a->fetch_array();

                    //====== New Schema.org generator for product list in Deere Equipment part-1 ======//
                    //* Insert that code inside async.php under if-else statement in the line 289(default)"if(isset($_POST["?search"]) || isset($_POST["search"]))"
                    $schemaOutput .= '<script type="application/ld+json">';
                    $schemaOutput .= '{"@context": "https://schema.org","@type": "ItemList","numberOfItems": "' . count(json_decode($b["equipment_content"], true)) . '",';
                    $schemaOutput .= '"itemListElement": [';
                    $r = 1;
                    //====== End of Schema.org generator for product list in Machine Finder Two part-1 ======//

                    $itemData = json_decode($b["equipment_content"], true);

                    if ($b["page_name"] == "Deere-Equipment") {
                        $greenText = "Deere Equipment";
                    } else {
                        $segments = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
                        $numSegments = count($segments);
                        $greenText = str_replace("-", " ", $segments[$numSegments - 2]);
                    }

                    if ($b["page_name"] == "Deere-Equipment") {
                        $yellowText = "";
                    } else {
                        $yellowText = str_replace("-", " ", $b["page_name"]);
                    }

                    $deereContent .= '<style>
                                        .top-spacer{
                                            height: 56px;
                                            background-color: #fff;
                                            opacity: 0.2;
                                            background: repeating-linear-gradient( -45deg, #efefef, #efefef 10px, #fff 3px, #fff 15px );
                                        }
                                        .green-head{
                                            background: var(--bcss-secondary);
                                            color: #fff;
                                            font-size: 1.4rem;
                                            line-height: 1.4rem;
                                            font-weight: 700;
                                        }
                                        .yellow-head{
                                            background: var(--bcss-active);
                                            color: var(--bcss-secondary);
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
                                        .element-line:nth-child(even){
                                            background: #F2F2F2;
                                        }
                                        .text-link{
                                            color: var(--bcss-secondary);
                                        }
                                        .title-button{
                                            background: var(--bcss-active);
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
                                            border-bottom: 2px solid var(--bcss-secondary);
                                        }
                                      </style>
                                      <div class="row top-spacer"></div>
                                      <div class="row">
                                        <div class="col-12 col-md-6 col-lg-3 py-3 text-right green-head">
                                            ' . $greenText . '
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-9 py-3 yellow-head">
                                            <h1>' . $yellowText . '</h1>
                                        </div>
                                      </div>';
                    for ($i = 0; $i <= count($itemData); $i++) {
                        if ($itemData[$i]["type"] == 'category') {
                            //HANDLE EQUIPMENT CATEGORY INFO HERE//
                            $c = $data->query("SELECT cat_img,page_desc,equipment_content,page_name FROM deere_pages WHERE page_name = '" . $itemData[$i]["title"] . "'");
                            $d = $c->fetch_array();

                            $deereContent .= '<div class="row element-line">
                                                  <div class="col-12 col-md-6 col-lg-3 border-right p-3 d-flex flex-column justify-content-center align-items-center">
                                                    <a class="text-center" href="' . $_SERVER['REQUEST_URI'] . '/' . $itemData[$i]["title"] . '">
                                                        <img class="img-responsive w-100" src="' . $d["cat_img"] . '" >
                                                    </a>
                                                    <a class="mt-2 mx-auto text-center text-link" href="' . $_SERVER['REQUEST_URI'] . '/' . $itemData[$i]["title"] . '"><h2 class="title-button text-capitalize">' . str_replace("-", " ", $itemData[$i]["title"]) . '</h2></a>
                                                  </div>
                                                  <div class="col-12 col-md-6 col-lg-3 border-right p-3 d-flex justify-content-center align-items-center">
                                                    <p class="py-0 my-0">' . $d["page_desc"] . '</p>
                                                  </div>
                                                  <div class="col-12 col-md-6 col-lg-3 border-right p-3 d-flex justify-content-center align-items-center"><div>';
                            $subLinks = json_decode($d["equipment_content"], true);

                            foreach ($subLinks as $el) {
                                if (in_array("product", $el)) {
                                    foreach ($el as $key => $value) {
                                        if ($value != "product" && $value != "category") {
                                            $deereContent .= '<a href="' . $_SERVER['REQUEST_URI'] . '/' . $itemData[$i]["title"] . '/' . $value . '" class="text-link text-uppercase">' . str_replace("-", " ", $value) . '</a>, ';
                                        }
                                    }
                                } else {
                                    foreach ($el as $key => $value) {
                                        if ($value != "product" && $value != "category") {
                                            $deereContent .= '<a href="' . $_SERVER['REQUEST_URI'] . '/' . $itemData[$i]["title"] . '/' . $value . '" class="text-link text-uppercase">' . str_replace("-", " ", $value) . '</a>, ';
                                        }
                                    }
                                }
                            }

                            $g = $data->query("SELECT * FROM deere_equipment WHERE title = '" . $subLinks[0]["title"] . "'");
                            $h = $g->fetch_array();
                            $brochureLink = json_decode($h['product_links'], true);
                            $brochureLink = $brochureLink[1]['LinkUrl'];

                            $shareLink = 'mailto:?subject=' . $d['model_number'] . '&body=http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '/' . $itemData[$i]["title"] . '';

                            $deereContent .= '</div></div>
                                                  <div class="col-12 col-md-6 col-lg-3 p-3 d-flex flex-column justify-content-center align-items-center">
                                                      <div class="d-inline-block">
                                                        <a href="' . $_SERVER['REQUEST_URI'] . '/' . $itemData[$i]["title"] . '" class="d-block text-link">
                                                            <h3 class="view-all">VIEW ALL <i class="fa fa-angle-double-right" aria-hidden="true"></i></h3>
                                                        </a>
                                                        <a href="' . $shareLink . '" class="d-block">
                                                            <span class="text-link"><?xml version="1.0" encoding="UTF-8"?><svg id="Layer_2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 12.31" style="width: 1rem; height: 1rem; transform: scale(1.1); margin: 0 3px -0.125rem; fill: var(--bcss-secondary);"><g id="Layer_1-2"><path class="cls-1" d="m9.94,9.72c-.58.34-1.33-.07-1.33-.76v-1.58S3.08,6.77,0,12.31C1.23,2.46,6.77,2.46,8.62,2.46V.88c0-.16.04-.31.12-.45.25-.42.79-.56,1.21-.31l5.62,4.04c.13.08.24.18.31.31.25.42.11.96-.31,1.21l-5.62,4.04h0Z"/></g></svg></span>
                                                            <span class="text-link abcd ' . $yellowText . '">SHARE</span>
                                                        </a>';
                            if ($brochureLink != null) {
                                $deereContent .= '<a href="' . $brochureLink . '" class="d-block" target="_blank">
                                                            <span class="text-link"><?xml version="1.0" encoding="UTF-8"?><svg id="Layer_2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 13.75" style="width: 1rem; height: 1rem; transform: scale(1.1); margin: 0 3px -0.125rem; fill: var(--bcss-secondary);"><g id="Layer_1-2"><path class="cls-1" d="m10,0c-1.65,0-3.24.6-4.49,1.68-.96.82-1.65,1.9-1.83,2.98-2.1.46-3.68,2.29-3.68,4.49,0,2.56,2.13,4.6,4.73,4.6h11.13c2.27,0,4.14-1.79,4.14-4.03,0-2.04-1.55-3.71-3.54-3.99-.3-3.22-3.1-5.72-6.46-5.72Zm2.94,8.57l-2.5,2.5c-.24.24-.64.24-.88,0,0,0,0,0,0,0l-2.5-2.5c-.24-.24-.24-.64,0-.89s.64-.24.89,0l1.43,1.43v-4.74c0-.35.28-.62.62-.62s.62.28.62.62v4.74l1.43-1.43c.24-.24.64-.24.89,0s.24.64,0,.89Z"/></g></svg></span>
                                                            <span class="text-link">DOWNLOAD BROCHURE</span>
                                                        </a>';
                            }

                            $link = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '/' . $itemData[$i]["title"];

                            if ($yellowText == "Implements" || $yellowText == "Front End Loaders For Tractors" || $yellowText == "Frontier Utility Attachments") {
                                $deereContent .= '';
                            } else {
                                $deereContent .= '<a href="test-drive?equip=' . $d['page_name'] . '&link=' . str_replace("/", "~", $link) . '" class="d-block" target="_blank">
                                                            <span class="text-link"><?xml version="1.0" encoding="UTF-8"?><svg id="Layer_2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18" style="width: 1rem; height: 1rem; transform: scale(1.1); margin: 0 3px -0.125rem; fill: var(--bcss-secondary);"><g id="Layer_1-2"><path class="cls-1" d="m9,0C4.04,0,0,4.04,0,9s4.04,9,9,9,9-4.04,9-9S13.96,0,9,0Zm0,1.72c3.31,0,6.11,2.22,6.99,5.25-2.47-.64-4.76-.95-6.99-.95s-4.52.31-6.99.95c.88-3.03,3.68-5.25,6.99-5.25h0Zm0,9.55c-.99,0-1.8-.81-1.8-1.8s.81-1.8,1.8-1.8,1.8.81,1.8,1.8-.81,1.8-1.8,1.8Zm-7.14-.86c2.96.03,5.26,2.43,5.26,5.48,0,.05,0,.09,0,.14-2.66-.71-4.72-2.89-5.26-5.62h0Zm9.02,5.62c0-.05,0-.1,0-.14,0-3.05,2.31-5.44,5.26-5.48-.54,2.73-2.6,4.91-5.26,5.62h0Z"/></g></svg></span>
                                                            <span class="text-link">TEST DRIVE</span>
                                                        </a>';
                            }
                            /*$deereContent .= '<a href="test-drive?equip=' . $d['page_name'] . '&link=' . str_replace("/", "~", $link) . '" class="d-block" target="_blank">
                                                            <span class="text-link"><?xml version="1.0" encoding="UTF-8"?><svg id="Layer_2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18" style="width: 1rem; height: 1rem; transform: scale(1.1); margin: 0 3px -0.125rem; fill: var(--bcss-secondary);"><g id="Layer_1-2"><path class="cls-1" d="m9,0C4.04,0,0,4.04,0,9s4.04,9,9,9,9-4.04,9-9S13.96,0,9,0Zm0,1.72c3.31,0,6.11,2.22,6.99,5.25-2.47-.64-4.76-.95-6.99-.95s-4.52.31-6.99.95c.88-3.03,3.68-5.25,6.99-5.25h0Zm0,9.55c-.99,0-1.8-.81-1.8-1.8s.81-1.8,1.8-1.8,1.8.81,1.8,1.8-.81,1.8-1.8,1.8Zm-7.14-.86c2.96.03,5.26,2.43,5.26,5.48,0,.05,0,.09,0,.14-2.66-.71-4.72-2.89-5.26-5.62h0Zm9.02,5.62c0-.05,0-.1,0-.14,0-3.05,2.31-5.44,5.26-5.48-.54,2.73-2.6,4.91-5.26,5.62h0Z"/></g></svg></span>
                                                            <span class="text-link">TEST DRIVE</span>
                                                        </a>';*/
                            $deereContent .= '</div>
                                                  </div>
                                              </div>';

                            /////////////////////////////
                            $schemaOutput .= '{"position": "' . $r++ . '","name": "Category",';
                            $schemaOutput .= '"url": "' . $_SERVER['REQUEST_URI'] . '/' . $itemData[$i]["title"] . '"},';
                            /////////////////////////////

                        } else {
                            //HANDLE EQUIPMENT INFO HERE//
                            if ($itemData[$i]["title"] != null) {
                                include('inc/config.php');
                                $c = $data->query("SELECT * FROM deere_equipment WHERE title = '" . $itemData[$i]["title"] . "'");
                                $d = $c->fetch_array();
                                $imageThumb = json_decode($d["eq_image"], true);
                                $textCat = $d["model_number"];
                                $mainImg = 'img/' . $imageThumb[0];

                                if ($imageThumb["ImageThumbnail"] != null) {
                                    $mainImg = 'https://deere.com' . $imageThumb["ImageThumbnail"];
                                } else {
                                    if (!isset($imageThumb[0]["ImageThumbnail"])) {
                                        $imageThumb = json_decode($d['eq_image'], true);
                                        $mainImg = 'img/' . $imageThumb[0];
                                    } else {
                                        $mainImg = 'https://deere.com' . $imageThumb[0]["ImageThumbnail"];
                                    }
                                }

                                $brochureLink = json_decode($d['product_links'], true);
                                $brochureLink = $brochureLink[1]['LinkUrl'];

                                $shareLink = 'mailto:?subject=' . $d['model_number'] . '&body=http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '/' . $itemData[$i]["title"] . '';

                                $deereContent .= '  <div class="row element-line">
                                                      <div class="col-12 col-md-6 col-lg-3 border-right p-3 d-flex flex-column justify-content-center align-items-center">
                                                        <a class="text-center" href="' . $_SERVER['REQUEST_URI'] . '/' . $itemData[$i]["title"] . '">
                                                            <img class="img-responsive w-100" src="' . $mainImg . '" >
                                                        </a>
                                                        <a class="mt-2 mx-auto text-center text-link" href="' . $_SERVER['REQUEST_URI'] . '/' . $itemData[$i]["title"] . '"><h2 class="title-button text-capitalize">' . str_replace("-", " ", $textCat) . '</h2></a>
                                                      </div>
                                                      <div class="col-12 col-md-6 border-right p-3 d-flex justify-content-center align-items-center">
                                                        <p class="py-0 my-0">' . $d["product_overview"] . '</p>
                                                      </div>
                                                      <!--<div class="col-12 col-md-6 col-lg-3 border-right p-3 d-flex justify-content-center align-items-center">
                                                      
                                                      </div>-->
                                                      <div class="col-12 col-md-6 col-lg-3 p-3 d-flex flex-column justify-content-center align-items-center">
                                                          <div class="d-inline-block">
                                                            <a href="' . $_SERVER['REQUEST_URI'] . '/' . $itemData[$i]["title"] . '" class="d-block text-link">
                                                                <h3 class="view-all">VIEW ALL <i class="fa fa-angle-double-right" aria-hidden="true"></i></h3>
                                                            </a>
                                                            <a href="' . $shareLink . '" class="d-block">
                                                                <span class="text-link"><?xml version="1.0" encoding="UTF-8"?><svg id="Layer_2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 12.31" style="width: 1rem; height: 1rem; transform: scale(1.1); margin: 0 3px -0.125rem; fill: var(--bcss-secondary);"><g id="Layer_1-2"><path class="cls-1" d="m9.94,9.72c-.58.34-1.33-.07-1.33-.76v-1.58S3.08,6.77,0,12.31C1.23,2.46,6.77,2.46,8.62,2.46V.88c0-.16.04-.31.12-.45.25-.42.79-.56,1.21-.31l5.62,4.04c.13.08.24.18.31.31.25.42.11.96-.31,1.21l-5.62,4.04h0Z"/></g></svg></span>
                                                                <span class="text-link xyz2 ' . $yellowText . '" >SHARE</span>
                                                            </a>';
                                if (!empty($brochureLink)) {
                                    $deereContent .= '<a href="' . $brochureLink . '" class="d-block" target="_blank">
                                                            <span class="text-link"><?xml version="1.0" encoding="UTF-8"?><svg id="Layer_2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 13.75" style="width: 1rem; height: 1rem; transform: scale(1.1); margin: 0 3px -0.125rem; fill: var(--bcss-secondary);"><g id="Layer_1-2"><path class="cls-1" d="m10,0c-1.65,0-3.24.6-4.49,1.68-.96.82-1.65,1.9-1.83,2.98-2.1.46-3.68,2.29-3.68,4.49,0,2.56,2.13,4.6,4.73,4.6h11.13c2.27,0,4.14-1.79,4.14-4.03,0-2.04-1.55-3.71-3.54-3.99-.3-3.22-3.1-5.72-6.46-5.72Zm2.94,8.57l-2.5,2.5c-.24.24-.64.24-.88,0,0,0,0,0,0,0l-2.5-2.5c-.24-.24-.24-.64,0-.89s.64-.24.89,0l1.43,1.43v-4.74c0-.35.28-.62.62-.62s.62.28.62.62v4.74l1.43-1.43c.24-.24.64-.24.89,0s.24.64,0,.89Z"/></g></svg></span>
                                                            <span class="text-link">DOWNLOAD BROCHURE</span>
                                                        </a>';
                                }
                                $link = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '/' . $itemData[$i]["title"];

                                if ($yellowText == "Front Loaders For Compact Tractors" || $yellowText == "Front Loaders For Utility Tractors" || $yellowText == "Front Loaders For Row Crop Tractors" || $yellowText == "Backhoes" || $yellowText == "frontier box blades" || $yellowText == "frontier livestock equine" || $yellowText == "frontier landscape equipment" || $yellowText == "frontier loader attachments" || $yellowText == "frontier seeding equipment" || $yellowText == "frontier tillage equipment") {
                                    $deereContent .= '';
                                } else {
                                    $deereContent .= '<a href="test-drive?equip=' . $d['page_name'] . '&link=' . str_replace("/", "~", $link) . '" class="d-block" target="_blank">
                                                                <span class="text-link"><?xml version="1.0" encoding="UTF-8"?><svg id="Layer_2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18" style="width: 1rem; height: 1rem; transform: scale(1.1); margin: 0 3px -0.125rem; fill: var(--bcss-secondary);"><g id="Layer_1-2"><path class="cls-1" d="m9,0C4.04,0,0,4.04,0,9s4.04,9,9,9,9-4.04,9-9S13.96,0,9,0Zm0,1.72c3.31,0,6.11,2.22,6.99,5.25-2.47-.64-4.76-.95-6.99-.95s-4.52.31-6.99.95c.88-3.03,3.68-5.25,6.99-5.25h0Zm0,9.55c-.99,0-1.8-.81-1.8-1.8s.81-1.8,1.8-1.8,1.8.81,1.8,1.8-.81,1.8-1.8,1.8Zm-7.14-.86c2.96.03,5.26,2.43,5.26,5.48,0,.05,0,.09,0,.14-2.66-.71-4.72-2.89-5.26-5.62h0Zm9.02,5.62c0-.05,0-.1,0-.14,0-3.05,2.31-5.44,5.26-5.48-.54,2.73-2.6,4.91-5.26,5.62h0Z"/></g></svg></span>
                                                                <span class="text-link">TEST DRIVE</span>
                                                            </a>';
                                }
                                /*$deereContent .= '<a href="test-drive?equip=' . $d['page_name'] . '&link=' . str_replace("/", "~", $link) . '" class="d-block" target="_blank">
                                                                <span class="text-link"><?xml version="1.0" encoding="UTF-8"?><svg id="Layer_2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18" style="width: 1rem; height: 1rem; transform: scale(1.1); margin: 0 3px -0.125rem; fill: var(--bcss-secondary);"><g id="Layer_1-2"><path class="cls-1" d="m9,0C4.04,0,0,4.04,0,9s4.04,9,9,9,9-4.04,9-9S13.96,0,9,0Zm0,1.72c3.31,0,6.11,2.22,6.99,5.25-2.47-.64-4.76-.95-6.99-.95s-4.52.31-6.99.95c.88-3.03,3.68-5.25,6.99-5.25h0Zm0,9.55c-.99,0-1.8-.81-1.8-1.8s.81-1.8,1.8-1.8,1.8.81,1.8,1.8-.81,1.8-1.8,1.8Zm-7.14-.86c2.96.03,5.26,2.43,5.26,5.48,0,.05,0,.09,0,.14-2.66-.71-4.72-2.89-5.26-5.62h0Zm9.02,5.62c0-.05,0-.1,0-.14,0-3.05,2.31-5.44,5.26-5.48-.54,2.73-2.6,4.91-5.26,5.62h0Z"/></g></svg></span>
                                                                <span class="text-link">TEST DRIVE</span>
                                                            </a>';*/
                                $deereContent .= '</div>
                                                      </div>
                                                  </div>';


                                /////////////////////////////
                                $schemaOutput .= '{"position": "' . $r++ . '","name": "Category",';
                                $schemaOutput .= '"url": "' . $_SERVER['REQUEST_URI'] . '/' . $itemData[$i]["title"] . '"},';
                                /////////////////////////////

                            }
                        }
                    }

                    /*for($i=0; $i <= count($itemData); $i++) {

                    }*/

                    /////////////////////////////
                    $schemaOutput = substr($schemaOutput, 0, -1);
                    $schemaOutput .= ']}';
                    $schemaOutput .= '</script>';

                    $deereContent .= $schemaOutput;
                    /////////////////////////////

                    return $deereContent;
                }, $pageTemplate);

                //$content[] = array("page_name" => '', "page_title" => '', "page_content" => $categoryOut, "active" => true, "created" => time(), "last_edit" => '', "last_user" => '', "page_lock" => 'none', "page_type" => '', "page_desc" => '', "check_out" => false, "check_out_date" => '', "page_js" => '', "dependants" => $arsOut);
                //$content[] = array("page_name" => ucwords(str_replace('-', ' ', $b['page_name'])), "page_title" => ucwords(str_replace('-', ' ', $b['page_name'])), "page_content" => $categoryOut, "active" => true, "created" => time(), "last_edit" => '', "last_user" => '', "page_lock" => 'none', "page_type" => '', "page_desc" => '', "check_out" => false, "check_out_date" => '', "page_js" => '', "dependants" => $arsOut);
                $content[] = array("page_name" => ucwords(str_replace('-', ' ', $b['page_name'])), "page_title" => ucwords(str_replace('-', ' ', $b['page_name'])) . " | SunSouth", "page_content" => $categoryOut, "active" => true, "created" => time(), "last_edit" => '', "last_user" => '', "page_lock" => 'none', "page_type" => '', "page_desc" => $b['page_desc'], "check_out" => false, "check_out_date" => '', "page_js" => '', "dependants" => $arsOut);

                return $content;
            } else {
                ///NO DATA RETURN NEEDED///
            }
        }
    }
}
