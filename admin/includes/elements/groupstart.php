<?php
if (!defined('IPHORM_VERSION')) exit;
$id = absint($element['id']);

if (!isset($element['name'])) $element['name'] = __('New', 'iphorm');
if (!isset($element['title'])) $element['title'] = '';
if (!isset($element['description'])) $element['description'] = '';
$helpUrl = iphorm_help_link('element-group');
?>
<div id="ifb-element-wrap-<?php echo $id; ?>" class="ifb-element-wrap ifb-element-wrap-groupstart">
    <div class="ifb-top-element-wrap clearfix">
        <?php include IPHORM_ADMIN_INCLUDES_DIR . '/elements/_actions.php'; ?>
        <div class="ifb-element-preview ifb-element-preview-text">
                <div class="ifb-group-start">
                    <span class="ifb-group-start-text"><?php printf(esc_html(__('Start of group: %s', 'iphorm')), '<span class="ifb-start-group-name">' . $element['name'] . '</span>'); ?></span>
                </div>
                <div class="ifb-group-start-wrap-user-text clearfix">
                    <div class="ifb-preview-title <?php if (!strlen($element['title'])) echo 'ifb-hidden'; ?>"><?php echo $element['title']; ?></div>
                    <p class="ifb-preview-description <?php if (!strlen($element['description'])) echo 'ifb-hidden'; ?>"><?php echo $element['description']; ?></p>
            </div>
            <span class="ifb-handle"></span>
        </div>
    </div>
    <div class="ifb-element-settings ifb-element-settings-groupstart">
        <div class="ifb-element-settings-tabs" id="ifb-element-settings-tabs-<?php echo $id; ?>">
            <ul class="ifb-tabs-nav">
                <li><a href="#ifb-element-settings-tab-settings-<?php echo $id; ?>"><?php esc_html_e('Settings', 'iphorm'); ?></a></li>
                <li><a href="#ifb-element-settings-tab-more-<?php echo $id; ?>"><?php esc_html_e('Optional', 'iphorm'); ?></a></li>
                <li><a href="#ifb-element-settings-tab-advanced-<?php echo $id; ?>"><?php esc_html_e('Advanced', 'iphorm'); ?></a></li>
            </ul>
            <div class="ifb-tabs-panel" id="ifb-element-settings-tab-settings-<?php echo $id; ?>">
                <div class="ifb-element-settings-inner">
                    <table class="ifb-form-table ifb-element-settings-form-table ifb-element-settings-settings-form-table">
                        <tr valign="top">
                            <th scope="row">
                                <div class="ifb-tooltip"><div class="ifb-tooltip-content">
                                    <?php esc_html_e('The group name is only shown in the form builder to help you identify groups.', 'iphorm'); ?>
                                </div></div>
                                <label for="name_<?php echo $id; ?>"><?php esc_html_e('Name', 'iphorm'); ?></label>
                            </th>
                            <td><input type="text" id="name_<?php echo $id; ?>" name="name_<?php echo $id; ?>" value="<?php echo esc_attr($element['name']); ?>" onkeyup="iPhorm.updateGroupName(iPhorm.getElementById(<?php echo $id; ?>));" /></td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <div class="ifb-tooltip"><div class="ifb-tooltip-content">
                                    <?php esc_html_e('The title will appear at the top of your group', 'iphorm'); ?>
                                </div></div>
                                <label for="title_<?php echo $id; ?>"><?php esc_html_e('Title', 'iphorm'); ?></label></th>
                            <td><input type="text" id="title_<?php echo $id; ?>" name="title_<?php echo $id; ?>" value="<?php echo _wp_specialchars($element['title'], ENT_COMPAT, false, true); ?>" onkeyup="iPhorm.updateGroupTitle(iPhorm.getElementById(<?php echo $id; ?>));" /></td>
                        </tr>
                        <?php include 'settings/description.php'; ?>
                        <?php include '_save.php'; ?>
                    </table>
                </div>
            </div>
            <div class="ifb-tabs-panel" id="ifb-element-settings-tab-more-<?php echo $id; ?>">
                <div class="ifb-element-settings-inner">
                <table class="ifb-form-table ifb-element-settings-form-table ifb-element-settings-more-form-table">
                    <?php if (!isset($element['number_of_columns'])) $element['number_of_columns'] = 1; ?>
                    <tr valign="top">
                        <th scope="row">
                            <div class="ifb-tooltip"><div class="ifb-tooltip-content">
                                <?php esc_html_e('The number of columns determines the how many elements should be display per row inside the group. After
                                this number of elements, further elements will appear on the line below.', 'iphorm'); ?>
                            </div></div>
                            <label for="number_of_columns_<?php echo $id; ?>"><?php esc_html_e('Number of columns', 'iphorm'); ?></label></th>
                        <td>
                            <select id="number_of_columns_<?php echo $id; ?>" name="number_of_columns_<?php echo $id; ?>">
                                <?php foreach (range(1, 5) as $num) : ?>
                                    <option value="<?php echo $num; ?>" <?php selected($element['number_of_columns'], $num); ?>><?php echo $num; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <?php if (!isset($element['column_alignment'])) $element['column_alignment'] = 'proportional'; ?>
                    <tr valign="top">
                        <th scope="row">
                            <div class="ifb-tooltip"><div class="ifb-tooltip-content">
                                <?php printf(esc_html__('Choose how the columns are aligned. %1$sProportional%2$s - each column is evenly
                                spaced. %1$sFloat left%2$s - the columns are compacted left.', 'iphorm'), '<span class="ifb-bold">', '</span>'); ?>
                            </div></div>
                            <label for="column_alignment_<?php echo $id; ?>"><?php esc_html_e('Column alignment', 'iphorm'); ?></label></th>
                        <td>
                            <select id="column_alignment_<?php echo $id; ?>" name="column_alignment_<?php echo $id; ?>">
                                <option value="proportional" <?php selected($element['column_alignment'], 'proportional'); ?>><?php esc_html_e('Proportional', 'iphorm'); ?></option>
                                <option value="left" <?php selected($element['column_alignment'], 'left'); ?>><?php esc_html_e('Float left', 'iphorm'); ?></option>
                            </select>
                        </td>
                    </tr>
                    <?php if (!isset($element['label_placement'])) $element['label_placement'] = 'inherit'; ?>
                    <tr valign="top">
                        <th scope="row">
                            <div class="ifb-tooltip"><div class="ifb-tooltip-content">
                                <?php esc_html_e('"Inherit" means that the label placement will be inherted from the global
                                form settings or if this group is inside another group then the setting will
                                be inherited from the parent group.', 'iphorm'); ?>
                            </div></div>
                            <label for="label_placement_<?php echo $id; ?>"><?php esc_html_e('Label placement', 'iphorm'); ?></label>
                        </th>
                        <td>
                            <select id="label_placement_<?php echo $id; ?>" name="label_placement_<?php echo $id; ?>" onchange="iPhorm.setElementLabelPlacement(iPhorm.getElementById(<?php echo $id; ?>));">
                                <option value="inherit" <?php selected($element['label_placement'], 'inherit'); ?>><?php esc_html_e('Inherit', 'iphorm'); ?></option>
                                <option value="above" <?php selected($element['label_placement'], 'above'); ?>><?php esc_html_e('Above', 'iphorm'); ?></option>
                                <option value="left" <?php selected($element['label_placement'], 'left'); ?>><?php esc_html_e('Left', 'iphorm'); ?></option>
                                <option value="inside" <?php selected($element['label_placement'], 'inside'); ?>><?php esc_html_e('Inside', 'iphorm'); ?></option>
                            </select>
                            <p class="description"><?php esc_html_e('Choose where to display the label relative to the input for the elements in this group. Changes to this setting will only be visible when viewing or previewing the form.', 'iphorm'); ?></p>
                        </td>
                    </tr>
                    <?php if (!isset($element['label_width'])) $element['label_width'] = ''; ?>
                    <tr valign="top" class="<?php if ($element['label_placement'] != 'left') echo 'ifb-hidden'; ?> ifb-show-if-element-label-placement-left">
                        <th scope="row">
                            <div class="ifb-tooltip"><div class="ifb-tooltip-content"><?php esc_html_e('Specify how wide the labels should be, this only applies when the label placement is left', 'iphorm'); ?></div></div>
                            <label for="label_width_<?php echo $id; ?>"><?php esc_html_e('Label width', 'iphorm'); ?></label>
                        </th>
                        <td>
                            <input name="label_width_<?php echo $id; ?>" id="label_width_<?php echo $id; ?>" type="text" value="<?php echo esc_attr($element['label_width']); ?>" class="ifb-halfwidth-input" />
                            <p class="description"><?php printf(esc_html__('The width of the element labels, any valid CSS width is accepted, e.g. %s200px%s', 'iphorm'), '<span class="ifb-bold">', '</span>'); ?></p>
                        </td>
                    </tr>
                    <?php if (!isset($element['group_style'])) $element['group_style'] = 'plain'; ?>
                    <tr valign="top">
                        <th scope="row">
                            <label for="group_style_<?php echo $id; ?>"><?php esc_html_e('Group style', 'iphorm'); ?></label>
                        </th>
                        <td>
                            <select id="group_style_<?php echo $id; ?>" name="group_style_<?php echo $id; ?>" onchange="iPhorm.groupStyleChanged(iPhorm.getElementById(<?php echo $id; ?>));">
                                <option value="plain" <?php selected($element['group_style'], 'plain'); ?>><?php esc_html_e('Plain', 'iphorm'); ?></option>
                                <option value="bordered" <?php selected($element['group_style'], 'bordered'); ?>><?php esc_html_e('Bordered', 'iphorm'); ?></option>
                            </select>
                            <p class="description"><?php esc_html_e('Plain groups have no additional styling. Bordered groups have a border and padding.', 'iphorm'); ?></p>
                        </td>
                    </tr>
                    <?php if (!isset($element['border_colour'])) $element['border_colour'] = ''; ?>
                    <tr valign="top" class="ifb-show-if-group-style-bordered <?php if ($element['group_style'] == 'plain') echo 'ifb-hidden'; ?>">
                        <th scope="row"><label for="border_colour_<?php echo $id; ?>"><?php esc_html_e('Border color', 'iphorm'); ?></label></th>
                        <td class="ifb-group-border-colour"><input type="text" id="border_colour_<?php echo $id; ?>" name="border_colour_<?php echo $id; ?>" value="<?php echo esc_attr($element['border_colour']); ?>" /></td>
                    </tr>
                    <?php if (!isset($element['background_colour'])) $element['background_colour'] = ''; ?>
                    <tr valign="top" class="ifb-show-if-group-style-bordered <?php if ($element['group_style'] == 'plain') echo 'ifb-hidden'; ?>">
                        <th scope="row"><label for="background_colour_<?php echo $id; ?>"><?php esc_html_e('Background color', 'iphorm'); ?></label></th>
                        <td class="ifb-group-background-colour"><input type="text" id="background_colour_<?php echo $id; ?>" name="background_colour_<?php echo $id; ?>" value="<?php echo esc_attr($element['background_colour']); ?>" /></td>
                    </tr>
                    <?php include 'settings/tooltip-type.php'; ?>
                    <?php include 'settings/conditional-logic.php'; ?>
                    <?php include '_save.php'; ?>
                </table>
                <script type="text/javascript">
                //<![CDATA[
                    jQuery(document).ready(function ($) {
                        $('#border_colour_<?php echo $id; ?>, #background_colour_<?php echo $id; ?>').ColorPicker({
                            onSubmit: function(hsb, hex, rgb, el) {
                                $(el).val('#' + hex);
                                $(el).ColorPickerHide();
                            },
                            onBeforeShow: function () {
                                $(this).ColorPickerSetColor(this.value);
                            },
                            onChange: function (hsb, hex, rgb) {
                                $($(this).data('colorpicker').el).val('#'+hex);
                            }
                        })
                        .bind('keyup', function(){
                            $(this).ColorPickerSetColor(this.value);
                        });
                    });
                //]]>
                </script>
                </div>
            </div>
            <div class="ifb-tabs-panel" id="ifb-element-settings-tab-advanced-<?php echo $id; ?>">
                <div class="ifb-element-settings-inner">
                    <table class="ifb-form-table ifb-element-settings-form-table ifb-element-settings-advanced-form-table">
                        <?php include 'settings/styles.php'; ?>
                        <?php include 'settings/selectors.php'; ?>
                        <?php include '_save.php'; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>