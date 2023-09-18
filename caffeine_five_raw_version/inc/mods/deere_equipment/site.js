
$( document ).ready(function() {

    console.log( "ready!" );

$('.search-toggle').on('click', function () {
    $("#site-search").slideToggle('fast');
    $("#serterm").focus();
})

});



$('#package_request').validate({

    submitHandler: function(form) {
        if ($("#package_request input:checkbox:checked").length > 0) {

            $.ajax({
                type: 'POST',
                url: 'inc/processPackage.php',
                data: $('#package_request').serialize(),
                success: function(data)
                {
                    $('.packs').html('<div class="alert alert-success">Thank You! - We have received your request and will get back with you A.S.A.P.</div>');
                    console.log(data);
                }
            });
        }else{
            $(".checkboxerror").html('Please select one option here.');
            $(".checkboxerror").show();
        }
    }
});

$(function() {



    //Function for Used Equipment Page
    $(function(){
        $('.your-class').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            adaptiveHeight: true,
            asNavFor: '.slider-nav'
        });
        $('.slider-nav').slick({
            slidesToShow: 2,
            slidesToScroll: 1,
            asNavFor: '.your-class',
            dots: true,
            arrows: false,
            centerMode: true,
            focusOnSelect: true
        });

        $(".moreinfo").on('click',function(){
            var equiLink = $(this).data('url');
            var equiTitle = $(this).data('equipment');

            $("#equipment_link").val(equiLink);
            $("#equipment_title").val(equiTitle);
        })
    })

  ///THIS IS A CORE FUNCTION THAT HELPS THE FORMS WORK.. DO NOT DELETE///
    $('.form-process').each(function() {
        $(this).validate({
            submitHandler: function(form) {

                $('.loader-overlay').show();
                $(".loader-message").show();

                        var formName = $(form).attr('id');
                        $.ajax({
                            type: "POST",
                            url: 'inc/shortCalls.php?action=formsubmit',
                            data: new FormData(form),
                            contentType: !1,
                            cache: !1,
                            processData: !1,
                            success: function(data) {
                                console.log(data);
                                data = data.replace('\'', '\\\'');
                                var response = $.parseJSON(data);
                                var rescode = response.code;
                                var resmessage = response.message.replace('\\','');
                                var reserrs = response.errors;

                                if (rescode == 'invalid') {
                                    $("#" + formName + "_alerts").html('<div class="alert alert-danger">' + resmessage + '</div>')
                                } else {
                                    $("#" + formName).remove();
                                    $("#" + formName + "_alerts").html('' + resmessage + '')
                                    $('.loader-overlay').hide();
                                    $(".loader-message").hide();
                                }
                            }
                        })
            }///HERE
        })
    })

    //Caffeine Click Event - DO NOT DELETE//

    $("[data-cafftrak]").on( "click", function () {
        var eventTar = $(this).data('cafftrak');
        var href = document.location.href;
        var lastPathSegment = href.substr(href.lastIndexOf('/') + 1);
        //console.log(eventTar);
        $.ajax({
            url:'inc/ajaxCalls.php?action=eventtrak&target='+eventTar+'&page='+lastPathSegment,
            success: function(data){
                // alert(data);
            }
        })
    } );
  
})

const observer = lozad(); // lazy loads elements with default selector as '.lozad'
observer.observe();

$(document).ready(function(){

    $('.new-equip-link').on('click', function() {
        $('#subdesktop').slideToggle();
    });


    // $('.sub-nav').click(function() {
    //
    //     var id = $(this).data('target');
    //
    //
    //     if( $('#'+id).css('display')=='none'){
    //         $(".sub-nav-menu").hide();
    //         $('#'+id).show();
    //     }else {
    //         $('#'+id).css('display', 'none');
    //     }
    //
    // });




    $("#find-loc").click(function(){
        $("#location-finder").slideToggle();
    });

    $("#location-detail").click(function() {
        $("#location-finder").css("display","none");
    });

});

    (function() {
        var css = document.createElement('link');
        css.href = '//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css';
        css.rel = 'stylesheet';
        css.type = 'text/css';
        document.getElementsByTagName('head')[0].appendChild(css);
    })();

