<?php if (!defined('IPHORM_VERSION')) exit; ?><table class="widefat">
    <tr>
        <th class="iphorm-db-widget-name-th"><?php esc_html_e('Form', 'iphorm'); ?></th>
        <th class="iphorm-db-widget-unread-th"><?php esc_html_e('Unread', 'iphorm'); ?></th>
        <th>&nbsp;</th>
    </tr>
    <?php foreach ($forms as $form) : ?>
        <?php $config = maybe_unserialize($form->config); ?>
        <tr>
            <td class="iphorm-db-widget-name"><a href="<?php echo admin_url('admin.php?page=iphorm_entries&amp;id=' . $config['id']); ?>"><?php echo esc_html($config['name']); ?></a></td>
            <td class="iphorm-db-widget-unread"><a href="<?php echo admin_url('admin.php?page=iphorm_entries&amp;id=' . $config['id']); ?>"><?php echo $form->entries; ?></a></td>
            <td class="iphorm-db-widget-link"><a class="button" href="<?php echo admin_url('admin.php?page=iphorm_entries&amp;id=' . $config['id']); ?>"><?php esc_html_e('View entries', 'iphorm'); ?></a></td>
        </tr>
    <?php endforeach; ?>
</table>