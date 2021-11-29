function validateEnrol(){

	var posta = document.getElementById("eposta").value;

	var irudia = document.createElement("img")
	irudia.src = "../images/loading.gif";
	irudia.id = "loading_img";
	irudia.setAttribute("height", "15px");
	irudia.style.display = 'inline-block';
	$('#posta_container').append(irudia);

	$.ajax({
		url: 'ClientVerifyEnrollment.php',
		type: 'POST',
		data: {"posta" : posta},
		success: function(data)
		{
			if(data == "1"){
				document.getElementById("eposta").style.borderColor = "green";
				document.getElementById("submitbutton").disabled = false;
			}else if(data == "0"){
				document.getElementById("eposta").style.borderColor = "red";
				document.getElementById("submitbutton").disabled = true;
			}else{
				alert(data);
				alert("Ezin izan da matrikula balioztatu!");
			}
		},

		complete: function(data){
			$('#loading_img').remove();
		}
	})
}
