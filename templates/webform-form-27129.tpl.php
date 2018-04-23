<?php
	/**
	*** @file
	*** Customize the display of a complete webform.
	***
	*** This file may be renamed "webform-form-[nid].tpl.php" to target a specific
	*** webform on your site. Or you can leave it "webform-form.tpl.php" to affect
	*** all webforms on your site.
	***
	*** Available variables:
	*** - $form: The complete form array.
	*** - $nid: The node ID of the Webform.
	***
	*** The $form array contains two main pieces:
	*** - $form['submitted']: The main content of the user-created form.
	*** - $form['details']: Internal information stored by Webform.
	**/
?>

<?php
	/* Dynamically add css files by form id. */
	drupal_add_css(drupal_get_path('theme',$GLOBALS['theme']).'/css/webform--form.tpl.css');
	drupal_add_css(drupal_get_path('theme',$GLOBALS['theme']).'/css/webform--form-'.strtolower($nid).'.tpl.css');
?>

<?php
	/* Determine if the current user can't vote. */
	$cant_vote = 'anonymous';
	if (user_is_logged_in()) {
		$cant_vote = '';
		$account = $GLOBALS['user'];
		/* User cannot vote if they don't have the "voting member" role. */
		if (!in_array('voting member', $account->roles)) {
			$cant_vote = $account->mail;
		}
		/* User cannot vote if they are in the {users_who_cant_vote} table. This overrides the "voting member" role. */
		else {
			$nonvoters = db_query("SELECT memberid, email FROM {users_who_cant_vote}")->fetchAllKeyed(0, 1);
			if (in_array($account->mail, $nonvoters)) {
				$cant_vote = $account->mail;
			}
		}
	}
	/* If the user isn't logged in, hide their info. */
	if(!user_is_logged_in()) {
		hide($form['submitted']['voter']);
	}
	/* Hide the voting button if the user can't vote. */
	if ($cant_vote) {
		hide($form['actions']);
	}
?>

<?php
  /* Print out the main part of the form. */
  print drupal_render($form['submitted']);
  print drupal_render_children($form);
?>

<?php if(!user_is_logged_in()): ?>
	<p class="alignb alignj"><a href="/user?destination=election"><input class="form-submit" id="edit-submit" type="button" value="You must login to vote"/></a></p>
<?php elseif ($cant_vote): ?>
	<p class="alignb alignj">
		<input class="form-submit" disabled="true" id="edit-submit" type="button" value="Your account cannot vote"/><br/>
		<label class="small" for="edit-submit">
			Voting eligibility does not include: student, complimentary, and chapter-only members.<br/>
			It may take up to a week to process voting access for new members.
		</label>
	</p>
<?php endif; ?>