/* Set the width of the side navigation to 250px and the left margin of the page content to 250px */
function openNav() {
    document.getElementById("mySidenav").style.width = "450px";
    document.getElementById("main").style.marginLeft = "450px";
}

/* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.getElementById("main").style.marginLeft = "0";
}

$(function(){
    $("#usedcatsel").on('change',function(){

        var selCat = $(this).val();

        var prifrm = $("#prifrm").val();
        var prito = $("#prito").val();
        var yrfrm = $("#yrfrm").val();
        var yrto = $("#yrto").val();
        var hrfrm = $("#hrfrm").val();
        var hrto = $("#hrto").val();
        $.ajax({
            url:'inc/sideprocess.php?action=processcats&selcat='+encodeURIComponent(selCat)+'&prifrm='+prifrm+'&prito='+prito+'&yrfrm='+yrfrm+'&yrto='+yrto+'&hrfrm='+hrfrm+'&hrto='+hrto,
            cache:false,
            success:function(data){
                $("#usedmansel").html(data);
            }
        })

    })

    $("#usedmansel").on('change',function(){

        var selman = $(this).val();
        var selCat = $("#usedcatsel").val();

        var prifrm = $("#prifrm").val();
        var prito = $("#prito").val();
        var yrfrm = $("#yrfrm").val();
        var yrto = $("#yrto").val();
        var hrfrm = $("#hrfrm").val();
        var hrto = $("#hrto").val();
        $.ajax({
            url:'inc/sideprocess.php?action=processmans&selcat='+encodeURIComponent(selCat)+'&selman='+encodeURIComponent(selman)+'&prifrm='+prifrm+'&prito='+prito+'&yrfrm='+yrfrm+'&yrto='+yrto+'&hrfrm='+hrfrm+'&hrto='+hrto,
            cache:false,
            success:function(data){
                $("#usedmodsel").html(data);
            }
        })

    })

    $("#usedmodsel").on('change',function(){

        var selmod = $(this).val();
        var selman = $('#usedmansel').val();
        var selCat = $("#usedcatsel").val();

        var prifrm = $("#prifrm").val();
        var prito = $("#prito").val();
        var yrfrm = $("#yrfrm").val();
        var yrto = $("#yrto").val();
        var hrfrm = $("#hrfrm").val();
        var hrto = $("#hrto").val();

        $.ajax({
            url:'inc/sideprocess.php?action=processmods&selcat='+encodeURIComponent(selCat)+'&selman='+encodeURIComponent(selman)+'&selmod='+selmod+'&prifrm='+prifrm+'&prito='+prito+'&yrfrm='+yrfrm+'&yrto='+yrto+'&hrfrm='+hrfrm+'&hrto='+hrto,
            cache:false,
            success:function(data){
                //DO NOTHING//
            }
        })

    })

    $(".js-range-slider-side").ionRangeSlider({
        skin: "modern",
        onFinish: function(a) {
            // $("#price_from").val(a.from), $("#price_to").val(a.to), pageData(1)
            var selmod = $("#usedmodsel").val();
            var selman = $('#usedmansel').val();
            var selCat = $("#usedcatsel").val();

            $("#prifrm").val(a.from);
            $("#prito").val(a.to);


            if(selCat == ''){
                $(".showissues").html('<strong>NOTICE!</strong> You must select a category first.');
                $(".showissues").show();
                var slider_instance = $('.js-range-slider-side').data("ionRangeSlider");
                slider_instance.reset();
            }else{
                $(".showissues").hide();

                var prifrm = $("#prifrm").val();
                var prito = $("#prito").val();
                var yrfrm = $("#yrfrm").val();
                var yrto = $("#yrto").val();
                var hrfrm = $("#hrfrm").val();
                var hrto = $("#hrto").val();

                $.ajax({
                    url:'inc/sideprocess.php?action=processmods&selcat='+encodeURIComponent(selCat)+'&selman='+encodeURIComponent(selman)+'&selmod='+selmod+'&prifrm='+prifrm+'&prito='+prito+'&yrfrm='+yrfrm+'&yrto='+yrto+'&hrfrm='+hrfrm+'&hrto='+hrto,
                    cache:false,
                    success:function(data){
                        //DO NOTHING//
                    }
                })
            }

        }

    })

    $(".js-range-slider-slide2").ionRangeSlider({
        skin: "modern",
        prettify_enabled: !1,
        onFinish: function(a) {
            //$("#year_from").val(a.from), $("#year_to").val(a.to), pageData(1)
            var selmod = $("#usedmodsel").val();
            var selman = $('#usedmansel').val();
            var selCat = $("#usedcatsel").val();

            $("#yrfrm").val(a.from);
            $("#yrto").val(a.to);

            if(selCat == ''){
                $(".showissues").html('<strong>NOTICE!</strong> You must select a category first.');
                $(".showissues").show();
                var slider_instance2 = $('.js-range-slider-slide2').data("ionRangeSlider");
                slider_instance2.reset();
            }else{
                $(".showissues").hide();

                var prifrm = $("#prifrm").val();
                var prito = $("#prito").val();
                var yrfrm = $("#yrfrm").val();
                var yrto = $("#yrto").val();
                var hrfrm = $("#hrfrm").val();
                var hrto = $("#hrto").val();

                $.ajax({
                    url:'inc/sideprocess.php?action=processmods&selcat='+encodeURIComponent(selCat)+'&selman='+encodeURIComponent(selman)+'&selmod='+selmod+'&prifrm='+prifrm+'&prito='+prito+'&yrfrm='+yrfrm+'&yrto='+yrto+'&hrfrm='+hrfrm+'&hrto='+hrto,
                    cache:false,
                    success:function(data){
                        //DO NOTHING//
                    }
                })
            }
        }
    })

    $(".moreinfo").on('click',function(){
        var equiLink = $(this).data('url');
        var equiTitle = $(this).data('equipment');

        $("#equipment_link").val(equiLink);
        $("#equipment_title").val(equiTitle);
    });

    $(".testeqreq").on('click',function(){
        var equiTitle = $(this).data('equipment');
        $("#equipment_title").val(equiTitle);
    });


    $('.new-bulls ul li a').click(function(e) {
        e.preventDefault();
        //do other stuff when a click happens
    });

    $(".js-range-slider-slide3").ionRangeSlider({
        skin: "modern",
        onFinish: function(a) {
            //$("#year_from").val(a.from), $("#year_to").val(a.to), pageData(1)
            var selmod = $("#usedmodsel").val();
            var selman = $('#usedmansel').val();
            var selCat = $("#usedcatsel").val();

            $("#hrfrm").val(a.from);
            $("#hrto").val(a.to);

            if(selCat == ''){
                $(".showissues").html('<strong>NOTICE!</strong> You must select a category first.');
                $(".showissues").show();
                var slider_instance3 = $('.js-range-slider-slide3').data("ionRangeSlider");
                slider_instance3.reset();
            }else{
                $(".showissues").hide();

                var prifrm = $("#prifrm").val();
                var prito = $("#prito").val();
                var yrfrm = $("#yrfrm").val();
                var yrto = $("#yrto").val();
                var hrfrm = $("#hrfrm").val();
                var hrto = $("#hrto").val();

                $.ajax({
                    url:'inc/sideprocess.php?action=processmods&selcat='+encodeURIComponent(selCat)+'&selman='+encodeURIComponent(selman)+'&selmod='+selmod+'&prifrm='+prifrm+'&prito='+prito+'&yrfrm='+yrfrm+'&yrto='+yrto+'&hrfrm='+hrfrm+'&hrto='+hrto,
                    cache:false,
                    success:function(data){
                        //DO NOTHING//
                    }
                })
            }
        }
    })

})

$(function(){

    if ($(window).width() < 960) {
        $('.sub-nav .dropdown-toggle').removeAttr('data-toggle');
        $('.sub-nav-menu').remove();
    }
    else {
        // $('.sub-nav .dropdown-toggle').removeAttr('data-toggle');
        // $('.megamenu').hide();
    }

})

