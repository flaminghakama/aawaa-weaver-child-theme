<!-- BEGIN  index.php  -->
<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Weaver II
 */

weaverii_get_header('index');
if ( weaverii_getopt('wii_infobar_location') == 'top' ) get_template_part('infobar');
weaverii_inject_area('premain');
echo("\t<div id=\"main\">\n");
weaverii_trace_template(__FILE__);
//weaverii_get_sidebar_left('index');
?>
		<div id="container_wrap" class="homepage_slideshow">

<!-- BEGIN adapted content for homepage slideshow -->

<?php

/*
    Return formatted HTML of a selctor.
    Specify a side, either R or L.
*/
function formatSelector($side) {
 
  return "<div class='selector' id='selector_$side'><img src='" . get_stylesheet_directory_uri() . "/images/feature-nav/transparent.png'></div for='selector_$side'>" ;
}

/*
    Return formatted HTML of a feature.
    The feature includes a DIV structure.

    The ID of the enclosing div is based on the slide_count

    If the nav_selectors is 'fake', then no selectors are added.
    Likewise, the class with either be 'feature' or 'feature_fake' 
*/  
function formatFeature($slide_count,$nav_selectors,$feature_url,$image_url,$title,$description,$excerpt) {

  $class = 'feature_fake' ; 
  $selectorL = "" ; 
  $selectorR = "" ; 
  if ( $nav_selectors != "fake" ) {
    $class = 'feature' ; 
    $selectorL = formatSelector('L') ; 
    $selectorR = formatSelector('R') ; 
  }

  $html = "" ; 
  $html .= "<div id='slide_$slide_count' class='$class'>\n" ; 
  $html .= "  <div class='feature_left_col'>\n" ; 

  $html .= $selectorL ; 
  $html .= "    <div class='media'><a href='$feature_url'><img height='372' width='495' src='$image_url'></a></div for='media'>\n" ; 
  $html .= $selectorR ; 
  $html .= "    <div class='meta'><p class='title'><a href='$feature_url'>$title</a></p>\n<p class='description'>$description</p></div for='meta'>\n" ; 
  $html .= "  </div for='feature_left_col'>\n" ;
  $html .= "  <div class='excerpt'>$excerpt</div for='excerpt'>\n" ; 

  $html .= "</div for='slide_$slide_count'>\n" ;

  return $html ; 
}

