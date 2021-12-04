function posta_balioztatu(){

  var posta = document.getElementById("posta").value;

  var request = $.ajax({
    url: "EmailController.php",
    data: {posta: posta},
    method: "POST",
    success: function(data){
      if(data != 1){
        document.getElementById('feedback').innerHTML = data;
      }else{
        document.getElementById('feedback').innerHTML = "<div class='okBox'><p>Mezu bat bidali dizugu " + posta +
                          " helbidera. <br> Bertan agertzen den linkean klikatu ezazu pasahitza aldatzeko.</p></div>";
        document.getElementById('forgot_password_form').style.display = "none";
      }
    }
  });

}
