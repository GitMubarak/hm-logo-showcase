<?php
global $post;
// Shortcoded Options
$hmlsCategory  = isset( $hmlsAttr['category'] ) ? $hmlsAttr['category'] : '';

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

$hmls_logos = new WP_Query( $hmls_arr );

if ( $hmls_logos->have_posts() ) {
  ?>
  <div class="hmls-logo-main-wrapper">
    <?php while( $hmls_logos->have_posts() ) : $hmls_logos->the_post(); ?>
    <div class="hmls-logo-item">
      <?php
        $hmls_logo_url = get_post_meta( $post->ID, 'hmls_logo_url', true );
        ?>
        <a href="<?php echo esc_url( $hmls_logo_url ); ?>" target="_blank">
        <?php
          if ( has_post_thumbnail() ) {
            the_post_thumbnail();
          } else { ?>
            <img src="<?php echo esc_attr( HMLS_ASSETS . 'img/noimage.jpg' ); ?>" alt="<?php esc_attr_e( 'No Logo Found', HMLS_TXT_DOMAIN ); ?>">
          <?php
          }
        ?>
        </a>
    </div>
    <?php endwhile; ?>
  </div>
  <?php
}
/* Restore original Post Data */
wp_reset_postdata();
?>