$(document).ready(function(){
	$("#gIrudia").change(function(){ //Argazkiari listener bat jarri noiz kargatzen denean jakiteko
		reloadImage(this);
	});
	$("#hustu").click(irudKendu) // Formuarioa borratzen duen botoiari borratzeko funtzioa gehitu
})

function reloadImage(input){
    if(validImgType(input) && input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
			var irudia = document.createElement("img")
			irudia.src = e.target.result
			irudia.id = "irudia"
			irudia.setAttribute("height", "200px")

			if($('#irudia') != null) {
				$('#irudia').remove()
			}
			
			$('#galderenF').append(irudia)
        }
        reader.readAsDataURL(input.files[0]);
    }else{
		input.value = ""
		irudKendu()
	}
	console.log("Sartu naiz");
};

function validImgType(input){
	var expr = /\.(jpg|png|jpeg|jfif|pjp)$/i //i horrek letra larriak eta xeheak ez desberdintzeko balio du
	var egokiaDa = expr.test(input.value)
	if(!egokiaDa){
		alert("Sartu behar duzun fitxategi mota argazki bat izan behar da:\n jpg|png|jpeg|jfif|pjp")
	}
	return egokiaDa
}

function irudKendu(){
	var i = $("#irudia")
	if (i != null) {
		i.remove()
	}
	
}