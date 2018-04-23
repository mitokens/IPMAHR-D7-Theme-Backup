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
	/* dynamically add css files by block name */
	drupal_add_css(drupal_get_path('theme',$GLOBALS['theme']).'/css/blocks--block.tpl.css');
	drupal_add_css(drupal_get_path('theme',$GLOBALS['theme']).'/css/blocks--'.strtolower($block_html_id).'.tpl.css');
?>

<?php
	$active_trail = menu_get_active_trail();
	$current_mlitem = end($active_trail);
	$parent_mlitem = prev($active_trail);
	$parent_mlitem = ($parent_mlitem['mlid'])? ($parent_mlitem): ($current_mlitem);
	if ($parent_mlitem['mlid'] != $current_mlitem['mlid']) {
		$submenu_parameters = array(
			'expanded' => array($current_mlitem['mlid']),
			'active_trail' => array($current_mlitem['mlid']),
			'min_depth' => $current_mlitem['depth']+1,
			'max_depth' => $current_mlitem['depth']+1,
		);
		$submenu_tree = menu_build_tree($current_mlitem['menu_name'], $submenu_parameters);
	}
	$menu_parameters = array(
		'expanded' => array($parent_mlitem['mlid']),
		'active_trail' => array($parent_mlitem['mlid']),
		'min_depth' => $parent_mlitem['depth']+1,
		'max_depth' => $parent_mlitem['depth']+1,
	);
	$menu_tree = menu_build_tree($parent_mlitem['menu_name'], $menu_parameters);
	foreach ($menu_tree as $mlkey => $mlitem) {
		if ($mlitem['link']['mlid'] == $current_mlitem['mlid'] && !empty($submenu_tree)) {
			$menu_tree[$mlkey]['below'] = $submenu_tree;
		}
	}
	$menu_render = menu_tree_output($menu_tree);
?>

<?php if ($menu_render): ?>
	<div id="<?=$block_html_id;?>" class="clearfix <?=$classes;?>"<?=$attrworkibutes;?>>
		<?=render($title_prefix);?>
		<h2<?=$title_attributes;?>><?=l($parent_mlitem['link_title'], $parent_mlitem['link_path']);?></h2>
		<?=render($title_suffix);?>
		<div class="content"<?=$content_attributes;?>>
			<?=drupal_render($menu_render);?>
		</div>
	</div>
<?php endif; ?>