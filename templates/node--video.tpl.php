<?php
	/* dynamically add css files by node type & id */
	drupal_add_css(drupal_get_path('theme',$GLOBALS['theme']).'/css/node--node.tpl.css');
	drupal_add_css(drupal_get_path('theme',$GLOBALS['theme']).'/css/node--'.preg_replace('/[_]/','-',$node->type).'.tpl.css');
	drupal_add_css(drupal_get_path('theme',$GLOBALS['theme']).'/css/node--'.$node->nid.'.tpl.css');
	/* hide some elements from the default call to render() */
	//hide($content['comments']);
	//hide($content['field_context']);
	//hide($content['field_image']);
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
<?php $secret = (user_access('Administer nodes'))? ($content['field_password']['#items']['0']['value']): (FALSE); ?>

<div id="node-<?=$node->nid;?>" class="<?=$classes;?> workflow<?=$node->workflow;?> workflow-current-sid-<?=$node->workflow;?> clearfix"<?=$attributes;?>>
	<?php if (!$page && $title): ?>
		<?=render($title_prefix);?>
		<h2<?=$title_attributes;?>><a href="<?=$node_url;?>"><?=$title;?></a></h2>
		<?=render($title_suffix);?>
	<?php endif; ?>
	<div class="content"<?=$content_attributes;?>>
		<h3 class="flatline">
			<span class="field-label" title="<?=$secret;?>">Tags:&nbsp;</span>
			<?=render($content['field_context']);?>
			<?=render($content['field_topics']);?>
			<?php $timestamp = (format_date($created, 'custom', 'His') == '000000')? (''): (' - ' . format_date($created, 'custom', 'g:ia')); ?>
			<?php $datestamp = (format_date($created, 'custom', 'md') == '1231' || format_date($created, 'custom', 'md') == '0101')? (format_date($created, 'custom', 'Y')): (format_date($created, 'custom', 'Y M jS')); ?>
			<small class="field field-name-created">(<?=$datestamp.$timestamp;?>)</small>
		</h3>
		<?=render($content['body']);?>
		<?php if ($content['field_video'] && (user_access('administer nodes') || empty($restricted_access_users) || in_array($current_user->uid, $restricted_access_users))): ?>
			<div id="mainfile">
				<?php if (preg_match('/\.zip\z/i', $content['field_video']['#items']['0']['uri']) || preg_match('/\.7z\z/i', $content['field_video']['#items']['0']['uri']) || preg_match('/\.gz\z/i', $content['field_video']['#items']['0']['uri'])): ?>
					<hr>
					<p class="alignc"><small>The following video file is contained within a zip archive. <br>To access it, you may need to install a program like <strong><a href="http://7-zip.org">7-Zip</a></strong>.</small></p>
				<?php endif; ?>
				<?=render($content['field_video']);?>
				<?php if ($content['field_password']['#items']['0']['value']): ?>
					<p class="alignc">
						<br><mark>Have you purchased this video, but lost the password?</mark>
						<br><mark>Contact <a href="/user/<?=$uid;?>"><strong><?=$name;?></strong></a> for help.</mark>
					</p>
				<?php endif; ?>
			</div>
		<?php elseif ($content['field_video']): ?>
			<p class="alignc"><mark>You don't have permission to view this <?=$node->type;?>.</mark></p>
		<?php elseif (!$content['field_video'] && $view_mode == 'full'): ?>
			<p class="alignc"><mark>This <?=$node->type;?> has not been uploaded yet.</mark></p>
		<?php endif; ?>
		<?//=render($content);?>
	</div>
</div><!-- /.node -->