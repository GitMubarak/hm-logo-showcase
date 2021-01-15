<?php
$hmlsShowGridMessage = false;

if ( isset( $_POST['updateGridSettings'] ) ) {
    
    $hmlsGridSettingsInfo = array(
        'hmls_cols_desktop'   => isset( $_POST['hmls_cols_desktop'] ) && filter_var( $_POST['hmls_cols_desktop'], FILTER_SANITIZE_NUMBER_INT ) ? $_POST['hmls_cols_desktop'] : 4,
    );
    
    $hmlsShowGridMessage = update_option( 'hmls_grid_settings', serialize( $hmlsGridSettingsInfo ) );
}

$hmlsGridSettings   = stripslashes_deep( unserialize( get_option('hmls_grid_settings') ) );
$hmls_cols_desktop  = isset( $hmlsGridSettings['hmls_cols_desktop'] ) ? $hmlsGridSettings['hmls_cols_desktop'] : 4;
?>
<div id="wph-wrap-all" class="wrap hmls-grid-settings-page">
    
    <div class="settings-banner">
        <h2><?php esc_html_e('Grid Layout', HMLS_TXT_DOMAIN); ?></h2>
    </div>

    <?php 
        if ( $hmlsShowGridMessage ) {
            $this->hmls_display_notification('success', 'Your information updated successfully.');
        }
    ?>

    <div class="hmacs-wrap">

        <nav class="nav-tab-wrapper">
            <a href="?post_type=hmls_logo&page=hmls-grid-settings&tab=settings" class="nav-tab <?php if ( $tab != 'styles' ) { ?>nav-tab-active<?php } ?>">Settings</a>
            <a href="?post_type=hmls_logo&page=hmls-grid-settings&tab=styles" class="nav-tab <?php if ( $tab === 'styles' ) { ?>nav-tab-active<?php } ?>">Styles</a>
        </nav>

        <div class="hmacs_personal_wrap hmacs_personal_help" style="width: 845px; float: left; margin-top: 5px;">
            <div class="tab-content">
                <?php 
                switch ( $tab ) {
                    case 'styles':
                        ?>
                        <h3><?php _e('Styles Settings', HMLS_TXT_DOMAIN); ?></h3>
                        <?php
                        _e('Will be added shortly.', HMLS_TXT_DOMAIN);
                        break;
                    default:
                        ?>
                        <h3><?php _e('Content Settings', HMLS_TXT_DOMAIN); ?></h3>
                        <form name="hmls_grid_settings_form" role="form" class="form-horizontal" method="post" action="" id="hmls-grid-settings-form">
                            <table class="hmls-grid-settings-table">
                                <tr class="hmls_cols_desktop">
                                    <th scope="row">
                                        <label for="hmls_cols_desktop"><?php esc_html_e('Logo Columns Desktop :', HMLS_TXT_DOMAIN); ?></label>
                                    </th>
                                    <td>
                                        <select name="hmls_cols_desktop" class="medium-text">
                                            <option value="2" <?php echo ( 2 == $hmls_cols_desktop ) ? 'selected' : ''; ?> ><?php esc_html_e('2', HMLS_TXT_DOMAIN); ?></option>
                                            <option value="3" <?php echo ( 3 == $hmls_cols_desktop ) ? 'selected' : ''; ?> ><?php esc_html_e('3', HMLS_TXT_DOMAIN); ?></option>
                                            <option value="4" <?php echo ( 4 == $hmls_cols_desktop ) ? 'selected' : ''; ?> ><?php esc_html_e('4', HMLS_TXT_DOMAIN); ?></option>
                                            <option value="5" <?php echo ( 5 == $hmls_cols_desktop ) ? 'selected' : ''; ?> ><?php esc_html_e('5', HMLS_TXT_DOMAIN); ?></option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                            <p class="submit"><button id="updateGridSettings" name="updateGridSettings" class="button button-primary"><?php esc_attr_e('Save Changes', HMLS_TXT_DOMAIN); ?></button></p>
                        </form>
                        <?php
                        break;
                } 
                ?>
            </div>
        </div>

        <?php $this->hmls_admin_sidebar(); ?>

    </div>

</div>