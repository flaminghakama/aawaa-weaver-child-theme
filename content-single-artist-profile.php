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
    echo "<!-- " ; $fields = get_field_objects($key, the_ID()) ; echo "-->\n" ; 

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
        $field = $fields[$key] ; 
        echo "assigning <b>" . $field['label'] . "</b>: " . $field['value'] . "<br>\n" ; 
        $values[$key] = $field['value'] ; 
        $labels[$key] = $field['label'] ; 
    }

    /*  Display the feature image profile picture */
    echo "    <div id='profile-featured-image'>" ; 
    the_post_thumbnail( $size, $attr );
    echo "    </div>\n" ; 

    /*  Display the short-format fields  */
    echo "    <div class='short'>\n" ; 
    echo "        <div class='artist-name'>" . $values['first_name'] . " " . $values['last_name'] . "</div>\n" ;
    echo "        <div class='website'>" . $values['artist_website'] . "</div>\n" ;
    echo "        <div class='email'>" . $values['published_email'] . "</div>\n" ;
    echo "        <div class='social-media-profiles'>" . $values['social-media-profiles'] . "</div>\n" ;
    echo "    </div class='short'>\n" ; 

    /*  Display the long-format fields  */
    function format_long_field($field) { 
        return 
            "    <div class='long'>\n" +
            "        <h3>" . $labels[$field] . "</h3>\n" +
            "        <div>" . $values[$field] . "</div>\n" ;
            "    </div class='long'>\n" ; 
     }
    echo format_long_field('artist_statement') ; 
    echo format_long_field('artist_bio') ; 
    echo format_long_field('artist_cv') ;     
?>
</div id="artist-profile">
<!-- END  content-single-artist-profile.php  -->
