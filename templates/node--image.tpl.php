
<?php $context_tids = array(); ?>
<?php foreach($content['field_context']['#items'] as $context): ?>
	<?php $context_tids[$context['taxonomy_term']->name] = $context['tid']; ?>
<?php endforeach; ?>

<?php if (!node_access('update', $node) && in_array('466', $context_tids) && $content['field_url']['#items']['0']['display_url']): ?>
	
	<!-- Redirect the user because this is an advertisement, and the user doesn't have access to edit the current node. !-->
	<h3>You are being redirected to:</h3>
	<p><a hreaf="<?=$content['field_url']['#items']['0']['display_url'];?>"><?=$content['field_url']['#items']['0']['display_url'];?></a></p>
	<meta http-equiv="refresh" content="2; URL='<?=$content['field_url']['#items']['0']['display_url'];?>'" />
	<!-- Else render this node as normal via the code below !-->
	
<?php else: ?>

	<?php
		/* dynamically add css files by node type & id */
		drupal_add_css(drupal_get_path('theme',$GLOBALS['theme']).'/css/node--node.tpl.css');
		drupal_add_css(drupal_get_path('theme',$GLOBALS['theme']).'/css/node--'.preg_replace('/[_]/','-',$node->type).'.tpl.css');
		drupal_add_css(drupal_get_path('theme',$GLOBALS['theme']).'/css/node--'.$node->nid.'.tpl.css');
		/* hide some elements from the default call to render() */
		//hide($content['comments']);
		//hide($content['field_image']);
		hide($content['field_url']);
		hide($content['field_paypal_id']);
		//hide($content['links']);
		//hide($content['workflow']);
		//hide($content['workflow_current_state']);
	?>

	<div id="node-<?=$node->nid;?>" class="<?=$classes;?> workflow<?=$node->workflow;?> workflow-current-sid-<?=$node->workflow;?> clearfix"<?=$attributes;?>>
		<?php if ($title && !$page): ?>
			<!--h2<?=$title_attributes;?>><a href="<?=$node_url;?>"><?=$title;?></a></h2-->
		<?php endif; ?>
		<?php if ($page): ?>
			<h3 class="flatline">
				<span class="field-label">Tags:&nbsp;</span>
				<?=render($content['field_context']);?>
				<?=render($content['field_topics']);?>
				<?php $timestamp = (format_date($created, 'custom', 'His') == '000000')? (''): (' - ' . format_date($created, 'custom', 'g:ia')); ?>
				<?php $datestamp = (format_date($created, 'custom', 'md') == '1231' || format_date($created, 'custom', 'md') == '0101')? (format_date($created, 'custom', 'Y')): (format_date($created, 'custom', 'Y M jS')); ?>
				<small class="field field-name-created">(<?=$datestamp.$timestamp;?>)</small>
			</h3>
		<?php endif; ?>
		<?=render($content['body']);?>
		<div class="alignc content">
			<?php if ($content['field_image']): ?>
				<a id="mainfile" class="dent8" href="<?=$content['field_url']['#items']['0']['display_url'];?>" title="<?=$content['field_url']['0']['#element']['display_url'];?>">
					<?=render($content['field_image']);?>
				</a>
			<?php else: ?>
				<mark>This <?=$node->type;?> has not been uploaded yet.</mark>
			<?php endif; ?>
		</div>
		<?=render($content);?>
	</div>
	
<?php endif; ?><!-- /.node !-->
