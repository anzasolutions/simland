<?php

class SelectGenderGenerator extends HTMLGenerator
{
	protected $request;
	
	public function SelectGenderGenerator(RequestHandler $request)
	{
		$this->request = $request;
	}
	
	public function generateSelectGender()
	{
		$gendersLength = 3;
		$gendersArray = array('', 'Kobieta', 'M&#281;&#380;czyzna');
		$genders = '<select id="register_gender" name="register_gender" class="select"><option value="" class="option">Wybierz p&#322;e&#263;:</option>';
		
		for ($i = 1; $i < $gendersLength; $i++)
		{
			if (array_key_exists('register_gender', $this->request->container) && $this->request->container['register_gender'] == $i)
			{
				$genders .= '<option value="' . $i . '" selected class="option">' . $gendersArray[$i] . '</option>';
				continue;
			}
			$genders .= '<option value="' . $i . '" class="option">' . $gendersArray[$i] . '</option>';
		}
		
        $genders .= '</select>';
		
		return $genders;
	}
}

?>