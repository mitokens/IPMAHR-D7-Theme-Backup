<?php
	/* dynamically add css files by node type & id */
	drupal_add_css(drupal_get_path('theme',$GLOBALS['theme']).'/css/node--node.tpl.css');
	drupal_add_css(drupal_get_path('theme',$GLOBALS['theme']).'/css/node--'.preg_replace('/[_]/','-',$node->type).'.tpl.css');
	drupal_add_css(drupal_get_path('theme',$GLOBALS['theme']).'/css/node--'.$node->nid.'.tpl.css');
	/* hide some elements from the default call to render() */
	//hide($content['comments']);
	//hide($content['field_banner_image']);
	//hide($content['field_context']);
	//hide($content['links']);
	//hide($content['workflow']);
	//hide($content['workflow_current_state']);
?>

<div id="node-<?=$node->nid;?>" class="<?=$classes;?> workflow<?=$node->workflow;?> workflow-current-sid-<?=$node->workflow;?> clearfix"<?=$attributes;?>>
	
	<?php if (!$page && $title): ?>
		<?=render($title_prefix);?>
		<h2<?=$title_attributes;?>><a href="<?=$node_url;?>"><?=$title;?></a></h2>
		<?=render($title_suffix);?>
	<?php endif; ?>
	
	<div class="content"<?=$content_attributes;?>>
		<?php if ($view_mode == 'full'): ?>
			<h3 class="flatline">
				<span class="field-label">Tags:&nbsp;</span>
				<?=render($content['field_context']);?>
				<?=render($content['field_topics']);?>
				<?php if (FALSE && (user_access('administer nodes') || node_access('update',$node->nid))): ?>
					<?php $timestamp = (format_date($created, 'custom', 'His') == '000000')? (''): (' - ' . format_date($created, 'custom', 'g:ia')); ?>
					<?php $datestamp = (format_date($created, 'custom', 'md') == '1231' || format_date($created, 'custom', 'md') == '0101')? (format_date($created, 'custom', 'Y')): (format_date($created, 'custom', 'Y M jS')); ?>
					<small class="field field-name-created">(<?=$datestamp.$timestamp;?>)</small>
				<?php endif; ?>
			</h3>
		<?php endif; ?>
		<?=render($content);?>
	</div>
	
</div><!-- /.node -->