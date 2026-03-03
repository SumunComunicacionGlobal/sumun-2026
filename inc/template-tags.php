<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package sumun
 */

if ( ! function_exists( 'smn_hybrid_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function smn_hybrid_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'sumun' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'smn_hybrid_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function smn_hybrid_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'sumun' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'smn_hybrid_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function smn_hybrid_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'sumun' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'sumun' ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'sumun' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'sumun' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'sumun' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'sumun' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'smn_hybrid_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function smn_hybrid_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

			<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php
					the_post_thumbnail(
						'post-thumbnail',
						array(
							'alt' => the_title_attribute(
								array(
									'echo' => false,
								)
							),
						)
					);
				?>
			</a>

			<?php
		endif; // End is_singular().
	}
endif;

if ( ! function_exists( 'wp_body_open' ) ) :
	/**
	 * Shim for sites older than 5.2.
	 *
	 * @link https://core.trac.wordpress.org/ticket/12563
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
endif;


function smn_hybrid_get_portfolio_gallery() {
	$html_fotos = '';

	$galeria_de_imagenes = apply_filters( 'the_content', get_field('galeria_de_imagenes') );
	if ( ! empty( $galeria_de_imagenes ) ) {
		$html_fotos .= $galeria_de_imagenes;
	}

	$galeria_de_videos = get_field('galeria_de_videos');
	if ( ! empty( $galeria_de_videos ) ) {
		$videos = explode( "\n", $galeria_de_videos );
		foreach ( $videos as $video_url ) {
			$video_url = trim( $video_url );
			if ( ! empty( $video_url ) ) {
				$html_fotos .= do_shortcode( '[video src="' . esc_url( $video_url ) . ']' );
			}
		}
	}

	if ( $html_fotos ) {
		$html_fotos = '<div class="portfolio-gallery">' . $html_fotos . '</div>';
	}

	return $html_fotos;
}

add_filter( 'post_gallery', 'modificar_shortcode_gallery', 10, 3  );
function modificar_shortcode_gallery( $output, $attr, $instance ) {
    if ( is_singular( 'portfolio_page' )) {
        $attr['columns'] = 1;
        $attr['size'] = 'large';
        $attr['link'] = 'none';

        remove_filter( 'post_gallery', 'modificar_shortcode_gallery', 10 );
        return gallery_shortcode( $attr );
    }

  
    return $output;
}

function smn_get_breadcrumb() {

	if ( is_front_page() ) return false;

	ob_start();

	if ( function_exists('yoast_breadcrumb') ) {
		yoast_breadcrumb( '<div id="breadcrumbs" class="breadcrumb"><div class="breadcrumb-inner">','</div></div>' );
	} elseif(function_exists('bcn_display')) {
		echo '<div class="breadcrumb" typeof="BreadcrumbList" vocab="https://schema.org/">';
			echo '<div class="breadcrumb-inner">';
				bcn_display();
			echo '</div>';
		echo '</div>';
	} elseif ( function_exists( 'rank_math_the_breadcrumbs') ) {
		echo '<div class="breadcrumb">';
			echo '<div class="breadcrumb-inner">';
				rank_math_the_breadcrumbs(); 
			echo '</div>';
		echo '</div>';
	}

	$r = ob_get_clean();

	if ( $r ) {
		return '<div class="breadcrumb-wrapper py-1">' . $r . '</div>';
	}

}

function smn_breadcrumb() {
	
	$r = smn_get_breadcrumb();

	if ( $r ) {
		echo '<div class="container">';
			echo $r;
		echo '</div>';
	}

}