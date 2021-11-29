function permutatu(posta){

    $.ajax({
        url: "../php/ChangeUserState.php",
        type: "POST",
        data: {"posta": posta},
        success: function(data){
            if($(data).find("egoera").text()== "success"){
                var egoera = $(data).find("erantzunEgokia").text();
                var egoeraText = "OFF";
                if(egoera == 1){
                    egoeraText = "ON"; 
                }
                $(document.getElementById(posta)).find(".egoera").html(egoera);
                $(document.getElementById(posta)).find(".egoeraButton").attr("value",egoeraText);
            }   
        }
    })

}

function ezabatu(posta){
    $.ajax({
        url: "../php/RemoveUser.php",
        type: "POST",
        data: {"posta": posta},
        success: function(data){
            if($(data).find("egoera").text()== "success"){
                $(document.getElementById(posta)).remove();
            }   
        }
    })


}