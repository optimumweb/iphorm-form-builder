<?php
if (!defined('IPHORM_VERSION')) exit;
if (!isset($element['filters'])) $element['filters'] = array();
$invalidFilters = iphorm_get_invalid_filter_types($element);
?>
<tr valign="top">
    <th scope="row">
        <div class="ifb-tooltip"><div class="ifb-tooltip-content">
            <?php esc_html_e('Filters allow you to strip various characters from the submitted form data', 'iphorm'); ?>
        </div></div>
        <label><?php esc_html_e('Filters', 'iphorm'); ?></label>
    </th>
    <td>
        <div id="ifb-filters-<?php echo $id; ?>">
            <?php if (count($element['filters'])) : ?>
                <?php foreach ($element['filters'] as $filter) : ?>
                    <?php
                        switch ($filter['type']) {
                            case 'alpha':
                                include IPHORM_ADMIN_INCLUDES_DIR . '/elements/settings/filters/alpha.php';
                                break;
                            case 'alphaNumeric':
                                include IPHORM_ADMIN_INCLUDES_DIR . '/elements/settings/filters/alpha-numeric.php';
                                break;
                            case 'digits':
                                include IPHORM_ADMIN_INCLUDES_DIR . '/elements/settings/filters/digits.php';
                                break;
                            case 'stripTags':
                                include IPHORM_ADMIN_INCLUDES_DIR . '/elements/settings/filters/strip-tags.php';
                                break;
                            case 'trim':
                                include IPHORM_ADMIN_INCLUDES_DIR . '/elements/settings/filters/trim.php';
                                break;
                            case 'regex':
                                include IPHORM_ADMIN_INCLUDES_DIR . '/elements/settings/filters/regex.php';
                                break;
                        }
                    ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="ifb-filters-empty ifb-info-message" id="ifb-filters-empty-<?php echo $id; ?>"<?php if (count($element['filters'])) echo 'style="display: none;"'; ?>><span class="ifb-info-message-icon"></span><?php esc_html_e('No filters.', 'iphorm'); ?></div>
    </td>
</tr>
<tr valign="top">
    <th scope="row"><label><?php esc_html_e('Add a filter', 'iphorm'); ?></label></th>
    <td class="ifb-add-filter-list">
        <?php if (!in_array('alpha', $invalidFilters)) : ?>
            <a class="button ifb-simple-tooltip" title="<?php esc_attr_e('Removes any non-alphabet characters', 'iphorm'); ?>" onclick="iPhorm.addFilter(iPhorm.getElementById(<?php echo $id; ?>), 'alpha');"><?php esc_html_e('Alpha', 'iphorm'); ?></a>
        <?php endif; ?>
        <?php if (!in_array('alphaNumeric', $invalidFilters)) : ?>
            <a class="button ifb-simple-tooltip" title="<?php esc_attr_e('Removes any non-alphabet characters and non-digits', 'iphorm'); ?>" onclick="iPhorm.addFilter(iPhorm.getElementById(<?php echo $id; ?>), 'alphaNumeric');"><?php esc_html_e('Alpha Numeric', 'iphorm'); ?></a>
        <?php endif; ?>
        <?php if (!in_array('digits', $invalidFilters)) : ?>
            <a class="button ifb-simple-tooltip" title="<?php esc_attr_e('Removes any non-digits', 'iphorm'); ?>" onclick="iPhorm.addFilter(iPhorm.getElementById(<?php echo $id; ?>), 'digits');"><?php esc_html_e('Digits', 'iphorm'); ?></a>
        <?php endif; ?>
        <?php if (!in_array('stripTags', $invalidFilters)) : ?>
            <a class="button ifb-simple-tooltip" title="<?php esc_attr_e('Removes any HTML tags', 'iphorm'); ?>" onclick="iPhorm.addFilter(iPhorm.getElementById(<?php echo $id; ?>), 'stripTags');"><?php esc_html_e('Strip Tags', 'iphorm'); ?></a>
        <?php endif; ?>
        <?php if (!in_array('trim', $invalidFilters)) : ?>
            <a class="button ifb-simple-tooltip" title="<?php esc_attr_e('Removes white space from the start and end', 'iphorm'); ?>" onclick="iPhorm.addFilter(iPhorm.getElementById(<?php echo $id; ?>), 'trim');"><?php esc_html_e('Trim', 'iphorm'); ?></a>
        <?php endif; ?>
        <?php if (!in_array('regex', $invalidFilters)) : ?>
            <a class="button ifb-simple-tooltip" title="<?php esc_attr_e('Removes characters matching the given regular expression', 'iphorm'); ?>" onclick="iPhorm.addFilter(iPhorm.getElementById(<?php echo $id; ?>), 'regex');"><?php esc_html_e('Regex', 'iphorm'); ?></a>
        <?php endif; ?>
    </td>
</tr>