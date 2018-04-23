<?php
	/**
	*** @file
	*** This template is used to print a single grouping in a view.
	***
	*** It is not actually used in default Views, as this is registered as a theme
	*** function which has better performance. For single overrides, the template is
	*** perfectly okay.
	***
	*** Variables available:
	*** - $view: The view object
	*** - $grouping: The grouping instruction.
	*** - $grouping_level: Integer indicating the hierarchical level of the grouping.
	*** - $rows: The rows contained in this grouping.
	*** - $title: The title of this grouping.
	*** - $content: The processed content output that will normally be used.
	**/
?>

<?php if ($grouping_level == 4): ?>
	<?php $header_level = 6; ?>
<?php elseif ($grouping_level == 3): ?>
	<?php $header_level = 5; ?>
<?php elseif ($grouping_level == 2): ?>
	<?php $header_level = 4; ?>
<?php elseif ($grouping_level == 1): ?>
	<?php $header_level = 3; ?>
<?php else/*if ($grouping_level == 0)*/: ?>
	<?php $header_level = 2; ?>
<?php endif; ?>

<div class="view-grouping <?=preg_replace("/[\s_]/","-",filter_xss($title,$allowed_tags=array('')));?>">
  <h<?=$header_level;?> class="view-grouping-header"><?=$title;?></h<?=$header_level;?>>
  <div class="view-grouping-content">
    <?=$content;?>
  </div>
</div>