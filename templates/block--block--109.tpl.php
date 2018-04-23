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
	$current_node = menu_get_item();
	$field_sidebar = $current_node['page_arguments']['0']->field_ad_image;
	$image_node = node_load($field_sidebar['und']['0']['nid']);
	$image_file = str_replace('public://', '/files/', $image_node->field_image['und']['0']['uri']);
	$image_url = $image_node->field_url['und']['0']['url'];
	$content_classes = "content node node-$image_node->nid node-$image_node->type-$image_node->nid workflow$image_node->workflow";
?>

<?php if ($field_sidebar && $image_node): ?>
	<div id="<?=$block_html_id;?>" class="alignc bare <?=$classes;?>"<?=$attributes;?>>
		<?=render($title_prefix);?>
		<?php if ($block->subject): ?>
			<h2<?=$title_attributes;?>><?=$block->subject?></h2>
		<?php endif;?>
		<?=render($title_suffix);?>
		<div class="<?=$content_classes;?>"<?=$content_attributes;?>>
			<a href="<?=$image_url;?>" title="<?=$image_node->title;?>" target="_blank">
				<img src="<?=$image_file;?>" alt="<?=$image_node->title;?>" />
			</a>
		</div>
		<?php if (node_access('update', $image_node)): ?>
			<b><a href="/node/<?=$image_node->nid;?>" title="you have edit access">edit this image</a></b>
		<?php endif; ?>
	</div>
<?php endif; ?>
