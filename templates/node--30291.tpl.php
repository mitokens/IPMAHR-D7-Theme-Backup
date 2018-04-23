
<br class="alignb">

<blockquote>
	<h3>Warning:</h3>
	<p>This node is horribly insecure, and should never ever be made publicly accessible.</p>
</blockquote>

<br class="alignb">

<p class="alignc alignl dent6">
	<b><a href="?mode=usernames">List bad usernames</a></b>
	<br><b><a href="?mode=usernames&rename">Rename bad usernames</a></b>
	<br><b><a href="?mode=usernames&delete">Delete bad usernames<br><small><i>(Only the ones that don't own any content!)</i></small></a></b>
	
</p>

<p class="alignc alignr dent6">
	<b><a href="?mode=emails">List bad emails</a></b>
	<br><b><a href="?mode=emails&rename">Rename bad emails</a></b>
	<br><b><a href="?mode=emails&delete">Delete bad emails<br><small><i>(Only the ones that don't own any content!)</i></small></a></b>
</p>

<br class="alignb">
<br class="alignb">

<?php $query = drupal_get_query_parameters(); ?>
<?php $query_mode = (isset($query['mode']))? ($query['mode']): (FALSE); ?>
<?php $query_rename = (isset($query['rename']))? (TRUE): (FALSE); ?>
<?php $query_delete = (isset($query['delete']))? (TRUE): (FALSE); ?>

<?php if ($query_mode): ?>
	
	<?php $userz = entity_load('user'); ?>
	<?php unset($userz[0]); ?>
	<?php unset($userz[1]); ?>
	<?php $user_numbers = array(); ?>
	<?php $user_emails = array(); ?>
	
	<?php if ($query_mode == 'usernames'): ?>
		<table class="alignc red" border="1">
			<tr>
				<th>Content</th>
				<th>Drupal ID</th>
				<th>Protech ID</th>
				<th>Username<br><i>&amp; Email</i></th>
				<th>Created<br><i>&amp; Last Used</i></th>
			</tr>
			<?php $usercount = 0; ?>
			<?php foreach ($userz as $user_id => $user_object): ?>
				<?php if (!preg_match('/^\d+$/', $user_object->name) && $user_object->name != 'ipmadnnadmin'): ?>
					<?php $user_number = (empty($user_object->field_member_id))? (FALSE): ($user_object->field_member_id['und'][0]['value']); ?>
					<?php $user_content = ofw_ipmahr_get_user_content($user_id, 'all total'); ?>
					<?php $user_created = format_date($user_object->created, 'custom', 'Y.m.d H:i'); ?>
					<?php $user_accessed = ($user_object->access)? (format_date($user_object->access, 'custom', 'Y.m.d H:i')): (''); ?>
					<tr>
						<td>(<a href="?mode=<?= $user_id ;?>"><?= $user_content; ?></a>)</td>
						<td>[<a href="/user/<?= $user_id; ?>" target="_blank"><?= $user_id; ?></a>]</td>
						<td>{<?php if ($user_number): ?><a href="/user/id/<?= $user_number; ?>" target="_blank"><?= $user_number; ?></a><?php endif; ?>}</td>
						<td><?= $user_object->name; ?><br><i><?= $user_object->mail; ?></i></td>
						<td><?= $user_created; ?><br><i><?= $user_accessed; ?></i></td>
					</tr>
					<?php $usercount += 1; ?>
					<?php if ($query_rename): ?>
						<?php if (preg_match('/^\d+$/', trim($user_object->name))): ?>
							<?php $user_object->name = trim($user_object->name); ?>
							<?php user_save((object) array('uid' => $user_id), (array) $user_object); ?>
						<?php elseif (preg_match('/^\d+$/', $user_number)): ?>
							<?php $user_object->name = $user_number; ?>
							<?php user_save((object) array('uid' => $user_id), (array) $user_object); ?>
						<?php elseif ($user_object->name != $user_object->mail): ?>
							<?php $user_object->name = $user_object->mail; ?>
							<?php user_save((object) array('uid' => $user_id), (array) $user_object); ?>
						<?php endif; ?>
					<?php endif; ?>
					<?php if ($query_delete && !$user_content && !preg_match('/^\d+$/', $user_object->name) && $user_object->name != 'ipmadnnadmin'): ?>
						<?php user_delete($user_id); ?>
					<?php endif; ?>
				<?php endif; ?>
			<?php endforeach; ?>
			<caption><?= $usercount; ?> bad usernames</caption>
		</table>
	
	<?php elseif ($query_mode == 'emails'): ?>
		<table class="alignc red" border="1">
			<tr>
				<th>Content Owned</th>
				<th>Drupal ID</th>
				<th>Protech ID</th>
				<th><i>Username</i><br>&amp; Email</th>
				<th>Created<br><i>&amp; Last Used</i></th>
			</tr>
			<?php $usercount = 0; ?>
			<?php foreach ($userz as $user_id => $user_object): ?>
				<?php $badstring = '@noemail.com'; ?>
				<?php if (!$user_object->mail || strpos($user_object->mail, $badstring) !== FALSE): ?>
					<?php $user_number = (empty($user_object->field_member_id))? (FALSE): ($user_object->field_member_id['und'][0]['value']); ?>
					<?php $user_content = ofw_ipmahr_get_user_content($user_id, 'all total'); ?>
					<?php $user_created = format_date($user_object->created, 'custom', 'Y.m.d H:i'); ?>
					<?php $user_accessed = ($user_object->access)? (format_date($user_object->access, 'custom', 'Y.m.d H:i')): ('Never'); ?>
					<tr>
						<td>(<a href="?mode=<?= $user_id ;?>"><?= $user_content; ?></a>)</td>
						<td>[<a href="/user/<?= $user_id; ?>" target="_blank"><?= $user_id; ?></a>]</td>
						<td>{<?php if ($user_number): ?><a href="/user/id/<?= $user_number; ?>" target="_blank"><?= $user_number; ?></a><?php endif; ?>}</td>
						<td><i><?= $user_object->name; ?></i><br><?= $user_object->mail; ?></td>
						<td><?= $user_created; ?><br><i><?= $user_accessed; ?></i></td>
					</tr>
					<?php $usercount += 1; ?>
					<?php if ($query_rename): ?>
						<?php $breakpoint = strpos($user_object->mail, $badstring); ?>
						<?php $newmail = substr($user_object->mail, 0, $breakpoint) . substr($user_object->mail, ($breakpoint + strlen($badstring))); ?>
						<?php $newmail = (strpos($newmail, '@') !== FALSE)? ($newmail): ($newmail . $badstring); ?>
						<?php $user_object->mail = $newmail; ?>
						<?php user_save((object) array('uid' => $user_id), (array) $user_object); ?>
					<?php elseif (!$user_content && $query_delete): ?>
						<?php user_delete($user_id); ?>
					<?php endif; ?>
				<?php endif; ?>
			<?php endforeach; ?>
			<caption><?= $usercount; ?> bad emails</caption>
		</table>
	
	<?php elseif (preg_match('/^\d+$/', $query_mode)): ?>
		<pre>UID: <?=print_r($query_mode, TRUE);?></pre>
		<pre>Nodes: <?=print_r(ofw_ipmahr_get_user_content($query_mode, 'nodes'), TRUE);?></pre>
		<pre>Orders: <?=print_r(ofw_ipmahr_get_user_content($query_mode, 'orders'), TRUE);?></pre>
	
	<?php endif; ?>
	
<?php endif; ?>
