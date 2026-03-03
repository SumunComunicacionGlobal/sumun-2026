<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package sumun
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		if ( is_singular() ) :
			smn_breadcrumb();
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) :
			?>
			<div class="entry-meta">
				<?php
				smn_hybrid_posted_on();
				smn_hybrid_posted_by();
				?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="is-layout-constrained">

		<div class="wp-block-columns is-layout-flex row-reverse-desktop">

			<div class="wp-block-column entry-content">
				<?php
				the_content(
					sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'sumun' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						wp_kses_post( get_the_title() )
					)
				);

				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'sumun' ),
						'after'  => '</div>',
					)
				);
				?>
			</div><!-- .entry-content -->

			<div class="wp-block-column entry-gallery">
				<?php echo smn_hybrid_get_portfolio_gallery(); ?>
			</div><!-- .entry-gallery -->

		</div><!-- .wp-block-columns -->

	</div><!-- .is-layout-constrained -->

	<footer class="entry-footer">
		<?php smn_hybrid_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
