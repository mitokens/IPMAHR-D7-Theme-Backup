<?php
	/* dynamically add css files by node type & id */
	drupal_add_css(drupal_get_path('theme',$GLOBALS['theme']).'/css/node--node.tpl.css');
	drupal_add_css(drupal_get_path('theme',$GLOBALS['theme']).'/css/node--'.preg_replace('/[_]/','-',$node->type).'.tpl.css');
	drupal_add_css(drupal_get_path('theme',$GLOBALS['theme']).'/css/node--'.$node->nid.'.tpl.css');
	/* hide some elements from the default call to render() */
	//hide($content['comments']);
	hide($content['field_banner_image']);
	//hide($content['field_context']);
	hide($content['field_external_redirect'])
	//hide($content['field_source_link']);
	//hide($content['links']);
	//hide($content['workflow']);
	//hide($content['workflow_current_state']);
?>

<div id="node-<?=$node->nid;?>" class="<?=$classes;?> workflow<?=$node->workflow;?> workflow-current-sid-<?=$node->workflow;?> clearfix"<?=$attributes;?>>
	
	<?php if ($content['field_source_link'] && $content['field_external_redirect'] && $content['field_external_redirect']['#items']['0']['value']): ?>
		<?php $account = user_load($GLOBALS['user']->uid); ?>
		<?php $ssotoken = $account->field_sso_token['und']['0']['value']; ?>
		<?php $link_query = ($content['field_source_link']['#items']['0']['query'])? ($content['field_source_link']['#items']['0']['query']): (array()); ?>
		<?php $link_query = ($ssotoken)? ($link_query + array('TOKEN' => $ssotoken)): ($link_query); ?>
		<?php $link_options = array('query'=>$link_query, 'fragment'=>$content['field_source_link']['#items']['0']['fragment']); ?>
		<?php //drupal_set_message('<pre>' . print_r($content['field_source_link']['#items'], TRUE) . '</pre>'); ?>
		<?php if (!node_access('update', $node)): ?>
			<?php drupal_goto($content['field_source_link']['#items']['0']['url'], $link_options); ?>
		<?php else: ?>
			<?php $redirect_notify = TRUE; ?>
		<?php endif; ?>
	<?php endif; ?>
	
	<?php if (!$page && $title): ?>
		<?=render($title_prefix);?>
		<h2<?=$title_attributes;?>><a href="<?=$node_url;?>"><?=$title;?></a></h2>
		<?=render($title_suffix);?>
	<?php endif; ?>
	
	<div class="content"<?=$content_attributes;?>>
		<h3 class="flatline">
			<span class="field-label">Tags:&nbsp;</span>
			<?=render($content['field_context']);?>
			<?=render($content['field_topics']);?>
			<?php $timestamp = (format_date($created, 'custom', 'His') == '000000')? (''): (' - ' . format_date($created, 'custom', 'g:ia')); ?>
			<?php $datestamp = (format_date($created, 'custom', 'md') == '1231' || format_date($created, 'custom', 'md') == '0101')? (format_date($created, 'custom', 'Y')): (format_date($created, 'custom', 'Y M jS')); ?>
			<small class="field field-name-created">(<?=$datestamp.$timestamp;?>)</small>
		</h3>
		
		<?=render($content);?>
		
		<?php if ($redirect_notify): ?>
			<blockquote>
				<h2>External Redirect</h2>
				<p>
					You're seeing this because you have permission to edit this article. Otherwise, you would be automatically redirected to:
					<br/><?=l($content['field_source_link']['#items']['0']['display_url'], $content['field_source_link']['#items']['0']['url'], $link_options);?>
				</p>
				<p><i>To disable the redirect, uncheck the "External Redirect" box on this article's edit screen.</i></p>
			</blockquote>
		<?php endif; ?>
		
	</div>
	
</div><!-- /.node -->