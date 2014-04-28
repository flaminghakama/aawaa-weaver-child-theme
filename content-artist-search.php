<!-- BEGIN  content-artist-search.php  -->
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
 
    /* See what the query is 
         by name 
         by location
         by media
         by discipline
         by keyword
     */

    /*  Get the published posts of type work-of-art by this author  */
    $profile_query = "
        SELECT DISTINCT t.*
        FROM wp_terms AS t
        INNER JOIN wp_term_taxonomy AS tt
            ON t.term_id = tt.term_id
        JOIN wp_term_relationships AS tr
            ON tr.term_taxonomy_id = tt.term_taxonomy_id
        JOIN wp_posts AS p
            ON p.ID = tr.object_id
        WHERE tt.taxonomy IN ('location', 'media', 'artistic-discipline', 'ethnicity')
        AND p.post_type = 'artist-profile'
        ORDER BY t.name ASC";

    format_profile_gallery($wpdb, array('artist-profile')) ;   
?>
</div id="profile-gallery">
<!-- END  content-artist-search.php  -->
