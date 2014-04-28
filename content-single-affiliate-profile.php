<!-- BEGIN  content-single-affiliate-profile.php  -->
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
require('gallery-lib.php') ; 
?>

<div id="artist-profile"><!-- ID: <?php the_ID(); ?> -->
<?php

    $taxonomies = array(
        'location' => 'affiliate-profile-location', 
	'disciplines' => 'affiliate-profile-discipline'
    ) ; 

    $delimiters = array ( 
        'location' => ' and ',
	'disciplines' => ', '
    ) ; 


    /*  Get the taxonomy terms  */
    $tag_info = get_artist_terms( $weaverii_cur_post_id, $taxonomies, $delimiters) ; 
    $tag_values = $tag_info['values'] ; 
    //var_dump($tag_values) ; 
    $tag_data = $tag_info['tags'] ; 
    //var_dump($tag_data) ; 

    echo "    <div class='artist-profile-columns'>\n" ; 
    echo "        <div class='colleft'>\n" ; 
    echo "            <div class='artist-profile-tags'>\n" ; 
    foreach ($tag_data as $key => $tag) {
        //var_dump($tag) ; 
        foreach ($tag as $div) { 	    
	    echo $div ;
	}
    }
    echo "            </div class='artist-profile-tags'>\n" ; 
    echo "            <div class='artist-profile-fields'>\n" ; 

    $profile_data = get_profile_data($weaverii_cur_post_id) ; 
    $values = $profile_data['values'] ; 
    $labels = $profile_data['labels'] ; 
    //var_dump($values) ; 
    //var_dump($labels) ; 

    /*  Display the feature image profile picture */
    echo "<!-- wp_get_attachment_image_src: " ; $image = wp_get_attachment_image_src( get_post_thumbnail_id( $weaverii_cur_post_id ), 'artist-profile-picture' ); echo "-->\n" ; 
    $imgSrc = $image[0] ; 
    $dimensions = ( $image[1] >= $image[2] ) ? "width='100%'" : "height='100%'" ;  
    //echo var_dump($image) ; 

    echo "    <div id='profile-featured-image'>\n" ; 
    echo "        <img $dimensions src='$imgSrc' class='attachment-artist-profile-picture wp-post-image' alt='" . $values['first_name'] . " " . $values['last_name'] . "'>\n" ; 
    echo "    </div>\n" ; 

    /*  Display the short-format fields */  
    echo "            <div class='short'>\n" ; 
    echo "                <h2>" . $values['first_name'] . " " . $values['last_name'] . "</h2>\n" ;
    echo "                <div class='disciplines'>" . $tag_values['disciplines'] . "</div>\n" ;
    echo "                <div class='location'>" . $tag_values['location'] . "</div>\n" ;
    echo "                <div class='website'>" . $values['artist_website'] . "</div>\n" ;
    echo "                <div class='email'>" . $values['published_email'] . "</div>\n" ;
    echo "                <div class='social-media-profiles'>" . $values['social-media-profiles'] . "</div>\n" ;
    echo "            </div class='short'>\n" ;

    /*  Display the long-format fields  */
    echo "                <div class='long-container'>\n" ; 
    format_long_field($labels['artist_statement'], $values['artist_statement']) ; 
    format_long_field($labels['artist_bio'], $values['artist_bio']) ; 
    format_long_field($labels['artist_cv'], $values['artist_cv']) ; 
    echo "                </div class='long-container'>\n" ; 
    echo "            </div class='artist-profile-fields'>\n" ; 
    echo "        </div class='colleft'>\n" ; 
    echo "    </div class='artist-profile-columns'>\n" ; 
?>
</div id="artist-profile">
<!-- END  content-single-affiliate-profile.php  -->
