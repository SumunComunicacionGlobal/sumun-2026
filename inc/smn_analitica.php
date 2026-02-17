<?php 
/**
 * sumun Analitica
 *
 * @package sumun
 */

 if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

add_action('wp_footer', function($contact_form) {
    ?>
    <script>
        document.addEventListener('wpcf7mailsent', function(event) {
            gtag('event', 'conversion', {'send_to': 'AW-17927473113/HkUICKzWzvMbENmPvuRC'});
        }, false);
    </script>
    <?php
});