function getUserInfo() {
    $.get('../json/Users.json', function(datuak){
        eposta = $('#eposta').val()
        aurkitua = false;
        console.log(datuak.erabiltzaileak)
        $.each(datuak.erabiltzaileak, function(i, erab){
            console.log()
            if (!aurkitua && erab.eposta == eposta ){
                aurkitua = true
                $('#telf').val(erab.telefonoa)
                $('#izena').val(erab.izena)
                $('#abizena').val(
                    erab.abizena1 + " " + erab.abizena2
                )
            }
        })
        if(!aurkitua){alert("Ez dago eposta hori duen pertsonarik")}
    })
}