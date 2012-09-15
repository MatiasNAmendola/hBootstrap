# hBootstrap: Twitter Bootstrap Helper (Form & Nav)

A PHP Helper Class to write easily twitter bootstrap forms & navs.  

##  Requirements

- Twitter Bootstrap CSS
- A Form Helper with static methods (hForm Class is provided).
- PHP 5.3+

##  Settings

- Settings are set in hBootstrap.php (to change)

## Method hBootstrap::form(Array $args)

Returns a control-group div element.  

This

	echo hBootstrap::form(array(
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

The array accepts 4 values, in the following order :  

1. control group label text
2. control group class (ex: 'success', 'error' ... )
3. help text 
4. help style (ex: 'inline' or 'block' etc.)

The string is the control group label text (see String shortchut example)


**Second value** is an array of values passed to the appropriate static helper method, defined by the key name.  
In the example above, the "input" method is called.  
Obviously, the values order must be the same as the function arguments order.


### More Examples

The hForm helper is used in these examples.  

### Readability

You can specify string keys for readibility purposes. 

	hBootstrap::form(array(
		'control' => array('label' => 'My label', 'class' => 'myClass'), 
		'input'   => array( 'id' => 'description', 'This is an input')
	));

### String shortchut

Shorter syntax with string as first array value.

	hBootstrap::form(array('My label',	
		'input' => array('description', 'This is an input')
	));


### Multiple

One label for multiple controls.  
You **must** specify "multiple" as key name for the second array and add the method name as the first value.   
In this example, the "radio" method is called.

	hBootstrap::form(array('Group of Radios',
		'multiple' => array(
			array('radio', 'radio1', 'radioGroup', 1, 'label_text' => 'First Radio',  'inline', false),
			array('radio', 'radio2', 'radioGroup', 2, 'label_text' => 'Second Radio', 'inline', true)
		)
	));	


### PHP 5.4 short array syntax

	hBootstrap::form([
		'control' => ['My label', 'help'], 
		'input'   => ['description', 'This is an input'])
	]);


## Method hBootstrap::nav($nav_class, Array $items, $url_filter, $url_active)

Returns a nav list. 

This

	$current = hUtils::getCurrentUrl();

	echo hBootstrap::nav(
		'nav-list', 
		
		array(
			'Display', // header
			array('All', hUtils::removeFromQueryString($current, 'sortby')), // link
			array('Unread', hUtils::replaceInQueryString($current, 'sortby', 'unread')),  // link
			
			'Order by',
			array('Subject', hUtils::removeFromQueryString($current, 'orderby')),
			array('Timestamp', hUtils::replaceInQueryString($current, 'orderby', 'timestamp')),
		), 

		$url_filter = function($url) = null,
		
		$url_active = function($url) {
			// ignore 'page' query string
			return ($url == hUtils::removeFromQueryString($_SERVER['REQUEST_URI'], 'page'));
		}
	);

will output :

	// assuming that we display unread messages order by subject 

	<ul class="nav nav-list">
		<li class="nav-header">Display</li>
		<li class="active">
			<a href="/app/messages?">All</a>
		</li>
		<li class="active">
			<a href="/app/messages?sortby=unread">Unread</a>
		</li>

		<li class="nav-header">Order by</li>
		<li class="active">
			<a href="/app/messages?sortby=unread">Subject</a>
		</li>
		<li>
			<a href="/app/messages?sortby=unread&orderby=timestamp">Timestamp</a>
		</li>
	</ul>

### Params  

$nav_class  : UL class ('nav', 'nav-tabs' etc.)  
$items      : Set of links and their text  
$url_filter : Link filter Closure function  
$url_active : Closure function that determines if the link is active or not   



##  Todo

- hForm phpdoc