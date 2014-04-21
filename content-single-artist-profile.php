<!-- BEGIN  content-single-artist-profile.php  -->
<?php
/**
 * The template part that displays an artist profile
 * typically called from the single-artist-profile.php template
 *
 * @package WordPress
 * @subpackage Weaver II AAWAA
 */
weaverii_trace_template(__FILE__);
global $weaverii_cur_post_id;
$weaverii_cur_post_id = get_the_ID();
weaverii_per_post_style();
?>

<div id="artist-profile"><!-- ID: <?php the_ID(); ?> -->
<?php

    /*  For some reason, this call echoes the post ID, so we wrap it in HTML comments */
    echo "<!-- get_field_objects: " ; $fields = get_field_objects($key, the_ID()) ; echo "-->\n" ; 

    /*  Get all the lables and values we need to display the data */
    $values = array () ;
    $labels = array () ;
    $profile_fields = array (
        0 => 'first_name',
	1 => 'last_name',
	2 => 'artist_website',
	3 => 'published_email',
	4 => 'social_media_profiles',
	5 => 'artist_statement',
	6 => 'artist_bio',
	7 => 'artist_cv'
     ) ; 

    foreach ($profile_fields as $count => $key) {
        $values[$key] = get_field($key); 
        $field = $fields[$key] ; 
        $labels[$key] = $field['label'] ;            
    }

    /*  Display the feature image profile picture */
    echo "<!-- wp_get_attachment_image_src: " ; $image = wp_get_attachment_image_src( get_post_thumbnail_id( the_ID() ), 'artist-profile-picture' ); echo "-->\n" ; 

    echo "    <div id='profile-featured-image'>" ; 
    echo "        <img width='100%' height='100%' src='$image' class='attachment-artist-profile-picture wp-post-image' alt='" . $values['first_name'] . " " . $values['last_name'] . "'>\n" ; 
    echo "    </div>\n" ; 

    /*  Display the short-format fields */  
    echo "    <div class='short'>\n" ; 
    echo "        <h2>" . $values['first_name'] . " " . $values['last_name'] . "</h2>\n" ;
    echo "        <div class='website'>" . $values['artist_website'] . "</div>\n" ;
    echo "        <div class='email'>" . $values['published_email'] . "</div>\n" ;
    echo "        <div class='social-media-profiles'>" . $values['social-media-profiles'] . "</div>\n" ;
    echo "    </div class='short'>\n" ;

    /*  Display the long-format fields  */
    echo "    <div class='long-container'>\n" ; 
    function format_long_field($label, $value) { 
        echo
            "        <div class='long'>\n" .
            "            <h3>$label</h3>\n" .
            "            <div>$value</div>\n" .
            "        </div class='long'>\n" ; 
     }
    format_long_field($labels['artist_statement'], $values['artist_statement']) ; 
    format_long_field($labels['artist_bio'], $values['artist_bio']) ; 
    format_long_field($labels['artist_cv'], $values['artist_cv']) ; 
    echo "    </div class='long-container'>\n" ; 
?>
</div id="artist-profile">
<!-- END  content-single-artist-profile.php  -->
