<?php
/**
 * Title: Query Grid
 * Slug: patterns-automotive/query-grid
 * Categories: query
 * Block Types: core/query
 * Description: Display a query block in a grid layout.
 *
 * @package    Patterns_Automotive
 * @subpackage Patterns_Automotive/patterns
 * @since      1.0.0
 */

?>
<!-- wp:query {"query":{"inherit":true,"postType":"post"},"align":"wide","layout":{"type":"constrained"}} -->
<div class="wp-block-query alignwide"><!-- wp:post-template {"align":"wide","layout":{"type":"grid","columnCount":2}} -->

<!-- wp:post-title {"isLink":true} /-->

<!-- wp:pattern {"slug":"patterns-automotive/post-meta"} /-->

<!-- wp:post-featured-image {"isLink":true,"width":"100%","height":"clamp(15vw, 30vh, 400px)","align":"wide","style":{"spacing":{"margin":{"bottom":"20px"}}}} /-->

<!-- wp:post-excerpt {"moreText":""} /-->

<!-- wp:spacer {"height":"40px"} -->
<div style="height:40px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->
<!-- /wp:post-template -->

<?php
	// Need to include from PHP since wp:pattern not working
	// <!-- wp:pattern {"slug":"patterns-automotive/pagination"} /-->
	// <!-- wp:pattern {"slug":"patterns-automotive/hidden-query-no-results"} /--> .
	require 'pagination.php';
	require 'hidden-query-no-results.php';
?>

</div>
<!-- /wp:query -->
