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
	function policy_term_sort($a, $b) {
		return $a->name > $b->name;
	}
?>

<?php
	function policy_term_link($term, $nodecount=0) {
		$term->nodecount = ($term->nodecount)? ($term->nodecount): ($nodecount);
		$output = '';
		//if ($term->nodecount > 0 || user_access('Edit terms in Topics')) {
			$output .= '<li class="taxonomy-term-' . $term->tid . ' content-count-' . $term->nodecount . '">';
			$output .= '<a href="' . url('taxonomy/term/'.$term->tid) . '">';
			$output .= $term->name;
			$output .= ' <small>[' . $term->nodecount . ']</small>';
			$output .= '</a>';
		//}
		return $output;
	}
?>

<?php $content_output = ''; ?>
<?php $policy_parents = taxonomy_get_parents_all(arg(2)); ?>
<?php $policy_parent_ids = array(); ?>
<?php foreach ($policy_parents as $index => $term): ?>
	<?php array_push($policy_parent_ids, $term->tid); ?>
<?php endforeach; ?>
<?php $vid = taxonomy_vocabulary_machine_name_load('topic')->vid; ?>
<?php $policy_tree = taxonomy_get_tree($vid, 587, 1); ?>
<?php uasort($policy_tree, "policy_term_sort"); ?>
<?php foreach ($policy_tree as $index => $term): ?>
	<?php $term->nodecount = count(taxonomy_select_nodes($term->tid, FALSE)); ?>
	<?php $content_output .= policy_term_link($term); ?>
	<?php if (in_array($term->tid, $policy_parent_ids)): ?>
		<?php $policy_subtree = taxonomy_get_tree($vid, $term->tid, 1); ?>
		<?php uasort($policy_subtree, "policy_term_sort"); ?>
		<?php $content_output .= '<ul>'; ?>
		<?php foreach ($policy_subtree as $subindex => $subterm): ?>
			<?php $subterm->nodecount = count(taxonomy_select_nodes($subterm->tid, FALSE)); ?>
			<?php $content_output .= policy_term_link($subterm) . '</li>'; ?>
		<?php endforeach; ?>
		<?php $content_output .= '</ul>'; ?>
	<?php endif; ?>
	<?php $content_output .= '</li>'; ?>
<?php endforeach; ?>

<?php if ($content_output): ?>
	<div id="<?= $block_html_id; ?>" class="clearfix <?= $classes; ?>"<?= $attributes; ?>>
		<?= render($title_prefix); ?>
		<?php if ($block->subject): ?>
			<h2<?= $title_attributes; ?>>
				<a href="<?=url('taxonomy/term/448');?>"><?=$block->subject;?></a>
			</h2>
		<?php endif;?>
		<?= render($title_suffix); ?>
		<?= ofw_ipmahr_login_prompt(); ?>
		<ul class="content taxonomy-index-587 taxonomy-index-448"<?=$content_attributes;?>>
			<?= $content_output; ?>
		</ul>
		<hr/>
		<?php if (!user_is_logged_in()): ?>
			<p class="alignc login-prompt"><mark><a class="small button" href="/user?destination=resources/policies">Log in</a> to view more.</mark></p>
		<?php endif; ?>
		<?php if (user_has_role(4) || user_has_role(6) || user_has_role(25)): ?>
			&emsp;<b><a href="/admin/structure/taxonomy/topic">&#x2699; Edit The Taxonomy</a></b>
			<!----pre><?//=print_r($policy_tree,TRUE);?></pre!---->
		<?php endif; ?>
	</div>
<?php endif; ?>
