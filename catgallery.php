<?php

/**
 * Cat-Gallery
 *
 * @package       CATGALLER
 * @author        Your-Name
 * @version       1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:   Cat-Gallery
 * Plugin URI:    https://wpaffair.com/catgallery/
 * Description:   Create a simple plugin which will fetch the cat images and render them in the frontend.
 * Version:       1.0.0
 * Author:        RJEE RUMY
 * Author URI:    https://wpaffair.com/catgallery/
 * Text Domain:   cat-gallery
 * Domain Path:   /languages
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;
// Include your custom code here.


function sharePost_shortcode($atts)
{
    $cat_images_gallery = '<div class="popup-gallery">';
    extract(shortcode_atts(array(
        'limit' => 10
    ), $atts));

    $cat_data = [];
    if ($limit) {
        $cat_data = get_catData_json("limit=$limit");
    }
    // print_r($cat_data);
    foreach ($cat_data as $key => $cat) {
        $cat_images_gallery = $cat_images_gallery . '<a href="'.$cat->url.'" title="The Cleaner"><img src="'.$cat->url.'" width="100" height="100"></a>';
    }
    $cat_images_gallery = $cat_images_gallery . '</div>';
    
    return $cat_images_gallery;
}

add_shortcode('sharePost', 'sharePost_shortcode');


function get_catData_json($query)
{
    $url = "https://api.thecatapi.com/v1/images/search?" . $query;
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            "x-api-key: live_u7odzA4zU9nyCm8lKYpqoRRiRamFEuaQ2N7zIx79HrsNReIYKGU8jl1yBrBZcfZF"
        ],
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);
    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        return json_decode($response);
    }
}


?>

<!-- Magnific Popup core CSS file -->
<link rel="stylesheet" href="<?php echo plugin_dir_url( __FILE__ ); ?>/Magnific-Popup-master/dist/magnific-popup.css">
<!-- jQuery 1.7.2+ or Zepto.js 1.0+ -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<!-- Magnific Popup core JS file -->
<script src="<?php echo plugin_dir_url( __FILE__ ); ?>/Magnific-Popup-master/dist/jquery.magnific-popup.js"></script>
<script>
    // $(document).ready(function() {
    $(window).ready(function() {
        $('.popup-gallery').magnificPopup({
            delegate: 'a',
            type: 'image',
            tLoading: 'Loading image #%curr%...',
            mainClass: 'mfp-img-mobile',
            gallery: {
                enabled: true,
                navigateByImgClick: true,
                preload: [0,1] // Will preload 0 - before current, and 1 after the current image
            },
            image: {
                tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
                titleSrc: function(item) {
                    return item.el.attr('title') + '<small>by Marsel Van Oosten</small>';
                }
            }
        });
    });
</script>