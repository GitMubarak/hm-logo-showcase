<div class="hmls-logo-main-wrapper <?php echo esc_attr( 'hmls-cols-desktop-' . $hmls_cols_desktop ); ?>">
    <?php 
    while ( $hmls_logos->have_posts() ) {
        $hmls_logos->the_post(); 
        ?>
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
        <?php
    }
    ?>
  </div>