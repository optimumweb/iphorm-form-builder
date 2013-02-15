<?php if (!defined('IPHORM_VERSION')) exit; ?><div id="ifb-filter-wrap-<?php echo $filter['element_id']; ?>-<?php echo $filter['id']; ?>" class="ifb-filter ifb-filter-alphanumeric">
    <div class="ifb-filter-actions">
        <a class="ifb-filter-close-link" title="<?php esc_attr_e('Hide filter settings', 'iphorm'); ?>" href="#" onclick="iPhorm.hideFilterSettings(<?php echo $filter['element_id']; ?>, <?php echo $filter['id']; ?>); return false;"><span></span><?php esc_html_e('Hide', 'iphorm'); ?></a>
        <a class="ifb-filter-settings-link" title="<?php esc_attr_e('Settings', 'iphorm'); ?>" href="#" onclick="iPhorm.showFilterSettings(<?php echo $filter['element_id']; ?>, <?php echo $filter['id']; ?>); return false;"><span></span><?php esc_html_e('Settings', 'iphorm'); ?></a>
        <a class="ifb-filter-delete-link" title="<?php esc_attr_e('Delete this filter', 'iphorm'); ?>" href="#" onclick="iPhorm.deleteFilter(iPhorm.getElementById(<?php echo $filter['element_id']; ?>), <?php echo $filter['id']; ?>); return false;"><?php esc_html_e('Delete', 'iphorm'); ?></a>
    </div>
    <?php if (!isset($filter['name'])) $filter['name'] = _x('Alpha Numeric', 'the name of alphanumeric filter which filters out non-alphanumeric characters', 'iphorm'); ?>
    <div class="ifb-filter-title"><?php echo esc_html($filter['name']); ?></div>
    <div class="ifb-filter-settings">
        <table class="ifb-form-table ifb-filter-settings-form-table">
            <?php if (!isset($filter['allow_white_space'])) $filter['allow_white_space'] = false; ?>
            <tr valign="top">
                <th scope="row">
                    <div class="ifb-tooltip">
                        <div class="ifb-tooltip-content">
                            <?php esc_html_e('If checked, any spaces or tabs will not be stripped', 'iphorm'); ?>
                        </div>
                    </div>
                    <label for="f_allow_white_space_<?php echo $filter['element_id']; ?>_<?php echo $filter['id']; ?>"><?php esc_html_e('Allow whitespace', 'iphorm'); ?></label>
                </th>
                <td><input type="checkbox" id="f_allow_white_space_<?php echo $filter['element_id']; ?>_<?php echo $filter['id']; ?>" name="f_allow_white_space_<?php echo $filter['element_id']; ?>_<?php echo $filter['id']; ?>" <?php checked($filter['allow_white_space'], true); ?> /></td>
            </tr>
        </table>
    </div>
</div>