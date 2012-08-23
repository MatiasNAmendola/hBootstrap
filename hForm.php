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
		return e($string);
	}

	
	/**
	 * Label 
	 * 
	 * @param  [type] $id	[description]
	 * @param  [type] $text  [description]
	 * @param  [type] $for   [description]
	 * @param  [type] $class [description]
	 * @return string		html content
	 */
	static function label($id = null, $text, $for = null, $class = null)
	{
		return '<label id="'.$id.'" for="'.$for.'" class="'.$class.'">'.$text.'</label>';
	}


	/**
	 * Input
	 * 
	 * @param  [type]  $id		  [description]
	 * @param  [type]  $value	   [description]
	 * @param  [type]  $class	   [description]
	 * @param  boolean $encode	  [description]
	 * @param  string  $placeholder [description]
	 * @param  string  $type		[description]
	 * @param  [type]  $extra	   [description]
	 * @return string			   [description]
	 */
	static function input($id, $value = null, $class = null, $encode = true, $placeholder = '', $type = 'text',  $extra = null) 
	{ 
		$val = ($encode === true) ? self::myEncode($value) : $value;
		return '<input id="'.$id.'" name="'.$id.'" type="'.$type.'" value="'.$val.'" class="'.$class.'" placeholder="'.$placeholder.'" '.$extra.'>';
	}

	
	/**
	 * Returns a textarea
	 * 
	 * @param  [type]  $id		  [description]
	 * @param  [type]  $value	   [description]
	 * @param  [type]  $class	   [description]
	 * @param  [type]  $rows		[description]
	 * @param  boolean $encode	  [description]
	 * @param  string  $placeholder [description]
	 * @param  [type]  $extra	   [description]
	 * @return string			   [description]
	 */
	static function textarea($id, $value = null, $class = null, $rows = null, $encode = true, $placeholder = '', $extra = null) 
	{ 
		$val = ($encode === true) ? self::myEncode($value) : $value;
		$dom = '<textarea id="'.$id.'" name="'.$id.'" class="'.$class.'" rows="'.$rows.'" placeholder="'.$placeholder.'" '.$extra.'>';
		$dom.= $val;
		$dom.= '</textarea>';
		return $dom;
	}
	

	/**
	 * Returns a checkbox within a label
	 * 
	 * @param  [type]  $id		  [description]
	 * @param  [type]  $value	   [description]
	 * @param  [type]  $label_text  [description]
	 * @param  [type]  $label_class [description]
	 * @param  boolean $checked	 [description]
	 * @return string			   [description]
	 */
	static function checkbox($id = null, $checked = false, $label_text, $label_class = null, $value = null) 
	{ 
		$checked_attr = (hUtils::pgbool($checked)) ? 'checked="checked"' : null;
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
	 * @param  [type]  $id		  [description]
	 * @param  [type]  $name		[description]
	 * @param  [type]  $value	   [description]
	 * @param  [type]  $label_text  [description]
	 * @param  [type]  $label_class [description]
	 * @param  boolean $checked	 [description]
	 * @return string			   [description]
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



	/**
	 * [numSelect description]
	 * @param  [type] $id		 [description]
	 * @param  [type] $value	  [description]
	 * @param  [type] $min		[description]
	 * @param  [type] $max		[description]
	 * @param  [type] $class	  [description]
	 * @param  [type] $null_label [description]
	 * @param  [type] $extra	  [description]
	 * @return [type]			 [description]
	 */
	static function numSelect($id, $value = null, $min, $max, $class = null, $null_label = null, $extra = null) 
	{
		$dom = '<select id="'.$id.'" name="'.$id.'" class="'.$class.'" '.$extra.'>';
		
		if ($null_label) $dom.= '<option value="">'.$null_label.'</option>';

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
	 * @param  [type]  $id			 [description]
	 * @param  [type]  $value		  [description]
	 * @param  [type]  $options		[description]
	 * @param  [type]  $class		  [description]
	 * @param  [type]  $null_label 	   [description]
	 * @param  boolean $optgroup	   [description]
	 * @param  boolean $multiple	   [description]
	 * @param  string  $placeholder	[description]
	 * @return string				  [description]
	 */
 	static function select($id, $value = null, Array $options = null, $class = null, $empty = true,  $multiple = false) 
	{	

		$selected_str =  ' selected="selected"';

		// so name & $value are Array
		if ( $multiple ) {
			$multiple_attr = 'multiple';
			$name = preg_replace('/(?:\d*)/', '', $id);
			$name.= '[]';

		} else {
			$multiple_attr = '';
			$name		  = $id;
		}

		$dom = '<select id="'.$id.'" name="'.$name.'" class="'.$class.'" '.$multiple_attr.'>';
		
		if ($empty) {
			$dom.= '<option value="">';
			$dom.= is_string($empty) ? $empty : null; 
			$dom.= '</option>';
		}

		foreach ($options as $o) {
						
			$o['value']	 = isset($o['value']) ? $o['value'] : null;
			$o['text']	  = isset($o['text']) ? $o['text'] : null;
			$o['data_attr'] = self::extractData($o);

			// No Optgroup
			if ( !isset($o['children']) ) {
				$dom.= '<option value="'.$o['value'].'" '.$o['data_attr'];
				
				if ( $multiple ) {
					// $value is an Array
					$valueLength = sizeof($value);
					for ($v=0; $v<$valueLength; $v++) {
						if ( $value[$v] == $o['value'] ) $dom.= $selected_str;
					}

				} else {
					if ( $value == $o['value'] ) $dom.= $selected_str;
				}

				$dom.= '>';
				$dom.= $o['text'];
				$dom.= '</option>';
			
			// Optgroup			
			} else { 
			
				$dom.= '<optgroup label="'.$o['text'].'">';
				
				foreach ($o['children'] as $o_child) {
					
					$o_child['value']	 = isset($o_child['value']) ? $o_child['value'] : null;
					$o_child['text']	  = isset($o_child['text']) ? $o_child['text'] : null;
					$o_child['data_attr'] = self::extractData($o_child);

					$dom.= '<option value="'.$o_child['value'].'" '.$o_child['data_attr'];
										
					if ( $multiple ) {
						for ($v=0; $length = sizeof($value), $v<$length; $v++) {
							if ( $value[$v] == $o_child['value'] ) $dom.= $selected_str;
						}

					} else {
						if ( $value == $o_child['value'] ) $dom.= $selected_str;
					}
					
					$dom.= '>';
					$dom.= $o_child['text'];
					$dom.= '</option>';
				}
				
				$dom.= '</optgroup>';
			}
	
		}

		$dom.= '</select>';
		
		return $dom;
	}


	static private function extractData($array) {
		$attr = null;
		foreach ($array as $key => $value) {
			if (preg_match('/^data_/', $key)) {
				if ($value) {
					$attr .= str_replace('data_', 'data-', $key).'="'.$value.'"';
				}
			}
		}
		return $attr;
	}
	

	static function itemText(Array $options, $value)
	{	
		foreach ($options as $o) {		
			if ($o['value'] == $value) {
				return $o['text'];
				break; 
			}		
		}

	}


}