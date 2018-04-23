<?php

/**
 * @file
 * Main view template.
 *
 * Variables available:
 * - $classes_array: An array of classes determined in template_preprocess_views_view(). Default classes are:
 *     $classes_array[0] => .view
 *     $classes_array[1] => .view-[css_name]
 *     $classes_array[2] => .view-id-[view_name]
 *     $classes_array[3] => .view-display-id-[display_name]
 *     $classes_array[4] => .view-dom-id-[dom_id]
 * - $classes: A string version of $classes_array for use in the class attribute
 * - $css_name: A css-safe version of the view name.
 * - $css_class: The user-specified classes names, if any
 * - $header: The view header
 * - $footer: The view footer
 * - $rows: The results of the view query, if any
 * - $empty: The empty text to display if the view is empty
 * - $pager: The pager next/prev links to display, if any
 * - $exposed: Exposed widget form/info to display
 * - $feed_icon: Feed icon to display, if any
 * - $more: A link to view more, if any
 *
 * @ingroup views_templates
 */
?>

<?php
	/* dynamically add css files by view name */
	drupal_add_css(drupal_get_path('theme',$GLOBALS['theme']).'/css/views--view.tpl.css');
	drupal_add_css(drupal_get_path('theme',$GLOBALS['theme']).'/css/views--'.strtolower($classes_array[1]).'.tpl.css');
	/* add contextual URL args to the $classes array */
	if ($view->args[0] !== NULL) {
		$classes .= ' tid-'.$view->args[0];
	}
	/**/
	$css_id = $classes_array[2] . substr($classes_array[3], 15);
?>

<div class="<?=$classes;?>" id="<?=$css_id;?>">
	
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

  <?php if ($exposed): ?>
		<div class="view-filters" id="<?=$css_id . '-filters';?>">
			<?=$exposed;?>
		</div>
  <?php endif; ?>

  <?php if ($attachment_before): ?>
    <div class="attachment attachment-before" id="<?=$css_id . '-attachment_before';?>">
      <?=$attachment_before;?>
    </div>
  <?php endif; ?>

  <?php if ($rows): ?>
    <div class="view-content" id="<?=$css_id . '-content';?>">
      <?=$rows;?>
    </div>
  <?php elseif ($empty): ?>
    <div class="view-empty" id="<?=$css_id . '-content';?>">
      <?=$empty;?>
    </div>
  <?php endif; ?>

  <?php if ($pager): ?>
    <?=$pager;?>
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

</div><?php/* class view */?>
