<?php

class HTMLBuilder
{
	public function linkBegin($url, $id = null, $title = null, $class = null, $style = null)
	{
		$id = !empty($id) ? ' id="' . $id . '"' : $id; // is this really necessary?
		$url = !empty($url) ? ' href="' . $url . '"' : $url;
		$title = !empty($title) ? ' title="' . $title . '"' : $title;
		$class = !empty($class) ? ' class="' . $class . '"' : $class;
		$style = !empty($style) ? ' style="' . $style . '"' : $style;
		
		return '<a' . $url . $title . $class . $style . '>';
	}
	
	public function linkEnd()
	{
		return '</a>';
	}
	
	public function divBegin($id = null, $class = null, $style = null)
	{
		$id = !empty($id) ? ' id="' . $id . '"' : $id;
		$class = !empty($class) ? ' class="' . $class . '"' : $class;
		$style = !empty($style) ? ' style="' . $style . '"' : $style;
		
		return '<div' . $id . $class . $style . '>';
	}
	
	public function divEnd()
	{
		return '</div>';
	}
	
	public function divClosed($id = null, $class = null, $style = null)
	{
		return $this->divBegin($id, $class, $style) . $this->divEnd();
	}
	
	public function spanBegin($id = null, $class = null, $style = null)
	{
		$id = !empty($id) ? ' id="' . $id . '"' : $id;
		$class = !empty($class) ? ' class="' . $class . '"' : $class;
		$style = !empty($style) ? ' style="' . $style . '"' : $style;
		
		return '<span' . $id . $class . $style . '>';
	}
	
	public function spanEnd()
	{
		return '</span>';
	}
	
	public function spanClosed($id = null, $class = null, $style = null)
	{
		return $this->spanBegin($id, $class, $style) . $this->spanEnd();
	}
	
	public function imageBegin($src, $id = null, $class = null, $style = null)
	{
		$src = !empty($src) ? ' src="' . $src . '"' : $src;
		$id = !empty($id) ? ' id="' . $id . '"' : $id;
		$class = !empty($class) ? ' class="' . $class . '"' : $class;
		$style = !empty($style) ? ' style="' . $style . '"' : $style;
		
		return '<img' . $src . $id . $class . $style;
	}
	
	public function imageEnd()
	{
		return ' />';
	}
	
	public function liBegin()
	{
		return '<li>';
	}
	
	public function liEnd()
	{
		return '</li>';
	}
	
	public function selectBegin($id = null, $class = null, $style = null, $name = null)
	{
		$id = !empty($id) ? ' id="' . $id . '"' : $id;
		$class = !empty($class) ? ' class="' . $class . '"' : $class;
		$style = !empty($style) ? ' style="' . $style . '"' : $style;
		$name = !empty($name) ? ' name="' . $name . '"' : $name;
		
		return '<select' . $id . $class . $style . $name . '>';
	}
	
	public function selectEnd()
	{
		return '</select>';
	}
	
	public function optionBegin($id = null, $class = null, $style = null, $value = null)
	{
		$id = !empty($id) ? ' id="' . $id . '"' : $id;
		$class = !empty($class) ? ' class="' . $class . '"' : $class;
		$style = !empty($style) ? ' style="' . $style . '"' : $style;
		$name = !empty($name) ? ' name="' . $name . '"' : $name;
		$value = !empty($value) ? ' value="' . $value . '"' : $value;
		
		return '<option' . $id . $class . $style . $name . $value . '>';
	}
	
	public function optionEnd()
	{
		return '</option>';
	}
}

?>