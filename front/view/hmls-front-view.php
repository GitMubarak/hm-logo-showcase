<?php
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

$hmls_logos = new WP_Query( $hmls_arr );

if ( $hmls_logos->have_posts() ) {
  ?>
  <div class="hmls-logo-main-wrapper">
    <?php while( $hmls_logos->have_posts() ) : $hmls_logos->the_post(); ?>
    <div class="hmls-logo-item">
      <?php
        if ( has_post_thumbnail() ) {
          the_post_thumbnail();
        } else { ?>
          <img src="<?php echo esc_attr( WBG_ASSETS . 'img/noimage.jpg' ); ?>" alt="No Logo Available">
        <?php
        }
      ?>
    </div>
    <?php endwhile; ?>
  </div>
  <?php
}
/* Restore original Post Data */
wp_reset_postdata();
?>