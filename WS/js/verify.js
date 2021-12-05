function posta_balioztatu(){
  var posta = document.getElementById("posta").value;
  var success = false;
  $.ajax({
    url: "EmailController.php",
    data: {posta: posta},
    method: "POST",
    success: function(data){
      if(data != 1){
        document.getElementById('feedback').innerHTML = "<div class='errorBox'><p>Ez dago posta hori duen konturik</p></div>";
      }else{
        success = true;
      }
    },
    async: false
  });
  return success;
}

function gakoa_balioztatu(gakoa1){
  var balioztatze_gakoa = document.getElementById("balioztatze_gakoa").value;

  if (balioztatze_gakoa == gakoa1) {
    return true;
  }else{
    document.getElementById('feedback').innerHTML = "<div class='errorBox'><p>Gako okerra</p></div>";
    return false;
  }
}

function pasahitza_eguneratu(){

  var pass1 = document.getElementById("pasahitza1").value;
  var pass2 = document.getElementById("pasahitza2").value;
  var posta = document.getElementById("posta").value;
  var balioztatze_gakoa = document.getElementById("balioztatze_gakoa").value;

  if (!(/^[^\s]*$/.test(pass1)) || pass1.length == 0) {
    document.getElementById('feedback').innerHTML = "<div class='errorBox'><p>Pasahitz formatua ez da egokia</p></div>";
  }else if (pass1 != pass2) {
    document.getElementById('feedback').innerHTML = "<div class='errorBox'><p>Pasahitzak ez datoz bat</p></div>";
  }else{
    $.ajax({
      url: "ChangePassword.php",
      data: {posta: posta, balioztatze_gakoa: balioztatze_gakoa, pass: pass1},
      type: "POST",
      success: function(data){
        if(data != 1){
          document.getElementById('feedback').innerHTML = "<div class='errorBox'><p>Errorea pasahitza aldatzen saiatzean</p></div>";
        }else{
          alert("Pasahitza zuzen aldatu da");
          window.location.replace("../php/LogIn.php");
        }
      },
      async: false
    });
  }
}
