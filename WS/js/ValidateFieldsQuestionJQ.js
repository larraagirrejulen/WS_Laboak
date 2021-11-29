function ValidateFieldsQuestionJQ (){
	if(checkMail($("#uposta").val())){
		if(checkQuestion($("#tgaldera").val())){
			if(checkOtherTxt($("#ezuzena").val()) && checkOtherTxt($("#eokerra1").val()) && checkOtherTxt($("#eokerra2").val()) && checkOtherTxt($("#eokerra3").val()) && checkOtherTxt($("#gArloa").val())){
				if(checkDif($('input:radio[name=zailtasun]:checked').val()))
					return true
			}
		}
	}
	return false
}

function hutsKarGabekoLuz(pText){
	strOK = pText.replace(/\s{2,}/, ' ');
	strOK = strOK.replace(/^\s+/, '');
	strOK = strOK.replace(/\s+$/, '');
	return strOK.length;
}

function checkMail(mail) {
	if(mail.length==0)
		alert("Posta elektronikoa sartu behar duzu!")
	else if(!(/^[A-Za-z]+\d{3}@ikasle\.ehu\.(eus|es)$/.test(mail) || /^[A-Za-z]+\.?[A-Za-z]*@ehu\.(eus|es)$/.test(mail)))
		alert("Sartu duzun posta elektronikoa ez da zuzena!")
	else
		return true
	return false
}

function checkQuestion(question){
	questSanitazeLen = hutsKarGabekoLuz(question)
	if(questSanitazeLen==0)
		alert("Galdera bat sartu behar duzu! (gutxienez 10 karaktere)")
	else if(questSanitazeLen<10)
		alert("Galderak gutxienez 10 karaktere izan behar ditu")
	else
		return true
	return false
}

function checkOtherTxt(txt){
	if(hutsKarGabekoLuz(txt)==0)
		alert("(*) ikurra duten gelaxka guztiak bete behar dituzu!")
	else
		return true
	return false
}

function checkDif(dif){
	console.log(dif)
    if(dif == null)
        alert("Galderaren zailtasuna ere adierazi behar duzu!")
    else
        return true
    return false
}