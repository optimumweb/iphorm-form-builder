<?php
if (!defined('IPHORM_VERSION')) exit;
$id = absint($element['id']);
$helpUrl = iphorm_help_link('element-hidden');
?>
<div id="ifb-element-wrap-<?php echo $id; ?>" class="ifb-element-wrap ifb-element-wrap-html">
	<div class="ifb-top-element-wrap clearfix">
        <?php include IPHORM_ADMIN_INCLUDES_DIR . '/elements/_actions.php'; ?>
        <div class="ifb-element-preview ifb-element-preview-html">
            <?php esc_html_e('This block of HTML is only visible when viewing or previewing the form.', 'iphorm'); ?>
            <span class="ifb-handle"></span>
        </div>
    </div>
    <div class="ifb-element-settings ifb-element-settings-html">
        <div class="ifb-element-settings-tabs" id="ifb-element-settings-tabs-<?php echo $id; ?>">
            <ul class="ifb-tabs-nav">
                <li><a href="#ifb-element-settings-tab-settings-<?php echo $id; ?>"><?php esc_html_e('Settings', 'iphorm'); ?></a></li>
            </ul>
            <div class="ifb-tabs-panel" id="ifb-element-settings-tab-settings-<?php echo $id; ?>">
                <div class="ifb-element-settings-inner">
                    <table class="ifb-form-table ifb-element-settings-form-table ifb-element-settings-settings-form-table">
                        <?php if (!isset($element['content'])) $element['content'] = ''; ?>
                        <tr valign="top">
                            <th scope="row"><label for="content_<?php echo $id; ?>"><?php esc_html_e('HTML', 'iphorm'); ?></label></th>
                            <td><textarea id="content_<?php echo $id; ?>" name="content_<?php echo $id; ?>"><?php echo _wp_specialchars($element['content'], ENT_NOQUOTES, false, true); ?></textarea></td>
                        </tr>
                        <?php if (!isset($element['enable_wrapper'])) $element['enable_wrapper'] = false; ?>
                        <tr valign="top">
                            <th scope="row">
                                <label for="enable_wrapper_<?php echo $id; ?>"><?php esc_html_e('Enable element wrapper', 'iphorm'); ?></label>
                            </th>
                            <td>
                                <input type="checkbox" id="enable_wrapper_<?php echo $id; ?>" name="enable_wrapper_<?php echo $id; ?>" <?php checked($element['enable_wrapper'], true); ?> />
                                <p class="description"><?php esc_html_e("Allows this block of HTML to behave like an normal form element - it will
                                    allow conditional logic to be applied to it and if it's inside a group it will behave like other elements.", 'iphorm'); ?></p>
                            </td>
                        </tr>
                        <?php include 'settings/conditional-logic.php'; ?>
                        <?php include '_save.php'; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>