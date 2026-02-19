<?php 
// Shortcodes 

 
function fecha_copyright_function() {
	return date('Y');
}
add_shortcode('fecha_copyright','fecha_copyright_function');

function contenido_pagina($atts) {
	extract( shortcode_atts(
		array(
			'id' => 0,
			'wrapper' => true,
		), $atts )
	);
	if ($id > 0) {
		$post_type = get_post_type($id);
		$post = get_post($id);
		$content = $post->post_content;
		$post_content_without_shortcodes = preg_replace ( '/\[google_map(.*?)\]/s' , '' , $content );

		$r = '';
		if ($wrapper) {
			$r .= '<div class="contenido-pagina-wrapper">';
		}
			$r .= do_shortcode( apply_filters( 'the_content', $post_content_without_shortcodes ) );
		if ($wrapper) {
			$r .= '</div>';
		}

		return $r;
	}
}
add_shortcode('contenido_pagina','contenido_pagina');

// Permite usar algunos shortcodes en formularios de contacto
add_filter( 'wpcf7_form_elements', 'mycustom_wpcf7_form_elements' );
function mycustom_wpcf7_form_elements( $form ) {
	$form = do_shortcode( $form );
	return $form;
}

function mockups_web( $atts ) {
	global $post;
	extract( shortcode_atts(
		array(
			'url' => get_post_meta($post->ID, 'imagen-web-1', true),
			'count' => 1,
			'position' => 1,
		), $atts )
	);

	$r = '';

	if ( '' != $url ) {
		wp_enqueue_style( 'mockup-web' );
		$r .= 	'<div class="contenedor-mockups-web">
					<div class="screendiv">
						<div class="dummy"></div>
						<span class="scroll-notice"><i class="fa fa-sort fa-2x"></i></span>
						<span class="scroll-notice count"><span class="contador-web">'.$position .'/'.$count.'</span></span>
						<div class="screenpack">
							<figure class="screenshot" id="screenshot" >
								<img src="' . $url . '" alt="'.__('Captura','sumun').': '.get_the_title().'" class="imagen-mockup-web" id="captura-web" onMouseOver="pauseDiv()" onMouseOut="resumeDiv()" />
							</figure>
							<div class="screen-overlay"></div>
						</div>
					</div>
				</div>';
		//$r .= '<img src="'. plugins_url( 'images/mockup-imac.png', __FILE__ ) .'" alt="Mockup Web" />';
	}
	return $r;
}
add_shortcode('mockup_web','mockups_web');

function lista_categorias_portfolio() {
	$tax_slug = 'portfolio_category';
	$tax_obj = get_taxonomy( $tax_slug );
	// echo '<pre>';print_r($tax_obj);echo '</pre>';
	$tax = $tax_obj->rewrite['slug'];
	$terms = get_terms( $tax_slug );
	$r = '';
	if ($terms) {
		$array_terms = array();
		$r .= '<h4>' . __( 'Más en detalle', 'sumun' ) . '</h4>';
		foreach ($terms as $term) {
			// $link = add_query_arg('full', 'true', get_term_link( $term ) );
			$link = get_home_url( null, $tax.'/'.$term->slug );
			$array_terms[] = '<a href="'. $link .'" title="'.$term->name.'">'.$term->name.'</a>';
		}
		$r .= '<p>' . implode(' · ', $array_terms) . '</p>';
	}
	return $r;
}
add_shortcode('lista_categorias_portfolio', 'lista_categorias_portfolio');

function googleoff() {
	return '<!--googleoff: all-->';
}
add_shortcode( 'googleoff', 'googleoff' );

function googleon() {
	return '<!--googleon: all-->';
}
add_shortcode( 'googleon', 'googleon' );

function shortcode_formulario_newsletter() {
	return '<form id="subForm" class="js-cm-form wpcf7" action="https://www.createsend.com/t/subscribeerror?description=" method="post" data-id="5B5E7037DA78A748374AD499497E309E5EC4835ABC2B283315EC7A2CB4A86DAD96E66689D544245EDE668DBDE1EDF7837859E6A4262A1A3F5B0B1C833BD78FAE">
    
    <p>
        <label for="fieldName">Nombre</label><br />
        <input id="fieldName" name="cm-name" type="text" class="wpcf7-form-control wpcf7-text" />
    </p>
    <p>
        <label for="fieldEmail">Email</label><br />
        <input id="fieldEmail" class="js-cm-email-input wpcf7-form-control wpcf7-text wpcf7-email" name="cm-ukkhuli-ukkhuli" type="email" required /> 
    </p>
    <p>
        <button class="js-cm-submit-button btn btn-outline-primary" type="submit">Suscribirme</button> 
    </p>
</form>
    <script type="text/javascript" src="https://js.createsend1.com/javascript/copypastesubscribeformlogic.js"></script>';
}
add_shortcode('formulario_newsletter', 'shortcode_formulario_newsletter');

function slider( $atts ) {

	extract( shortcode_atts(
		array(
			'slider_cat' 		=> false,
		), $atts )
	);

	ob_start();
	get_template_part( 'global-templates/slider' );
	return ob_get_clean();

}
add_shortcode('slider', 'slider');

function casos_de_exito( $atts ) {

	ob_start();
	get_template_part( 'global-templates/casos-de-exito' );
	return ob_get_clean();

}
add_shortcode('casos_de_exito', 'casos_de_exito');

function journal( $atts ) {

	ob_start();
	get_template_part( 'global-templates/journal' );
	return ob_get_clean();

}
add_shortcode('journal', 'journal');