/*
    Return formatted JavaScript that will add a handler to the specified selector (R or L).
*/
function formatHandler($side) {

  return "   \$(\"#selector_$side\").click( function(){ \n" . 
         "       advanceSlide('$side') ;\n" .
         "       abortTimer() ;\n" . 
         "   }) ;\n" ; 
}

  //  Query for pages with custom variable "Homepage Feature Order" sorted by that variable
  $querystr = "
    SELECT $wpdb->posts.* 
    FROM $wpdb->posts, $wpdb->postmeta
    WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id 
    AND $wpdb->postmeta.meta_key = 'Homepage Feature Order' 
    AND $wpdb->posts.post_status = 'publish' 
    AND $wpdb->posts.post_type = 'post'
    ORDER BY $wpdb->postmeta.meta_value ASC
  ";

  $pageposts = $wpdb->get_results($querystr, OBJECT);
  global $post; 

  // collect the featured posts
  $featured = array() ; 
  $slide_count = 0 ; 
  // collect the featured nav selectors
  $reference_slides = "" ; 
  $next_slides = "" ; 
  $prev_slides = "" ; 
  $duration = 3000 ; 

  //                          
  // loop through the posts.
  //                          
  foreach ($pageposts as $post): 

    setup_postdata($post); 
    $single = true ; 

    // Get the nav 
    $order = get_post_meta( $post->ID, 'Homepage Feature Order', $single ); 
    $title = get_the_title() ;
    $description = get_post_meta( $post->ID, 'Homepage Feature Description', $single ); 
    $this_duration = get_post_meta( $post->ID, 'Homepage Feature Duration', $single ); 

    //echo "<p>title is $title</p>\n" ; 

    if (( $order == "" ) || ( $order < 1 )) { 
      echo "<!-- omitting homepage feature '$title' since order = '$order' -->\n" ; 
      continue ; 
    }
    echo "<!-- including homepage feature '$title' since order = '$order' -->\n" ; 

    // Get the featured image and excerpt
    $image_url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
    $excerpt = $post->post_excerpt ; 

     // Get the URL of the actual featured page 
    $slug = get_post_meta( $post->ID, 'Homepage Feature Slug', $single ); 
    $feature_url = get_site_url() . "/$slug" ; 

    // Populate this feature
    $this_feature['order'] = $order ; 
    $this_feature['ID'] = $post->ID ;
    $this_feature['image_url'] = $image_url ;
    $this_feature['excerpt'] = $excerpt ;
    $this_feature['slug'] = $slug ;
    $this_feature['feature_url'] = $feature_url ;
    $this_feature['order'] = $order ;
    $this_feature['title'] = $title ;
    $this_feature['description'] = $description ;
    $this_feature['duration'] = $this_duration ;

    // Add this feature to the list
    $last_slide = $slide_count ; 
    $slide_count++ ;    
    $featured[$slide_count] = $this_feature ;

    if ( $slide_count == 1 ) { 
      if ( $this_duration != "" ) { 
         $duration = $this_duration ; 
      }
    } else { 
      $next_slides .= "next_slide['slide_$last_slide'] = 'slide_$slide_count' ;\n" ;  
      $prev_slides .= "prev_slide['slide_$slide_count'] = 'slide_$last_slide' ;\n" ;  
    }

    echo "<!-- adding to reference slide $slide_count -->\n" ; 
    $reference_slides .= formatFeature($slide_count,'fake',$feature_url,$image_url,$title,$description,$excerpt) ; 

  endforeach;

  $next_slides .= "next_slide['slide_$slide_count'] = 'slide_1' ;\n" ;  
  $prev_slides .= "prev_slide['slide_1'] = 'slide_$slide_count' ;\n" ;  

  $this_feature = $featured[1] ; 
  echo formatFeature('visible','real',$this_feature[feature_url],$this_feature[image_url],$this_feature[title],$this_feature[description],$this_feature[excerpt]) ; 
  echo $reference_slides ; 
?>

<!-- Javascript to control homepage slidshow -->

<script src="<?php echo get_stylesheet_directory_uri() ; ?>/js/jquery-1.6.1.js" type="text/javascript"></script>
<script language="JavaScript">

/*  Change the contents of the featured slide based on the specified reference slide ID.  */
function updateFeature(selector_id) {

  selector = "#" + selector_id ; 

  //alert('in updateFeature with slide ' + selector_id) ; 

  var excerpt = $(selector + " div.excerpt").html() ; 
  var feature_url = $(selector + " div.media a").attr("href") ; 
  var image_url = $(selector + " div.media img").attr("src") ; 
  var title = $(selector + " div.meta p.title a").text() ; 
  var description = $(selector + " div.meta p.description").html() ;

  //alert('title is ' + title) ; 

  var length_out = 1200 ; 
  var length_in = 700 ; 
  $("div.feature div.excerpt").fadeOut(function() { length_out,
    $(this).html(excerpt).fadeIn(length_in) ;
  }) ;  
  $("div.feature div.media img").fadeOut(function() {length_out,
    $(this).attr({src: image_url}).fadeIn(length_in); 
  });
  $("div.feature div.meta p.title a").fadeOut(function() {length_out,
    $(this).text(title).fadeIn(length_in); 
  });

  $("div.feature div.meta p.description").html(description) ;
  $("div.feature div.media a").prop("href", feature_url) ;
  $("div.feature div.meta p.title a").prop("href", feature_url) ;

  abortTimer() ;
  timer_id = setInterval(cycleFeature, <?php echo $duration ; ?>); 
}

function flickerNav(side) {

  var selector = '#selector_' + side ;  
  //alert('in flickerNav with ' + selector) ; 
  var length_out = 6 ; 
  var length_in = 60 ; 
  $(selector).fadeOut(function() { length_out,
    $(selector).addClass("blink").removeClass("blink").fadeIn(length_in) ;
  }) ;  
} 

function showNextSlide() {
  var slide_id = next_slide[current_slide] ; 
  updateFeature(slide_id) ; 
  flickerNav('R') ;   
  current_slide = slide_id ; 
}

function showPrevSlide() {
  var slide_id = prev_slide[current_slide] ; 
  updateFeature(slide_id) ; 
  flickerNav('L') ; 
  current_slide = slide_id ; 
}

