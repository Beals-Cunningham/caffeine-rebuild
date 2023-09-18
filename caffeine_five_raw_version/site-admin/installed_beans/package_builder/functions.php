<?php
if(file_exists('../../inc/harness.php')){
    include('../../inc/harness.php');
}else{
    include('inc/harness.php');
}
class tractorclass {


    function editAddons($post)
    {
        if(file_exists('../../inc/harness.php')){
        include('../../inc/harness.php');
    }else{
        include('inc/harness.php');
    }
        $data->query("UPDATE custom_addons SET addon_name = '" . $data->real_escape_string($post["addonname"]) . "', addon_image = '" . $data->real_escape_string($post["cat_img"]) . "', addon_price = '" . $data->real_escape_string($post["addonprice"]) . "',new_name = '" . $data->real_escape_string($post["name"]) . "', addon_details = '" . $data->real_escape_string($post["addondetails"]) . "' WHERE id = '" . $post["itemnum"] . "'");
    }

    function addAddons($post)
    {
        if(file_exists('../../inc/harness.php')){
        include('../../inc/harness.php');
    }else{
        include('inc/harness.php');
    }

        if ($_POST["addoncheck"]= "checked") {
            $data->query("INSERT INTO custom_addons SET addon_name = '" . $data->real_escape_string($post["addonname"]) . "', addon_image = '" . $data->real_escape_string($post["cat_img"]) . "', addon_price = '" . $data->real_escape_string($post["addonprice"]) . "',checkbox = '" . $data->real_escape_string($post["addoncheck"]) . "' ,new_name = '" . $data->real_escape_string($post["name"]) . "', addon_details = '" . $data->real_escape_string($post["addondetails"]) . "', created = '" . time() . "'");

        } else {
            $data->query("INSERT INTO custom_addons SET addon_name = '" . $data->real_escape_string($post["addonname"]) . "', addon_image = '" . $data->real_escape_string($post["cat_img"]) . "', addon_price = '" . $data->real_escape_string($post["addonprice"]) . "',new_name = '" . $data->real_escape_string($post["name"]) . "', addon_details = '" . $data->real_escape_string($post["addondetails"]) . "', created = '" . time() . "'");
        }
    }


    function getProdsItem($title)
    {
        if(file_exists('../../inc/harness.php')){
        include('../../inc/harness.php');
    }else{
        include('inc/harness.php');
    }
        $a = $data->query("SELECT * FROM custom_addons WHERE addon_name LIKE '%$title%'")or die($data->error);
        if ($a->num_rows > 0) {
            while($b = $a->fetch_array()){
                $cats[] = array("title" => $b["addon_name"], "price" => $b["addon_price"], "new_name" => $b["new_name"]);
            }
            return $cats;
        } else {
            $c = $data->query("SELECT * FROM deere_equipment WHERE title LIKE '%$title%'")or die($data->error);
            if ($c->num_rows > 0) {
                while($d = $c->fetch_array()){
                    $cats[] = array("title" => $d["title"], "price" => $d["price"], "sub_title" => $d["sub_title"], "parent_cat" => $d["parent_cat"]);
                }
                return $cats;
            } else {
                $e = $data->query("SELECT * FROM kuhn_equipment WHERE title LIKE '%$title%'")or die($data->error);
                if ($e->num_rows > 0) {
                    while($f = $e->fetch_array()){
                        $cats[] = array("title" => $f["title"], "price" => $f["price"],"cat_one" => $f["cat_one"], "parent_cat" => $f["parent_cat"],"cat_two" => $f["cat_two"])or die($data->error);
                    }
                    return $cats;
                } else {
                    $g = $data->query("SELECT * FROM woods_equipment WHERE title LIKE '%$title%'")or die($data->error);
                    if ($g->num_rows > 0) {
                        while($h = $g->fetch_array()){
                            $cats[] = array("title" => $h["title"], "price" => $h["price"],"cat_one" => $h["cat_one"], "parent_cat" => $h["parent_cat"]);
                        }
                        return $cats;
                    }
                }
            }
        }

    }


    function getCustomItems($id)
    {
        if(file_exists('../../inc/harness.php')){
        include('../../inc/harness.php');
    }else{
        include('inc/harness.php');
    }
        $a = $data->query("SELECT * FROM custom_addons WHERE id = '$id'");
        $b = $a->fetch_array();

        return $b;
    }

    function getCustomItem()
    {
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }
        $a = $data->query("SELECT * FROM custom_addons WHERE active = 'true' ORDER BY addon_name ASC") or die($data->error);
        while ($b = $a->fetch_array()) {
            $catOut[] = array("title" => $b["addon_name"], "id" => $b["id"]);
        }

        return $catOut;
    }

    function getPackagePages()
    {
        if(file_exists('../../inc/harness.php')){
        include('../../inc/harness.php');
    }else{
        include('inc/harness.php');
    }
        $a = $data->query("SELECT * FROM package_deals WHERE active = 'true' ORDER BY package_name DESC");
        while ($b = $a->fetch_array()) {
            $packs[] = $b;
        }
        return $packs;
    }

    function getPackageDetails($id)
    {
        if(file_exists('../../inc/harness.php')){
        include('../../inc/harness.php');
    }else{
        include('inc/harness.php');
    }
        $a = $data->query("SELECT * FROM package_deals WHERE id = '$id'");
        $b = $a->fetch_array();

        return $b;
    }

    function updatePackage($post)
    {
        if(file_exists('../../inc/harness.php')){
        include('../../inc/harness.php');
    }else{
        include('inc/harness.php');
    }
        $addons = json_encode($post["dropped-info"]);
        $data->query("UPDATE package_deals SET package_name = '" . $data->real_escape_string($post["package_name"]) . "', equip_for = '" . $data->real_escape_string($post["tags"]) . "', package_info = '" . $data->real_escape_string($post["package_info"]) . "', addons = '" . $data->real_escape_string($addons) . "' WHERE id = '" . $post["packageid"] . "'");
    }

    function createPackage($post)
    {
        if(file_exists('../../inc/harness.php')){
        include('../../inc/harness.php');
    }else{
        include('inc/harness.php');
    }
        $addons = json_encode($post["dropped-info"]);
        $packagename = 'package_builder-packageCall-'.$post["token"];
        $data->query("INSERT INTO package_deals SET package_name = '" . $data->real_escape_string($post["package_name"]) . "', equip_for = '" . $data->real_escape_string($post["tags"]) . "', package_info = '" . $data->real_escape_string($post["package_info"]) . "', addons = '" . $data->real_escape_string($addons) . "', created = '" . time() . "', token = '". $packagename . "'");
    }

    function getEqCats($filter){
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }
        if($filter != null && $filter != 'all'){
            $addSql = "AND cat_type = '$filter'";
        }else{
            $addSql = '';
        }
        $a = $data->query("SELECT * FROM pages WHERE iseqcat = 'true' AND line_type = 'deere' $addSql ORDER BY page_name ASC")or die($data->error);
        while($b = $a->fetch_array()){
            $catOut[] = array("catname"=>$b["page_name"],"catid"=>$b["id"]);
        }

        return $catOut;
    }


}