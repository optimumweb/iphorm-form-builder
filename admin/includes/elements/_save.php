<?php if (!defined('IPHORM_VERSION')) exit; ?><tr class="ifb-save-element-tr" valign="top">
    <td colspan="2">
        <div class="ifb-save-element-wrap clearfix">
            <?php if (isset($helpUrl)) : ?>
                <a class="ifb-help-element" href="<?php echo esc_attr($helpUrl); ?>"><?php esc_html_e('Help', 'iphorm'); ?></a>
            <?php endif; ?>
            <a class="ifb-save-element" onclick="iPhorm.saveElementSettings(this, '<?php echo wp_create_nonce('iphorm_save_form'); ?>'); return false;"><?php esc_html_e('Save', 'iphorm'); ?></a>
            <a class="ifb-close-element" onclick="iPhorm.hideSettings(<?php echo $id; ?>); return false;"><?php esc_html_e('Hide', 'iphorm'); ?></a>
            <a class="ifb-save-close-element" onclick="iPhorm.saveAndCloseElementSettings('<?php echo wp_create_nonce('iphorm_save_form'); ?>', <?php echo $id; ?>); return false;"><?php esc_html_e('Save & Hide', 'iphorm'); ?></a>
        </div>
    </td>
</tr>