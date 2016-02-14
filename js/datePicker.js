	function genDays()
	{
		var daysInMonth = 32;
		var iYear = document.getElementById('register_year').value;
		var iMonth = document.getElementById('register_month').value - 1;
		var newDaysInMonth = getDaysInMonth(iYear, iMonth);
		
		document.getElementById('register_day').innerHTML = '';
		
		if (newDaysInMonth != null)
		{
			daysInMonth = newDaysInMonth;
		}

		document.getElementById('register_day').innerHTML += '<option value="">Dzie&#324;</option>';
		for (var i = 1; i < daysInMonth + 1; i++)
		{
			document.getElementById('register_day').innerHTML += '<option value="' + i + '" class="option">' + i + '</option>';
		}
	}

	function genMonths()
	{
		var lenm = 13;
		var months = new Array('','Stycze&#324', 'Luty', 'Marzec', 'Kwiecie&#324;', 'Maj', 'Czerwiec', 'Lipiec', 'Sierpie&#324;', 'Wrzesie&#324;', 'Pa&#378;dziernik', 'Listopad', 'Grudzie&#324;');

		document.getElementById('register_month').innerHTML = '';

		document.getElementById('register_month').innerHTML += '<option value="">Miesi&#261;c</option>';
		for (var i = 1; i < lenm; i++)
		{
			document.getElementById('register_month').innerHTML += '<option value="' + i + '" class="option">' + months[i] + '</option>';
			
		}
	}

	function genYears()
	{
		var leny = 80;
		//var months = new Array('','Stycze&#324', 'Luty', 'Marzec', 'Kwiecie&#324;', 'Maj', 'Czerwiec', 'Lipiec', 'Sierpie&#324;', 'Wrzesie&#324;', 'Pa&#378;dziernik', 'Listopad', 'Grudzie&#324;');

		document.getElementById('register_year').innerHTML = '';

		document.getElementById('register_year').innerHTML += '<option value="">Rok</option>';
		for (var i = 2000; i > 2000 - 80; i--)
		{
			document.getElementById('register_year').innerHTML += '<option value="' + i + '" class="option">' + i + '</option>';
			
		}
	}
	
	function getDaysInMonth(iYear, iMonth)
	{
		return 32 - new Date(iYear, iMonth, 32).getDate();
	}