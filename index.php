
function sharePost_shortcode($atts){
  extract(shortcode_atts(array(
    'share' => 0
  ), $atts));

  $title = "How to Create custom Shortcode in WordPress";
  $link = urlencode("https://makitweb.com/how-to-create-custom-shortcode-in-wordpress/");

  $twitterURL = 'https://twitter.com/intent/tweet?text='.$title.'&amp;url='.$link.'&amp;via=yssyogesh_singh';
  $facebookURL = 'https://www.facebook.com/sharer/sharer.php?u='.$link;

  $message = "I hope you find this tutorial helpful.";

  if($share){
    $message .= "<br>Share it on <a href='".$twitterURL."' target='_blank'>Twitter</a>, <a href='".$facebookURL."' target='_blank'>Facebook</a>";
  }
  return $message;
}