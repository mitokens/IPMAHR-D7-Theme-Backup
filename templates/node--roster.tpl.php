
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
	//hide($content['comments']);
	//hide($content['links']);
	//hide($content['workflow']);
	//hide($content['workflow_current_state']);
	hide($content['field_president']);
?>

<div id="node-<?=$node->nid;?>" class="<?=$classes;?> clearfix"<?=$attributes;?>>
	
	<?php if ($title && !$page /*&& (user_access('administer nodes') || node_access('update',$node->nid))*/): ?>
		<h2<?=$title_attributes;?>><a href="<?=$node_url;?>"><?=$title;?></a></h2>
	<?php endif; ?>
	
	<?php if ($display_submitted && $content['field_president']['#items']): ?>
		<br class="alignb clearfix">
	<?php endif; ?>
	
	<?php if ($display_submitted): ?>
		<?php $author = user_load($uid); ?>
		<?php $author_name = ($author->field_name[und][0][value])? ($author->field_name[und][0][value]): ($name); ?>
		<?php $author_email = $author->mail; ?>
		<?php $author_phone = $author->field_phone[und][0][value]; ?>
		<aside class="alignc alignl dent6">
			<h3>Primary Contact</h3>
			<p>
				<?php if ($author_name): ?>
					<strong><a href="/user/<?=$author_email;?>"><?=$author_name;?></a></strong>
				<?php endif; ?>
				<?php if ($author_phone): ?>
					<br/><a href="tel:<?=$author_phone;?>"><?=$author_phone;?></a>
				<?php endif; ?>
				<?php if ($author_email): ?>
					<br/><a href="mailto:<?=$author_email;?>"><?=$author_email;?></a>
				<?php endif; ?>
			</p>
		</aside>
	<?php endif; ?>
	
	<?php if ($content['field_president']['#items']): ?>
		<?php $prez_object = $content['field_president']['#items']['0']['user']; ?>
		<aside class="alignc alignr dent6">
			<h3><?= $content['field_president']['#title']; ?></h3>
			<p>
				<?php if ($prez_object->realname): ?>
					<strong><a href="/user/<?= $prez_object->uid; ?>"><?= $prez_object->realname; ?></a></strong>
				<?php endif; ?>
				<?php if ($prez_object->field_phone): ?>
					<br/><a href="tel:<?= $prez_object->field_phone[und][0][value]; ?>"><?= $prez_object->field_phone[und][0][value]; ?></a>
				<?php endif; ?>
				<?php if ($prez_object->mail): ?>
					<br/><a href="mailto:<?= $prez_object->mail; ?>"><?= $prez_object->mail; ?></a>
				<?php endif; ?>
			</p>
		</aside>
	<?php endif; ?>
	
	<div class="content"<?=$content_attributes;?>>
		<?=render($content['field_website']);?>
		<?=render($content['field_description']);?>
		<div class="more-content">
			<?=render($content);?>
		</div>
	</div>
	
</div><!-- /.node -->
