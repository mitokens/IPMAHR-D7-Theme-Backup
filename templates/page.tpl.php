<a href="#content" class="element-invisible element-focusable"><?=t('Skip to content');?></a>
<?php if ($main_menu): ?>
	<a href="#main-nav" class="element-invisible element-focusable" data-target=".nav-collapse" data-toggle="collapse"><?=t('Skip to navigation');?></a>
<?php endif; ?>

<?php if ($logo || $site_name || $site_slogan || ($page['header']) || ($page['search_box'])): ?>
	<div id="header" class="clearfix header" role="banner">
		<div class="container">
			<div class="row">
					<?php if ($logo): ?>
						<div id="logo" class="site-logo"><a href="<?=$front_page;?>" rel="home"><img src="<?=$logo;?>" alt="<?=$site_name;?>" role="presentation" /></a></div>
					<?php endif; ?>
					<?php if ($site_name || $site_slogan): ?>
						<div id="name-and-slogan">
							<?php if ($site_name): ?>
								<div id="site-name" class="site-name"><a href="<?=$front_page;?>" rel="home"><?=$site_name;?></a></div>
							<?php endif; ?>
							<?php if ($site_slogan): ?>
								<div id="site-slogan" class="site-slogan"><?=$site_slogan;?></div>
							<?php endif; ?>
						</div>
					<?php endif; ?>
					<?php if (($site_name || $site_slogan)): ?>
						<!--div id="site" class="hide">
							<div id="name"><a href="<?=$front_page;?>"><?=$my_site_title;?></a></div>
						</div!-->
					<?php endif; ?>
					<?php if ($page['header']): ?>
						<div id="header-content" class="header-content"><?=render($page['header']);?></div>
					<?php endif; ?>
			</div>
		</div>
	</div>
<?php endif; ?>

<?php if ((!empty($page['navigation'])) || !empty($page['search_box'])): ?>
	<div id="main-menu" class="clearfix site-main-menu">
		<div class="container">
			<div class="navbar">
					<div class="navbar-inner">
						<div class="container">
							<?php if ($page['search_box']): ?>
								<div id="nav-search" class="nav-search"><?=render($page['search_box']);?></div>
							<?php endif; ?>
							<?php if (!empty($page['navigation'])): ?>
								<?php if (!empty($page['navigation']['block_103'])): ?>
									<?=render($page['navigation']['block_103']);?>
								<?php endif; ?>
								<a class="btn btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">MENU</a>
								<div class="nav-collapse collapse">
									<nav id="main-nav" role="navigation">
										<?=render($page['navigation']);?>
									</nav>
								</div>
							<?php endif; ?>
						</div>
					</div>
			</div>
		</div>
	</div>
<?php endif; ?>

<div id="main" class="clearfix main" role="main">
	<div class="container">
		<?php if (!($is_front) && ($breadcrumb)): ?>
			<div id="breadcrumb"><?=$breadcrumb;?></div>
		<?php endif; ?>
		<?php if ($page['main_top']): ?>
			<div id="main-top" class="row-fluid main-top"> <?=render($page['main_top']);?> </div>
		<?php endif; ?>
		<div id="main-content" class="row main-content">
			<div id="content" class="mc-content <?php if (($page['sidebar_first']) && ($page['sidebar_second'])): print 'span6'; elseif (($page['sidebar_first']) || ($page['sidebar_second'])): print 'span9'; else: print 'span12'; endif; ?>">
				<?php if ($page['content_top']): ?>
					<div id="content-top" class="row-fluid content-top"> <?=render($page['content_top']);?> </div>
				<?php endif; ?>
				<div id="content-wrapper" class="content-wrapper">
					<div id="content-head" class="row-fluid content-head">
						<?=render($title_prefix);?>
						<?php if ($title): ?>
							<?php $promote_symbol = ($node->promote)? ('&#127968;&nbsp;'): (''); ?>
							<?php $sticky_symbol = ($node->sticky)? ('&#128204;&nbsp;'): (''); ?>
								<h1 class="title" id="page-title">
									<small class="promoted visibility-staff" title="promoted to the front page"><?= $promote_symbol; ?></small>
									<small class="sticky visibility-staff" title="sticky to the top of lists"><?= $sticky_symbol; ?></small>
									<span class="title-text"><?=$title;?></span>
								</h1>
						<?php endif; ?>
						<?=render($title_suffix);?>
						<?php if (isset($tabs['#primary'][0]) || isset($tabs['#secondary'][0])): ?>
							<div class="tabs"> <?=render($tabs);?> </div>
						<?php endif; ?>
						<?php if ($messages): ?>
							<div id="console" class="clearfix"><?=$messages;?></div>
						<?php endif; ?>
						<?php if ($action_links): ?>
							<ul class="action-links">
								<?=render($action_links);?>
							</ul>
						<?php endif; ?>
					</div>
					<?php if (($page['content']) || ($feed_icons)): ?>
						<div id="content-body" class="row-fluid content-body"> <?=render($page['content']);?> <?=$feed_icons;?> </div>
					<?php endif; ?>
				</div>
				<?php if ($page['content_bottom']): ?>
					<div id="content-bottom" class="row-fluid content-bottom"> <?=render($page['content_bottom']);?> </div>
				<?php endif; ?>
			</div>
			<?php if ($page['sidebar_first']): ?>
				<div id="sidebar-first" class="sidebar span3 site-sidebar-first">
					<div class="row-fluid"><?=render($page['sidebar_first']);?></div>
					<?php //ofw_ipmahr_set_message_r($page['sidebar_first'], 1); ?>
				</div>
			<?php endif; ?>
			<?php if ($page['sidebar_second']): ?>
				<div id="sidebar-second" class="sidebar span3 site-sidebar-second">
					<div class="row-fluid"><?=render($page['sidebar_second']);?></div>
				</div>
			<?php endif; ?>
		</div>
		<?php if ($page['main_bottom']): ?>
			<div id="main-bottom" class="row-fluid main-bottom"> <?=render($page['main_bottom']);?> </div>
		<?php endif; ?>
	</div>
</div>

<?php if ($page['footer']): ?>
	<div id="footer" class="clearfix site-footer" role="contentinfo">
		<div class="container">
			<div id="footer-content" class="row-fluid footer-content"> <?=render($page['footer']);?> </div>
		</div>
	</div>
<?php endif; ?>