$(document).ready(function() {
    userCountEguneratu();
    setInterval(userCountEguneratu, 1000);
});

function userCountEguneratu(){
    $.ajaxSetup({ cache: false });
    $.ajax({
        url: "../xml/UserCounter.xml", 
        method: "GET",
        success: function(datuak){
            $(document).find(".usercounter").html($(datuak).find('erabiltzaileak').attr('logeatuta'));
        }, 
        cache: false // Cachea desaktibatu
    });
}