function advanceSlide(direction) { 
  if (direction == 'L') { 
    showPrevSlide() ; 
  } else { 
    showNextSlide() ; 
  }
}

function cycleFeature() { 

  //  Determine the next selector
  var slide_id = next_slide[current_slide] ; 

  //  update the slide
  updateFeature(slide_id)  ; 
  flickerNav('R') ; 

  current_slide = slide_id ; 
}

function abortTimer() { // to be called when you want to stop the timer
  clearInterval(timer_id);
}

var timer_id = "" ; 
var current_slide = "slide_1" ; 

var next_slide = new Array(); 
<?php echo $next_slides ; ?>

var prev_slide = new Array(); 
<?php echo $prev_slides ; ?>

$( document ).ready(function() {

  //alert('In document ready') ; 

<?php 
  echo formatHandler('L') ; 
  echo formatHandler('R') ; 
?>

  timer_id = setInterval(cycleFeature, <?php echo $duration ; ?>); 
}) ; 
</script>

<!-- END adapted content for homepage slideshow -->



<?php		if ( weaverii_getopt('wii_infobar_location') == 'content' ) get_template_part('infobar');
		weaverii_inject_area('precontent'); ?>
		<div id="container" class="cf index-posts">
<?php		weaverii_get_sidebar_top('index'); ?>
		    <div id="content" class = "cf" role="main">

<?php 			if ( have_posts() ) {

                          /*
			    $paged = weaverii_get_page();

			    weaverii_content_nav( 'nav-above' );
			    $col = 0;
			    $num_cols = weaverii_use_mobile('mobile') ? 1 : weaverii_getopt('wii_blog_cols');
			    if (!$num_cols || $num_cols > 3) $num_cols = 1;

			    $sticky_one = weaverii_getopt_checked( 'wii_blog_sticky_one' ) && $paged <= 1;
			    $first_one = weaverii_getopt_checked( 'wii_blog_first_one' ) && $paged <= 1;
			    $masonry_wrap = false;	// need this for one-column posts

			    weaverii_post_count_clear();

			    while ( have_posts() ) {
				the_post();
				weaverii_post_count_bump();

				if ( is_sticky() && $sticky_one) {
				    get_template_part( 'content', get_post_format() );
				} else if ( $first_one ) {
				    get_template_part( 'content', get_post_format() );
				    $first_one = false;
				} else {
				if (!$masonry_wrap) {
				    $masonry_wrap = true;
				    if (weaverii_masonry('begin-posts'))	// wrap all posts
					$num_cols = 1;		// force to 1 cols
				}
				weaverii_masonry('begin-post');	// wrap each post
				switch ($num_cols) {
				case 1:
				    get_template_part( 'content', get_post_format() );
				    $sticky_one = false;
				    break;
				case 2:
				    echo ('<div class="content-2-col cf">' . "\n");
				    get_template_part( 'content', get_post_format() );
				    echo ("</div> <!-- content-2-col -->\n");
				    $col++;
				    if ( !($col % 2) ) {	// force stuff to be even
					echo "<div style=\"clear:left;\"></div>\n";
				    }
				    $sticky_one = false;
				    break;
				case 3:
				    echo ('<div class="content-3-col cf">' . "\n");
				    get_template_part( 'content', get_post_format() );
				    echo ("</div> <!-- content-3-col -->\n");
				    $col++;
				    if ( !($col % 3) ) {	// force stuff to be even
					echo "<div style=\"clear:left;\"></div>\n";
				    }
				    $sticky_one = false;
				    break;
				default:
				    get_template_part( 'content', get_post_format() );
				    $sticky_one = false;
				}   // end switch num cols
				weaverii_masonry('end-post');
				} /* end first one col * /

			    }	// end while have posts
			    weaverii_masonry('end-posts');
			    weaverii_content_nav( 'nav-below' );
                          */
			} else {
			    weaver_not_found_search(__FILE__);
			} 
                         ?>

		    </div><!-- #content -->
<?php		weaverii_get_sidebar_bottom('index'); ?>
		</div><!-- #container -->
		</div><!-- #container_wrap -->

<?php 	weaverii_get_sidebar_right('index');
	weaverii_get_footer('index');
?>
<!-- END  index.php  -->
