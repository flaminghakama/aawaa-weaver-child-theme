<!-- BEGIN  content-single-work-of-art.php  -->
<?php
/**
 * The template part that displays a work of art
 * typically called from the single-work-of-art.php template
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

<div id="work-of-art">
<?php
    $art = get_the_ID() ; 
    $art_title = get_the_title() ;
    $altText = $art_title ; 

    /*  For some reason, these calls echo the post ID, so we wrap it in HTML comments */
    $fields = get_field_objects($key, $art) ; 

    /*  Get all the lables and values we need to display the data */
    $values = array () ;
    $labels = array () ;
    $art_fields = array (
        0 => 'medium',
	1 => 'dimensions',
	2 => 'year',
	3 => 'event',
     ) ; 

    foreach ($art_fields as $count => $key) {
        $values[$key] = get_field($key); 
        $field = $fields[$key] ; 
        $labels[$key] = $field['label'] ;            
    }

    /*  Display the work of art */
    echo "<!-- wp_get_attachment_image_src: " ; $image = wp_get_attachment_image_src( get_post_thumbnail_id( $art ), 'work-of-art' ); echo "-->\n" ; 
    $geo = imageDimensions($image, 858, 642) ; 
    $imgSrc = $image[0] ; 
    $dimensions = $geo['dimensions'] ; 

    echo "    <div id='featured-image'>\n" ; 
    echo "        <img $dimensions src='$imgSrc' class='attachment-work-of-art-picture wp-post-image' alt='$altText'>\n" ; 
    echo "    </div>\n" ; 

    /*  Display the short-format fields */  
    echo "    <div class='short'>\n" ; 
    echo "        <h2>$art_title</h2>\n" ;
    echo "        <div class=''>" . $values['medium'] . " / " . $values['dimensions'] . " / " . $values['year'] . "</div>\n" ;  
    echo "        <div class=''>" . $values['event'] . "</div>\n" ;
    echo "    </div class='short'>\n" ;

    /*  Get the author of this post  */
    $author = get_the_author();
    //echo "<p>author is $author</p>\n"; 
    $author_ID = $post->post_author;
    //echo "<p>author_ID is $author_ID</p>\n"; 
    format_gallery($wpdb, $author_ID) ; 
?>
</div id="work-of-art">
<!-- END  content-single-work-of-art.php  -->
