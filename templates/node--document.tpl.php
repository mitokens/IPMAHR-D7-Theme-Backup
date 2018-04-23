<?php
	$current_user = $GLOBALS["user"];
	/* dynamically add css files by node type & id */
	drupal_add_css(drupal_get_path('theme',$GLOBALS['theme']).'/css/node--node.tpl.css');
	drupal_add_css(drupal_get_path('theme',$GLOBALS['theme']).'/css/node--'.preg_replace('/[_]/','-',$node->type).'.tpl.css');
	drupal_add_css(drupal_get_path('theme',$GLOBALS['theme']).'/css/node--'.$node->nid.'.tpl.css');
	/* hide some elements from the default call to render() */
	//hide($content['comments']);
	//hide($content['field_context']);
	//hide($content['field_topics']);
	//hide($content['links']);
	//hide($content['workflow']);
	//hide($content['workflow_current_state']);
	//hide($content['field_restricted_access_users']);
	/* define extra variables needed later */
	$restricted_access_users = array();
	if($content['field_restricted_access_users']) {
		foreach ($content['field_restricted_access_users']['#items'] as $key => $restricted_access_user) {
			$restricted_access_users[$key] = $restricted_access_user['uid'];
		}
	}
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
				<?php $timestamp = (format_date($created, 'custom', 'His') == '000000')? (''): (' - ' . format_date($created, 'custom', 'g:ia')); ?>
				<?php $datestamp = (format_date($created, 'custom', 'md') == '1231' || format_date($created, 'custom', 'md') == '0101')? (format_date($created, 'custom', 'Y')): (format_date($created, 'custom', 'Y M jS')); ?>
				<small class="field field-name-created">(<?=$datestamp.$timestamp;?>)</small>
			</h3>
		<?php endif; ?>
		<?=render($content['body']);?>
		<?php if ($content['field_document'] && (user_access('administer nodes') || empty($restricted_access_users) || in_array($current_user->uid, $restricted_access_users))): ?>
			<div id="mainfile">
				<?=render($content['field_document']);?>
			</div>
			<?php if (!empty($content['field_download_link']) && $content['field_download_link']['#items']['0']['value']): ?>
				<div class="alignc">
					<?php $file_url = str_replace('public://', 'files/', $content['field_document']['#items']['0']['uri']); ?>
					<?php $file_ext = strtoupper(substr($content['field_document']['#items']['0']['uri'], strrpos($content['field_document']['#items']['0']['uri'], '.')+1)); ?>
					<?php $file_ext = ($file_ext)? ($file_ext): ('DOCUMENT'); ?>
					<?php $file_button = l(t('DOWNLOAD THIS ' . $file_ext), $file_url, array('attributes'=>array('class'=>array('button', 'pdf-reader-download-link'), 'target'=>'_BLANK'))); ?>
					<?= $file_button; ?>
				</div>
			<?php endif; ?>
		<?php elseif ($content['field_document']): ?>
			<p class="alignc"><mark>You don't have permission to view this <?=$node->type;?>.</mark></p>
		<?php elseif (!$content['field_document'] && $view_mode == 'full'): ?>
			<p class="alignc"><mark>This <?=$node->type;?> has not been uploaded yet.</mark></p>
		<?php endif; ?>
		<?//=render($content);?>
	</div>
	
</div><!-- /.node -->