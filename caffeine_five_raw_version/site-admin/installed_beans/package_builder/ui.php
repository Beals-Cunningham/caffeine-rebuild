<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('America/Chicago');

$modFolder = 'installed_beans/package_builder';
include('../package_builder/functions.php');
if(file_exists('../../inc/harness.php')){
    include('../../inc/harness.php');
}else{
    include('inc/harness.php');
}
$site = new tractorclass();

?>


<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="../../plugins/switchery/switchery.min.css" rel="stylesheet" />

    <link href="../../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../../codemirror/lib/codemirror.css"/>
    <link rel="stylesheet" href="../../codemirror/theme/mbo.css">
    <link href="../../assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="../../plugins/sweet-alert/sweetalert2.min.css" rel="stylesheet">
    <link href="../../plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="../../plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="../../plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- Multi Item Selection examples -->
    <link href="../../plugins/datatables/select.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="../../plugins/nestable/jquery.nestable.css" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/bootstrap-datetimepicker.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="../../assets/css/style.css" rel="stylesheet" type="text/css">

    <style>
        .dropitemsin {
            padding: 10px;
            text-align: center;
            background: #f5dda3;
            margin: 2px;
            font-weight: bold;
        }

        .droparea {
            padding: 20px;
            background: #efefef;
            border: dashed thin #333;
        }
    </style>

    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js" integrity="" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <script src="js/bootstrap-switch.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
    <script src="js/carousel-back.js"></script>
    <!-- Required datatable js -->
    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- Buttons examples -->

    <!-- Key Tables -->
    <script src="../../plugins/datatables/dataTables.keyTable.min.js"></script>

    <!-- Responsive examples -->
    <script src="../../plugins/datatables/dataTables.responsive.min.js"></script>
    <script src="../../plugins/datatables/responsive.bootstrap4.min.js"></script>

    <!-- Selection table -->
    <script src="../../plugins/datatables/dataTables.select.min.js"></script>

    <script src="../../codemirror/lib/codemirror.js"></script>
    <script src="../../codemirror/mode/css/css.js"></script>
    <script src="../../codemirror/mode/javascript/javascript.js"></script>
    <script src="../../codemirror/mode/xml/xml.js"></script>
    <script src="../../codemirror/mode/htmlmixed/htmlmixed.js"></script>
    <script src="../../tinymce/js/tinymce/tinymce.min.js"></script>
    <script src="js/md5.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/jquery.hideseek.js"></script>
    <script src="../../plugins/sweet-alert/sweetalert2.min.js"></script>
    <script src="../../assets/pages/jquery.sweet-alert.init.js"></script>
    <style>

    <title>Hello, world!</title>

    <style>
        .modal-lg {
            max-width: 80%;
        }

    </style>
