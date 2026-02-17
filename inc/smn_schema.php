<?php 
/**
 * sumun Schema
 *
 * @package sumun
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}



add_action( 'wp_head', 'smn_add_frontpage_schema' );
function smn_add_frontpage_schema() {
    if ( !is_front_page() )  return false; ?>

    <script type="application/ld+json">
        {
        "@context": "https://schema.org",
        "@type": "LocalBusiness",
        "name": "Sumun Comunicación Global - Estrategia, Marketing y Diseño",
        "image": "https://sumun.net/wp-content/uploads/2026/02/Favicon-Sumun.png",
        "@id": "",
        "url": "https://sumun.net",
        "telephone": "976495420",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "Fray Luis Amigó, 6",
            "addressLocality": "Zaragoza",
            "postalCode": "50006",
            "addressCountry": "ES"
        },
        "geo": {
            "@type": "GeoCoordinates",
            "latitude": 41.6367516,
            "longitude": -0.8930638999999999
        },
        "openingHoursSpecification": {
            "@type": "OpeningHoursSpecification",
            "dayOfWeek": [
            "Monday",
            "Tuesday",
            "Wednesday",
            "Thursday",
            "Friday"
            ],
            "opens": "08:30",
            "closes": "16:30"
        },
        "sameAs": [
            "https://www.facebook.com/Sumun.net",
            "https://x.com/_Sumun_",
            "https://www.instagram.com/sumuntheagency/",
            "https://www.youtube.com/@agenciasumun",
            "https://www.linkedin.com/company/sumun/",
            "https://es.pinterest.com/sumun__/,
            "https://github.com/SumunComunicacionGlobal",
            "https://sumun.net"
        ] 
        }
    </script>

<?php }