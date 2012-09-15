<?php
/**
 * hForm : Form Helper
 *
 * Visit {@link http://github.com/younes0/hBootForm/} for more information.
 *
 * Last Modified: 09/15/2012
 * TODO: phpdoc
 * 
 *  @author	 	Younès El Biache <younes.elbiache@gmail.com>
 *  @license 	http://opensource.org/licenses/bsd-license.php  New BSD License
 */


class hForm 
{

	/**
	 * Encode / htmlentities function 
	 */
	static protected function encode($string)
	{

		if (function_exists('e')) {
			return e($string);
		
		} else {
			return htmlentities($string);
		}
	}

	
	/**
	 * Label 
	 */
	static public function label($id = null, $text, $for = null, $class = null, Array $extras = array())
	{
		$dom = '<label id="'.$id.'" for="'.$for.'" class="'.$class.'" '.static::add_extras($dom, $extras).'>';
		$dom.= $text;
		$dom.= '</label>';
		return $dom;
	}


	/**
	 * Input
	 */
	static public function input($id, $value = null, $class = null, $encode = true, $type = 'text', Array $extras = array()) 
	{ 
		$val = ($encode === true) ? self::encode($value) : $value;
		$dom = '<input id="'.$id.'" name="'.$id.'" type="'.$type.'" value="'.$val.'" class="'.$class.'" '.static::add_extras($dom, $extras).'>';
		$dom.= $val;
		$dom.= '</input>';
		return $dom;
	}

	
	/**
	 * Returns a textarea
	 */
	static public function textarea($id, $value = null, $class = null, $encode = true, Array $extras = array()) 
	{ 
		$val = ($encode === true) ? self::encode($value) : $value;
		$dom = '<textarea id="'.$id.'" name="'.$id.'" class="'.$class.'" '.static::add_extras($dom, $extras).'>';
		$dom.= $val;
		$dom.= '</textarea>';
		return $dom;
	}
	

	/**
	 * Returns a checkbox within a label
	 */
	static public function checkbox($id = null, $value = true, $checked = false, $label_text, $label_class = null) 
	{ 
		$checked_str = ($checked) ? 'checked="checked"' : null;
		$dom = '
			<label class="checkbox '.$label_class.'">
				<input id="'.$id.'" name="'.$id.'" type="checkbox" value="'.$value.'" '.$checked_str.'>
				'.$label_text.'
			</label>
		';
		return $dom;
	}


	/**
	 * Returns a radio within a label
	 */
	static public function radio($id = null, $name, $value, $checked = false, $label_text, $label_class = null) 
	{ 
		$checked_str = ($checked) ? 'checked="checked"' : null;
		$dom = '
			<label class="radio '.$label_class.'">
				<input id="'.$id.'" name="'.$name.'" type="radio" value="'.$value.'" '.$checked_str.'>
				'.$label_text.'
			</label>
		';
		return $dom;
	}



	/**
	 * Returns a select
	 * --------------------------------
	 * 
	 * Exemple of complex array:
	 * array(
	 * 		array(
	 * 			'value' => 'myval_one', 'text' => 'mytext_one', 'extras' => array('picture' => 'myurl_one'), 
	 * 		 	'children' => array('value' => 'myval_child', 'text' => 'mytext_child', 'extras' => array('thumb' => 'myurl_child') )
	 * 	   ),
	 * 	   array(
	 * 		  'value' => 'myval_two', 'text_two' => 'mytext', 'extras' => array('picture' => 'myurl_two'), 
	 * 		  'children' => array('value' => 'myval_child', 'text' => 'mytext_child', 'extras' => array('thumb' => 'myurl_child') )
	 * 	   )
	 * 	);
	 */
 	static public function select($id, $value = null, $options = array(), $class = null, $allow_null = true, $multiple = false, Array $extras = array()) 
	{	

		$selected_str =  ' selected="selected"';

		// is multiple ?
		$name = ($multiple) ? (preg_replace('/(?:\d*)/', '', $id)).'[]' : $id;
		$multiple_str = ($multiple) ? $id : null;

		$dom = '<select id="'.$id.'" name="'.$name.'" class="'.$class.'" '.$multiple_str.' '.static::add_extras($dom, $extras).'>';

		if ($allow_null) {
			$null_text = is_string($allow_null) ? $allow_null : null; 
			$dom.= '<option value="">'.$null_text.'</option>';
		}

		foreach ($options as $opt) {

			// no optgroup
			if ( !isset($opt['children']) ) {
				$dom.= static::option($opt, $value);
				
			// optgroup			
			} else { 
				$dom.= '<optgroup label="'.$opt['text'].'">';
				
				foreach ($opt['children'] as $opt_child) {
					$dom.= static::option($opt_child, $value);
				}
				$dom.= '</optgroup>';
			}
		}

		$dom.= '</select>';
		
		return $dom;
	}


	/**
	 * Returns an option
	 */
	static public function option(Array $option = array(), $value)
	{
		$selected_str = ' selected="selected" ';
		
		$option['value'] = isset($option['value']) ? $option['value'] : null;
		$option['text']  = isset($option['text']) ? $option['text'] : null;

		$dom.= '<option value="'.$option['value'].'" ';
		
		if (isset($option['extras']) and is_array($option['extras'])) {
			$dom.= static::add_extras($dom, $option['extras']);
		}

		// multiple: $value must be an array
		if ($multiple) {
			$length = sizeof($value);
			for ($i=0; $i<$length; $i++) {
				if ($value[$i] == $option['value'] ) {
					$dom.= $selected_str;
				}
			}

		// not multiple
		} else {
			if ($value == $option['value']) {
				$dom.= $selected_str;
			}
		}

		$dom.= '>';
		$dom.= $option['text'];
		$dom.= '</option>';

		return $dom;
	}



	/**
	 * Returns a Numeric select
	 */
	static public function num_select($id, $value = null, $min, $max, $class = null, $allow_null = true, Array $extras = array()) 
	{
		$dom = '<select id="'.$id.'" name="'.$id.'" class="'.$class.'" '.static::add_extras($dom, $extras).'>';
		
		if ($allow_null) {
			$null_text = is_string($allow_null) ? $allow_null : null; 
			$dom.= '<option value="">'.$null_text.'</option>';
		}

		for ($i=$min; $i<=$max; $i++) {
			$selected = ( $i == $value ) ? 'selected="selected"' : null;
			$dom.= '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
		}

		$dom.= '</select>';
		return $dom;
	}


 
 	/**
 	 * Add extra attributes
 	 */
	static private function add_extras($dom, Array $extras = array())
	{
		foreach ($extras as $extra => $value) {
			$dom.= $extra.'="'.$value.'" ';
		}
		return $dom;
	}



}