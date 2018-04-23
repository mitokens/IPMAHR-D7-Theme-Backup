<?php
	/**
	*** @file
	*** Main view template.
	*** 
	*** Variables available:
	*** - $classes_array: An array of classes determined in template_preprocess_views_view(). Default classes are:
	***     $classes_array[0] => .view
	***     $classes_array[1] => .view-[css_name]
	***     $classes_array[2] => .view-id-[view_name]
	***     $classes_array[3] => .view-display-id-[display_name]
	***     $classes_array[4] => .view-dom-id-[dom_id]
	*** - $classes: A string version of $classes_array for use in the class attribute
	*** - $css_name: A css-safe version of the view name.
	*** - $css_class: The user-specified classes names, if any
	*** - $header: The view header
	*** - $footer: The view footer
	*** - $rows: The results of the view query, if any
	*** - $empty: The empty text to display if the view is empty
	*** - $pager: The pager next/prev links to display, if any
	*** - $exposed: Exposed widget form/info to display
	*** - $feed_icon: Feed icon to display, if any
	*** - $more: A link to view more, if any
	*** 
	*** @ingroup views_templates
	**/
?>

<?php
	/* dynamically add css files by view name */
	drupal_add_css(drupal_get_path('theme',$GLOBALS['theme']).'/css/views--view.tpl.css');
	drupal_add_css(drupal_get_path('theme',$GLOBALS['theme']).'/css/views--'.strtolower($classes_array[1]).'.tpl.css');
	/* add contextual URL args to the $classes array */
	if ($view->args[0] !== NULL) {
		$classes .= ' tid-'.$view->args[0];
	}
?>
<?php $css_id = $classes_array[2] . substr($classes_array[3], 15); ?>
<?php $url_query = drupal_get_query_parameters(); ?>
<?php $content_filtered = (!empty($url_query['mindate']) || !empty($url_query['maxdate']) || !empty($url_query['title']) || !empty($url_query['context'])); ?>
<?php $term = (arg(1) == 'term')? (taxonomy_term_load(arg(2))): (NULL); ?>
<?php $hidefilters = ($term)? ($term->field_hide_filters['und'][0]['value']): (0); ?>
<?php $hidedates = ($term)? ($term->field_hide_datestamps['und'][0]['value']): (0); ?>
<?php $hidedates_class = ($hidedates)? (' hide-dates'): (''); ?>
<?php $hidesummaries = ($term)? ($term->field_hide_summary['und'][0]['value']): (0); ?>
<?php $hidesummaries_class = ($hidesummaries)? (' hide-summaries'): (''); ?>
<?php $showtype = ($term)? ($term->field_show_content['und'][0]['value']): (0); ?>
<?php $showtype_class = ($showtype)? ($showtype): ('show-all'); ?>
<?php $render_overview = ($term)? ($term->field_overview['und'][0]['value']): (0); ?>

<?php if ((count($view->result) > 0 || $empty) || user_access('Bypass views access control')): ?>

	<div class="<?=$showtype_class;?> <?=$classes;?>" id="<?=$css_id;?>" results="<?=count($view->result);?>">

		<?=render($title_prefix);?>

		<?php if ($title): ?>
			<?='~'.$title;?>
		<?php endif; ?>

		<?=render($title_suffix);?>

		<?php if ($header): ?>
			<div class="view-header" id="<?=$css_id . '-header';?>">
				<?=$header;?>
			</div>
		<?php endif; ?>

		<?php if ($render_overview): ?>
			<hr>
			<div class="term-overview">
				<?php $menuitem = menu_link_get_preferred(); ?>
				<?php $teaser_exceptions = array($menuitem['href'], $menuitem['href'].'/mid/*'); ?>
				<?php $teaser_list = ofw_ipmahr_overview_teaser_list($menuitem, $teaser_exceptions); ?>
				<?= ofw_ipmahr_render_all($teaser_list); ?>
			</div>
			<hr>
		<?php endif; ?>
		
		<?php if ($showtype_class != 'show-all'): ?>
			<?php if (user_has_role(4) || user_has_role(6) || user_has_role(25)): ?>
				<input class="show-all" id="<?=$css_id;?>-show-all" type="checkbox"> <label class="show-label" for="<?=$css_id;?>-show-all"><b>Hidden Content</b></label>
			<?php else: ?>
				<input class="show-all" id="<?=$css_id;?>-show-all" type="checkbox">
			<?php endif; ?>
		<?php endif; ?>

		<?php if ($exposed && !(!$content_filtered && !$rows) && !$hidefilters): ?>
			<div class="view-filters" id="<?=$css_id . '-filters';?>">
				<?= $exposed; ?>
			</div>
		<?php endif; ?>

		<?php if ($attachment_before): ?>
			<div class="attachment attachment-before" id="<?=$css_id . '-attachment_before';?>">
				<?=$attachment_before;?>
			</div>
		<?php endif; ?>

		<?php if ($rows): ?>
			<div class="view-content<?=$hidedates_class;?><?=$hidesummaries_class;?>" id="<?=$css_id . '-content';?>">
				<?=$rows;?>
			</div>
		<?php elseif ($empty): ?>
			<div class="view-empty" id="<?=$css_id . '-content';?>">
				<?=$empty;?>
			</div>
		<?php endif; ?>

		<?php if ($exposed && !(!$content_filtered && !$rows)): ?>
			<?php if (!$hidefilters): ?>
				<div class="view-filters" id="<?=$css_id . '-filters2';?>">
					<?=$exposed;?>
				</div>
			<?php endif; ?>
		<?php endif; ?>

		<?php if ($pager): ?>
			<div class="view-pager" id="<?=$css_id . '-pager';?>">
				<?=$pager;?>
			</div>
		<?php endif; ?>

		<?php if ($attachment_after): ?>
			<div class="attachment attachment-after" id="<?=$css_id . '-attachment_after';?>">
				<?=$attachment_after;?>
			</div>
		<?php endif; ?>

		<?php if ($more): ?>
			<?=$more;?>
		<?php endif; ?>

		<?php if ($footer): ?>
			<div class="view-footer" id="<?=$css_id . '-footer';?>">
				<?=$footer;?>
			</div>
		<?php endif; ?>

		<?php if ($feed_icon): ?>
			<div class="feed-icon" id="<?=$css_id . '-icon';?>">
				<?=$feed_icon;?>
			</div>
		<?php endif; ?>

	</div>

<?php endif; ?>