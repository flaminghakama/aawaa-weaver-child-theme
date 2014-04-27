<?php

/*
 * get_profile_data -- get the custom field data for an artist profile
 * @param integer post_ID The WordPress post ID
 * @returns an array of two arrays: values and labels
 */
function get_profile_data($post_ID) {

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

    return array ( 
        'values' => $values, 
	'labels' => $labels
    ) ; 
}

/*  
 *  imageDimensions -- Determine the optimal display dimensions of an image, 
 *      based on the specified target dimensions.
 *  @param WPImage image An object with height and width properties
 *  @param number target_width The size, in pixels, of the maximum width 
 *  @param number target_height The size, in pixels, of the maximum height
 *  @returns array Returns several different measurements:
 *    relative -- used as the value of a style attribute, specfies either height or width to be 100%
 *    dimensions -- used as the value of a style attribute, with explicit values for width and height
 *    width -- the nummerical value of the new image width
 *    height -- the nummerical value of the new image height
 *    padding -- used as the value of a style attribute for margin-bot or margin-right, the amount to make up the target height/width
 */
function imageDimensions($image, $target_width, $target_height) { 
    $image_width = $image[1] ; 
    $image_height = $image[2] ; 
    $image_ratio = ( $image_height > 0 ) ? $image_width / $image_height : $image_width ; 
    $target_ratio = $target_width / $target_height ; 
    $compare = $image_ratio / $target_ratio ; 
    $relative = 'height=100%' ; 
    $width = $target_width ; 
    $height = $target_height ;
    $space = 0 ; 
    $padding = "" ; 
    if ( $compare > 1 ) {  
	echo "<!-- compare=$compare: width $image_width is the max dimension (height is $image_height)-->\n" ; 
        $relative = 'width=100%' ; 
        $height = number_format($target_width / $image_ratio, 0);
        $space = $target_height - $height ; 
        //$padding = "margin-bottom:$space" . "px" ; 
    } else {  
	echo "<!-- compare=$compare: height $image_height is the max dimension (width is $image_width)-->\n" ; 
        $width = number_format($target_height * $image_ratio, 0);
        $space = $target_width - $width ; 
        $half_space = number_format($space / 2, 0) ; 
        $padding = "margin-right:$half_space" . "px;margin-left:$half_space" . "px" ; 
    }
  
    return array (
	'relative' => $relative,
        'dimensions' => "width='$width' height='$height'",
        'width' => $width,
        'height' => $height,
	'padding' => $padding
    ) ;   	    	       
}

/*  Create a thumbnail for an artist profile, linked to its post  */
function format_profile_thumbnail($permalink, $image, $first_name, $last_name) { 
    $imgSrc = $image[0] ; 
    $geo = imageDimensions($image, 146, 146) ; 
    //$dimensions = $geo['relative'] ; 
    $dimensions = $geo['dimensions'] ; 
    $margins = ( $geo['padding'] ) ? "style='" . $geo['padding'] . "'" : "" ; 
    $name = "$first_name $last_name" ; 
    echo "            <li><div class='artist-profile-wrapper'><div $margins class='profile-thumbnail'><a href='$permalink'><img src='$imgSrc' $dimensions alt='$name'></a></div><p><a href='$permalink'>$name</a></p></div></li>\n" ;  
}

/*  Create a thumbnail for a work of art, linked to its post  */
function format_gallery_thumbnail($permalink, $image) { 
    $imgSrc = $image[0] ; 
    $geo = imageDimensions($image, 142, 158) ; 
    //$dimensions = $geo['relative'] ; 
    $dimensions = $geo['dimensions'] ; 
    $margins = "style='" . $geo['padding'] . "'" ; 
    echo "            <li $margins><div class='work-of-art'><a href='$permalink'><img src='$imgSrc' $dimensions alt=''></a></div></li>\n" ;  
}

/*
 *  format_gallery -- produce a list of thumbnails of works of art by the specified artist
 *  @param string author_ID The WP user ID of an artist
 *  @returns 
 */
function format_gallery($wpdb, $author_ID) { 

    /*  Get the published posts of type work-of-art by this author  */
    $artwork_query = "
        SELECT $wpdb->posts.* 
        FROM $wpdb->posts 
        WHERE $wpdb->posts.post_type = 'work-of-art'
    	AND $wpdb->posts.post_author = $author_ID 
    ";
    
    $author_posts = $wpdb->get_results($artwork_query);
    global $post; 
    
    echo "    <div id='artwork-gallery'>\n" ; 
    echo "        <ul>\n" ; 
    $works_of_art = array() ; 
    foreach ($author_posts as $post):
        setup_postdata($post);
        $this_title = get_the_title() ;
        $this_permalink = get_permalink() ;
        $art_id = get_the_ID() ; 
        $this_image = wp_get_attachment_image_src( get_post_thumbnail_id( $art_id ), 'artwork-gallery-thumbnail' );
        $works_of_art[] = format_gallery_thumbnail($this_permalink, $this_image, $this_title) ; 
    endforeach; 
    echo "        </ul>\n" ; 
    echo "    </div>\n" ; 
}
?>