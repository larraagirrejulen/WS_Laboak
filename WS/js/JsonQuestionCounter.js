$(document).ready(function() {
    galderakEguneratu();
    setInterval(galderakEguneratu, 10000);
});

function galderakEguneratu(){
    $.ajax({
        url: "../json/Questions.json",
        type: "GET",
        success: function(datuak){
            eposta = $('#uposta').val()
            var kont = 0;
            var totalKont = 0;
            $.each(datuak.assessmentItems, function(i, erab){
    
                if (erab.author == eposta ){
                    kont = kont + 1;
                }
                totalKont = totalKont + 1;
            });
            $(document).find('#nireGalderak').html(kont);
            $(document).find('#guztiraGalderak').html(totalKont);
        },
        cache: false
    });
   
}



