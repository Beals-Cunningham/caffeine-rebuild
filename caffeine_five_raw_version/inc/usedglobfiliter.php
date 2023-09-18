<?php include('config.php'); ?>

<div id="mySidenav" class="sidenav" style="z-index: 99999; background: #696969;">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <div style="padding: 20px">
        <strong style="color:#fff; font-size: 20px">Quick Used Equipment Filter</strong>
        <hr style="border: solid thin #fff">
    <form name="quickserc" id="quickserc" action="Used-Equipment" method="post">
        <label style="color: #fff;">1. Select Category</label><br>
        <select class="form-control" name="usedcatsel" id="usedcatsel">
            <option value="">Select Category</option>
            <?php
            $a = $data->query("SELECT category FROM used_equipment WHERE active = 'true' GROUP BY category ASC");
            while($b = $a->fetch_array()){
                if($b["category"] != null) {
                    echo '<option value="' . $b["category"] . '">' . $b["category"] . '</option>';
                }
            }
            ?>
        </select>
        <br>
        <label style="color: #fff;">2. Select Manufacturer</label><br>
        <select class="form-control" name="usedmansel" id="usedmansel">
            <option value="">Select Manufacturer</option>
        </select>
        <br>
        <label style="color: #fff;">3. Select Model</label><br>
        <select class="form-control" name="usedmodsel" id="usedmodsel">
            <option value="">Select Model</option>
        </select>
        <br>
        <div class="showissues" style="color: red; display: none; padding: 10px 0px;"></div>
        <div class="pricerange" style="color: #fff">
            <label class="bold-label">Price Range</label>
            <input type="text" class="js-range-slider-side" name="price_range_sel" value="" data-type="double" data-step="500" data-min="0" data-max="900000" data-grid="true"/>
        </div>
        <br>
        <div class="pricerange" style="color: #fff">
            <label class="bold-label">Year Range</label>
            <input type="text" class="js-range-slider-slide2" name="year_range" value="" data-type="double" data-min="1900" data-max="<?php echo date('Y'); ?>" data-grid="true"/>
        </div>
        <br>
        <div class="hourrsrange" style="color:#fff">
            <label class="bold-label">Hours Filter</label>
            <input type="text" class="js-range-slider-slide3" name="hours_range" value="" data-type="double" data-min="0" data-max="9000" data-grid="true"/>
        </div>
        <br><br>
        <input type="hidden" name="prifrm" id="prifrm" value="0">
        <input type="hidden" name="prito" id="prito" value="900000">
        <input type="hidden" name="yrfrm" id="yrfrm" value="1900">
        <input type="hidden" name="yrto" id="yrto" value="<?php echo date('Y'); ?>">
        <input type="hidden" name="hrfrm" id="hrfrm" value="0">
        <input type="hidden" name="hrto" id="hrto" value="9000">
        <button class="btn btn-success">Filter Equipment</button>
    </form>
        <br><br>

    </div>
</div>

<!-- Use any element to open the sidenav -->
<span class="d-none d-sm-none d-sm-block" style="width:54px;position:fixed;top:18%;z-index:8000;writing-mode:vertical-rl;cursor:pointer;left:0;" onclick="openNav()"><img style="height: 255px;"  src="img/Tab.png" alt="used search tag">
<?php if ($page =='used-equipment'){ echo 'style="display:none;"'; } ?></span>