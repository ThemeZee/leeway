<?php get_header(); ?>

<?php // Get Theme Options from Database
	$theme_options = leeway_theme_options();
?>

	<div id="wrap" class="clearfix">
		
		<section id="content" class="primary" role="main">
		
			<header class="page-header">
				<h2 id="search-title" class="archive-title">
					<?php printf( __( 'Search Results for: %s', 'leeway' ), '<span>' . get_search_query() . '</span>' ); ?>
				</h2>
			</header>
			
		<?php if (have_posts()) : while (have_posts()) : the_post();
		
				get_template_part( 'content', $theme_options['posts_length'] );
		
			endwhile;
			
			leeway_display_pagination();

		else : ?>

			<div class="type-page">
				
				<div class="entry">
					<p><?php _e('No matches. Please try again, or use the navigation menus to find what you search for.', 'leeway'); ?></p>
				</div>
				
			</div>

			<?php endif; ?>
			
		</section>
		
		<?php get_sidebar(); ?>
	</div>
	
<?php get_footer(); ?>	