<?php if (!defined('IPHORM_VERSION')) exit; ?><div class="ifb-info-box ifb-info-message"><span class="ifb-info-message-icon"></span><?php printf(__('The unique identifier for this element is %s. You can use the CSS selectors below in your stylesheet to style this element individually.', 'iphorm'), '<span class="ifb-bold">iphorm_<span class="ifb-update-form-id">' . $form['id'] . '</span>_' . $element['id'] . '</span>'); ?></div>
<h4><?php esc_html_e('Outer wrapper', 'iphorm'); ?></h4>
<pre>.iphorm_<span class="ifb-update-form-id"><?php echo $form['id']; ?></span>_<?php echo $element['id']; ?>-element-wrap { }</pre>
<h4><?php esc_html_e('Label', 'iphorm'); ?></h4>
<pre>.iphorm_<span class="ifb-update-form-id"><?php echo $form['id']; ?></span>_<?php echo $element['id']; ?>-element-wrap label { }</pre>
<h4><?php esc_html_e('Inner wrapper', 'iphorm'); ?></h4>
<pre>.iphorm_<span class="ifb-update-form-id"><?php echo $form['id']; ?></span>_<?php echo $element['id']; ?>-input-wrap { }</pre>
<h4><?php esc_html_e('Day field', 'iphorm'); ?></h4>
<pre>.iphorm_<span class="ifb-update-form-id"><?php echo $form['id']; ?></span>_<?php echo $element['id']; ?>-input-day { }</pre>
<h4><?php esc_html_e('Month field', 'iphorm'); ?></h4>
<pre>.iphorm_<span class="ifb-update-form-id"><?php echo $form['id']; ?></span>_<?php echo $element['id']; ?>-input-month { }</pre>
<h4><?php esc_html_e('Year field', 'iphorm'); ?></h4>
<pre>.iphorm_<span class="ifb-update-form-id"><?php echo $form['id']; ?></span>_<?php echo $element['id']; ?>-input-year { }</pre>
<h4><?php esc_html_e('Description', 'iphorm'); ?></h4>
<pre>.iphorm_<span class="ifb-update-form-id"><?php echo $form['id']; ?></span>_<?php echo $element['id']; ?>-element-wrap .iphorm-description { }</pre>