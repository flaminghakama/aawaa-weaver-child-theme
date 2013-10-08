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
    Return formatted HTML of a feature.
    The feature includes a DIV structure.

    The ID of the enclosing div is based on the slide_count
    If the nav_selectors is 'fake', then no feature nav is added.
    Likewise, the class with either be 'actual' 

    If the nav_selectors is 'fake', then no feature nav is added.
    Otherwise, the nav_selectors is used as the content of the feature_nav.
*/  
function formatFeature($slide_count,$nav_selectors,$feature_url,$image_url,$title,$description,$excerpt) {

  $class = 'fake' ; 
  $nav = "<!-- no feature_nav -->\n" ; 
  if ( $nav_selectors != "fake" ) {
    $class = 'actual' ; 
    $nav = "      <div class='feature_nav'>$nav_selectors</div for='feature_nav'>\n" ; 
  }

  $html = "" ; 
  $html .= "<div id='slide_$slide_count' class='feature $class'>\n" ; 
  $html .= "  <div class='feature_left_col'>\n" ; 
  $html .= "    <div class='media'><a href='$feature_url'><img src='$image_url'></a></div for='media'>\n" ; 
  $html .= "    <div class='bottom_left'>\n" ;
  $html .= "      <div class='meta'><p class='title'><a href='$feature_url'>$title</a></p>\n<p class='description'>$description</p></div for='meta'>\n" ; 
  $html .= $nav ; 
  $html .= "    </div for='bottom_left'>\n" ;
  $html .= "  </div for='feature_left_col'>\n" ;
  $html .= "  <div class='excerpt'>$excerpt</div for='excerpt'>\n" ; 

  $html .= "</div for='slide_$slide_count'>\n" ;

  return $html ; 
}

function formatSelector($slide_count, $class) {
 
  return "<div class='selector $class' id='selector_$slide_count'><img src='" . get_stylesheet_directory_uri() . "/images/feature-nav/transparent.png'></div for='selector_$slide_count'>" ;
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
  $selectors = "" ; 
  $reference_slides = "" ; 
  $next_slides = "" ; 
  $next_selectors = "" ; 
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
      $selectors .= formatSelector($slide_count, 'selected') ; 
      if ( $this_duration != "" ) { 
         $duration = $this_duration ; 
      }
    } else { 
      $selectors .= formatSelector($slide_count, 'not_selected') ;
      $next_slides .= "next_slide['slide_$last_slide'] = 'slide_$slide_count' ;\n" ;  
      $next_selectors .= "next_selector['slide_$last_slide'] = 'selector_$slide_count' ;\n" ;  
    }

    echo "<!-- adding to reference slide $slide_count -->\n" ; 
    $reference_slides .= formatFeature($slide_count,'fake',$feature_url,$image_url,$title,$description,$excerpt) ; 

  endforeach;

  $next_slides .= "next_slide['slide_$slide_count'] = 'slide_1' ;\n" ;  
  $next_selectors .= "next_selector['slide_$slide_count'] = 'selector_1' ;\n" ;  

  $this_feature = $featured[1] ; 
  echo formatFeature('visible',$selectors,$this_feature[feature_url],$this_feature[image_url],$this_feature[title],$this_feature[description],$this_feature[excerpt]) ; 
  echo $reference_slides ; 
?>


<!-- Javascript to control homepage slidshow -->

<script src="<?php echo get_stylesheet_directory_uri() ; ?>/js/jquery-1.6.1.js" type="text/javascript"></script>
<script language="JavaScript">

function updateFeature(selector_id) {

  selector = "#" + selector_id ; 

  //alert('in updateFeature with slide ' + selector) ; 

  var excerpt = $(selector + " div.excerpt").html() ; 
  var feature_url = $(selector + " div.media a").attr("href") ; 
  var image_url = $(selector + " div.media img").attr("src") ; 
  var title = $(selector + " div.meta p.title a").text() ; 
  var description = $(selector + " div.meta p.description").html() ;

  //alert('title is ' + title) ; 

  var length_out = 1200 ; 
  var length_in = 700 ; 
  $("div.feature.actual div.excerpt").fadeOut(function() { length_out,
    $(this).html(excerpt).fadeIn(length_in) ;
  }) ;  
  $("div.feature.actual div.media img").fadeOut(function() {length_out,
    $(this).attr({src: image_url}).fadeIn(length_in); 
  });
  $("div.feature.actual div.meta p.title a").fadeOut(function() {length_out,
    $(this).text(title).fadeIn(length_in); 
  });

  $("div.feature.actual div.meta p.description").html(description) ;
  $("div.feature.actual div.media a").prop("href", feature_url) ;
  $("div.feature.actual div.meta p.title a").prop("href", feature_url) ;

  abortTimer() ;
  timer_id = setInterval(cycleFeature, <?php echo $duration ; ?>); 
}

function updateNav(selector_id) {

  var length_out = 6 ; 
  var length_in = 60 ; 
  $("div.selector.selected").fadeOut(function() { length_out,
    $(this).removeClass("selected not_selected").addClass("not_selected").fadeIn(length_in) ;
  }) ;    
  $("#" + selector_id).fadeOut(function() { length_out,
    $(this).removeClass("selected not_selected").addClass("selected").fadeIn(length_in) ;
  }) ;  

  abortTimer() ;
  timer_id = setInterval(cycleFeature, <?php echo $duration ; ?>);   
} 

var timer_id = "" ; 
var current_slide = "slide_1" ; 

var next_slide = new Array(); 
<?php echo $next_slides ; ?>

var next_selector = new Array(); 
<?php echo $next_selectors ; ?>

function cycleFeature() { 
  //  alert("in cycleFeature with current_slide " + current_slide) ; 
  //  Determine the next selector
  var slide_id = next_slide[current_slide] ; 
  var selector_id = next_selector[current_slide] ; 
 
  //  update the slide
  updateFeature(slide_id)  ; 
  updateNav(selector_id) ; 

  current_slide = slide_id ; 
}

function abortTimer() { // to be called when you want to stop the timer
  clearInterval(timer_id);
}

$( document ).ready(function() {
<?php 
  foreach ($featured as $slide_count=>$f):  

    echo "\n// slide_count $slide_count \n" ; 

    $handler = "   \$(\"#selector_$slide_count\").click( function(){ \n" . 
               "       updateFeature('slide_" . $slide_count . "') ;\n" .
               "       updateNav('selector_" . $slide_count . "') ;\n" . 
               "       abortTimer() ;\n" . 
               "   }) ;\n" ; 

    echo $handler ; 

  endforeach; 
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
