<?php

class SelectDateGenerator extends HTMLGenerator
{
	protected $request;
	
	public function SelectDateGenerator(RequestHandler $request)
	{
		$this->request = $request;
	}
	
	public function generateSelectDate()
	{
		$days = $this->generateSelectDateDay();
		$months = $this->generateSelectDateMonth();
		$years = $this->generateSelectDateYear();
		
		return $years . ' ' . $months . ' ' . $days;
	}
	
	private function generateSelectDateDay()
	{
		$daysLength = 32;
		$days = '<select id="register_day" name="register_day" class="select" onfocus="return genDays();" style="width: 60px;"><option value="">Dzie&#324;</option>';
	
		for ($i = 1; $i < $daysLength; $i++)
		{
			if (array_key_exists('register_day', $this->request->container) && $this->request->container['register_day'] == $i)
			{
				$days .= '<option value="' . $i . '" selected class="option">' . $i . '</option>';
				continue;
			}
			$days .= '<option value="' . $i . '" class="option">' . $i . '</option>';
		}
		
        $days .= '</select>';
        
		return $days;
	}
	
	private function generateSelectDateMonth()
	{
		$monthsLength = 13;
		$monthsArray = array('','Stycze&#324', 'Luty', 'Marzec', 'Kwiecie&#324;', 'Maj', 'Czerwiec', 'Lipiec', 'Sierpie&#324;', 'Wrzesie&#324;', 'Pa&#378;dziernik', 'Listopad', 'Grudzie&#324;');
		
		$months = '<select id="register_month" name="register_month" class="select" onchange="return genDays();" style="width: 71px;"><option value="" class="option">Miesi&#261;c</option>';
	
		for ($i = 1; $i < $monthsLength; $i++)
		{
			if (array_key_exists('register_month', $this->request->container) && $this->request->container['register_month'] == $i)
			{
				$months .= '<option value="' . $i . '" selected class="option">' . $monthsArray[$i] . '</option>';
				continue;
			}
			$months .= '<option value="' . $i . '" class="option">' . $monthsArray[$i] . '</option>';
		}
		
        $months .= '</select>';
        
		return $months;
	}
	
	private function generateSelectDateYear()
	{
		$yearsLength = 80;
		$years = '<select id="register_year" name="register_year" class="select"><option value="" class="option">Rok</option>';

		for ($i = 2000; $i > 2000 - $yearsLength; $i--)
		{
			if (array_key_exists('register_year', $this->request->container) && $this->request->container['register_year'] == $i)
			{
				$years .= '<option value="' . $i . '" selected class="option">' . $i . '</option>';
				continue;
			}
			$years .= '<option value="' . $i . '" class="option">' . $i . '</option>';
		}
		
        $years .= '</select>';
        
		return $years;
	}
}

?>