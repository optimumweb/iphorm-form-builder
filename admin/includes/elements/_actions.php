<?php if (!defined('IPHORM_VERSION')) exit; ?><div class="ifb-element-actions">
    <a class="ifb-close-link" title="<?php esc_attr_e('Hide settings - you will not lose unsaved data!', 'iphorm'); ?>" href="#" onclick="iPhorm.hideSettings(<?php echo $id; ?>); return false;"><span></span><?php esc_html_e('Hide', 'iphorm'); ?></a>
    <a class="ifb-settings-link" title="<?php esc_attr_e('Settings', 'iphorm'); ?>" href="#" onclick="iPhorm.showSettings(<?php echo $id; ?>); return false;"><span></span><?php esc_html_e('Settings', 'iphorm'); ?></a>
    <a class="ifb-delete-link" title="<?php esc_attr_e('Delete this element', 'iphorm'); ?>" href="#" onclick="iPhorm.deleteElement(<?php echo $id; ?>); return false;"><?php esc_html_e('Delete', 'iphorm'); ?></a>
    <a class="ifb-move-link" title="<?php esc_attr_e('Click and drag to move this element', 'iphorm'); ?>" href="#" onclick="return false;"><span></span><?php esc_html_e('Move', 'iphorm'); ?></a>
</div>