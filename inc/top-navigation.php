<?php
/***
 * Top Header Content
 *
 * This template displays the content in the right-hand header area based on theme options.
 *
 */
 
	// Get Theme Options from Database
	$theme_options = leeway_theme_options();
	
	// Display Social Icons
	if ( isset($theme_options['header_icons']) and $theme_options['header_icons'] == true ) : ?>

		<div id="header-social-icons" class="social-icons-wrap clearfix">
			<?php leeway_display_social_icons(); ?>
		</div>

<?php
	endif;

	// Display Top Navigation Menu
	if ( has_nav_menu( 'secondary' ) ) : ?>
	
		<nav id="topnav" class="clearfix" role="navigation">
			<div id="topnav-icon"><span><?php _e('Topmenu', 'leeway'); ?></span></div>
			<?php // Display Top Navigation
				wp_nav_menu(array('theme_location' => 'secondary', 'container' => false, 'menu_id' => 'topnav-menu', 'echo' => true, 'fallback_cb' => '', 'before' => '', 'after' => '', 'link_before' => '', 'link_after' => '', 'depth' => 1));
			?>
		</nav>
		
	<?php endif;

?>