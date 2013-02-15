<?php if (!defined('IPHORM_VERSION')) exit; ?><div id="top" class="wrap">
	<div class="iphorm-top-right">
        <div class="iphorm-information">
        	<span class="iphorm-copyright"><a href="http://www.themecatcher.net" onclick="window.open(this.href); return false;">www.themecatcher.net</a> &copy; <?php echo date('Y'); ?></span>
        	<span class="iphorm-bug-link"><a href="http://www.themecatcher.net/support.php" onclick="window.open(this.href); return false;"><?php esc_html_e('Report a bug', 'iphorm'); ?></a></span>
        	<span class="iphorm-help-link"><a href="<?php echo iphorm_help_link(); ?>" onclick="window.open(this.href); return false;"><?php esc_html_e('Help', 'iphorm'); ?></a></span>
        </div>
    </div>
    <?php screen_icon('iphorm'); ?>
    <h2 class="ifb-main-title"><span class="ifb-iphorm-title">Quform</span><span class="ifb-iphorm-entries"><?php esc_html_e('View entry', 'iphorm'); ?></span></h2>
    <?php if (isset($entry->id)) : ?>
        <div class="iphorm-global-nav-wrap clearfix">
        	<ul class="iphorm-global-nav-ul">
            	<li><a href="<?php echo esc_url(remove_query_arg(array('action', 'entry_id'))); ?>"><span class="ifb-arrow-left"><?php esc_html_e('Back to entries list', 'iphorm'); ?></span></a></li>
            </ul>
        </div>
        <div class="iphorm-entry-wrap">
            <div class="iphorm-entry-right">
                <div class="iphorm-entry-additional">
                	<h3 class="iphorm-entry-heading"><?php esc_html_e('Additional information', 'iphorm'); ?></h3>
                    <table class="iphorm-entry-table iphorm-entry-table-right">
                        <tr>
                            <th scope="row"><?php esc_html_e('Date', 'iphorm'); ?></th>
                            <td><?php echo iphorm_format_date($entry->date_added); ?></td>
                        </tr>
                        <tr>
                            <th><?php esc_html_e('Form', 'iphorm'); ?></th>
                            <td><?php echo esc_html($config['name']); ?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?php esc_html_e('Entry ID', 'iphorm'); ?></th>
                            <td><?php echo $entry->id; ?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?php esc_html_e('Form URL', 'iphorm'); ?></th>
                            <td>
                                <?php if (strlen($entry->form_url)) : ?>
                                    <a href="<?php echo esc_attr($entry->form_url); ?>" onclick="window.open(this.href); return false;"><?php echo esc_html($entry->form_url); ?></a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><?php esc_html_e('Referring URL', 'iphorm'); ?></th>
                            <td>
                                <?php if (strlen($entry->referring_url)) : ?>
                                    <a href="<?php echo esc_attr($entry->referring_url); ?>" onclick="window.open(this.href); return false;"><?php echo esc_html($entry->referring_url); ?></a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><?php esc_html_e('IP address', 'iphorm'); ?></th>
                            <td><?php echo esc_html($entry->ip); ?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?php esc_html_e('Post / page ID', 'iphorm'); ?></th>
                            <td><?php echo esc_html($entry->post_id); ?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?php esc_html_e('Post / page title', 'iphorm'); ?></th>
                            <td><?php echo esc_html($entry->post_title); ?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?php esc_html_e('User WordPress display name', 'iphorm'); ?></th>
                            <td><?php echo esc_html($entry->user_display_name); ?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?php esc_html_e('User WordPress email', 'iphorm'); ?></th>
                            <td>
                                <?php if (strlen($entry->user_email)) : ?>
                                    <a href="mailto:<?php echo esc_attr($entry->user_email); ?>"><?php echo esc_html($entry->user_email); ?></a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><?php esc_html_e('User WordPress login', 'iphorm'); ?></th>
                            <td><?php echo esc_html($entry->user_login); ?></td>
                        </tr>
                    </table>
                </div>
            </div> <!-- /.iphorm-entry-right -->
            <div class="iphorm-entry-left">
                <h3 class="iphorm-entry-heading"><?php esc_html_e('Submitted form data', 'iphorm'); ?></h3>
                <div class="iphorm-entry-data">
                    <?php if (count($columns)) : ?>
                        <table class="iphorm-entry-table iphorm-entry-table-left">
                            <?php foreach ($columns as $key => $element) : ?>
                                <?php if (property_exists($entry, $key)) : ?>
                                    <tr>
                                        <th><?php echo esc_html(iphorm_get_element_admin_label($element)); ?></th>
                                        <td><?php echo $entry->{$key}; ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </table>
                    <?php else : ?>

                    <?php endif; ?>
                </div>
            </div> <!-- /.iphorm-entry-left -->
        </div> <!-- /.iphorm-entry-wrap -->
    <?php else : ?>
        <div class="iphorm-admin-notice error"><p><strong>
            <?php esc_html_e('Sorry, I couldn\'t find that entry. Perhaps it was deleted?', 'iphorm'); ?>
        </strong></p></div>
    <?php endif; ?>
</div>