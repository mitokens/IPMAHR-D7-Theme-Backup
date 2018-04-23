<?php
/**
*** @file
*** Default theme implementation to present all user profile data.
***
*** This template is used when viewing a registered member's profile page,
*** e.g., example.com/user/123. 123 being the users ID.
***
*** Use render($user_profile) to print all profile items, or print a subset
*** such as render($user_profile['user_picture']). Always call
*** render($user_profile) at the end in order to print all remaining items. If
*** the item is a category, it will contain all its profile items. By default,
*** $user_profile['summary'] is provided, which contains data on the user's
*** history. Other data can be included by modules. $user_profile['user_picture']
*** is available for showing the account picture.
***
*** Available variables:
***   - $user_profile: An array of profile items. Use render() to print them.
***   - Field variables: for each field instance attached to the user a
***     corresponding variable is defined; e.g., $account->field_example has a
***     variable $field_example defined. When needing to access a field's raw
***     values, developers/themers are strongly encouraged to use these
***     variables. Otherwise they will have to explicitly specify the desired
***     field language, e.g. $account->field_example['en'], thus overriding any
***     language negotiation rule that was previously applied.
***
*** @see user-profile-category.tpl.php
***   Where the html is handled for the group.
*** @see user-profile-item.tpl.php
***   Where the html is handled for each item in the group.
*** @see template_preprocess_user_profile()
***
*** @ingroup themeable
***/
?>

<?php $destination_array = drupal_get_destination(); ?>
<?php if ($destination_array['destination'] != current_path() && strpos($_SERVER[REQUEST_URI], drupal_get_path_alias()) === FALSE && strpos(drupal_get_path_alias(), $_SERVER[REQUEST_URI]) === FALSE): ?>
	<?php //drupal_goto(drupal_get_path_alias()); ?>
	<?php header('Location: /' . drupal_get_path_alias()); ?>
	<?php exit(); ?>
<?php endif; ?>

<?php $viewer_user = $GLOBALS['user']; ?>
<?php $user_object = user_load_by_mail($user_profile['mail']); ?>
<?php $user_roles = ofw_ipmahr_get_user_roles($user_object, 'string', 'weight', '</li><li>'); ?>
<?php $user_roles = ($user_roles)? ('<ul class="dent"><li>' . $user_roles . '</li></ul>'): ('<ul class="dent"><li>non-member</li></ul>'); ?>
<?php $showbio = FALSE; ?>
<?php if ($field_department): ?>
	<?php foreach ($field_department as $department): ?>
		<?php if ($department['value'] == 'profile'): ?>
			<?php $showbio = TRUE; ?>
		<?php endif; ?>
	<?php endforeach; ?>
<?php endif; ?>


<?php //ofw_ipmahr_set_message_r(current_path(), 'View published content'); ?>

<div class="profile"<?= $attributes; ?>>
	
	<!-- login_referer=<?=$_SESSION['login_referer'];?> !-->
	<!-- login_destination=<?=$_SESSION['login_destination'];?> !-->
	<!-- login_path=<?=$_SESSION['login_path'];?> !-->
	<!-- login_alias=<?=$_SESSION['login_alias'];?> !-->
	
	<?php if (user_access('Administer users') || user_has_role(6)): ?>
		<div class="alignb alignc">
			<small>
				<i title="Created"><?=format_date($user_object->created, 'custom', 'Y.m.d H:i');?></i>
				&emsp;&mdash;&emsp; <i title="Accessed"><?=format_date($user_object->access, 'custom', 'Y.m.d H:i');?></i>
			</small>
			<br>
			<br>
		</div>
	<?php endif; ?>
	
	<div class="alignc">
		<?php if ($field_name && FALSE): ?>
			<?= render_in($user_profile['field_name'], 'h1'); ?>
		<?php endif; ?>
		<?php if ($user_object->uid == $viewer_user->uid || user_access('Administer users') || user_has_role(6)): ?>
			<h2>
				<a href="/user/<?=$user_object->uid;?>">#</a> <?= $user_object->name; ?>
			</h2>
		<?php endif; ?>
	</div>
	
	<?php if ($user_profile['mail'] || $field_phone): ?>
		<div class="alignl dent6">
			<?php if ($user_profile['mail']): ?>
				<aside class="alignc dent12">
					<h4>Email</h4>
					<p><a href="mailto:<?= $user_profile['mail']; ?>"><?= $user_profile['mail']; ?></a></p>
				</aside>
			<?php endif; ?>
			<?php if ($field_phone): ?>
				<aside class="alignc dent12">
					<h4><?= $user_profile['field_phone']['#title']; ?></h4>
					<?php $user_profile['field_phone']['#label_display'] = 'hidden'; ?>
					<?= drupal_render($user_profile['field_phone']); ?>
				</aside>
			<?php endif; ?>
		</div>
	<? endif; ?>
	
	<?php if ($user_roles || $field_agency || $field_chapter): ?>
		<div class="alignr dent6">
			<?php if ($user_roles && ($user_object->uid == $viewer_user->uid || user_access('Administer users'))): ?>
				<aside class="dent12">
					<h4>Account Access</h4>
					<?= $user_roles; ?>
				</aside>
			<?php endif; ?>
			
			<?php if ($field_agency[0]['value']): ?>
				<aside class="alignc dent12">
					<h4><?= $user_profile['field_agency']['#title']; ?></h4>
					<?php $user_profile['field_agency']['#label_display'] = 'hidden'; ?>
					<?= drupal_render($user_profile['field_agency']); ?>
					<?php $user_profile['field_agency_title']['#label_display'] = 'hidden'; ?>
					<?= drupal_render($user_profile['field_agency_title']); ?>
				</aside>
			<?php endif; ?>
			<?php if ($field_chapter[0]['value']): ?>
				<aside class="alignc dent12">
					<h4><?= $user_profile['field_chapter']['#title']; ?></h4>
					<?php $user_profile['field_chapter']['#label_display'] = 'hidden'; ?>
					<?= drupal_render($user_profile['field_chapter']); ?>
					<?php $user_profile['field_chapter_role']['#label_display'] = 'hidden'; ?>
					<?= drupal_render($user_profile['field_chapter_role']); ?>
				</aside>
			<?php endif; ?>
		</div>
	<? endif; ?>
	
	<?php if ($field_image || $field_profile): ?>
		<aside class="alignb">
			<?php if ($field_image): ?>
				<div class="alignl dent4">
					<?= drupal_render($user_profile['field_image']); ?>
				</div>
			<?php endif; ?>
			<?php if ($field_profile): ?>
				<?= drupal_render($user_profile['field_profile']); ?>
			<?php endif; ?>
		</aside>
	<?php endif; ?>
	
	<?//= drupal_render($user_profile); ?>
	
</div>
