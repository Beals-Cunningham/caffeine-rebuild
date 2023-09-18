<?php
if(file_exists('../../inc/harness.php')){
    include('../../inc/harness.php');
}else{
    include('inc/harness.php');
}

include('functions.php');
$tractorstuff = new tractorclass();
$act = $_REQUEST["action"];

if($act == 'getcustomdrags'){
    if(file_exists('../../inc/harness.php')){
        include('../../inc/harness.php');
    }else{
        include('inc/harness.php');
    }
    $realCats = $tractorstuff->getCustomItem();

    if($realCats != null) {
        for ($b = 0; $b <= count($realCats); $b++) {
            if ($realCats[$b]["title"] != null) {
                $categoryOutReal .= '<div class="productitem draggable" data-thename="' . $realCats[$b]["title"] . '" data-listtype="product" data-linetype="Custom" style="padding: 5px; text-align: center; background: #fff; margin: 5px; cursor:pointer"><div class="dragsa col-md-2" style="cursor:move; text-align: left"><img style="width: 6px" src="img/grip.png"></div><div class="col-md-10" style="text-align: left">' . $realCats[$b]["title"] . ' | <a href="javascript:editAddon(\''.$realCats[$b]["id"].'\')">Edit</a></div><div class="clearfix"></div></div>';
            }
        }
    }else{
        $categoryOutReal = '<div class="col-md-12"><div class="box_message">No active categories.</div></div>';
    }

    echo $categoryOutReal;


}

if($act == 'filtercustomcats'){
    if(file_exists('../../inc/harness.php')){
    include('../../inc/harness.php');
}else{
    include('inc/harness.php');
}
    $realCats = $site->getEqCats($_REQUEST["filter"]);

    if($realCats != null) {
        for ($b = 0; $b <= count($realCats); $b++) {
            if ($realCats[$b]["catname"] != null) {
                $categoryOutReal .= '<div class="productitem draggable" data-thename="' . $realCats[$b]["catname"] . '" data-listtype="category" style="padding: 5px; text-align: center; background: #fff; margin: 5px; cursor:pointer"><div class="dragsa col-md-2" style="cursor:move; text-align: left"><img style="width: 6px" src="img/grip.png"></div><div class="col-md-10" style="text-align: left">' . $realCats[$b]["catname"] . '</div><div class="clearfix"></div></div>';
            }
        }
    }else{
        $categoryOutReal = '<div class="col-md-12"><div class="box_message">No active categories.</div></div>';
    }

    echo $categoryOutReal;
}

if($act == 'createaddon'){
    if(file_exists('../../inc/harness.php')){
    include('../../inc/harness.php');
}else{
    include('inc/harness.php');
}
    $html .= '<div style="padding:10px">';
    $html .= '<form name="item_creator" id="item_creator" method="post" action="">';
    //$html .= '<div class="row"><div class="col-md-12" style="margin-top:10px"><input type="text" style="background: #fff;" class="form-control" name="cat_ser_og" id="cat_ser_og" placeholder="Search Products" data-list=".dragbox" autocomplete="off" value=""> <span class="input-group-btn"></span></div></div>';
    $html .= '<div class="row">';
    $html .= '<div class="col-md-4" style="padding-left:5px; padding-right:5px;"><label>Name/Model Number</label><br><input class="form-control" type="text" name="addonname" id="addonname" placeholder="Search Products" autocomplete="off"><div class="results-out"></div></div><div class="col-md-4" style="padding-left:5px; padding-right:5px;"><label>Short Description</label><input class="form-control" placeholder="limit:25 characters" id="addondetails" name="addondetails"/></div><div class="col-md-4" style="padding-left:5px; padding-right:5px;"><label>Add-On Price</label><br><input class="form-control" type="text" name="addonprice" id="addonprice"></div>';
    $html .= '</div>';
    $html .= '<div class="row">';
    $html .= '<br>';
    $html .= '<div class="input-group col-md-12" style="padding-left: 5px; padding-right: 10px;"><input type="text" class="form-control" name="cat_img" id="cat_img" placeholder="No Image" value=""><span class="input-group-btn"><button class="btn btn-primary img-browser" style="border: solid thin #ccc;background: #cccccc; color: #333;" data-setter="cat_img" type="button">Browse Images</button></span></div>';
    $html .= '<p style="padding-left: 10px;font-weight: bold;">If Product not found</p>';
    $html .= '<div class="col-md-12" style="padding-left: 5px;"><input name="addoncheck" type="checkbox" id="addoncheck" value="checked"/> Select to Add a Custom Product</label></div>';
    $html .= '<br>';
    $html .= '</div><button class="btn btn-success btn-fill" type="submit">Save</button>';
    $html .= '</form>';

    echo $html;
}

