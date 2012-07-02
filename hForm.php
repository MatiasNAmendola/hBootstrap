<?php
/**
 * hForm : Form Helper
 *
 */
class hForm 
{


	static protected function myEncode($string)
	{
		// your htmlentities function
		return fHTML::encode($string);
	}


	/**
	 * Label 
	 * 
	 * @param  [type] $id    [description]
	 * @param  [type] $text  [description]
	 * @param  [type] $for   [description]
	 * @param  [type] $class [description]
	 * @return string        html content
	 */
	static function label($id = null, $text, $for = null, $class = null)
	{
		return '<label id="'.$id.'" for="'.$for.'" class="'.$class.'">'.$text.'</label>';
	}


	/**
	 * Input
	 * 
	 * @param  [type]  $id          [description]
	 * @param  [type]  $value       [description]
	 * @param  [type]  $class       [description]
	 * @param  boolean $encode      [description]
	 * @param  string  $placeholder [description]
	 * @param  string  $type        [description]
	 * @param  [type]  $extra       [description]
	 * @return string               [description]
	 */
	static function input($id, $value = null, $class = null, $encode = true, $placeholder = '', $type = 'text',  $extra = null) 
	{ 
		$val = ($encode === true) ? self::myEncode($value) : $value;
		return '<input id="'.$id.'" name="'.$id.'" type="'.$type.'" value="'.$val.'" class="'.$class.'" placeholder="'.$placeholder.'" '.$extra.'>';
	}

	
	/**
	 * Returns a textarea
	 * 
	 * @param  [type]  $id          [description]
	 * @param  [type]  $value       [description]
	 * @param  [type]  $class       [description]
	 * @param  [type]  $rows        [description]
	 * @param  boolean $encode      [description]
	 * @param  string  $placeholder [description]
	 * @param  [type]  $extra       [description]
	 * @return string               [description]
	 */
	static function textarea($id, $value = null, $class = null, $rows = null, $encode = true, $placeholder = '', $extra = null) 
	{ 
		$val = ($encode === true) ? self::myEncode($value) : $value;
		$dom.= '<textarea id="'.$id.'" name="'.$id.'" class="'.$class.'" rows="'.$rows.'" placeholder="'.$placeholder.'" '.$extra.'>';
		$dom.= $val;
		$dom.= '</textarea>';
		return $dom;
	}
	

	/**
	 * Returns a checkbox within a label
	 * 
	 * @param  [type]  $id          [description]
	 * @param  [type]  $value       [description]
	 * @param  [type]  $label_text  [description]
	 * @param  [type]  $label_class [description]
	 * @param  boolean $checked     [description]
	 * @return string               [description]
	 */
	static function checkbox($id = null, $value, $label_text, $label_class = null, $checked = false) 
	{ 
		$checked_attr = ($checked) ? 'checked="checked"' : null;
		$dom = '
			<label class="checkbox '.$label_class.'">
				<input id="'.$id.'" name="'.$id.'" type="checkbox" value="'.$value.'" '.$checked_attr.'>
				'.$label_text.'
			</label>
		';
		return $dom;
	}


	/**
	 * [Returns a radio within a label
	 * @param  [type]  $id          [description]
	 * @param  [type]  $name        [description]
	 * @param  [type]  $value       [description]
	 * @param  [type]  $label_text  [description]
	 * @param  [type]  $label_class [description]
	 * @param  boolean $checked     [description]
	 * @return string               [description]
	 */
	static function radio($id = null, $name, $value, $label_text, $label_class = null, $checked = false) 
	{ 
		$checked_attr = ($checked) ? 'checked="checked"' : null;
		$dom = '
			<label class="radio '.$label_class.'">
				<input id="'.$id.'" name="'.$name.'" type="radio" value="'.$value.'" '.$checked_attr.'>
				'.$label_text.'
			</label>
		';
		return $dom;
	}




	static function numSelect($id, $value = null, $min, $max, $class = null, $label_for_null = null, $extra = null) 
	{
		$dom = '<select id="'.$id.'" name="'.$id.'" class="'.$class.'" '.$extra.'>';
		
		if ($label_for_null) $dom.= '<option value="">'.$label_for_null.'</option>';

		for ($i=$min; $i<=$max; $i++) {

			$dom.= '<option value="'.$i.'"';
			if ( $i == $value ) $dom.= ' selected="selected"';
			$dom.= '>';
			$dom.= $i;
			$dom.= '</option>';
		}

		$dom.= '</select>';
		return $dom;
	}


	/**
	 * [select description]
	 * 
	 * @param  [type]  $id             [description]
	 * @param  [type]  $value          [description]
	 * @param  [type]  $options        [description]
	 * @param  [type]  $class          [description]
	 * @param  [type]  $label_for_null [description]
	 * @param  boolean $optgroup       [description]
	 * @param  boolean $multiple       [description]
	 * @param  string  $placeholder    [description]
	 * @return string                  [description]
	 */
 	static function select
 	(
 		$id, $value = null, $options = null, $class = null, $label_for_null = null, 
 		$optgroup = false, $multiple = false,  $placeholder = ''
 	) 
	
	{	

		// so name & $value are Array
		if ( $multiple ) {
			$multiple_attr = 'multiple';
			$name = preg_replace('/(?:\d*)/', '', $id);
			$name.= '[]';

		} else {
			$multiple_attr = '';
			$name          = $id;
		}

		$dom = '<select id="'.$id.'" name="'.$name.'" class="'.$class.'" placeholder="'.$placeholder.'"  '.$multiple_attr.'>';
		
		$dom.= (isset($label_for_null)) ? '<option value="">'.$label_for_null.'</option>' : null; 

		foreach ($options as $opt) {
						
			$i_value = (isset($opt['value'])) ? $opt['value'] : null;
			$i_text  = (isset($opt['text'])) ? $opt['text'] : null;
	
			// No Optgroup
			if ( !$optgroup ) {
				$dom.= '<option value="'.$i_value.'"';
				if ( $multiple ) {
					// $value is an Array
					$valueLength = sizeof($value);
					for ($v=0; $v<$valueLength; $v++) {
						if ( $value[$v] == $i_value ) $dom.= ' selected="selected"';
					}

				} else {
					if ( $value == $i_value ) $dom.= ' selected="selected"';
				}
				$dom.= '>';
				$dom.= $i_text;
				$dom.= '</option>';
			
			// Optgroup			
			} else { 
			
				$dom.= '<optgroup label="'.$opt['text'].'">';
				
				foreach ($opt['options'] as $opt_child) {
					
					$j_value = (isset($opt_child['value'])) ? $opt_child['value'] : null;
					$j_text  = (isset($opt_child['text'])) ? $opt_child['text'] : null;

					$dom.= '<option value="'.$j_value.'"';
										
					if ( $multiple ) {
						for ($v=0; $length = sizeof($value), $v<$length; $v++) {
							if ( $value[$v] == $j_value ) $dom.= ' selected="selected"';
						}

					} else {
						if ( $value == $j_value ) $dom.= ' selected="selected"';
					}
					
					$dom.= '>';
					$dom.= $j_text;
					$dom.= '</option>';
				}
				
				$dom.= '</optgroup>';
			}
	
		}

		$dom.= '</select>';
		
		return $dom;
	}

}