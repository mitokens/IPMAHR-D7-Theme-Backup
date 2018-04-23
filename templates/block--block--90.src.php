<?php $account = user_load($GLOBALS['user']->uid); ?>
<?php if ($account): ?>
	<?php $sso_token_field = field_get_items('user', $account, 'field_sso_token'); ?>
	<?php $sso_token_value = $sso_token_field[0]['value']; ?>
	<?php if ($sso_token_value): ?>
		<script type="text/javascript">
			jQuery(window).ready(function() {
				jQuery('a[href*="members.ipma-hr.org"]').each(function() {
					var self = jQuery(this);
					var href = self.attr('href');
					var href_fragment = (href.indexOf('#') > -1)? (href.slice(href.indexOf('#'))): ('');
					var href_url = (href_fragment)? (href.slice(0, href.indexOf('#'))): (href);
					if (href_url.indexOf('?') === -1) {
						href_url += '?TOKEN=<?=$sso_token_value;?>';
					}
					else if (href_url.indexOf('?') === (href_url.length - 1)) {
						href_url += 'TOKEN=<?=$sso_token_value;?>';
					}
					else if (href_url.toUpperCase().indexOf('TOKEN=') === -1) {
						href_url += '&TOKEN=<?=$sso_token_value;?>';
					}
					console.log('MX_SSO_HREF = ' + href_url + href_fragment);
					self.attr('href', (href_url + href_fragment));
				});
			});
		</script>
	<?php endif; ?>
<?php endif; ?>