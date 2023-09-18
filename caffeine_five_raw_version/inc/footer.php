FOOTER

    <!--BELOW ARE SYSTEM REQUIREMENTS AND SHOULD NOT BE ALTERED -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js' type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.0/js/ion.rangeSlider.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/lozad/dist/lozad.min.js"></script>
    <script src="js/list.min.js"></script>
    <script src="js/site.js"></script>
    <script type="text/javascript" src="js/locationgetter.js"></script>

    <script>
        $(function() {
            $(".search-toggle").on('click', function() {
                event.preventDefault();
            })
        });
    </script>

    <?php
    ///CORE CAFFEINE ELEMENTS DO NOT REMOVE THIS///
    $dependenciesjs = $info->loadBeanDepsjs();
    for ($i = 0; $i < count($dependenciesjs); $i++) {
        echo '<script src="' . $dependenciesjs[$i]["file"] . '"></script>' . PHP_EOL;
    }

    $depJs = $dependants["js"];

    foreach ($depJs as $jsKey) {
        echo '<script src="' . $jsKey . '"></script>' . PHP_EOL;
    }
    ?>

    <?php


    ///CORE CAFFEINE ELEMENTS DO NOT REMOVE THIS///
    if ($pageDetails[0]["page_js"] == '') {
        $pageScripts = 'js/page_js/' . $page . '_js_events.js';
        if (file_exists($pageScripts)) {
            echo '<script src="' . $pageScripts . '"></script>';
        }
    } else {
        $pageScripts = 'js/page_js/' . $pageDetails[0]["page_js"] . '';
        echo '<script src="' . $pageScripts . '"></script>';
    }




    ?>






</footer>
</body>

</html>

<?php include('site_tracker.php'); ?>