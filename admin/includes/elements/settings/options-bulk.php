<?php if (!defined('IPHORM_VERSION')) exit; ?><div class="ifb-button ifb-add-bulk-options-button" onclick="iPhorm.showBulkOptions(iPhorm.getElementById(<?php echo $id; ?>));"><?php esc_html_e('Add bulk options', 'iphorm'); ?></div>
<div id="ifb-bulk-options-<?php echo $id; ?>" class="ifb-bulk-options clearfix">
    <p class="ifb-bulk-options-instructions"><?php esc_html_e('Click a category on the left hand side to insert predefined options. You can edit the options on the right hand side or enter your own options, one per line.', 'iphorm'); ?></p>
    <div class="clearfix bulk-options-wrap">
        <div class="ifb-bulk-options-right">
            <textarea id="bulk_options_textarea_<?php echo $id; ?>"></textarea>
        </div>
        <div class="ifb-bulk-options-left">
            <ul>
                <li><div onclick="iPhorm.loadBulkExistingOptions(iPhorm.getElementById(<?php echo $id; ?>));" class="ifb-button ifb-add-bulk-option-button"><?php esc_html_e('Existing Options', 'iphorm'); ?></div></li>
                <?php
                $bulkOptions = array_keys(iphorm_get_bulk_options());
                foreach ($bulkOptions as $key) : ?>
                    <li><div onclick="iPhorm.loadBulkOptions('<?php echo esc_js($key); ?>', iPhorm.getElementById(<?php echo $id; ?>));" class="ifb-button ifb-add-bulk-option-button"><?php echo esc_html($key); ?></div></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div class="ifb-bulk-options-clear clearfix">
    	<div class="ifb-bulk-options-clear-inner">
            <label for="bulk_options_clear_<?php echo $id; ?>"><input type="checkbox" name="bulk_options_clear_<?php echo $id; ?>" id="bulk_options_clear_<?php echo $id; ?>" /> <?php esc_html_e('Overwrite existing options', 'iphorm'); ?></label>
            <div class="ifb-tooltip"><div class="ifb-tooltip-content">
                <?php esc_html_e('Removes any existing options before adding', 'iphorm'); ?>
            </div></div>
        </div>
    </div>
    <div class="ifb-bulk-options-buttons-wrap clearfix">
        <div onclick="iPhorm.insertBulkOptions(iPhorm.getElementById(<?php echo $id; ?>));" class="ifb-button-blue"><?php esc_html_e('Add options', 'iphorm'); ?></div>
        <div onclick="tb_remove();" class="ifb-button-grey"><?php esc_html_e('Cancel', 'iphorm'); ?></div>
    </div>
</div>