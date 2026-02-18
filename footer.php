<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package sumun
 */

$ocultar_contacto_footer = get_field('ocultar_contacto_footer');
?>

	<footer id="colophon" class="site-footer">
		<?php if ( ! $ocultar_contacto_footer ) : ?>
			<?php block_template_part( 'footer' ); ?>
		<?php endif; ?>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
