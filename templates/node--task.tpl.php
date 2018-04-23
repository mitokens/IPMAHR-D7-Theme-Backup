
<?php
	/* dynamically add css files by node type & id */
	drupal_add_css(drupal_get_path('theme',$GLOBALS['theme']).'/css/node--node.tpl.css');
	drupal_add_css(drupal_get_path('theme',$GLOBALS['theme']).'/css/node--'.preg_replace('/[_]/','-',$node->type).'.tpl.css');
	drupal_add_css(drupal_get_path('theme',$GLOBALS['theme']).'/css/node--'.$node->nid.'.tpl.css');
	/* dynamically add js files by node type, if appropriate */
	if ($node->type == 'job') {
		drupal_add_js(drupal_get_path('theme',$GLOBALS['theme']).'/js/node--'.preg_replace('/[_]/','-',$node->type).'.tpl.js');
	}
	/* hide fields that shouldn't be displayed */
	//hide($content['links']);
	//hide($content['workflow']);
	//hide($content['workflow_current_state']);
?>

<div id="node-<?=$node->nid;?>" class="<?=$classes;?> workflow<?=$node->workflow;?> workflow-current-sid-<?=$node->workflow;?> clearfix"<?=$attributes;?>>
	
	<?php if ($title && !$page /*&& (user_access('administer nodes') || node_access('update',$node->nid))*/): ?>
		<h2<?=$title_attributes;?>><a href="<?=$node_url;?>"><?=$title;?></a></h2>
	<?php endif; ?>
	
	<?php if ($display_submitted && (user_access('administer nodes') || node_access('update',$node->nid))): ?>
		<div class="alignc submitted"><?//=$submitted;?></div>
	<?php endif; ?>
	
	<div class="content"<?=$content_attributes;?>>
		<?php if($content['body']): ?>
			<aside class="dent12">
				<h4>Description</h4>
				<?=render($content['body']);?>
			</aside>
		<?php endif; ?>
		<div class="alignc">
			<?php if(TRUE): ?>
				<aside class="dent6">
					<h4>Status</h4>
					<?=render($content['field_task_category']);?>
					<div class="field field-name-created field-type-datetime field-label-inline clearfix">
						<div class="field-label">Created:</div>
						<div class="field-items">
							<div class="field-item even">
								<?=format_date($created, 'custom', 'Y-M-d H:i');?>
							</div>
						</div>
					</div>
					<div class="field field-name-changed field-type-datetime field-label-inline clearfix">
						<div class="field-label">Updated:</div>
						<div class="field-items">
							<div class="field-item even">
								<?=format_date($changed, 'custom', 'Y-M-d H:i');?>
							</div>
						</div>
					</div>
					<?=render($content['field_end_date']);?>
					<?=render($content['field_progress']);?>
				</aside>
			<?php endif; ?>
			<?php if(TRUE): ?>
				<aside class="dent6">
					<h4>Relations</h4>
					<?=render($content['field_parent']);?>
					<div class="field field-name-author field-type-datetime field-label-inline clearfix">
						<div class="field-label">Author:</div>
						<div class="field-items">
							<div class="field-item even">
								<?php $author = user_load($uid); ?>
								<?php $author_name = ($author->field_name[und][0][safe_value])? ($author->field_name[und][0][safe_value]): ($author->name); ?>
								<a href="/user/<?=$author->mail;?>"><?=($author_name)?($author_name):('Anonymous');?></a>
							</div>
						</div>
					</div>
					<?=render($content['field_delegates']);?>
				</aside>
			<?php endif; ?>
			<?php if ($content['field_document']): ?>
				<aside class="dent8">
					<h4>Supporting Documents</h4>
					<?=render($content['field_document']);?>
				</aside>
			<?php endif; ?>
		</div>
		<hr/>
		<?=render($content['comments']);?>
	</div>
	
</div><!-- /.node -->
