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
require('gallery-lib.php') ; 
?>

<div id="artist-profile"><!-- ID: <?php the_ID(); ?> -->
<?php

    $profile_data = get_profile_data($weaverii_cur_post_id) ; 
    $values = $profile_data['values'] ; 
    $labels = $profile_data['labels'] ; 
 
    /*  Display the feature image profile picture */
    echo "<!-- wp_get_attachment_image_src: " ; $image = wp_get_attachment_image_src( get_post_thumbnail_id( $weaverii_cur_post_id ), 'artist-profile-picture' ); echo "-->\n" ; 
    $imgSrc = $image[0] ; 
    $dimensions = ( $image[1] >= $image[2] ) ? "width='100%'" : "height='100%'" ;  
    //echo var_dump($image) ; 

    echo "    <div id='profile-featured-image'>\n" ; 
    echo "        <img $dimensions src='$imgSrc' class='attachment-artist-profile-picture wp-post-image' alt='" . $values['first_name'] . " " . $values['last_name'] . "'>\n" ; 
    echo "    </div>\n" ; 


    function _concatTerm($list, $delimiter, $name) { 
        return ( $list ) ? $list . $delimiter . $name : $name ; 
    }

    /*  Get the taxonomy terms  */
    $locations = wp_get_object_terms($weaverii_cur_post_id, 'artist-profile-location');
    //var_dump($locations) ; 
    if(!empty($locations)){
        if(!is_wp_error( $locations )){
            foreach($locations as $term){
                $values['location'] = _concatTerm( $values['location'], " and ", $term->name) ; 
            }
        }
    }

    $ethnicities = wp_get_object_terms($weaverii_cur_post_id, 'artist-profile-ethnicity');
    if(!empty($ethnicities)){
        if(!is_wp_error( $ethnicities )){
            foreach($ethnicities as $term){
                $values['ethnicity'] = _concatTerm( $values['ethnicity'], ', ', $term->name) ; 
            }
        }
    }

    $disciplines = wp_get_object_terms($weaverii_cur_post_id, 'artist-profile-discipline');
    if(!empty($disciplines)){
        if(!is_wp_error( $disciplines )){
            foreach($disciplines as $term){
                $values['discipline'] = _concatTerm( $values['discipline'], ', ', $term->name) ; 
            }
        }
    }

    function format_tag($name, $taxonomy) { 
        return "            <div class='tag $taxonomy'>$name</div>\n" ; 
    }

    $mediums = wp_get_object_terms($weaverii_cur_post_id, 'artist-profile-medium');
    if(!empty($mediums)){
        if(!is_wp_error( $mediums )){
            foreach($mediums as $term){
                $values['media'] = _concatTerm( $values['media'], ', ', $term->name) ; 
                $values['mediums'][] = format_tag($term->name, 'medium') ;
            }
        }
    }


    /*  Display the short-format fields */  
    echo "    <div class='short'>\n" ; 
    echo "        <h2>" . $values['first_name'] . " " . $values['last_name'] . "</h2>\n" ;
    echo "        <div class='discipline'>" . $values['discipline'] . "</div>\n" ;
    echo "        <div class=''>" . $values['media'] . "</div>\n" ;
    echo "        <div class='location'>" . $values['location'] . "</div>\n" ;
    echo "        <div class='ethnicity'>" . $values['ethnicity'] . "</div>\n" ;
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

 
    /*  Get the author of this post  */
    $author = get_the_author();
    //echo "<p>author is $author</p>\n"; 
    $author_ID = $post->post_author;
    //echo "<p>author_ID is $author_ID</p>\n"; 
    format_gallery($wpdb, $author_ID) ; 
?>
</div id="artist-profile">
<!-- END  content-single-artist-profile.php  -->
