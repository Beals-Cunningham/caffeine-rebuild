$(function(){
  $('.carousel').carousel()
});


$( document ).ready(function() {
  //  $('#exampleModalCenter').modal();
  
    /*$('#feat-used').slick({
    infinite: true,
    slidesToShow: 3,
    slidesToScroll: 3,
      responsive: [
        {
          breakpoint: 500,
          settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          }
        }
      ]
  
   });*/
  $('.slick').slick({
  infinite: true,
  slidesToShow: 3,
  slidesToScroll: 1,
    responsive: [
      {
        breakpoint: 500,
        settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
        }
      }
    ]
});
});
$( ".select-location" ).each(function(index) {
  $(this).on("click", function(){
    var output;
    var main;
    var first;
    var second;
    var location = $(this).data('location');
    $.ajax({
      url: 'inc/tomasz_test.php?location_name='+location,
      cache: false,
      success: function(data){
        var output = JSON.parse(data);
        var main = output[0];
        var first = output[1];
        var second = output[2];

        $.each(first, function(i, item) {
          first[i] = first[i].replace(/[^a-zA-Z0-9 ]/g, "");
        });

        $.each(second, function(i, item) {
          second[i] = second[i].replace(/[^a-zA-Z0-9 ]/g, "");
        });


        $(".show-nearest-location").empty();
        $(".show-nearest-location").html("<a class='col-6 d-flex justify-content-center' href='"+first.location_name+"'>"
    +"<img class='d-bock locations-img-small mr-3' src='"+window.location.href+first.location_img.slice(2)+"' alt='"+first.location_name+", "+first.location_state+"'>"
    +"<div class=''>"
        +"<ul class='p-0 m-0 list-unstyled'>"
            +"<li>"+first.location_name+", "+first.location_state+"</li>"
            +"<li>"+first.location_address+"</li>"
            +"<li>"+first.location_city+", "+first.location_state+" "+first.location_zip+"</li>"
            +"<li>"
                +"<svg xmlns='http://www.w3.org/2000/svg' class='bi bi-geo-alt-fill' viewBox='0 0 16 16'>"
                    +"<path d='M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z'/>"
                +"</svg>"
               +"<span class='distance'>"+first.distance+" miles AWAY</span>" 
            +"</li>"
        +"</ul>"
    +"</div>"
    +"</a>"
    +"<a class='col-6 d-flex justify-content-center' href='"+second.location_name+"'>"
        +"<img class='d-bock locations-img-small mr-3' src='"+window.location.href+second.location_img.slice(2)+"' alt='"+second.location_name+", "+second.location_state+"'>"
        +"<div class=''>"
            +"<ul class='p-0 m-0 list-unstyled'>"
                +"<li>"+second.location_name+", "+second.location_state+"</li>"
                +"<li>"+second.location_address+"</li>"
                +"<li>"+second.location_city+", "+second.location_state+" "+second.location_zip+"</li>"
                +"<li>"
                    +"<svg xmlns='http://www.w3.org/2000/svg' class='bi bi-geo-alt-fill' viewBox='0 0 16 16'>"
                        +"<path d='M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z'/>"
                        +"</svg>"
                    +"<span class='distance'>"+second.distance+" miles AWAY</span>"
                    +"</li>"
                +"</ul>"
            +"</div>"
        +"</a>"); 
        $(".selected-location").empty();
        var emailsObj = JSON.parse(main.location_emails);
        var phonesObj = JSON.parse(main.location_phones);
        var hoursObj = JSON.parse(main.location_hours);
        var emails = "";
        $.each(emailsObj, function(i, item) {
        emails +="<li>"
            emails +="<svg xmlns='http://www.w3.org/2000/svg' class='bi bi-envelope-fill mr-1' viewBox='0 0 16 16'>"
                emails +="<path d='M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z'/>"
                emails +="</svg>"
            emails +="<a class='' href='mailto:"+emailsObj[i].emailOut.replace(/[^a-zA-Z0-9 ]/g, "")+"'> "+emailsObj[i].emailName.replace(/[^a-zA-Z0-9 ]/g, "")+"</a>"
            emails +="</li>"
        });
        $(".selected-location").html("<img class='locations-img-left' src='"+window.location.href+main.location_img.slice(2).replace(/[^a-zA-Z0-9 ]/g, "")+"' alt='"+main.location_name.replace(/[^a-zA-Z0-9 ]/g, "")+", "+main.location_state.replace(/[^a-zA-Z0-9 ]/g, "")+"'>"
+"<div class='row'>"
    +"<div class='col-12'>"
        +"<h3 class='' style=''>"+main.location_name.replace(/[^a-zA-Z0-9 ]/g, "")+"</h3>"
        +"</div>"
    +"<div class='col-lg-6'>"
        +"<ul class='pl-3 m-0 list-unstyled'>"
            +"<li> "+main.location_address.replace(/[^a-zA-Z0-9 ]/g, "")+"</li>"
            +"<li> "+main.location_city.replace(/[^a-zA-Z0-9 ]/g, "")+", "+main.location_state.replace(/[^a-zA-Z0-9 ]/g, "")+" "+main.location_zip.replace(/[^a-zA-Z0-9 ]/g, "")+"</li>"
            +"</ul>"
        +"<ul class='pl-3 mt-3 list-unstyled'>"
            +"<li> MAIN >> <a class='' href='phone:'"+phonesObj[0].phoneNum.replace(/[^a-zA-Z0-9 ]/g, "")+"'>"+phonesObj[0].phoneNum.replace(/[^a-zA-Z0-9 ]/g, "")+"</a></li>"
            +"<li> FAX >> <a class='' href='phone:"+phonesObj[1].phoneNum.replace(/[^a-zA-Z0-9 ]/g, "")+"'>"+phonesObj[1].phoneNum.replace(/[^a-zA-Z0-9 ]/g, "")+"</a></li>"
            +"</ul>"
        +"<ul class='p-0 mt-3 list-unstyled'>"
            +emails
            +"</ul>"
        +"</div>"
    +"<div class='col-lg-6'>"
        +"<a class='d-block locations-link text-active mb-3' href='Used-Equipment?locations="+main.location_city+"'>SHOP USED INVENTORY</a>"
        +"<ul class='p-0 m-0 border-left list-unstyled' style='text-align: end;'>"
            +"<li>MON. >> "+hoursObj[0].hours.replace(/[^a-zA-Z0-9 ]/g, "")+"</li>"
            +"<li>TUE. >> "+hoursObj[1].hours.replace(/[^a-zA-Z0-9 ]/g, "")+"</li>"
            +"<li>WED. >> "+hoursObj[2].hours.replace(/[^a-zA-Z0-9 ]/g, "")+"</li>"
            +"<li>THU. >> "+hoursObj[3].hours.replace(/[^a-zA-Z0-9 ]/g, "")+"</li>"
            +"<li>FRI. >> "+hoursObj[4].hours.replace(/[^a-zA-Z0-9 ]/g, "")+"</li>"
            +"<li>SAT. >> "+hoursObj[5].hours.replace(/[^a-zA-Z0-9 ]/g, "")+"</li>"
            +"<li>SUN. >> CLOSED                 </li>"
            +"</ul>"
        +"</div>");
      }
    })
  })


})