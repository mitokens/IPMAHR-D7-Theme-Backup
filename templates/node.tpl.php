<?php
/**
 * @file
 * Zen theme's implementation to display a node.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 *
 * - $content: An array of node items. Use render($content) to print them all,
 *   or print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 *
 * - $user_picture: The node author's picture from user-picture.tpl.php.
 *
 * - $date: Formatted creation date. Preprocess functions can reformat it by
 *   calling format_date() with the desired parameters on the $created variable.
 *
 * - $name: Themed username of node author output from theme_username().
 *
 * - $node_url: Direct url of the current node.
 *
 * - $display_submitted: Whether submission information should be displayed.
 *
 * - $submitted: Submission information created from $name and $date during
 *   template_preprocess_node().
 *
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - node: The current template type, i.e., "theming hook".
 *   - node-[type]: The current node type. For example, if the node is a
 *     "Blog entry" it would result in "node-blog". Note that the machine
 *     name will often be in a short form of the human readable label.
 *   - node-teaser: Nodes in teaser form.
 *   - node-preview: Nodes in preview mode.
 *   - view-mode-[mode]: The view mode, e.g. 'full', 'teaser'...
 *   The following are controlled through the node publishing options.
 *   - node-promoted: Nodes promoted to the front page.
 *   - node-sticky: Nodes ordered above other non-sticky nodes in teaser
 *     listings.
 *   - node-unpublished: Unpublished nodes visible only to administrators.
 *   The following applies only to viewers who are registered users:
 *   - node-by-viewer: Node is authored by the user currently viewing the page.
 *
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 *
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 *
 * - $type: Node type, i.e. story, page, blog, etc.
 *
 * - $comment_count: Number of comments attached to the node.
 *
 * - $uid: User ID of the node author.
 *
 * - $created: Time the node was published formatted in Unix timestamp.
 *
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 *
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 *
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $view_mode: View mode, e.g. 'full', 'teaser'...
 * - $teaser: Flag for the teaser state (shortcut for $view_mode == 'teaser').
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content. Currently broken; see http://drupal.org/node/823380
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * Field variables: for each field instance attached to the node a corresponding
 * variable is defined, e.g. $node->body becomes $body. When needing to access
 * a field's raw values, developers/themers are strongly encouraged to use these
 * variables. Otherwise they will have to explicitly specify the desired field
 * language, e.g. $node->body['en'], thus overriding any language negotiation
 * rule that was previously applied.
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 * @see zen_preprocess_node()
 * @see template_process()
 */
?>

<?php /* dynamically add css files by node type & id */
	drupal_add_css(drupal_get_path('theme',$GLOBALS['theme']).'/css/node.tpl.css');
	drupal_add_css(drupal_get_path('theme',$GLOBALS['theme']).'/css/node--'.preg_replace('/[_]/','-',$node->type).'.tpl.css');
	drupal_add_css(drupal_get_path('theme',$GLOBALS['theme']).'/css/node--'.$node->nid.'.tpl.css');
?>

<?php /* dynamically add js files by node type, if appropriate */
	if ($node->type == 'job') {
		drupal_add_js(drupal_get_path('theme',$GLOBALS['theme']).'/js/node--'.preg_replace('/[_]/','-',$node->type).'.tpl.js');
	}
?>

<?php /* hide fields that shouldn't be displayed */
	hide($content['comments']);
	hide($content['field_overview']);
	hide($content['field_underview']);
?>

<?php /* define calculated fields that affect node rendering */
	if ($overview['type'] == 'sidebar' || $underview['type'] == 'sidebar') {
		$classes .= ' dent8';
	}
?>

<?php if (!($node->nid == 30590 && empty($content['body']['#items']['0']['value']))): ?>

	<?php if ($view_mode == 'full' && !empty($overview)): ?>
		<<?=$overview['tag'];?> class="node-overview node-<?=$node->type;?>-overview <?=$overview['classes'];?>">
			<?= ofw_ipmahr_render_all($teaser_list); ?>
		</<?=$overview['tag'];?>>
	<?php endif; ?>

	<div id="node-<?=$node->nid;?>" class="<?=$classes;?> workflow<?=$node->workflow;?> workflow-current-sid-<?=$node->workflow;?> clearfix"<?=$attributes;?>>
		<?php if ($title && !$page): ?>
			<h2<?=$title_attributes;?>><a href="<?=$node_url;?>"><?=$title;?></a></h2>
		<?php endif; ?>
		<?php if ($display_submitted && (user_access('administer nodes') || node_access('update',$node->nid))): ?>
			<div class="alignc submitted"><?=$submitted;?></div>
		<?php endif; ?>
		<div class="content"<?=$content_attributes;?>><?=render($content);?></div>
	</div><!-- /.node -->

	<?php if ($view_mode == 'full' && !empty($underview)): ?>
		<<?=$underview['tag'];?> class="node-underview node-<?=$node->type;?>-underview <?=$underview['classes'];?>">
			<?= ofw_ipmahr_render_all($teaser_list); ?>
		</<?=$underview['tag'];?>>
	<?php endif; ?>

<?php endif; ?>