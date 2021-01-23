<?php
global $post;

$hmlsGridSettings   = stripslashes_deep( unserialize( get_option('hmls_grid_settings') ) );
$hmls_cols_desktop  = isset( $hmlsGridSettings['hmls_cols_desktop'] ) ? $hmlsGridSettings['hmls_cols_desktop'] : 4;

// Shortcoded Options
$hmlsCategory = isset( $hmlsAttr['category'] ) ? $hmlsAttr['category'] : '';
$hmlsDisplay  = isset( $hmlsAttr['display'] ) ? $hmlsAttr['display'] : '';
$hmlsLayout   = isset( $hmlsAttr['layout'] ) ? $hmlsAttr['layout'] : '';

$hmls_arr = array(
                  'post_type' => 'hmls_logo',
                  'post_status' => 'publish',
                  'order' => 'DESC',
                  'meta_query' => array(
                                        'relation' => 'and',
                                          array(
                                            'key' => 'hmls_status',
                                            'value' => 'active',
                                            'compare' => '='
                                          ),
                                      ),
                );

// If Categor params found in shortcode
if ( $hmlsCategory ) {
  $hmls_arr['tax_query'] = array(
                                    array(
                                      'taxonomy'  => 'logo_category',
                                      'field'     => 'slug',
                                      'terms'     => $hmlsCategory
                                    )
                                  );
}

// If display params found in shortcode
if ( $hmlsDisplay ) {
  $hmls_arr['posts_per_page'] = $hmlsDisplay;
}

$hmls_logos = new WP_Query( $hmls_arr );

if ( $hmls_logos->have_posts() ) {

  // If layout params found in shortcode
  if ( $hmlsLayout ) {
    if ( 'grid' === $hmlsLayout ) {
      include HMLS_PATH . 'front/view/layout/hmls-display-grid.php';
    }
    if ( 'slide' === $hmlsLayout ) {
      include HMLS_PATH . 'front/view/layout/hmls-display-slide.php';
    }
  }
}
/* Restore original Post Data */
wp_reset_postdata();
?>