//import * as myModule from '../js/ValidateFieldsQuestionJQ.js';

function AddQuestionAjax(){
	if(ValidateFieldsQuestionJQ()){
		var dest = "AddQuestionWithImage.php";

		var form = document.getElementById("galderenF");
		var formData = new FormData(form);

		$.ajax({
			url: dest,
			data: formData,
			type: "POST", //ADDED THIS LINE
			// THIS MUST BE DONE FOR FILE UPLOADING
			contentType: false,
			processData: false,
			success: function(data)
			{
				// Jasotako datu guztietatik (AddQuestionWithImage orri osotik) galderaren gehitze egoera lortu
				var status = $(data).find('#status');
				// Jasotako galderaren gehitze egoera dokumentuan bistaratu
				$(document).find('#egoera').html(status.html());
				// Frogatu ea galdera era gokian prozesatu den zerbitzarian
				if (status.find('.errorBox').length == 0) {
					// era egokian prozezatu da, formularioaren edukiak erreseteatu.
					$(document).find('#galderenF').trigger("reset");
				}
			}
		})


	}
}
