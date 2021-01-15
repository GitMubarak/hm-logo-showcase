<?php
// Coming Soon
?>
<div id="wph-wrap-all" class="wrap hmls-general-settings-page">
    
    <div class="settings-banner">
        <h2><?php esc_html_e('General Information', HMLS_TXT_DOMAIN); ?></h2>
    </div>

    <div class="hmacs-wrap">

        <nav class="nav-tab-wrapper">
            <a href="?post_type=hmls_logo&page=hmls-general-settings&tab=settings" class="nav-tab <?php if ( $tab != 'styles' ) { ?>nav-tab-active<?php } ?>">Settings</a>
            <a href="?post_type=hmls_logo&page=hmls-general-settings&tab=styles" class="nav-tab <?php if ( $tab === 'styles' ) { ?>nav-tab-active<?php } ?>">Styles</a>
        </nav>

        <div class="hmacs_personal_wrap hmacs_personal_help" style="width: 845px; float: left; margin-top: 5px;">
            <div class="tab-content">
                <?php 
                switch ( $tab ) {
                    case 'styles':
                        _e('Will be added shortly', HMLS_TXT_DOMAIN);
                        break;
                    default:
                        _e('Will be added shortly', HMLS_TXT_DOMAIN);
                        break;
                } 
                ?>
            </div>
        </div>

        <?php $this->hmls_admin_sidebar(); ?>

    </div>

</div>