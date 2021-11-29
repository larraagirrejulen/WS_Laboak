
var xhr = new XMLHttpRequest();

function ShowQuestionsJsonAjax(){
	xhr.onreadystatechange = eskaerarenEgoeraShowJson;

	var dest = "ShowJsonQuestions.php";

	xhr.open("GET", dest, true);
	xhr.send();
}

function  eskaerarenEgoeraShowJson(){

	if(xhr.readyState == 4){
		document.getElementById('jsongaldera').innerHTML=$(xhr.responseText).find('#jsontable').html();
		console.log(xhr.responseText)
	}
}
