<?php if (!defined('IPHORM_VERSION')) exit; ?><div id="ifb-filter-wrap-<?php echo $filter['element_id']; ?>-<?php echo $filter['id']; ?>" class="ifb-filter ifb-filter-trim">
    <div class="ifb-filter-actions">
        <a class="ifb-filter-delete-link" title="<?php esc_attr_e('Delete this filter', 'iphorm'); ?>" href="#" onclick="iPhorm.deleteFilter(iPhorm.getElementById(<?php echo $filter['element_id']; ?>), <?php echo $filter['id']; ?>); return false;"><?php esc_html_e('Delete', 'iphorm'); ?></a>
    </div>
    <?php if (!isset($filter['name'])) $filter['name'] = _x('Trim', 'the name of trim filter which filters out white space from the start and end', 'iphorm'); ?>
    <div class="ifb-filter-title"><?php echo esc_html($filter['name']); ?></div>
</div>