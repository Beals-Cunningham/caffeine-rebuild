<?php
include('config.php');
$act = $_REQUEST["action"];

if($act == 'requestcat'){
    $sel .= '<option value="none">Select Option</option>';
    if($_REQUEST["manufacturer"] != 'none') {
        $a = $data->query("SELECT * FROM used_equipment WHERE manufacturer = '" . $_REQUEST["manufacturer"] . "' AND active != 'false' GROUP BY category");
    }else{
        $a = $data->query("SELECT * FROM used_equipment WHERE active != 'false' GROUP BY category");
    }
    while($b = $a->fetch_array()){
        $sel .= '<option value="'.$b["category"].'">'.$b["category"].'</option>';
    }
    echo $sel;
}

if($act == 'updateimgpos'){
    $profid = $_REQUEST["profid"];
    $lefts = $_REQUEST["left"];
    $top = $_REQUEST["top"];
    $site->updateImgPos($profid,$lefts,$top);
}



if($act == 'saveforlater'){
    $total = 0;
    session_start();
    $eqipid = $_POST["eqipid"];
    $eqname = $_POST["eqname"];
    $eqtype = $_POST["eqtype"];
    $price = $_POST["price"];
    $url = $_POST["url"];
    $theSession = $_COOKIE["savedData"];


    if(isset($theSession)){
        $theSession = json_decode($theSession,true);
        for($i=0; $i < count($theSession); $i++){
            $mydata[] = array("machine"=>array("id"=>$theSession[$i]["machine"]["id"],"name"=>$theSession[$i]["machine"]["name"], "eqtype"=>$theSession[$i]["machine"]["eqtype"], "price"=>$theSession[$i]["machine"]["price"], "url"=>$theSession[$i]["machine"]["url"]));
        }

        $mydata[] = array("machine"=>array("id"=>$eqipid,"name"=>$eqname, "eqtype"=>$eqtype, "price"=>$price, "url"=>$url));

        $eq = json_encode($mydata);
        setcookie("savedData", $eq,time() + (86400 * 30),"/", false);

        $theSessionOut = json_decode($eq,true);
            for ($i = 0; $i < count($theSessionOut); $i++) {
                if ($theSessionOut[$i]["machine"]["eqtype"] == 'deere') {
                    $mydataOut[] = array("machine" => array("id" => $theSessionOut[$i]["machine"]["id"], "name" => $theSessionOut[$i]["machine"]["name"], "eqtype" => $theSession[$i]["machine"]["eqtype"], "price"=>$theSession[$i]["machine"]["price"], "url" => $theSessionOut[$i]["machine"]["url"]));
                    $a = $data->query("SELECT * FROM deere_equipment WHERE id = '" . $theSessionOut[$i]["machine"]["id"] . "'") or die($data->error);
                    $b = $a->fetch_array();
                    $img = 'img/' . $b["eq_image"];
                    $htmlOG .= '<div style="display: block; padding: 0; margin: 1px; text-align: center; border-bottom:solid thin #efefef; width:300px">
                    <div class="col-md-4" style="padding: 0"><div style="width:40px; height: 40px; background: #efefef; background-image:url(\'' . $img . '\'); background-position: center; background-size:cover  "></div></div><div class="col-md-8" style="padding: 0"><a href="' . $theSessionOut[$i]["machine"]["url"] . '">' . $theSessionOut[$i]["machine"]["name"] . '</a><br><a href="" class="text-danger"><i class="fa fa-times"></i> remove</a></div>
                    <div class="clearfix"></div>
                </div>';

                    $html .= ' <li class="clearfix">
                            <a href="' . $theSessionOut[$i]["machine"]["url"] . '"><div style="width:50px; height: 50px; background: #efefef; background-image:url(\'' . $img . '\'); background-position: center; background-size:cover;  float:left; margin:20px"></div></a>
                            <span class="item-name">' . $theSessionOut[$i]["machine"]["name"] . '</span>
                            <span class="item-price">$'.number_format($theSessionOut[$i]["machine"]["price"],2).'</span>
                            <span class="item-quantity">Quantity: 01</span><br>
                            <a href="javascript:void(0)" onclick="removeSaved(\'' . $theSessionOut[$i]["machine"]["name"] . '\')" class="text-danger"><i class="fa fa-times"></i> remove</a>
                        </li>';

                    $thePrice .= $theSession[$i]["machine"]["price"];
                }

                if ($theSessionOut[$i]["machine"]["eqtype"] == 'honda') {
                    $mydataOut[] = array("machine" => array("id" => $theSessionOut[$i]["machine"]["id"], "name" => $theSessionOut[$i]["machine"]["name"], "eqtype" => $theSession[$i]["machine"]["eqtype"], "price"=>$theSession[$i]["machine"]["price"], "url" => $theSessionOut[$i]["machine"]["url"]));
                    $a = $data->query("SELECT * FROM honda_equipment WHERE id = '" . $theSessionOut[$i]["machine"]["id"] . "'") or die($data->error);
                    $b = $a->fetch_array();
                    $outImg = json_decode($b["eq_image"]);
                    $img = 'img/Honda/' . $outImg[0];
                    $htmlOG .= '<div style="display: block; padding: 0; margin: 1px; text-align: center; border-bottom:solid thin #efefef; width:300px">
                    <div class="col-md-4" style="padding: 0"><div style="width:40px; height: 40px; background: #efefef; background-image:url(\'' . $img . '\'); background-position: center; background-size:cover  "></div></div><div class="col-md-8" style="padding: 0"><a href="' . $theSessionOut[$i]["machine"]["url"] . '">' . $theSessionOut[$i]["machine"]["name"] . '</a><br><a href="" class="text-danger"><i class="fa fa-times"></i> remove</a></div>
                    <div class="clearfix"></div>
                </div>';

                    $html .= ' <li class="clearfix">
                            <a href="' . $theSessionOut[$i]["machine"]["url"] . '"><div style="width:50px; height: 50px; background: #efefef; background-image:url(\'' . $img . '\'); background-position: center; background-size:cover;  float:left; margin:20px"></div></a>
                            <span class="item-name">' . $theSessionOut[$i]["machine"]["name"] . '</span>
                            <span class="item-price">$'.number_format($theSessionOut[$i]["machine"]["price"],2).'</span>
                            <span class="item-quantity">Quantity: 01</span><br>
                            <a href="javascript:void(0)" onclick="removeSaved(\'' . $theSessionOut[$i]["machine"]["name"] . '\')" class="text-danger"><i class="fa fa-times"></i> remove</a>
                        </li>';

                    $thePrice .= $theSession[$i]["machine"]["price"];
                }

                if ($theSessionOut[$i]["machine"]["eqtype"] == 'stihl') {
                    $mydataOut[] = array("machine" => array("id" => $theSessionOut[$i]["machine"]["id"], "name" => $theSessionOut[$i]["machine"]["name"], "eqtype" => $theSession[$i]["machine"]["eqtype"], "price"=>$theSession[$i]["machine"]["price"], "url" => $theSessionOut[$i]["machine"]["url"]));
                    $a = $data->query("SELECT * FROM stihl_equipment WHERE id = '" . $theSessionOut[$i]["machine"]["id"] . "'") or die($data->error);
                    $b = $a->fetch_array();
                    $outImg = json_decode($b["eq_image"]);
                    $img = 'img/Stihl/' . $outImg[0];
                    $htmlOG .= '<div style="display: block; padding: 0; margin: 1px; text-align: center; border-bottom:solid thin #efefef; width:300px">
                    <div class="col-md-4" style="padding: 0"><div style="width:40px; height: 40px; background: #efefef; background-image:url(\'' . $img . '\'); background-position: center; background-size:cover  "></div></div><div class="col-md-8" style="padding: 0"><a href="' . $theSessionOut[$i]["machine"]["url"] . '">' . $theSessionOut[$i]["machine"]["name"] . '</a><br><a href="" class="text-danger"><i class="fa fa-times"></i> remove</a></div>
                    <div class="clearfix"></div>
                </div>';

                    $html .= ' <li class="clearfix">
                            <a href="' . $theSessionOut[$i]["machine"]["url"] . '"><div style="width:50px; height: 50px; background: #efefef; background-image:url(\'' . $img . '\'); background-position: center; background-size:cover;  float:left; margin:20px"></div></a>
                            <span class="item-name">' . $theSessionOut[$i]["machine"]["name"] . '</span>
                            <span class="item-price">$'.number_format($theSessionOut[$i]["machine"]["price"],2).'</span>
                            <span class="item-quantity">Quantity: 01</span><br>
                            <a href="javascript:void(0)" onclick="removeSaved(\'' . $theSessionOut[$i]["machine"]["name"] . '\')" class="text-danger"><i class="fa fa-times"></i> remove</a>
                        </li>';

                    $thePrice .= $theSession[$i]["machine"]["price"];
                }

                $total += $theSessionOut[$i]["machine"]["price"];
            }

            $html .= '<input type="hidden" id="cart_total" name="cart_total" value="'.number_format($total,2).'">';

        echo $html;



    }else{
        $mydata[] = array("machine"=>array("id"=>$eqipid,"name"=>$eqname,"eqtype"=>$eqtype, "price"=>$price,"url"=>$url));
        $eq = json_encode($mydata);
        if($eqtype == 'deere') {
            setcookie("savedData", $eq, time() + (86400 * 30), "/", false);
            $a = $data->query("SELECT * FROM deere_equipment WHERE id = '" . $eqipid . "'") or die($data->error);
            $b = $a->fetch_array();
            $img = 'img/' . $b["eq_image"];
            $htmlOG .= '<div style="display: block; padding: 0; margin: 1px; text-align: center; border-bottom:solid thin #efefef; width:300px">
                    <div class="col-md-4" style="padding: 0"><div style="width:40px; height: 40px; background: #efefef; background-image:url(\'' . $img . '\'); background-position: center; background-size:cover  "></div></div><div class="col-md-8" style="padding: 0"><a href="' . $url . '">John Deere ' . $eqname . ',</a><br><a href="" class="text-danger"><i class="fa fa-times"></i> remove</a></div>
                    <div class="clearfix"></div>
                </div>';
            $html .= ' <li class="clearfix">
                            <a href="' . $url . '"><div style="width:50px; height: 50px; background: #efefef; background-image:url(\'' . $img . '\'); background-position: center; background-size:cover;  float:left; margin:20px"></div></a>
                            <span class="item-name">' . $eqname . '</span>
                            <span class="item-price">$'.number_format($price,2).'</span>
                            <span class="item-quantity">Quantity: 01</span><br>
                            <a href="javascript:void(0)" onclick="removeSaved(\'' . $eqname . '\')" class="text-danger"><i class="fa fa-times"></i> remove</a>
                        </li>';
        }

        if($eqtype == 'honda') {
            setcookie("savedData", $eq, time() + (86400 * 30), "/", false);
            $a = $data->query("SELECT * FROM honda_equipment WHERE id = '" . $eqipid . "'") or die($data->error);
            $b = $a->fetch_array();
            $outImg = json_decode($b["eq_image"]);
            $img = 'img/Honda/' . $outImg[0];
            $htmlOG .= '<div style="display: block; padding: 0; margin: 1px; text-align: center; border-bottom:solid thin #efefef; width:300px">
                    <div class="col-md-4" style="padding: 0"><div style="width:40px; height: 40px; background: #efefef; background-image:url(\'' . $img . '\'); background-position: center; background-size:cover  "></div></div><div class="col-md-8" style="padding: 0"><a href="' . $url . '">John Deere ' . $eqname . ',</a><br><a href="" class="text-danger"><i class="fa fa-times"></i> remove</a></div>
                    <div class="clearfix"></div>
                </div>';
            $html .= ' <li class="clearfix">
                            <a href="' . $url . '"><div style="width:50px; height: 50px; background: #efefef; background-image:url(\'' . $img . '\'); background-position: center; background-size:cover;  float:left; margin:20px"></div></a>
                            <span class="item-name">' . $eqname . '</span>
                            <span class="item-price">$'.number_format($price,2).'</span>
                            <span class="item-quantity">Quantity: 01</span><br>
                            <a href="javascript:void(0)" onclick="removeSaved(\'' . $eqname . '\')" class="text-danger"><i class="fa fa-times"></i> remove</a>
                        </li>';
        }

        if($eqtype == 'stihl') {
            setcookie("savedData", $eq, time() + (86400 * 30), "/", false);
            $a = $data->query("SELECT * FROM stihl_equipment WHERE id = '" . $eqipid . "'") or die($data->error);
            $b = $a->fetch_array();
            $outImg = json_decode($b["eq_image"]);
            $img = 'img/Stihl/' . $outImg[0];
            $htmlOG .= '<div style="display: block; padding: 0; margin: 1px; text-align: center; border-bottom:solid thin #efefef; width:300px">
                    <div class="col-md-4" style="padding: 0"><div style="width:40px; height: 40px; background: #efefef; background-image:url(\'' . $img . '\'); background-position: center; background-size:cover  "></div></div><div class="col-md-8" style="padding: 0"><a href="' . $url . '">John Deere ' . $eqname . ',</a><br><a href="" class="text-danger"><i class="fa fa-times"></i> remove</a></div>
                    <div class="clearfix"></div>
                </div>';
            $html .= ' <li class="clearfix">
                            <a href="' . $url . '"><div style="width:50px; height: 50px; background: #efefef; background-image:url(\'' . $img . '\'); background-position: center; background-size:cover;  float:left; margin:20px"></div></a>
                            <span class="item-name">' . $eqname . '</span>
                            <span class="item-price">$'.number_format($price,2).'</span>
                            <span class="item-quantity">Quantity: 01</span><br>
                            <a href="javascript:void(0)" onclick="removeSaved(\'' . $eqname . '\')" class="text-danger"><i class="fa fa-times"></i> remove</a>
                        </li>';
        }

        $html .= '<input type="hidden" id="cart_total" name="cart_total" value="'.number_format($price,2).'">';

        echo $html;
    }


}

if($act == 'removesaved'){
    include('siteFunctions.php');
    $a = new site();
    $outty = $a->removeSave($_REQUEST["varid"]);

}

if($act == 'getcartitems'){
    include('siteFunctions.php');
    $a = new site();
    $outty = $a->getSaves();

    echo $outty["saves"].'<input type="hidden" id="cart_total" name="cart_total" value="'.number_format($outty["total"],2).'">';

}

if($act == 'submitreview'){
    include('siteFunctions.php');
    $a = new site();
    $a->processReview($_POST);

}

if($act == 'destroycart'){
    echo "We are going";
    include('siteFunctions.php');
    $a = new site();
    session_start();
    setcookie("savedData", '', time() - (86400 * 30), "/", false);
    $results = $a->destroyCart();
    echo "This is ".$results;
}

if($act == 'eventtrak'){
    include('siteFunctions.php');
    $a = new site();
    $a->saveCaffEvent($_REQUEST["target"],$_REQUEST["page"]);
}
