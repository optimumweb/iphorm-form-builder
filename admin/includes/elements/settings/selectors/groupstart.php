<?php if (!defined('IPHORM_VERSION')) exit; ?><div class="ifb-info-box ifb-info-message"><span class="ifb-info-message-icon"></span><?php printf(__('The unique identifier for this element is %s. You can use the CSS selectors below in your stylesheet to style this element individually.', 'iphorm'), '<span class="ifb-bold">iphorm_<span class="ifb-update-form-id">' . $form['id'] . '</span>_' . $element['id'] . '</span>'); ?></div>
<h4><?php esc_html_e('Group wrapper', 'iphorm'); ?></h4>
<pre>.iphorm_<span class="ifb-update-form-id"><?php echo $form['id']; ?></span>_<?php echo $element['id']; ?>-group-wrap { }</pre>
<h4><?php esc_html_e('Title', 'iphorm'); ?></h4>
<pre>.iphorm_<span class="ifb-update-form-id"><?php echo $form['id']; ?></span>_<?php echo $element['id']; ?>-group-wrap .iphorm-group-title { }</pre>
<h4><?php esc_html_e('Description', 'iphorm'); ?></h4>
<pre>.iphorm_<span class="ifb-update-form-id"><?php echo $form['id']; ?></span>_<?php echo $element['id']; ?>-group-wrap .iphorm-group-description { }</pre>
<h4><?php esc_html_e('Group elements wrapper', 'iphorm'); ?></h4>
<pre>.iphorm_<span class="ifb-update-form-id"><?php echo $form['id']; ?></span>_<?php echo $element['id']; ?>-group-wrap .iphorm-group-elements { }</pre>