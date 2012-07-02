# hBootForm: Twitter Bootstrap Form Helper

This is a PHP Helper Class, with static methods, to write easily twitter bootstrap forms.  
The hDom helper class is included to generate form elements.

##  Requirements

- Twitter Bootstrap CSS
- A Form Helper with static methods (the **hForm** Class is provided).

##  Settings

- Settings are set directly in hBootForm.php

##  Methods

### hBootForm::c(array $args)

Returns a control-group div element.  

Example: 

	echo hBootForm::c(array(
		'control' => array('My Label', 'class', 'help-text', 'block'), 
		'input'   => array('description', 'This is an input')
	));

will output :

	<div class="control-group class">
		<label id="" class="control-label" for="description">My Label</label>
		<div class="controls">
			<input id="description" name="description" type="text" value="This is an input">
			<p class="help-block">help-text</p>
		</div>
	</div>

**First value** of $args can be either an array (with  key or not) or a string.  

In case of an array, the array accepts 4 values, in the following order :  

1. control group label text
2. control group class (ex: 'success', 'error' ... )
3. help text 
4. help style (ex: 'inline' or 'block' etc.)

In case of a string, the string is the control group label text.


**Second value** is an array of values passed to the appropriate static helper method, defined by the key name.  
In the example above, the "input" method is called.  
The values order must be the same as the function arguments order.


## More Examples

The hForm helper is used in these examples.  


### Readability

You can specify string keys for values for readibility purposes. 

	hBootForm::c(array(
		'control' => array('label' => 'My label', 'class' => 'myClass'), 
		'input'   => array( 'id' => 'description', 'This is an input')
	));

### String shortchut

Shorter syntax with string as first array value.

	hBootForm::c(array('My label',	
		'input' => array('description', 'This is an input')
	));


### Multiple

One label for multiple controls. 
You **must** specify "multiple" as key name for the second array and add the method name as the first value.  
In this example, the "radio" method is called.

	hBootForm::c(array('Group of Radios',
		'multiple' => array(
			array('radio', 'radio1', 'radioGroup', 1, 'label_text' => 'First Radio',  'inline', false),
			array('radio', 'radio2', 'radioGroup', 2, 'label_text' => 'Second Radio', 'inline', true)
		)
	));	


### PHP 5.4 short array syntax

	hBootForm::c([
		'control' => ['My label', 'help'], 
		'input'   => ['description', 'This is an input'])
	]);


### String shortchut + PHP 5.4 short array syntax

	hBootForm::c(['My label', 'input' => ['description', 'This is a input'] ]);


##  Todo

- hForm improvements and comments
- Append + Prepend ?
- Actions + Buttons ??