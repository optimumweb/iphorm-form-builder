<?php if (!defined('IPHORM_VERSION')) exit; ?><div id="top" class="wrap">
	<div class="iphorm-top-right">
        <div class="iphorm-information">
        	<span class="iphorm-copyright"><a href="http://www.themecatcher.net" onclick="window.open(this.href); return false;">www.themecatcher.net</a> &copy; <?php echo date('Y'); ?></span>
        	<span class="iphorm-bug-link"><a href="http://www.themecatcher.net/support.php" onclick="window.open(this.href); return false;"><?php esc_html_e('Report a bug', 'iphorm'); ?></a></span>
        	<span class="iphorm-help-link"><a href="<?php echo iphorm_help_link(); ?>" onclick="window.open(this.href); return false;"><?php esc_html_e('Help', 'iphorm'); ?></a></span>
        </div>
    </div>
    <?php screen_icon('iphorm'); ?>
    <h2 class="ifb-main-title"><span class="ifb-iphorm-title">Quform</span><?php esc_html_e('Help', 'iphorm'); ?></h2>
    <?php if (strlen(get_option('iphorm_licence_key'))) : ?>
        <div class="iphorm-help-wrap clearfix">
            <?php iphorm_global_nav('help'); ?>

        	<div class="iphorm-global-sub-nav-wrap clearfix">
            	<ul class="iphorm-global-sub-nav-ul">
                	<li><a href="<?php echo iphorm_help_link(); ?>"><span class="ifb-no-arrow"><?php esc_html_e('Basics', 'iphorm'); ?></span></a></li>
                    <li><a href="<?php echo iphorm_help_link('elements'); ?>"><span class="ifb-no-arrow"><?php esc_html_e('Elements', 'iphorm'); ?></span></a></li>
                    <li><a href="<?php echo iphorm_help_link('settings'); ?>"><span class="ifb-no-arrow"><?php esc_html_e('Settings', 'iphorm'); ?></span></a></li>
                    <li><a href="<?php echo iphorm_help_link('faq'); ?>" title="<?php esc_attr_e('Frequently asked questions', 'iphorm'); ?>"><span class="ifb-no-arrow"><?php esc_html_e('FAQ', 'iphorm'); ?></span></a></li>
                </ul>
            </div>
            <?php
                switch ($section) {
                    case 'basics':
                    default:
                        include IPHORM_ADMIN_INCLUDES_DIR . '/help/basics.php';
                        break;
                    case 'elements':
                        include IPHORM_ADMIN_INCLUDES_DIR . '/help/elements.php';
                        break;
                    case 'settings':
                        include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings.php';
                        break;
                    case 'faq':
                        include IPHORM_ADMIN_INCLUDES_DIR . '/help/faq.php';
                        break;
                    case 'element-text':
                        include IPHORM_ADMIN_INCLUDES_DIR . '/help/element-text.php';
                        break;
                    case 'element-textarea':
                        include IPHORM_ADMIN_INCLUDES_DIR . '/help/element-textarea.php';
                        break;
                    case 'element-email':
                        include IPHORM_ADMIN_INCLUDES_DIR . '/help/element-email.php';
                        break;
                    case 'element-select':
                        include IPHORM_ADMIN_INCLUDES_DIR . '/help/element-select.php';
                        break;
                    case 'element-checkbox':
                        include IPHORM_ADMIN_INCLUDES_DIR . '/help/element-checkbox.php';
                        break;
                    case 'element-radio':
                        include IPHORM_ADMIN_INCLUDES_DIR . '/help/element-radio.php';
                        break;
                    case 'element-captcha':
                        include IPHORM_ADMIN_INCLUDES_DIR . '/help/element-captcha.php';
                        break;
                    case 'element-captcha':
                        include IPHORM_ADMIN_INCLUDES_DIR . '/help/element-captcha.php';
                        break;
                    case 'element-group':
                        include IPHORM_ADMIN_INCLUDES_DIR . '/help/element-group.php';
                        break;
                    case 'element-file':
                        include IPHORM_ADMIN_INCLUDES_DIR . '/help/element-file.php';
                        break;
                    case 'element-recaptcha':
                        include IPHORM_ADMIN_INCLUDES_DIR . '/help/element-recaptcha.php';
                        break;
                    case 'element-html':
                        include IPHORM_ADMIN_INCLUDES_DIR . '/help/element-html.php';
                        break;
                    case 'element-date':
                        include IPHORM_ADMIN_INCLUDES_DIR . '/help/element-date.php';
                        break;
                    case 'element-time':
                        include IPHORM_ADMIN_INCLUDES_DIR . '/help/element-time.php';
                        break;
                    case 'element-hidden':
                        include IPHORM_ADMIN_INCLUDES_DIR . '/help/element-hidden.php';
                        break;
                    case 'element-password':
                        include IPHORM_ADMIN_INCLUDES_DIR . '/help/element-password.php';
                        break;
                    case 'settings-global':
                        include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings-global.php';
                        break;
                    case 'settings-general':
                        include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings-general.php';
                        break;
                    case 'settings-email':
                        include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings-email.php';
                        break;
                    case 'settings-style':
                        include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings-style.php';
                        break;
                    case 'settings-entries':
                        include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings-entries.php';
                        break;
                    case 'settings-database':
                        include IPHORM_ADMIN_INCLUDES_DIR . '/help/settings-database.php';
                        break;
                }
            ?>
        </div>
    <?php else : ?>
        <?php echo '<div class="error"><p><strong>' . sprintf(esc_html__('You are using an unlicensed version. Please %senter your license key%s or %spurchase a license key%s.', 'iphorm'), '<a href="' . admin_url('admin.php?page=iphorm_settings') .'">', '</a>', '<a href="http://www.themecatcher.net/iphorm-form-builder/buy.php" onclick="window.open(this.href); return false;">', '</a>') . '</strong></p></div>'; ?>
        <p><?php esc_html_e('Help is not available in the unlicensed version.', 'iphorm'); ?></p>
    <?php endif; ?>
</div>