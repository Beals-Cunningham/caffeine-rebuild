function closestLocation(targetLocation, locationData) {
    function vectorDistance(dx, dy) {
        return Math.sqrt(dx * dx + dy * dy);
    }

    function locationDistance(location1, location2) {
        var dx = location1.latitude - location2.latitude,
            dy = location1.longitude - location2.longitude;

        return vectorDistance(dx, dy);
    }

    return locationData.reduce(function(prev, curr) {
        var prevDistance = locationDistance(targetLocation , prev),
            currDistance = locationDistance(targetLocation , curr);
        return (prevDistance < currDistance) ? prev : curr;
    });
}

function getMylatlong(){
    var locationzip = $("#locationzip").val();
    if(locationzip != null){
        $.ajax({
            url: 'inc/getClose.php?act=getzipbase&zip='+locationzip,
            dataType: "json",
            success: function(data){
                //alert('gonig');
                var lat = data.dir.lat;
                var long = data.dir.long;
///console.log(lat+' '+long);
                getClose(lat,long);
            }
        })
    }else{
        alert('Enter Zip Code');
    }
}

function getClose(lat,long){
    var closest;
    $.ajax({
        url: 'inc/getClose.php?act=process',
        dataType: "json",
        success: function(data){

            targetLocation = {
                latitude: lat,
                longitude: long
            },
                closest = closestLocation(targetLocation, data.Locations.Location);

            console.log(closest);


            //$("#location-detail").html('HELLO THERHE'+closest.address);
            $("#location-detail").html('<h4>'+closest.name+'</h4><p>'+closest.address+'</p><p>'+closest.city+' '+closest.state+' '+closest.zip+'</p><a id="setlocation">Make This My Location</a>');

// closest is now the location that is closest to the target location
            $("#setlocation").on("click", function(){
                $("#location-det").html('<i class="fa fa-map-marker" aria-hidden="true"></i>'+closest.name+' '+closest.state+' | '+closest.phone+'');
                $("#location-det").css("visibility", "visible");

                var locName = closest.name;
                var locState = closest.state;
                var locPhone = closest.phone;

                $.ajax({
                    url: 'inc/getClose.php?act=setcookie&locname='+locName+'&locstate='+locState+'&locphone='+locPhone,
                    success: function(data) {

                    }

                })


            });
        }
    });


}