if($act == 'finishaddon'){
    if(file_exists('../../inc/harness.php')){
    include('../../inc/harness.php');
}else{
    include('inc/harness.php');
}
    $site->addAddons($_POST);
    echo '<div class="alert alert-success">Item has been successfully added.</div>';
}

if($act == 'editaddon'){
    if(file_exists('../../inc/harness.php')){
    include('../../inc/harness.php');
}else{
    include('inc/harness.php');
}
    $details = $site->getCustomItems($_REQUEST["id"]);

    $html .= '<div style="padding:10px">';
    $html .= '<form name="item_creator_edit" id="item_creator_edit" method="post" action="">';
    //$html .= '<div class="input-group col-md-12" style="margin-top:10px"><input type="text" style="background: #fff" class="form-control" name="cat_ser_two" id="cat_ser_two" placeholder="Search Categories" data-list=".dragbox" autocomplete="off" value=""> <span class="input-group-btn"><button class="btn btn-primary ser-thcats1" style="border: solid thin #ccc;background: #cccccc; color: #333;" type="button" </button></span></div></div>';
    $html .= '<div><label>Name/Model Number</label><br><input class="form-control" type="text" name="addonname" id="addonname" value="'.$details["addon_name"].'"></div><br><br>';
    $html .= '<div class="input-group col-md-12"><input type="text" class="form-control" name="cat_img" id="cat_img" placeholder="No Image" value="'.$details["addon_image"].'"><span class="input-group-btn"><button class="btn btn-primary img-browser" style="border: solid thin #ccc;background: #cccccc; color: #333;" data-setter="cat_img" type="button">Browse Images</button></span></div>';
    $html .= '<div><label>Add-On Price</label><br><input class="form-control" type="text" name="addonprice" id="addonprice" value="'.$details["addon_price"].'"></div><br><br>';
    $html .= '<div><label>Details</label><br><textarea class="form-control" id="addondetails" name="addondetails">'.$details["addon_details"].'</textarea></div><br><br>';
    $html .= '<input type="hidden" name="itemnum" id="itemnum" value="'.$_REQUEST["id"].'">';
    $html .= '<div class="container"><br/>';
    $html .= '<div class="form-group">';
    //$html .= '<div class="" id="addoncheck" name="addoncheck[]" value="checked">';
    //$html .= '<label data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">';
    //$html .= '<input type="checkbox" id="addoncheck" name="addoncheck[]" value="'.$details["checkbox"].'"/> Product does not exists</label>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '<div id="collapseOne" aria-expanded="false" class="collapse">';
    $html .= '<label for="name">Name:</label>';
    $html .= '<input type="text" name="name" id="name" value="'.$details["new_name"].'">';
    $html .= '</div>';
    $html .= '<button class="btn btn-success btn-fill">Update</button>';
    $html .= '</form>';
    $html .= '</div>';

    echo $html;
}

if($act == 'editfinishaddon'){
    if(file_exists('../../inc/harness.php')){
    include('../../inc/harness.php');
}else{
    include('inc/harness.php');
}
    $site->editAddons($_POST);
    echo '<div class="alert alert-success">Item has been successfully updated.</div>';
}

if($act == 'createbean'){
    if(file_exists('../../inc/harness.php')){
        include('../../inc/harness.php');
    }else{
        include('inc/harness.php');
    }
    $data->query("INSERT INTO beans SET bean_name = '".$data->real_escape_string($_REQUEST["beanname"])."', bean_type = 'native', user_type = 'all', created = '".time()."', bean_id = '".$_REQUEST["bean_id"]."', category = '$category', active = 'true'");
}

