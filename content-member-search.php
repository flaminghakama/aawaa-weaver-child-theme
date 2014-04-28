<!-- BEGIN  content-member-search.php  -->
<?php
/*
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

<div id="profile-gallery">
<?php
 
    format_profile_gallery($wpdb, array('artist-profile', 'affiliate-profile')) ;   
?>
</div id="profile-gallery">
<!-- END  content-member-search.php  -->
