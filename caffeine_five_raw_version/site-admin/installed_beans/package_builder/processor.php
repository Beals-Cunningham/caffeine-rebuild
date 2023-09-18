<?php

class packageCall{
    function runOutput($packname)
    {
//        echo 'this is'.$packname;

        include('inc/config.php');

        $a = $data->query("SELECT * FROM package_deals WHERE package_name = '".$packname."'");
        $b = $a->fetch_array();

        $c = $data->query("SELECT * FROM deere_equipment WHERE title = '" . $b["equip_for"] . "'");
        $d = $c->fetch_array();


        $e = $data->query("SELECT * FROM custom_addons WHERE addon_name = '" . $b["addon_details"] . "'");
        $f = $e->fetch_array();


        $html .= '<div class="row" style="background: #efefef; padding: 10px; margin: 30px 0px;">';
        //$html .= '<p style="font-size: 30px; color: #005000;"><button type="button" class="btn btn-success" style="font-size: 30px;"><b>Step 2: Add Attachments & Products To Build Your Package</b></button></p>';f

        $image1 = $d["eq_image"];
        //$image2 = trim($image1, '"');
        $imgpath = json_decode($image1);

        $html .= '<div class="col-md-5"><h2 style="padding: 10px;margin: 15px;color: green;">' . $b["package_name"] . '</h2><img class="img-responsive img-thumbnail" src="../img/equip_images/' . $imgpath[0] . '"></div>';
        $html .= '<div class="col-md-7 packs"><p><img src="../img/tractorbuilder/step2.png" /> <span style="font-size: 25px; color: #005000;">&nbsp;<b>Add Attachments & Products</b></span></p><small>Click on images to learn more.</small><br><br>';

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
                $imageZ = '<img class="img-responsive builderlink" src="img/' . $image . '" data-eqimage="img/' . $image . '" data-eqtitle="' . $dropnow[$i]["title"] . '">';
            } elseif (isset($prodDetails["iscustom"])) {
                $imageZ = '<img id="attach-modal"class="img-responsive builderlink" src="img/' . $image . '" data-eqlink="New-Equipment/' . $dropnow[$i]["title"] . '">';
            } else {
                $imageZ = '<img class="img-responsive builderlink" src="img/' . $image . '" data-eqlink="New-Equipment/' . $dropnow[$i]["title"] . '">';
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
        $html .= '<br>';
        $html .= '<p><img src="../img/tractorbuilder/step3.png" /> <span style="font-size: 25px; color: #005000;">&nbsp;<b>Let Us Know How To Reach Youuuuu</b></span></p>';
        $html .= '<br>';
        $html .= '<div class="formbox" style="padding-left:20px;">';
        //$html .= '<br>';
        $html .= '<div class="col-md-12"><label>Full Name:</label><br><input id="full_name" name="full_name" class="form-control" type="text" required></div>';
        $html .= '<input type="hidden" id="url" name="url" class="form-control" value=""/>';
        $html .= '<div class="col-md-6"><label>Email:</label><br><input id="email" name="email" class="form-control" type="email" required></div>';
        $html .= '<div class="col-md-6"><label>Phone:</label><br><input id="phone" name="phone" class="form-control" type="text" required></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div class="col-md-12"><label>Zip:</label><br><input id="zip" name="zip" class="form-control" type="text" required></div>';
        $html .= '<div class="col-md-12"><label>Comments:</label><br><textarea id="comment" name="comment" class="form-control" type="text"></textarea></div>';
        $html .= '</br>';
        $html .= '<p><img src="../img/tractorbuilder/step4.png"/> <span style="font-size: 25px; color: #005000;">&nbsp;<b>Click Submit To Send Your Request</b></span></p>';
        //$html .= '<button type="submit" style="float: right" class="btn btn-success" style="font-size:30px;">Request Special "Package Deal" Pricing</button>';
        $html .= '<button type="submit" style="margin-bottom: 55px;" class="btn btn-success">Submit Request</button>';
        $html .= '</div>';

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