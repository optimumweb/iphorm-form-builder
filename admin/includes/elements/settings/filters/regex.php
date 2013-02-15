<?php if (!defined('IPHORM_VERSION')) exit; ?><div id="ifb-filter-wrap-<?php echo $filter['element_id']; ?>-<?php echo $filter['id']; ?>" class="ifb-filter ifb-filter-regex">
    <div class="ifb-filter-actions">
        <a class="ifb-filter-close-link" title="<?php esc_attr_e('Hide filter settings', 'iphorm'); ?>" href="#" onclick="iPhorm.hideFilterSettings(<?php echo $filter['element_id']; ?>, <?php echo $filter['id']; ?>); return false;"><span></span><?php esc_html_e('Hide', 'iphorm'); ?></a>
        <a class="ifb-filter-settings-link" title="<?php esc_attr_e('Settings', 'iphorm'); ?>" href="#" onclick="iPhorm.showFilterSettings(<?php echo $filter['element_id']; ?>, <?php echo $filter['id']; ?>); return false;"><span></span><?php esc_html_e('Settings', 'iphorm'); ?></a>
        <a class="ifb-filter-delete-link" title="<?php esc_attr_e('Delete this filter', 'iphorm'); ?>" href="#" onclick="iPhorm.deleteFilter(iPhorm.getElementById(<?php echo $filter['element_id']; ?>), <?php echo $filter['id']; ?>); return false;"><?php esc_html_e('Delete', 'iphorm'); ?></a>
    </div>
    <?php if (!isset($filter['name'])) $filter['name'] = _x('Regex', 'the name of regex filter which filters out characters by regular expression', 'iphorm'); ?>
    <div class="ifb-filter-title"><?php echo esc_html($filter['name']); ?></div>
    <div class="ifb-filter-settings">
        <table class="ifb-form-table ifb-filter-settings-form-table">
            <?php if (!isset($filter['pattern'])) $filter['pattern'] = ''; ?>
            <tr valign="top">
                <th scope="row">
                    <div class="ifb-tooltip">
                        <div class="ifb-tooltip-content">
                            <?php esc_html_e('Any text matching this regular expression pattern will be stripped', 'iphorm'); ?>
                        </div>
                    </div>
                    <label for="f_pattern_<?php echo $filter['element_id']; ?>_<?php echo $filter['id']; ?>"><?php esc_html_e('Pattern', 'iphorm'); ?></label>
                </th>
                <td><input type="text" id="f_pattern_<?php echo $filter['element_id']; ?>_<?php echo $filter['id']; ?>" name="f_pattern_<?php echo $filter['element_id']; ?>_<?php echo $filter['id']; ?>" value="<?php echo esc_attr($filter['pattern']); ?>" /></td>
            </tr>
        </table>
    </div>
</div>