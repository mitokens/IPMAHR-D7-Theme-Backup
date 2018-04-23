<?php
	/**
	*** @file
	*** Default simple view template to display a list of rows.--taxonomy-term
	***
	*** @ingroup views_templates
	***/
?>

<?php if (!empty($title)): ?>
	<?php $header_level = $grouping_level + 2; ?>
	<?php if ($header_level > 6): ?>
		<?php $header_level = 6; ?>
	<?php elseif ($header_level < 1): ?>
		<?php $header_level = 1; ?>
	<?php endif; ?>
	<?php $title_text = str_replace(' ', '-', trim(drupal_html_to_text($title, array()))); ?>
	<details class="views-group views-group-level-<?= $grouping_level; ?> <?= $title_text; ?>" open>
	<summary class="<?= $title_text; ?>"><h<?= $header_level; ?>><?= $title; ?></h<?= $header_level; ?>></summary>
<?php endif; ?>

<?php foreach ($rows as $id => $row): ?>
	<?php $classes_string = ($classes_array[$id])? (' class="' . $classes_array[$id] . '"'): (''); ?>
	<?php $id_string = ' id="' . $view->name . '-' . $view->args[0] . '-node-' . $view->result[$id]->nid . '"'; ?>
	<div<?= $classes_string ?><?= $id_string ?>>
		<?= $row; ?>
	</div>
<?php endforeach; ?>

<?php if (!empty($title)): ?>
	</details>
<?php endif; ?>
