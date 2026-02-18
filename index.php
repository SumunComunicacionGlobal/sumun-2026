<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package sumun
 */

get_header();
?>

	<main id="primary" class="site-main is-layout-constrained">

		<?php
		if ( have_posts() ) :

			if ( is_home() && ! is_front_page() ) :
				$blog_id = get_option( 'page_for_posts' );
				$blog_content = get_post( $blog_id );
				echo apply_filters( 'the_content', $blog_content->post_content );
			else :

				/* Start the Loop */
				while ( have_posts() ) :
					the_post();

					/*
					* Include the Post-Type-specific template for the content.
					* If you want to override this in a child theme, then include a file
					* called content-___.php (where ___ is the Post Type name) and that will be used instead.
					*/
					get_template_part( 'template-parts/content', get_post_type() );

				endwhile;

				the_posts_navigation();

			endif;

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
