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
	function menu_multiarray_search($searchmenu, $searchid) {
		foreach ($searchmenu as $element) {
			if (is_array($element) && !empty($element['link']) && $element['link']['mlid'] == $searchid) {
				if ($searchmenu !== menu_tree_page_data('main-menu')) {
					return $searchmenu;
				}
			}
			elseif (is_array($element) && !empty($element['below'])) {
				$return = menu_multiarray_search($element['below'], $searchid);
				if ($return !== FALSE) {
					return $return;
				}
			}
		}
		return FALSE;
	}
?>

<?php if(user_access('Administer content')): ?>
	<?php //drupal_set_message('<pre>' . print_r(menu_tree_page_data('main-menu', 1, TRUE), TRUE) . '</pre>'); ?>
	<?php //drupal_set_message('<pre>' . print_r(menu_get_active_trail(), TRUE) . '</pre>'); ?>
	<?php //drupal_set_message('<pre>' . print_r(drupal_get_breadcrumb(), TRUE) . '</pre>'); ?>
<?php endif; ?>

<?php
	/* dynamically add css files by block name */
	drupal_add_css(drupal_get_path('theme',$GLOBALS['theme']).'/css/blocks--block.tpl.css');
	drupal_add_css(drupal_get_path('theme',$GLOBALS['theme']).'/css/blocks--'.strtolower($block_html_id).'.tpl.css');
?>

<?php
	$menuitem = menu_link_get_preferred();
	$content_output = FALSE;
	if ($menuitem) {
		$mainmenu = menu_tree_page_data('main-menu');
		$content_menu_output = menu_multiarray_search($mainmenu, $menuitem['mlid']);
	}
?>

<?php if ($content_menu_output): ?>
	<div id="<?= $block_html_id; ?>" class="clearfix <?= $classes; ?>"<?= $attributes; ?>>
		<?= render($title_prefix); ?>
		<?php if ($block->subject): ?>
			<h2<?= $title_attributes; ?>><?= $block->subject; ?></h2>
		<?php endif;?>
		<?= render($title_suffix); ?>
		<div class="content"<?=$content_attributes;?>>
			<?= drupal_render(menu_tree_output($content_menu_output)); ?>
		</div>
	</div>
<?php endif; ?>
