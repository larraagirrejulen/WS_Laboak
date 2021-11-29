function getUserInfo() {

    $.get('../xml/Users.xml', function(datuak){
        eposta = $('#eposta').val()
        aurkitua = false;
        $(datuak).find('erabiltzailea').each(function(){
            if (!aurkitua && $(this).find('eposta').text() == eposta ){
                aurkitua = true
                $('#telf').val($(this).find('telefonoa').text())
                $('#izena').val($(this).find('izena').text())
                $('#abizena').val(
                    $(this).find('abizena1').text() + " " + $(this).find('abizena2').text()
                )
            }
        })
        if(!aurkitua){alert("Ez dago eposta hori duen pertsonarik")}
    })
}