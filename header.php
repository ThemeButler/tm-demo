<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width">
		<meta name="description" content="ThemeButler Demos">
		<title>ThemeButler Demos - WordPress themes &amp; plugins</title>
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
		<?php

			// ThemeButler domain.
			$themebutler_domain = 'http://www.themebutler.com/themes';

			// Fetch all demos and remove main install from array.
			$demos = array_reverse( array_slice( wp_get_sites(), 1 ) );

			// Set selected.
			$selected = get_blog_details( beans_get( 'name', $_GET, $demos[0]['blog_id'] ) );

		?>
		<header role="banner">
			<div class="uk-container uk-container-center">
				<div class="tm-logo uk-float-left uk-text-small">
					<a href="http://www.themebutler.com" title="ThemeButler Demo's">ThemeButler</a>
					<span><i class="uk-icon-long-arrow-right uk-margin-small-left uk-margin-small-right"></i><a href="/" title="ThemeButler Demos">Theme demo's</a></span>
				</div>
				<div class="uk-float-right">
					<div class="uk-position-relative uk-float-left" data-uk-dropdown="{mode:'click'}">
						<div class="tm-select"><span class="tm-select-text"><?php echo $selected->blogname; ?></span><i class="uk-icon-caret-down uk-float-right"></i></div>
						<div class="uk-dropdown">
							<ul>
								<?php foreach ( $demos as $demo ) : $details = get_blog_details( $demo['blog_id'] ); ?>
									<li><a href="<?php echo $details->siteurl; ?>" data-name="<?php echo urlencode( $details->blogname ); ?>"><?php echo $details->blogname; ?></a></li>
								<?php endforeach; ?>
							</ul>
						</div>
					</div>
					<a class="tm-download uk-float-left" data-tb-domain="<?php echo $themebutler_domain; ?>" href="<?php echo $themebutler_domain . $selected->path; ?>"><i class="uk-icon-download uk-margin-small-right"></i> <span>Download</span></a>
				</div>
			</div>
		</header>
		<figure class="uk-overlay">
			<iframe id="iframe" frameborder="0" border="0" src="<?php echo $selected->siteurl; ?>" style="height: 100vh; width: 100vw;"></iframe>
			<div class="uk-overlay-panel uk-overlay-background uk-flex uk-flex-center uk-flex-middle"><i class="uk-icon-refresh uk-icon-large uk-icon-spin"></i></div>
		</figure>
