<?php

class packageCall
{
    function runOutput($packname)
    {
        //echo 'this is' . $packname;

        include('inc/config.php');

        $a = $data->query("SELECT * FROM package_deals WHERE package_name = '" . $packname . "'");
        $b = $a->fetch_array();

        $c = $data->query("SELECT * FROM deere_equipment WHERE title = '" . $b["equip_for"] . "'");
        $d = $c->fetch_array();


        $e = $data->query("SELECT * FROM custom_addons WHERE addon_name = '" . $b["addon_details"] . "'");
        $f = $e->fetch_array();


        $html .= '<style>
                    .funkyradio div {
                        clear: both;
                        overflow: hidden;
                    }
                    
                    .funkyradio label {
                        width: 100%;
                        border-radius: 3px;
                        border: 1px solid #D1D3D4;
                        font-weight: normal;
                    }
                    
                    .funkyradio input[type="radio"]:empty,
                    .funkyradio input[type="checkbox"]:empty {
                        display: none;
                    }
                    
                    .funkyradio input[type="radio"]:empty ~ label,
                    .funkyradio input[type="checkbox"]:empty ~ label {
                        position: relative;
                        line-height: 2.5em;
                        text-indent: 3.25em;
                        margin-top: 0;
                        cursor: pointer;
                        -webkit-user-select: none;
                        -moz-user-select: none;
                        -ms-user-select: none;
                        user-select: none;
                    }
                    
                    .funkyradio input[type="radio"]:empty ~ label:before,
                    .funkyradio input[type="checkbox"]:empty ~ label:before {
                        position: absolute;
                        display: block;
                        top: 0;
                        bottom: 0;
                        left: 0;
                        content: \'\';
                        width: 2.5em;
                        background: #D1D3D4;
                        border-radius: 3px 0 0 3px;
                    }
                    
                    .funkyradio input[type="radio"]:hover:not(:checked) ~ label,
                    .funkyradio input[type="checkbox"]:hover:not(:checked) ~ label {
                        color: #888;
                    }
                    
                    .funkyradio input[type="radio"]:hover:not(:checked) ~ label:before,
                    .funkyradio input[type="checkbox"]:hover:not(:checked) ~ label:before {
                        content: "\2713";
                        text-indent: .9em;
                        color: #C2C2C2;
                    }
                    
                    .funkyradio input[type="radio"]:checked ~ label,
                    .funkyradio input[type="checkbox"]:checked ~ label {
                        color: #777;
                    }
                    
                    .funkyradio input[type="radio"]:checked ~ label:before,
                    .funkyradio input[type="checkbox"]:checked ~ label:before {
                        content: "\2713";
                        text-indent: .9em;
                        color: #333;
                        background-color: #ccc;
                    }
                    
                    .funkyradio input[type="radio"]:focus ~ label:before,
                    .funkyradio input[type="checkbox"]:focus ~ label:before {
                        box-shadow: 0 0 0 3px #999;
                    }
                    
                    .funkyradio-default input[type="radio"]:checked ~ label:before,
                    .funkyradio-default input[type="checkbox"]:checked ~ label:before {
                        color: #333;
                        background-color: #ccc;
                    }
                    
                    .funkyradio-primary input[type="radio"]:checked ~ label:before,
                    .funkyradio-primary input[type="checkbox"]:checked ~ label:before {
                        color: #fff;
                        background-color: #337ab7;
                    }
                    
                    .funkyradio-success input[type="radio"]:checked ~ label:before,
                    .funkyradio-success input[type="checkbox"]:checked ~ label:before {
                        color: #fff;
                        background-color: #5cb85c;
                    }
                    
                    .funkyradio-danger input[type="radio"]:checked ~ label:before,
                    .funkyradio-danger input[type="checkbox"]:checked ~ label:before {
                        color: #fff;
                        background-color: #d9534f;
                    }
                    
                    .funkyradio-warning input[type="radio"]:checked ~ label:before,
                    .funkyradio-warning input[type="checkbox"]:checked ~ label:before {
                        color: #fff;
                        background-color: #f0ad4e;
                    }
                    
                    .funkyradio-info input[type="radio"]:checked ~ label:before,
                    .funkyradio-info input[type="checkbox"]:checked ~ label:before {
                        color: #fff;
                        background-color: #5bc0de;
                    }
                    
                    .funkyradio-success label:before{
                        content: \'ï¿½4\';
                        text-indent: .9em;
                        color: #333;
                        background-color: #ccc;
                    }
                    .formbox .section-title,
                    .formbox .border {
                        display: none;
                    }
                    
                    .formbox .form-control {
                        display: block;
                        width: 100%;
                        padding: 0.375rem 0.75rem;
                        font-size: 0.8rem;
                        line-height: 1.6rem;
                        color: #495057;
                        background-color: #fff;
                        background-clip: padding-box;
                        border: 2px solid var(--bcss-secondary);
                        border-radius: 0;
                        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
                    }
                    
                    .formbox input:focus,
                    .formbox select:focus,
                    .formbox textarea:focus {
                        outline: none !important;
                    }
                    
                    .formbox select {
                        background-color: white;
                        border: thin solid grey;
                        border-radius: 4px;
                        display: inline-block;
                        font: inherit;
                        line-height: 1.5em;
                        padding: 0.5em 3.5em 0.5em 1em;
                        -webkit-box-sizing: border-box;
                        -moz-box-sizing: border-box;
                        box-sizing: border-box;
                        -webkit-appearance: none;
                        -moz-appearance: none;
                    }
                    
                    .formbox select {
                        background-image: url("data:image/svg+xml,%3Csvg class=\'svg-icon\' style=\'width: 1em; height: 1em;vertical-align: middle;fill:%2318572E;overflow: hidden;\' viewBox=\'0 0 1024 1024\' version=\'1.1\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M512.03799 0 921.675981 411.648 102.4 411.648 512.03799 0ZM512.03799 995.328 102.4 583.68 921.675981 583.68 512.03799 995.328Z\' /%3E%3C/svg%3E");
                        background-size: 1.5em 1.5em;
                        background-position: right;
                        background-repeat: no-repeat;
                    
                    }
                    .formbox .btn-success{
                        background: var(--bcss-secondary);
                        color: var(--bcss-active);
                        border: 1px solid var(--bcss-secondary);
                        transition: .35s ease-in-out;
                        font-size: 1rem;
                        margin-top: 16px;
                        position: relative;
                    
                    }
                    .formbox .btn-success:after {
                        content: "";
                        position: absolute;
                        top: 49%;
                        left: 115%;
                        border-bottom: 2px solid var(--bcss-secondary);
                        width: 9000%;
                        max-width: 1083px;
                    
                    }
                    
                    .formbox.row{
                        overflow-x:hidden;
                    }
                    .formbox .btn-success:after {
                        width: 36vw;
                        max-width: 300%;
                    }
                </style>';
        $html .= '<div class="row jumbotron">';
        //$html .= '<p style="font-size: 30px; color: #005000;"><button type="button" class="btn btn-success" style="font-size: 30px;"><b>Step 2: Add Attachments & Products To Build Your Package</b></button></p>';f

        $image1 = $d["eq_image"];
        //$image2 = trim($image1, '"');
        $imgpath = json_decode($image1, true);
        if($imgpath[0]["ImageLarge"] == null){
            $eqImage = $imgpath["ImageLarge"];
        }else{
            $eqImage = $imgpath[0]["ImageLarge"];
        }

        $html .= '<div class="col-md-5"><img class="img-fluid img-thumbnail" src="https://deere.com' . $eqImage . '"></div>';

        $html .= '<div class="col-md-7"><div class="row mb-3">
                      <div class="col-12 col-md-6 col-lg-3 py-3 text-right green-head"> STEP 2 </div>
                      <div class="col-12 col-md-6 col-lg-9 py-3 yellow-head">
                        <h2>Add Attachments & Products</h2>
                      </div>
                </div>';

        $items = stripslashes($b["addons"]);


        $items = trim($items, '"');
        $dropnow = json_decode($items, true);


        $html .= '<form name="package_request" id="package_request" method="post" action="">';


        $html .= '<div style="padding: 20px; display: none" class="checkboxerror error"></div>';

        for ($i = 0; $i < count($dropnow); $i++) {

            $prodDetails = $this->findProductDet($dropnow[$i]["title"]);
            //var_dump('$prodDetails[iscustom""]');
            //var_dump('$prodDetails["addoncheck"]');

            if (file_exists('img/' . $prodDetails["image"]) && $prodDetails["image"] != null) {
                $image = $prodDetails["image"];
            } else {
                $image = 'No_Image_Available.jpg';
            }
            if (isset($prodDetails["iscustom"]) && $prodDetails["checkbox"] != "") {
                $imageZ = '<img class="img-fluid builderlink" src="img/' . $image . '" data-eqimage="img/' . $image . '" data-eqtitle="' . $dropnow[$i]["title"] . '">';
            } elseif (isset($prodDetails["iscustom"])) {
                $imageZ = '<img id="attach-modal"class="img-fluid builderlink" src="img/' . $image . '" data-eqlink="New-Equipment/' . $dropnow[$i]["title"] . '">';
            } else {
                $imageZ = '<img class="img-fluid builderlink" src="img/' . $image . '" data-eqlink="New-Equipment/' . $dropnow[$i]["title"] . '">';
            }
            if ($dropnow[$i]["linetype"] == 'Custom') {
                $linetype = '';
            } else {
                $linetype = $dropnow[$i]["linetype"];
            }

            $poop = $data->query("SELECT * FROM custom_addons WHERE addon_name = '" . $dropnow[$i]["title"] . "'");
            $pee = $poop->fetch_array();


            //$html .= '<div class="dropitemsin" data-thedrop="'.$dropnow[$i]["title"].'" data-thedroptype="product">Product: '.$dropnow[$i]["title"].' | <a href="javascript:void(0)" class="removeites"><i class="fa fa-trash" aria-hidden="true"></i> Remove</a></div>';
            $html .= '<div class="row"><div class="col-md-2">' . $imageZ . '</div><div class="col-md-10"><div class="funkyradio">
        <div class="funkyradio-success">
            <input type="checkbox" class="checker" name="checkbox[]" id="checkbox' . $i . '" value="' . $dropnow[$i]["title"] . '"/>
            <label style="font-size:15px" for="checkbox' . $i . '">Select ' . $linetype . ' ' . $dropnow[$i]["title"] . ' | ' . $pee["addon_details"] . '</label>
        </div>
       </div></div></div>';
        }
        $html .= '<div class="row my-3">
                      <div class="col-12 col-md-6 col-lg-3 py-3 text-right green-head"> STEP 3 </div>
                      <div class="col-12 col-md-6 col-lg-9 py-3 yellow-head">
                        <h2>Let Us Know How To Reach You</h2>
                      </div>
                </div>';
        $html .= '<div class="formbox">';
        $html .= '<div class="row">';
        //$html .= '<br>';
        $html .= '<div class="col-md-6 mb-3"><input id="full_name" name="full_name" class="form-control" type="text" placeholder="Full Name" required></div>';
        $html .= '<input type="hidden" id="url" name="url" class="form-control" value=""/>';
        $html .= '<div class="col-md-6 mb-3"><input id="email" name="email" class="form-control" type="email" placeholder="Email" required></div>';
        $html .= '<div class="col-md-6 mb-3"><input id="phone" name="phone" class="form-control" type="text" placeholder="Phone" required></div>';
        $html .= '<div class="col-md-6 mb-3"><input id="zip" name="zip" class="form-control" type="text" placeholder="Zip" required></div>';
        $html .= '<div class="col-md-12"><div class="fb-select form-group field-locations">
        
        <select class="form-control" name="location" id="location" required="required" aria-required="true">
            <option disabled="null" selected="null">Choose A Location</option>
            <option value="abbeville" id="locations-0">Abbeville, AL</option>
            <option value="andulasia" id="locations-1">Andulasia, AL</option>
            <option value="auburn" id="locations-2">Auburn, AL</option>
            <option value="brundidge" id="locations-3">Brundidge, AL</option>
            <option value="clanton" id="locations-4">Clanton, AL</option>
            <option value="demopolis" id="locations-5">Demopolis, AL</option>
            <option value="dothan" id="locations-6">Dothan, AL</option>
            <option value="foley" id="locations-7">Foley, AL</option>
            <option value="mobile" id="locations-8">Mobile, AL</option>
            <option value="montgomery" id="locations-9">Montgomery, AL</option>
            <option value="samson" id="locations-10">Samson, AL</option>
            <option value="tuscaloosa" id="locations-11">Tuscaloosa, AL</option>
            <option value="barnesville" id="locations-12">Barnesville, GA</option>
            <option value="blakely" id="locations-13">Blakely, GA</option>
            <option value="carrollton" id="locations-14">Carollton, GA</option>
            <option value="columbus" id="locations-15">Columbus, GA</option>
            <option value="donalsonville" id="locations-16">Donalsonville, GA</option>
            <option value="carthage" id="locations-17">Carthage, MS</option>
            <option value="gulfport" id="locations-18">Gulfport, MS</option>
            <option value="lucedale" id="locations-19">Lucedale, MS</option>
            <option value="meridian" id="locations-20">Meridian, MS</option>
        </select>
    </div></div>';
        $html .= '<div class="col-md-12 mb-3"><textarea id="comment" name="comment" class="form-control" type="text" placeholder="Comments"></textarea></div>';
        $html .= '<div class="col-12"><div class="row">
                      <div class="col-12 col-md-6 col-lg-3 py-3 text-right green-head"> STEP 4 </div>
                      <div class="col-12 col-md-6 col-lg-9 py-3 yellow-head">
                        <h2>Click Submit To Send Your Request</h2>
                      </div>
                </div></div>';
        //$html .= '<button type="submit" style="float: right" class="btn btn-success" style="font-size:30px;">Request Special "Package Deal" Pricing</button>';
        $html .= '<button type="submit" style="margin-bottom: 55px;" class="btn btn-success">Submit Request</button>';
        $html .= '</div></div>';

        $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $html .= '<input type="hidden" name="package-type" id="package-type" value="' . $actual_link . '">';
        $html .= '</form>';
        $html .= '<div class="packs"></div>';

        //$html .= '<button type="submit" style="float: right" class="btn btn-success" style="font-size:30px;">Request Quote</button>';
        //$html .= '<br><button style="float: right" class="btn btn-success package-form">Request Quote</button>';

        $html .= '</div>';

        $html .= '</div>';

        return $html;
    }

    function findProductDet($name)
    {
        include('inc/config.php');
        $h = $data->query("SELECT * FROM custom_addons WHERE addon_name = '$name'");
        if ($h->num_rows > 0) {
            $i = $h->fetch_array();
            return array("image" => str_replace('../img', '', $i["addon_image"]), "price" => $i["addon_price"], "iscustom" => true, "details" => $i["addon_details"], "new_name" => $i["new_name"], "checkbox" => $i["checkbox"]);
        }
    }
}
