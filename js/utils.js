function toggle()
{
	var div1 = document.getElementById('left');
	var zuzo = document.getElementById('toggle');
	
	if (div1.style.display == 'none') {
		div1.style.display = 'block'
	} else {
		div1.style.display = 'none'
	}
	
	if (zuzo.style.display == 'block') {
		zuzo.style.display = 'none'
	} else {
		zuzo.style.display = 'block'
	}
}

function checkForm()
{
	var firstName = document.getElementById('register_firstname').value;
	
	if (firstName == '')
	{
		document.getElementById('error').innerHTML = 'errorrrr!!!';
		return false;
	}
	else
	{
		return true;
	}
}

function enableRegisterSubmit()
{
	document.getElementById('register_submit').disabled = false;
}

function clearError()
{
	document.getElementById('error').innerHTML = '';
}