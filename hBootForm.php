<?php
/**
 * hBootForm : Twitter Bootstrap Form Helper
 *
 * Visit {@link http://github.com/younes0/hBootForm/} for more information.
 *
 * Last Modified: 07/02/2012
 * 
 *  @author     Younès El Biache <younes.elbiache@gmail.com>
 *  @license 	http://opensource.org/licenses/bsd-license.php  New BSD License
 */

class hBootForm
{

	/**
	 * Form helper class name.
	 * @var string
	 */
	static public $dom_helper = 'hForm';



	/**
	 * Returns a control-group div element. Read README.markdown for more information.
	 * @param  Array  $args two values
	 * @return string  control-group div element
	 *	 
	 */
	static public function c(Array $args)
	{
		// element type
		$keys = array_keys($args);
		$type = $keys[1];
		
		// multiple elements
		if ($type === 'multiple') {

			foreach ($args['multiple'] as $values){
				$type = $values[0];
				array_shift($values); // removes type
				$controls .= call_user_func_array(array(self::$dom_helper, $type), $values);
			}

			$for = null;

		// single element
		} else {
			$values   = self::normalizeArray($args[$type]);
			$controls.= call_user_func_array(array(self::$dom_helper, $type), $values);
			$for      = $values[0];

		}
	

		// controls: variables setup
		if ($args['control']) {

			$c = $args['control']; 

			$label        = $c[0] ?: null;
			$class        = $c[1] ?: null;
			$help_text    = $c[2] ?: null;
			$help_display = $c[3] ?: 'block';

			// help
			$help = ($help_text) ? '<p class="help-'.$help_display.'">'.$help_text.'</p>' : null;

		// controls: string shortcut	
		} else {
			$label = $args[0] ?: null;
			$class = null;
			$help  = null;
		}

		// dom
		$dom = '<div class="control-group '.$class.'">';
		$dom.= call_user_func_array(array(self::$dom_helper, label), array(null, $label, $for, 'control-label'));
		$dom.= '<div class="controls">'.$controls.$help.'</div>';
		$dom.= '</div>';

		// return
		return $dom;

	}


	/**
	 * Converts array strings keys to numeric keys
	 * @param  array $array in
	 * @return array        out
	 */
	static private function normalizeArray(Array $array){
		$newarray   = array();
		$array_keys = array_keys($array);
		$i = 0;
		foreach($array_keys as $key){
			$newarray[$i] = $array[$key];
			$i++;
		}
		return $newarray;
    }


}