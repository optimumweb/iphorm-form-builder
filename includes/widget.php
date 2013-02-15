<?php
if (!defined('IPHORM_VERSION')) exit;

/**
 * Standard iPhorm Widget to display a form
 */
class iPhormWidget extends WP_Widget {

    function iPhormWidget() {
        $options = array(
            'description' => __('Display one of your created forms', 'iphorm'),
            'classname' => 'iphorm-widget'
        );
        parent::WP_Widget('iphorm-widget', $name = 'Quform', $options);
    }

    function widget($args, $instance) {
        if (!isset($instance['title'])) $instance['title'] = '';
        if (!isset($instance['form_id'])) $instance['form_id'] = 0;

        if (iphorm_form_exists($instance['form_id'])) {
            extract($args);

            echo $before_widget;

            $title = apply_filters('widget_title', $instance['title']);
            if (strlen($title)) {
                echo $before_title . $title . $after_title;
            }

            echo iphorm($instance['form_id']);

            echo $after_widget;
        }
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        $instance['form_id'] = $new_instance['form_id'];
        return $instance;
    }

    function form($instance) {
        $formRows = iphorm_get_all_form_rows();
        if (!isset($instance['title'])) $instance['title'] = '';
        if (!isset($instance['form_id'])) $instance['form_id'] = 0;
        ?>
        <?php if (count($formRows)) : ?>
        <div>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title (optional)', 'iphorm'); ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
        </div>
        <div style="margin-top: 10px;">
            <label for="<?php echo $this->get_field_id('form_id'); ?>"><?php esc_html_e('Select a form', 'iphorm'); ?></label>
            <select id="<?php echo $this->get_field_id('form_id'); ?>" name="<?php echo $this->get_field_name('form_id'); ?>">
            <?php foreach ($formRows as $formRow) : ?>
                <?php $config = iphorm_get_form_config($formRow->id); ?>
                <option value="<?php echo absint($config['id']); ?>" <?php selected($instance['form_id'], $config['id']); ?>><?php echo esc_html($config['name']); ?></option>
            <?php endforeach; ?>
            </select>
        </div>
        <?php else : ?>
            <?php printf(esc_html__('You have not created a form yet, %sclick here to create one%s.', 'iphorm'), '<a href="' . admin_url('admin.php?page=iphorm_form_builder') . '">', '</a>'); ?>
        <?php endif; ?>
        <?php
    }

}

add_action('widgets_init', create_function('', 'return register_widget("iPhormWidget");'));

/**
 * Widget to display a form in popup (lightbox)
 */
class iPhormPopupWidget extends WP_Widget {

    function iPhormPopupWidget() {
        $options = array(
            'description' => __('Display one of your created forms in a popup (lightbox)', 'iphorm'),
            'classname' => 'iphorm-popup-widget'
        );
        parent::WP_Widget('iphorm-popup-widget', $name = 'Quform Popup', $options);
    }

    function widget($args, $instance) {
        if (iphorm_form_exists($instance['form_id'])) {
            extract($args);

            echo $before_widget;

            $title = apply_filters('widget_title', $instance['title']);
            if ($title) {
                echo $before_title . $title . $after_title;
            }

            echo iphorm_popup($instance['form_id'], $instance['content'], $instance['options']);

            echo $after_widget;
        }
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        $instance['form_id'] = $new_instance['form_id'];
        $instance['content'] = $new_instance['content'];
        $instance['options'] = $new_instance['options'];
        update_option('iphorm_fancybox_requested', true);
        return $instance;
    }

    function form($instance) {
        $formRows = iphorm_get_all_form_rows();
        if (!isset($instance['title'])) $instance['title'] = '';
        if (!isset($instance['form_id'])) $instance['form_id'] = 0;
        if (!isset($instance['content'])) $instance['content'] = '';
        if (!isset($instance['options'])) $instance['options'] = '';
        ?>
        <?php if (count($formRows)) : ?>
        <div>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title (optional)', 'iphorm'); ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
        </div>
        <div style="margin-top: 10px;">
            <label for="<?php echo $this->get_field_id('form_id'); ?>"><?php esc_html_e('Select a form', 'iphorm'); ?></label>
            <select id="<?php echo $this->get_field_id('form_id'); ?>" name="<?php echo $this->get_field_name('form_id'); ?>">
            <?php foreach ($formRows as $formRow) : ?>
                <?php $config = iphorm_get_form_config($formRow->id); ?>
                <option value="<?php echo absint($config['id']); ?>" <?php selected($instance['form_id'], $config['id']); ?>><?php echo esc_html($config['name']); ?></option>
            <?php endforeach; ?>
            </select>
        </div>
        <div style="margin-top: 10px;">
            <label for="<?php echo $this->get_field_id('content'); ?>"><?php esc_html_e('Text or HTML to trigger the popup', 'iphorm'); ?></label>
            <textarea id="<?php echo $this->get_field_id('content'); ?>" name="<?php echo $this->get_field_name('content'); ?>" class="widefat"><?php echo esc_attr($instance['content']); ?></textarea>
        </div>
        <div style="margin-top: 10px;">
            <label for="<?php echo $this->get_field_id('options'); ?>"><?php esc_html_e('Fancybox options (advanced)', 'iphorm'); ?></label>
            <input type="text" class="widefat" name="<?php echo $this->get_field_name('options'); ?>" id="<?php echo $this->get_field_id('options'); ?>" value="<?php echo esc_attr($instance['options']); ?>" />
            <p class="description" style="margin-bottom: 3px;"><?php printf(esc_html__('Enter any Fancybox options as a JSON formatted string, %sexample%s.', 'iphorm'), '<a href="'.iphorm_help_link('faq#website-lightbox-widget-options').'" onclick="window.open(this.href); return false;">', '</a>'); ?></p>
        </div>
        <?php else : ?>
            <?php printf(esc_html__('You have not created a form yet, %sclick here to create one%s.', 'iphorm'), '<a href="' . admin_url('admin.php?page=iphorm_form_builder') . '">', '</a>'); ?>
        <?php endif; ?>
        <?php
    }
}

add_action('widgets_init', create_function('', 'return register_widget("iPhormPopupWidget");'));