
function ValidateFieldsQuestionJS (qfo){
	if(checkMail(qfo.uposta.value)){
		if(checkQuestion(qfo.tgaldera.value)){
			if(checkOtherTxt(qfo.ezuzena.value) && checkOtherTxt(qfo.eokerra1.value) && checkOtherTxt(qfo.eokerra2.value) && checkOtherTxt(qfo.eokerra3.value) && checkOtherTxt(qfo.gArloa.value)){
				if(checkDif(qfo.querySelectorAll('input[name="zailtasun"]')))
					return true
			}
		}
	}
	return false
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
	if(question.length==0)
		alert("Galdera bat sartu behar duzu! (gutxienez 10 karaktere)")
	else if(question.length<10)
		alert("Galderak gutxienez 10 karaktere izan behar ditu")
	else
		return true
	return false
}

function checkOtherTxt(txt){
	if(txt.length==0)
		alert("(*) ikurra duten gelaxka guztiak bete behar dituzu!")
	else
		return true
	return false
}

function checkDif(dif){
	let selectedValue = 0
    for (const d of dif) {
        if (d.checked) {
            selectedValue = d.value;
            break;
        }
    }
    if(selectedValue == 0)
        alert("Galderaren zailtasuna ere adierazi behar duzu!")
    else
        return true
    
    return false
}