</head>
<body>
<?php
error_reporting(0);
date_default_timezone_set('America/Chicago');
?>
<?php
if(isset($_REQUEST["createnew"])){

    ?>


<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog" style="z-index: 1044">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modal Header</h4>
            </div>
            <div class="modal-body">
                <p>Some text in the modal.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<!-- Modal -->
<div id="myModalAS" class="modal fade" role="dialog" style="z-index: 1044">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modal Header</h4>
            </div>
            <div class="modal-body">
                <p>Some text in the modal.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>


<div class="wrapper">
    <div class="sidebar" data-background-color="white" data-active-color="danger">

        <!--
            Tip 1: you can change the color of the sidebar's background using: data-background-color="white | black"
            Tip 2: you can change the color of the active button using the data-active-color="primary | info | success | warning | danger"
        -->

        <?php include('inc/sidebar.php'); ?>
    </div>

    <div class="main-panel">
        <?php include('inc/top_nav.php'); ?>


        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Packages</h4>
                                <p class="category">Create and edit package deals.</p>




                                <div class="clearfix"></div>
                            </div>

                            <div style="padding: 20px">

                                <?php
                                if(isset($_POST["package_name"])){

                                    $packName = preg_replace('/[^A-Za-z0-9]/', "", $_POST["package_name"]).'-'.substr(md5(time().$_POST["package_name"]), 0, 7);

                                    $_POST['token'] = $packName;

                                    $site->createPackage($_POST);

                                    echo '<div class="alert alert-success" role="alert"><strong>Well done!</strong> The package has been created successfully.</div>';



                                    echo '<small>You can copy and paste the usage code below into any page to output the package.</small><br><br>';
                                    echo '<code style="padding: 10px">The usage code is: {mod}package_builder-packageCall-'.$packName.'{/mod}</code><br><br>';
                                    echo '<a href="" class="btn btn-default">Click here to return to package list.</a>';

                                }else{?>

                                    <form class="validforms" id="package_deals" name="package_deals" method="post" action="">
                                        <div class="row">
                                            <div class="col-md-4"><label>Package Name</label><br><input id="package_name" name="package_name" type="text" class="form-control" required></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8"><label>Search Equipment</label><br>
                                                <input id="tags" name="tags" type="text" class="form-control" placeholder="Search Equipment" required>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label>Package Info</label><br>
                                                <textarea class="form-control" name="package_info" id="package_info"></textarea>
                                            </div>
                                        </div>
                                        <input type="hidden" id="dropped-info" name="dropped-info" value="">
                                    </form>

                                    <div class="row">
                                        <div class="col-md-8" style="padding: 0">
                                            <br>
                                            <small style="padding: 15px">Drag & Drop Items Below</small>
                                            <div class="addscontainer droparea" style="background: #efefef; border:dashed thin #a0a0a0; padding: 30px; margin: 15px"></div><br><br>

                                            &nbsp;&nbsp;&nbsp;<button class="btn btn-success sendform">Save Package</button>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="dragcol" style="background: #efefef; padding: 10px; margin: 15px">
                                                <div class="col-md-12">



                                                    <label>Sort by Type:</label><br>
                                                    <div style="width:100%;" class="btn-group thefilter" role="group" aria-label="Basic example">
<!--                                                        <button style="width: 25%" type="button" class="btn btn-primary btn-xs btn-fill active filterbutton" onclick="filterCustomCats('getfrontierdrags')">Frontier</button>-->
<!--                                                        <button style="width: 25%" type="button" class="btn btn-primary btn-xs btn-fill filterbutton" onclick="filterCustomCats('getwoodsdrags')">Woods</button>-->
<!--                                                        <button style="width: 25%" type="button" class="btn btn-primary btn-xs btn-fill filterbutton" onclick="filterCustomCats('getkuhndrags')">Kuhn</button>-->
                                                        <button style="width: 35%" type="button" class="btn btn-primary btn-xs btn-fill filterbutton" onclick="filterCustomCats('getcustomdrags')">Custom</button>
                                                    </div>
                                                    <div class="input-group col-md-12" style="margin-top:10px"><input type="text" style="background: #fff" class="form-control" name="cat_ser" id="cat_ser" placeholder="Search Categories" data-list=".dragbox" autocomplete="off" value=""> <span class="input-group-btn"><button class="btn btn-primary ser-thcats" style="border: solid thin #ccc;background: #cccccc; color: #333;" type="button">Search</button></span></div></div>
                                                <h4 style="text-align: center">Select Items</h4>
                                                <div class="dragbox" style="height: 250px; overflow-y:scroll; width: 100%"></div><br>
                                                <button class="btn btn-sm btn- btn-fill" onclick="createAddon()">Create Custom Add-on</button>
                                            </div>
                                        </div>
                                    </div>

                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <script src="../../js/jquery.min.js"></script>
    <script src="../../js/jquery.hideseek.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>


    <script>
        $(".validform").validate({
            rules: {
                password: "required",
                confirmpassword: {
                    equalTo: "#password"
                }
            }
        });

        $(function() {
            $(function(){
                $('#cat_ser').hideseek({
                    highlight: true
                });
            })

            $("#tags").autocomplete({
                source: 'asyncData.php?action=getequipmentlist',
                select: function( event, ui ) {
                    event.preventDefault();
                    $("#tags").val(ui.item.value);
                }
            });

            getFrontier();
        });

        function getFrontier(){
            $.ajax({
                url: 'asyncData.php?action=getfrontierdrags',
                success: function(data){
                    $(".dragbox").html(data);
                    $( ".draggable" ).draggable({
                        helper: 'clone',
                        handle: ".dragsa"
                    });

                    intDropable();
                }
            })
        }

        function intDropable(){

            var array = [];
            $( ".droparea" ).droppable({
                connectToSortable: '.droparea',
                drop: function( event, ui ) {
                    var thistype = ui.draggable.data('listtype');
                    var nameout = ui.draggable.data('thename');
                    var itemtype = ui.draggable.data('linetype');
                    if(nameout != undefined) {
                        if (thistype == 'product') {
                            var nowtype = 'Product: ';
                        }
                        if(thistype == 'category') {
                            var nowtype = 'Category: ';
                        }
                        if(thistype == 'htmlarea') {
                            var dt = new Date($.now());
                            nameout = md5(dt);
                            nameout = nameout.substring(0, 8);

                            $.ajax({
                                url:'asyncData.php?action=createbean&beanname=productbean&bean_id='+nameout,
                                success: function(data){
                                    console.log('Completed');
                                    runMiniEdits();
                                }
                            })

                            var nowtype = '<span class="isolatetext">HTML Widget:</span> | <button type="button" class="btn btn-xs btn-default minimodset" data-causedata="'+nameout+'">Edit HTML</button> | ';
                        }
                        $(".droparea").append('<div class="dropitemsin" data-thedrop="'+nameout+'" data-thedroptype="'+thistype+'" data-linetypes="'+itemtype+'">' + nowtype + '' + nameout + ' | <a href="javascript:void(0)" class="removeites"><i class="fa fa-trash" aria-hidden="true"></i> Remove</a></div>');
                    }

                    //dropped-info
                    $('.droparea > .dropitemsin').each(function(){

                        array.push({
                            title: $(this).data('thedrop'),
                            type: $(this).data('thedroptype'),
                            linetype: $(this).data('linetypes')
                        });
                    });
                    var jsonString = JSON.stringify(array);
                    //console.log(jsonString);
                    $("#dropped-info").val(jsonString);
                    array = [];
                    setRemoves();
                }
            });

            $( ".droparea" ).sortable({
                containment: "parent",
                stop: function(event,ui){
                    $('.droparea > .dropitemsin').each(function(){

                        array.push({
                            title: $(this).data('thedrop'),
                            type: $(this).data('thedroptype'),
                            linetype: $(this).data('linetypes')
                        });
                    });
                    var jsonString = JSON.stringify(array);
                    $("#dropped-info").val(jsonString);
                    array = [];
                }
            });
        }

        function setRemoves(){
            $(".removeites").on('click',function(){
                $(this).parent().remove();
                var array = [];
                //dropped-info
                $('.droparea > .dropitemsin').each(function(){
                    array.push({
                        title: $(this).data('thedrop'),
                        type: $(this).data('thedroptype'),
                        linetype: $(this).data('linetypes')
                    });
                });
                var jsonString = JSON.stringify(array);
                //console.log(jsonString);
                $("#dropped-info").val(jsonString);
                array = [];
            })
        }

        function filterCustomCats(type){
            $.ajax({
                url: 'asyncData.php?action='+type,
                cache: false,
                success: function(data){
                    $(".dragbox").html(data);
                    $( ".draggable" ).draggable({
                        helper: 'clone',
                        handle: ".dragsa"
                    });

                    intDropable();
                }
            })
        }

        $(function(){
            $(".filterbutton").on('click',function(){

                $('.filterbutton').each(function(i, obj) {
                    $(this).removeClass('active');
                });

                $(this).addClass('active');
            })
        })

        $(function(){
            $(".sendform").on('click',function(){
                $("#package_deals").submit();
            })


        })

        function createAddon(){
            $.ajax({
                url: 'asyncData.php?action=createaddon',
                cache: false,
                success:function(data){
                    $("#myModal .modal-title").html('Create Add-On');
                    $("#myModal .modal-body").html(data);
                    $("#myModal").modal();
                    $("#item_creator").validate({
                        submitHandler: function(form) {
                            $.ajax({
                                type: "POST",
                                url: "asyncData.php?action=finishaddon",
                                cache: false,
                                data: $("#item_creator").serialize(),
                                success: function(data)
                                {
                                    $('#myModal .modal-body').html(data);

                                    filterCustomCats('getcustomdrags');
                                    $( ".thefilter button").removeClass('active');
                                    $( ".thefilter button:last" ).addClass('active');
                                }
                            });
                        }
                    });
                    $(".img-browser").on('click',function(){
                        var itemsbefor = $(this).data('setter');
                        $("#myModalAS .modal-title").html('Select an Image For Link');
                        $("#myModalAS .modal-body").html('<iframe id="themedia" style="width: 100%; height: 450px; border: none" src="filedfiles.php?typeset=simple&fldset='+itemsbefor+'"></iframe>');
                        $(".modal-dialog").css('width','869px');
                        $("#myModalAS").modal();
                    })
                }
            })

        }

        function editAddon(id){
            $.ajax({
                url: 'asyncData.php?action=editaddon&id='+id,
                cache: false,
                success:function(data){
                    $("#myModal .modal-title").html('Edit Add-On');
                    $("#myModal .modal-body").html(data);
                    $("#myModal").modal();
                    $("#item_creator_edit").validate({
                        submitHandler: function(form) {
                            $.ajax({
                                type: "POST",
                                url: "asyncData.php?action=editfinishaddon",
                                cache: false,
                                data: $("#item_creator_edit").serialize(),
                                success: function(data)
                                {
                                    $('#myModal .modal-body').html(data);

                                    filterCustomCats('getcustomdrags');
                                    $( ".thefilter button").removeClass('active');
                                    $( ".thefilter button:last" ).addClass('active');
                                }
                            });
                        }
                    });
                    $(".img-browser").on('click',function(){
                        var itemsbefor = $(this).data('setter');
                        $("#myModalAS .modal-title").html('Select an Image For Link');
                        $("#myModalAS .modal-body").html('<iframe id="themedia" style="width: 100%; height: 450px; border: none" src="filedfiles.php?typeset=simple&fldset='+itemsbefor+'"></iframe>');
                        $(".modal-dialog").css('width','869px');
                        $("#myModalAS").modal();
                    })
                }
            })

        }

        function passImage(imgpath,fld){
            $("#"+fld).val(imgpath);
            $("#myModalAS").modal('hide');
        }
    </script>



<?php
}else{

    ///IF IN EDIT////

    if(isset($_REQUEST["editview"])){
 ?>

    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog" style="z-index: 1044">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
                </div>
                <div class="modal-body">
                    <p>Some text in the modal.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal -->
    <div id="myModalAS" class="modal fade" role="dialog" style="z-index: 1044">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
                </div>
                <div class="modal-body">
                    <p>Some text in the modal.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>


    <div class="wrapper">
        <div class="sidebar" data-background-color="white" data-active-color="danger">

            <!--
                Tip 1: you can change the color of the sidebar's background using: data-background-color="white | black"
                Tip 2: you can change the color of the active button using the data-active-color="primary | info | success | warning | danger"
            -->

            <?php include('inc/sidebar.php'); ?>
        </div>

        <div class="main-panel">

            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="header">
                                    <h4 class="title">Packages</h4>
                                    <p class="category">Create and edit package deals.</p>




                                    <div class="clearfix"></div>
                                </div>

                                <div style="padding: 20px">

                                    <?php
                                    if(isset($_POST["package_name"])){

                                        $packName = preg_replace('/[^A-Za-z0-9]/', "", $_POST["package_name"]).'-'.substr(md5(time().$_POST["package_name"]), 0, 7);

                                        $_POST['token'] = $packName;

                                        $site->updatePackage($_POST);

                                        echo '<div class="alert alert-success" role="alert"><strong>Well done!</strong> The package has been updated successfully.</div>';



                                        echo '<small>You can copy and paste the usage code below into any page to output the package.</small><br><br>';
                                        echo '<a href="" class="btn btn-default">Click here to return to package list.</a>';

                                    }

                                    $packThing = $site->getPackageDetails($_REQUEST["packageid"]);

                                    $items = stripslashes($packThing["addons"]);


                                    $items = trim($items,'"');
                                    $dropnow = json_decode($items,true);



                                    for($i=0; $i < count($dropnow); $i++){
                                        $dragable .= '<div class="dropitemsin" data-thedrop="'.$dropnow[$i]["title"].'" data-thedroptype="product" data-linetypes="'.$dropnow[$i]["linetype"].'">Product: '.$dropnow[$i]["title"].' | <a href="javascript:void(0)" class="removeites"><i class="fa fa-trash" aria-hidden="true"></i> Remove</a></div>';
                                    }

                                    ?>

                                    <form class="validforms" id="package_deals" name="package_deals" method="post" action="">
                                        <div class="row">
                                            <div class="col-md-4"><label>Package Name</label><br><input id="package_name" name="package_name" type="text" class="form-control" required value="<?php echo $packThing["package_name"]; ?>"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8"><label>Search Equipment</label><br>
                                                <input id="tags" name="tags" type="text" class="form-control" placeholder="Search Equipment" required value="<?php echo $packThing["equip_for"]; ?>">

                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-8">
                                                <label>Package Info</label><br>
                                                <textarea class="form-control" name="package_info" id="package_info"><?php echo $packThing["package_info"]; ?></textarea>
                                            </div>
                                        </div>
                                        <input type="hidden" id="dropped-info" name="dropped-info" value='<?php echo $items; ?>'>
                                        <input type="hidden" name="packageid" id="packageid" value="<?php echo $_REQUEST["packageid"]; ?>">
                                    </form>

                                    <div class="row">
                                        <div class="col-md-8" style="padding: 0">
                                            <br>
                                            <small style="padding: 15px">Drag & Drop Items Below</small>
                                            <div class="addscontainer droparea" style="background: #efefef; border:dashed thin #a0a0a0; padding: 30px; margin: 15px"><?php echo $dragable; ?></div><br><br>

                                            &nbsp;&nbsp;&nbsp;<button class="btn btn-success sendform">Save Package</button>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="dragcol" style="background: #efefef; padding: 10px; margin: 15px">
                                                <div class="col-md-12">



                                                    <label>Click to diplay the Custom Products</label><br>
                                                    <div style="width:100%;" class="btn-group thefilter" role="group" aria-label="Basic example">
                                                        <!--<button style="width: 25%" type="button" class="btn btn-primary btn-xs btn-fill active filterbutton" onclick="filterCustomCats('getfrontierdrags')">Frontier</button>
                                                        <button style="width: 25%" type="button" class="btn btn-primary btn-xs btn-fill filterbutton" onclick="filterCustomCats('getwoodsdrags')">Woods</button>
                                                        <button style="width: 25%" type="button" class="btn btn-primary btn-xs btn-fill filterbutton" onclick="filterCustomCats('getkuhndrags')">Kuhn</button>-->
                                                        <button style="width: 35%" type="button" class="btn btn-primary btn-xs btn-fill filterbutton" onclick="filterCustomCats('getcustomdrags')">Custom</button>
                                                    </div>
                                                    <div class="input-group col-md-12" style="margin-top:10px"><input type="text" style="background: #fff" class="form-control" name="cat_ser" id="cat_ser" placeholder="Search Products" data-list=".dragbox" autocomplete="off" value=""> <span class="input-group-btn"><button class="btn btn-primary ser-thcats" style="border: solid thin #ccc;background: #cccccc; color: #333;" type="button">Search</button></span></div></div>
                                                <h4 style="text-align: center">Select Items</h4>
                                                <div class="dragbox" style="height: 250px; overflow-y:scroll; width: 100%"></div><br>
                                                <button class="btn btn-sm btn- btn-fill" onclick="createAddon()">Create Custom Add-on</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>

        <script src="../../js/jquery.min.js"></script>
        <script src="../../js/jquery.hideseek.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>


        <script>
            $(".validform").validate({
                rules: {
                    password: "required",
                    confirmpassword: {
                        equalTo: "#password"
                    }
                }
            });

            $(function() {
                $(function(){
                    $('#cat_ser').hideseek({
                        highlight: true
                    });
                })

                $("#tags").autocomplete({
                    source: 'asyncData.php?action=getequipmentlist',
                    select: function( event, ui ) {
                        event.preventDefault();
                        $("#tags").val(ui.item.value);
                    }
                });

                getFrontier();
            });

            function getFrontier(){
                $.ajax({
                    url: 'asyncData.php?action=getfrontierdrags',
                    cache: false,
                    success: function(data){
                        $(".dragbox").html(data);
                        $( ".draggable" ).draggable({
                            helper: 'clone',
                            handle: ".dragsa"
                        });

                        intDropable();
                    }
                })
            }

            function intDropable(){

                var array = [];
                $( ".droparea" ).droppable({
                    connectToSortable: '.droparea',
                    drop: function( event, ui ) {
                        var thistype = ui.draggable.data('listtype');
                        var nameout = ui.draggable.data('thename');
                        var itemtype = ui.draggable.data('linetype');
                        if(nameout != undefined) {
                            if (thistype == 'product') {
                                var nowtype = 'Product: ';
                            }
                            if(thistype == 'category') {
                                var nowtype = 'Category: ';
                            }
                            if(thistype == 'htmlarea') {
                                var dt = new Date($.now());
                                nameout = md5(dt);
                                nameout = nameout.substring(0, 8);

                                $.ajax({
                                    url:'asyncData.php?action=createbean&beanname=productbean&bean_id='+nameout,
                                    cache: false,
                                    success: function(data){
                                        console.log('Completed');
                                        runMiniEdits();
                                    }
                                })

                                var nowtype = '<span class="isolatetext">HTML Widget:</span> | <button type="button" class="btn btn-xs btn-default minimodset" data-causedata="'+nameout+'">Edit HTML</button> | ';
                            }
                            $(".droparea").append('<div class="dropitemsin" data-thedrop="'+nameout+'" data-thedroptype="'+thistype+'" data-linetypes="'+itemtype+'">' + nowtype + '' + nameout + ' | <a href="javascript:void(0)" class="removeites"><i class="fa fa-trash" aria-hidden="true"></i> Remove</a></div>');
                        }

                        //dropped-info
                        $('.droparea > .dropitemsin').each(function(){



                            array.push({
                                title: $(this).data('thedrop'),
                                type: $(this).data('thedroptype'),
                                linetype: $(this).data('linetypes')
                            });
                        });
                        var jsonString = JSON.stringify(array);
                        //console.log(jsonString);
                        $("#dropped-info").val(jsonString);
                        array = [];
                        setRemoves();
                    }
                });

                $( ".droparea" ).sortable({
                    containment: "parent",
                    stop: function(event,ui){
                        $('.droparea > .dropitemsin').each(function(){

                            array.push({
                                title: $(this).data('thedrop'),
                                type: $(this).data('thedroptype'),
                                linetype: $(this).data('linetypes')
                            });
                        });
                        var jsonString = JSON.stringify(array);
                        $("#dropped-info").val(jsonString);
                        array = [];
                    }
                });
            }

            function setRemoves(){
                $(".removeites").on('click',function(){
                    $(this).parent().remove();
                    var array = [];
                    //dropped-info
                    $('.droparea > .dropitemsin').each(function(){
                        array.push({
                            title: $(this).data('thedrop'),
                            type: $(this).data('thedroptype'),
                            linetype: $(this).data('linetypes')
                        });
                    });
                    var jsonString = JSON.stringify(array);
                    //console.log(jsonString);
                    $("#dropped-info").val(jsonString);
                    array = [];
                })
            }

            function filterCustomCats(type){
                $.ajax({
                    url: 'asyncData.php?action='+type,
                    cache: false,
                    success: function(data){
                        $(".dragbox").html(data);
                        $( ".draggable" ).draggable({
                            helper: 'clone',
                            handle: ".dragsa"
                        });

                        intDropable();
                    }
                })
            }

            $(function(){
                $(".filterbutton").on('click',function(){

                    $('.filterbutton').each(function(i, obj) {
                        $(this).removeClass('active');
                    });

                    $(this).addClass('active');
                })
            })

            $(function(){
                $(".sendform").on('click',function(){
                    $("#package_deals").submit();
                })


            })

            function createAddon(){
                console.log('hello');
                $.ajax({
                    url: 'asyncData.php?action=createaddon',
                    cache: false,
                    success:function(data){
                        $("#myModal .modal-title").html('Create Add-On');
                        $("#myModal .modal-body").html(data);
                        $("#myModal").modal();
                        $("#addonname").keyup(function(){
                            var serval = $(this).val();
                            $.ajax({
                                url: 'asyncData.php?action=yoursearch&serval='+serval,
                                cache: false,
                                success:function(data){
                                    $(".results-out").html(data);

                                    $(".clickitem").on('click',function(){
                                        var title = $(this).data('title');
                                        var price = $(this).data('price');
                                        $("#addonname").val(title);
                                        if(price != null){
                                            $("#addonprice").val(price);
                                        }

                                        $(".results-out").empty();
                                    })
                                }
                            })
                        })

                        $("#item_creator").validate({
                            submitHandler: function(form) {
                                $.ajax({
                                    type: "POST",
                                    url: "asyncData.php?action=finishaddon",
                                    cache: false,
                                    data: $("#item_creator").serialize(),
                                    success: function(data)
                                    {
                                        $('#myModal .modal-body').html(data);


                                        filterCustomCats('getcustomdrags');
                                        $( ".thefilter button").removeClass('active');
                                        $( ".thefilter button:last" ).addClass('active');
                                    }
                                });
                            }
                        });
                        $(".img-browser").on('click',function(){
                            var itemsbefor = $(this).data('setter');
                            $("#myModalAS .modal-title").html('Select an Image For Link');
                            $("#myModalAS .modal-body").html('<iframe id="themedia" style="width: 100%; height: 450px; border: none" src="filedfiles.php?typeset=simple&fldset='+itemsbefor+'"></iframe>');
                            $(".modal-dialog").css('width','869px');
                            $("#myModalAS").modal();
                        })



                    }
                })

            }

            function editAddon(id){
                $.ajax({
                    url: 'asyncData.php?action=editaddon&id='+id,
                    cache: false,
                    success:function(data){
                        $("#myModal .modal-title").html('Edit Add-On');
                        $("#myModal .modal-body").html(data);
                        $("#myModal").modal();
                        $("#item_creator_edit").validate({
                            submitHandler: function(form) {
                                $.ajax({
                                    type: "POST",
                                    url: "asyncData.php?action=editfinishaddon",
                                    cache: false,
                                    data: $("#item_creator_edit").serialize(),
                                    success: function(data)
                                    {
                                        $('#myModal .modal-body').html(data);

                                        filterCustomCats('getcustomdrags');
                                        $( ".thefilter button").removeClass('active');
                                        $( ".thefilter button:last" ).addClass('active');
                                    }
                                });
                            }
                        });
                        $(".img-browser").on('click',function(){
                            var itemsbefor = $(this).data('setter');
                            $("#myModalAS .modal-title").html('Select an Image For Link');
                            $("#myModalAS .modal-body").html('<iframe id="themedia" style="width: 100%; height: 450px; border: none" src="filedfiles.php?typeset=simple&fldset='+itemsbefor+'"></iframe>');
                            $(".modal-dialog").css('width','869px');
                            $("#myModalAS").modal();
                        })


                    }
                })

            }

            function passImage(imgpath,fld){
                $("#"+fld).val(imgpath);
                $("#myModalAS").modal('hide');
            }

            $(function(){
                setRemoves();
            })
        </script>


    }
        <?php }else{ ///SHOW LIST VIEW ?>


        <div class="wrapper">
            <div class="sidebar" data-background-color="white" data-active-color="danger">

                <!--
                    Tip 1: you can change the color of the sidebar's background using: data-background-color="white | black"
                    Tip 2: you can change the color of the active button using the data-active-color="primary | info | success | warning | danger"
                -->

                <?php include('inc/sidebar.php'); ?>
            </div>

            <div class="main-panel">
                <?php include('inc/top_nav.php'); ?>


                <div class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="header">
                                        <h4 class="title">Packages</h4>
                                        <p class="category">Create and edit package deals.</p>

                                        <a href="?createnew=true" class="btn btn-success btn-fill" style="float:right; margin: 20px">Create New Package</a>


                                        <div class="clearfix"></div>
                                    </div>

                                    <div style="padding: 20px">
                                        <div class="content table-responsive table-full-width">
                                            <table class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th style="font-weight: bold;background: #5d5d5d;color: #fff; border-right:solid thin #efefef">Package Name</th>
                                                    <th style="font-weight: bold;background: #5d5d5d;color: #fff; border-right:solid thin #efefef">Package For</th>
                                                    <th style="font-weight: bold;background: #5d5d5d;color: #fff; border-right:solid thin #efefef">Package Token</th>
                                                    <th class="nosort" style="text-align: right; font-weight:bold;background: #5d5d5d;color: #fff;">Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php

                                                $packsLine = $site->getPackagePages();

                                                for($i=0; $i<count($packsLine); $i++){
                                                    echo '<tr><td>'.$packsLine[$i]["package_name"].'</td> <td>'.$packsLine[$i]["equip_for"].'</td><td>{mod}package_builder-packageCall-'.$packsLine[$i]["token"].'{/mod}</td><td style="text-align: center"><a href="?editview=true&packageid='.$packsLine[$i]["id"].'" class="btn btn-success btn-sm">Edit</a></td></tr>';
                                                }

                                                ?>

                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>





            <?php } } ?>

</body>
</html>
