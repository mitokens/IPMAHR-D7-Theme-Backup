<?php
	$account = $GLOBALS['user'];
	$roles = '';
	foreach ($account->roles as $role) {
		$roles = $roles.' '.strtolower(str_replace(' ','-',$role));
	}
	function get_title_from_nid($nid) {
		return db_result(db_query('SELECT title FROM {node} WHERE nid = %d',preg_replace('/[^\D]/g','',$nid)));
	}
	if (user_is_logged_in() && (!$_COOKIE['CRM4MWebPortal'] || !$_COOKIE['ProtechToken'])) {
		$current_user = user_load($account->uid, TRUE);
		$cookiestring = 'NAMEID=' . $current_user->field_member_id['und']['0']['value'];
		$cookiestring .= '&FIRSTNAME=' . $current_user->field_name_first['und']['0']['value'];
		$cookiestring .= '&LASTNAME=' . $current_user->field_name_last['und']['0']['value'];
		$cookiestring .= '&TOKEN=' . $current_user->field_sso_token['und']['0']['value'];
		$cookiestring .= '&TIMESTAMP=' . date('M j Y h:iA');
		$ssotoken = $current_user->field_sso_token['und']['0']['value'];
		setcookie('CRM4MWebPortal', $cookiestring, 0, '/', '.ipma-hr.org', FALSE, TRUE);
		setcookie('ProtechToken', $ssotoken, 0, '/', '.ipma-hr.org', FALSE, TRUE);
	}
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="drupal ie6 ie <?='user-'.$account->uid;?> <?=$roles?>" id="top" lang="<?=$language->language;?>" dir="<?=$language->dir;?>"> <![endif]-->
<!--[if IE 7]>    <html class="drupal ie7 ie <?='user-'.$account->uid;?> <?=$roles?>" id="top" lang="<?=$language->language;?>" dir="<?=$language->dir;?>"> <![endif]-->
<!--[if IE 8]>    <html class="drupal ie8 ie <?='user-'.$account->uid;?> <?=$roles?>" id="top" lang="<?=$language->language;?>" dir="<?=$language->dir;?>"> <![endif]-->
<!--[if IE 9]>    <html class="drupal ie9 ie <?='user-'.$account->uid;?> <?=$roles?>" id="top" lang="<?=$language->language;?>" dir="<?=$language->dir;?>"> <![endif]-->
<!--[if !IE]> --> <html class="drupal notie <?='user-'.$account->uid;?> <?=$roles?>" id="top" lang="<?=$language->language;?>" dir="<?=$language->dir;?>"> <!-- <![endif]-->
	<head>
		<title><?=$head_title;?></title>
		<?=$head;?>
		<meta name="viewport" content="initial-scale=1.0, target-densitydpi=device-dpi, width=device-width" />
		<link href='http://fonts.googleapis.com/css?family=Andika|Source+Code+Pro:400,700|Source+Sans+Pro:400,600,700|Source+Serif+Pro:400,700' rel='stylesheet' type='text/css'>
		<?=$styles;?>
		<!--[if IE 7]><link rel="stylesheet" href="<?=base_path().drupal_get_path('theme','open_framework').'/fontawesome/css/font-awesome-ie7.min.css';?>"><![endif]-->
		<script src="https://www.youtube.com/iframe_api"></script>
		<?=$scripts;?>
		<!--[if lt IE 9]><script src="<?=base_path().drupal_get_path('theme','open_framework').'/js/html5shiv.js';?>"></script><![endif]-->
		<!-- START MGI Facebook Tracking Code !-->
			<script>!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,'script','https://connect.facebook.net/en_US/fbevents.js');fbq('init','988512567891968');fbq('track','PageView');</script>
			<noscript><img src="https://www.facebook.com/tr?id=988512567891968&ev=PageView&noscript=1" height="1" width="1" style="display:none"></noscript>
		<!-- END MGI Facebook Tracking Code !-->
		<!-- START MGI LinkedIn Tracking Code !-->
			<script type="text/javascript">_linkedin_data_partner_id = "28095";</script>
			<script type="text/javascript">(function(){var s=document.getElementsByTagName("script")[0];var b=document.createElement("script");b.type="text/javascript";b.async=true;b.src="https://snap.licdn.com/li.lms-analytics/insight.min.js";s.parentNode.insertBefore(b,s);})();</script>
		<!-- END MGI LinkedIn Tracking Code !-->
		<!-- START Google Charts API -->
			<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
			<script type="text/javascript">
				google.charts.load('current', {packages: ['corechart']});
				//google.charts.setOnLoadCallback(drawChart);
			</script>
		<!-- END Google Charts API -->
		<!-- START DoubleClick AdSense Code -->
			<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
			<script>
				(adsbygoogle = window.adsbygoogle || []).push({
					google_ad_client: "ca-pub-1524544659555511",
					enable_page_level_ads: true
				});
			</script>
		<!-- END DoubleClick Adsense Code -->
	</head>
	<body class="<?=$classes;?> <?=$body_bg_type;?> <?=$body_bg_classes;?> <?=$content_order_classes;?> <?=$front_heading_classes;?> <?=$breadcrumb_classes;?> <?=$border_classes;?> <?=$corner_classes;?>" <?=$attributes;?>>
		<?=$page_top;?>
		<?=$page;?>
		<?=$page_bottom;?>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/jquery-ui.min.js"></script>
		<!-- START MGI Google Remarketing Code !-->
			<script type="text/javascript">/*<![CDATA[*/ var google_conversion_id = 923679085; var google_custom_params = window.google_tag_params; var google_remarketing_only = true; /*]]>*/ </script>
			<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js"></script>
			<noscript><div style="display:inline;"><img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/923679085/?value=0&amp;guid=ON&amp;script=0"/></div></noscript>
		<!-- END MGI Google Remarketing Code !-->
		<!-- START MGI LinkedIn Tracking Code !-->
			<script type="text/javascript">_linkedin_data_partner_id = "28095";</script>
			<script type="text/javascript">(function(){ var s=document.getElementsByTagName("script")[0],b=document.createElement("script"); b.type="text/javascript",b.async=!0,b.src="https://snap.licdn.com/li.lms-analytics/insight.min.js",s.parentNode.insertBefore(b,s); })(); </script>
			<noscript><img height="1" width="1" style="display:none;" alt="" src="https://dc.ads.linkedin.com/collect/?pid=28095&fmt=gif" /></noscript>
		<!-- END MGI LinkedIn Tracking Code !-->
	</body>
</html>