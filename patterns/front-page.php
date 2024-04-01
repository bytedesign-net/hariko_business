<?php
/**
 * Title: front-page
 * Slug: hariko_blog/front-page
 * Categories: hidden
 * Inserter: no
 */
?>
<!-- wp:template-part {"slug":"header","tagName":"header","area":"header"} /-->

<!-- wp:cover {"url":"<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/images/hero.jpg","id":57,"dimRatio":0,"isDark":false,"style":{"spacing":{"margin":{"top":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-cover is-light" style="margin-top:0"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span><img class="wp-block-cover__image-background wp-image-57" alt="" src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/images/hero.jpg" data-object-fit="cover"/><div class="wp-block-cover__inner-container"><!-- wp:site-title {"isLink":false,"fontSize":"xxxxxxl"} /-->

<!-- wp:site-tagline /--></div></div>
<!-- /wp:cover -->

<!-- wp:group {"tagName":"main","style":{"spacing":{"margin":{"top":"var:preset|spacing|l"}}},"layout":{"type":"constrained"}} -->
<main class="wp-block-group" style="margin-top:var(--wp--preset--spacing--l)"><!-- wp:group {"style":{"border":{"radius":"8px"}},"backgroundColor":"base-2"} -->
<div class="wp-block-group has-base-2-background-color has-background" style="border-radius:8px"><!-- wp:group -->
<div class="wp-block-group"><!-- wp:template-part {"slug":"posts"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group --></main>
<!-- /wp:group -->

<!-- wp:template-part {"slug":"footer","tagName":"footer"} /-->