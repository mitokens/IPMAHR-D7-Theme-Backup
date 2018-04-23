<?php
/**
 * Available variables:
 * $block->subject: Block title.
 * $content: Block content.
 * $block->module: Module that generated the block.
 * $block->delta: An ID for the block, unique within each module.
 * $block->region: The block region embedding the current block.
 * $classes: String of classes that can be used to style contextually through 
 *   CSS. It can be manipulated through the variable $classes_array from 
 *   preprocess functions. The default values can be one or more of the 
 *   following:
 *   block: The current template type, i.e., "theming hook".
 *   block-[module]: The module generating the block. For example, the user 
 *   module is responsible for handling the default user navigation block. In 
 *   that case the class would be 'block-user'.
 * $title_prefix (array): An array containing additional output populated by 
 *   modules, intended to be displayed in front of the main title tag that 
 *   appears in the template.
 * $title_suffix (array): An array containing additional output populated by 
 *   modules, intended to be displayed after the main title tag that appears 
 *   in the template.
 * 
 * Helper variables:
 * $classes_array: Array of html class attribute values. It is flattened 
 *   into a string within the variable $classes.
 * $block_zebra: Outputs 'odd' and 'even' dependent on each block region.
 * $zebra: Same output as $block_zebra but independent of any block region.
 * $block_id: Counter dependent on each block region.
 * $id: Same output as $block_id but independent of any block region.
 * $is_front: Flags true when presented in the front page.
 * $logged_in: Flags true when the current user is a logged-in member.
 * $is_admin: Flags true when the current user is an administrator.
 * $block_html_id: A valid HTML ID and guaranteed unique.
**/
?>

<?php
	/**
	*** These $_SESSION variables are important for later.
	*** After the login completes, a redirect script will point the user to either the referer or the destination, as needed.
	**/
	$request_uri = implode('', explode('/', $_SERVER['REQUEST_URI'], 2));
	$_SESSION['login_query'] = ($_SERVER['QUERY_STRING'])? associative_explode($_SERVER['QUERY_STRING']): (array());
	$destination = isset($_SESSION['login_query']['destination'])? ($_SESSION['login_query']['destination']): ($request_uri);
	$destination = str_replace(' ', '+', urldecode($destination));
	$_SESSION['login_referer'] = $_SERVER['HTTP_REFERER'];
	$_SESSION['login_destination'] = $destination;
?>

<div id="<?=$block_html_id;?>" class="clearfix <?=$classes;?>"<?=$attributes;?>>
	<!-- block--block--110.tpl.php !-->
	<!-- uri=<?=$request_uri;?> !-->
	<!-- login_query=<?=print_r($_SESSION['login_query'],TRUE);?> !-->
	<!-- login_referer=<?=$_SESSION['login_referer'];?> !-->
	<!-- login_destination=<?=$_SESSION['login_destination'];?> !-->
</div>
