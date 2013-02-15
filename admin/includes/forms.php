<?php if (!defined('IPHORM_VERSION')) exit; ?><div class="wrap">
	<div class="iphorm-top-right">
        <div class="iphorm-information">
        	<span class="iphorm-copyright"><a href="http://www.themecatcher.net" onclick="window.open(this.href); return false;">www.themecatcher.net</a> &copy; <?php echo date('Y'); ?></span>
        	<span class="iphorm-bug-link"><a href="http://www.themecatcher.net/support.php" onclick="window.open(this.href); return false;"><?php esc_html_e('Report a bug', 'iphorm'); ?></a></span>
        	<span class="iphorm-help-link"><a href="<?php echo iphorm_help_link(); ?>" onclick="window.open(this.href); return false;"><?php esc_html_e('Help', 'iphorm'); ?></a></span>
        </div>
    </div>
    <?php screen_icon('iphorm'); ?>
    <h2 class="ifb-main-title"><span class="ifb-iphorm-title">Quform</span><span class="ifb-iphorm-title-forms"><?php esc_html_e('Forms', 'iphorm'); ?></span> <a href="admin.php?page=iphorm_form_builder" class="button add-new-h2"><?php esc_html_e('Add New', 'iphorm'); ?><span class="ifb-add-icon"></span></a></h2>
    <?php if (strlen($message)) : ?>
        <div id="message" class="updated below-h2">
            <p><?php echo $message; ?></p>
        </div>
    <?php endif; ?>
    <form method="post" action="">

    <?php iphorm_global_nav('forms'); ?>
	<div class="iphorm-global-sub-nav-wrap clearfix">
        <ul class="iphorm-global-sub-nav-ul">
            <li><a href="admin.php?page=iphorm_forms" class="<?php echo $active === null ? 'current' : ''; ?>"><?php esc_html_e('All', 'iphorm'); ?> <span class="count">(<?php echo iphorm_get_form_count(); ?>)</span></a></li> 
            <li><a href="admin.php?page=iphorm_forms&amp;active=1" class="<?php echo $active === 1 ? 'current' : ''; ?>"><?php esc_html_e('Active', 'iphorm'); ?> <span class="count">(<?php echo iphorm_get_form_count(1); ?>)</span></a></li> 
            <li><a href="admin.php?page=iphorm_forms&amp;active=0" class="<?php echo $active === 0 ? 'current' : ''; ?>"><?php esc_html_e('Inactive', 'iphorm'); ?> <span class="count">(<?php echo iphorm_get_form_count(0); ?>)</span></a></li>
        </ul>
    </div>

    <div class="tablenav top">
        <div class="alignleft actions">
            <select id="iphorm-bulk-action" name="bulk_action">
                <option selected="selected" value="-1"><?php esc_html_e('Bulk Actions', 'iphorm'); ?></option>
                <option value="activate"><?php esc_html_e('Activate', 'iphorm'); ?></option>
                <option value="deactivate"><?php esc_html_e('Deactivate', 'iphorm'); ?></option>
                <option value="delete"><?php esc_html_e('Delete', 'iphorm'); ?></option>
            </select>
            <input type="submit" value="<?php esc_attr_e('Apply', 'iphorm'); ?>" class="button-secondary action iphorm-bulk-delete-go" id="doaction" name="" />
        </div>
        <br class="clear" />
    </div> <!-- /.tablenav top -->

    <table cellspacing="0" class="wp-list-table widefat fixed iphorm-list-table">
        <thead>
            <tr>
                <th style="" class="manage-column column-cb check-column" id="cb" scope="col">
                    <input type="checkbox" />
                </th>
                <th style="" class="manage-column column-id" id="id" scope="col">
                    <?php esc_html_e('ID', 'iphorm'); ?>
                </th>
                <th style="" class="manage-column column-name" id="name" scope="col">
                    <?php esc_html_e('Name', 'iphorm'); ?>
                </th>
                <th style="" class="manage-column column-entries" id="entries" scope="col">
                    <?php esc_html_e('Entries', 'iphorm'); ?>
                </th>
                <th style="" class="manage-column column-active" id="active" scope="col">
                    <?php esc_html_e('Active', 'iphorm'); ?>
                </th>
            </tr>
        </thead>

        <tfoot>
            <tr>
                <th style="" class="manage-column column-cb check-column" scope="col">
                    <input type="checkbox" />
                </th>
                <th style="" class="manage-column column-id" scope="col">
                    <?php esc_html_e('ID', 'iphorm'); ?>
                </th>
                <th style="" class="manage-column column-name" scope="col">
                    <?php esc_html_e('Name', 'iphorm'); ?>
                </th>
                <th style="" class="manage-column column-entries" scope="col">
                    <?php esc_html_e('Entries', 'iphorm'); ?>
                </th>
                <th style="" class="manage-column column-active" scope="col">
                    <?php esc_html_e('Active', 'iphorm'); ?>
                </th>
            </tr>
        </tfoot>

        <tbody id="the-list">
            <?php if (count($forms)) : ?>
                <?php $i = 1; ?>
                <?php foreach ($forms as $row) : ?>
                    <?php $config = unserialize($row->config); ?>
                    <tr valign="top" class="<?php echo (++$i % 2 == 1) ? 'alternate' : ''; ?>" id="iphorm-<?php echo $row->id; ?>">
                        <th class="check-column" scope="row">
                            <input type="checkbox" value="<?php echo $row->id; ?>" name="form[]" />
                        </th>
                        <td class="iphorm-id">
                            <?php echo esc_html($row->id); ?>
                        </td>
                        <td class="iphorm-name">
                            <strong><a title="<?php echo esc_attr($config['name']); ?>" href="admin.php?page=iphorm_form_builder&amp;id=<?php echo $row->id; ?>"><?php echo esc_html($config['name']); ?></a></strong>
                            <div class="row-actions">
                                <span class="edit"><a href="admin.php?page=iphorm_form_builder&amp;id=<?php echo $row->id; ?>" title="<?php esc_attr_e('Edit this form', 'iphorm'); ?>"><?php esc_html_e('Edit', 'iphorm'); ?></a> |</span>
                                <span class="view"><a href="?iphorm_preview=1&amp;id=<?php echo $row->id; ?>" title="<?php esc_attr_e('Preview this form', 'iphorm'); ?>"><?php esc_html_e('Preview', 'iphorm'); ?></a> |</span>
                                <span class="entries"><a href="admin.php?page=iphorm_entries&amp;id=<?php echo $row->id; ?>" title="<?php esc_attr_e('View submitted form entries', 'iphorm'); ?>"><?php esc_html_e('Entries', 'iphorm'); ?></a> |</span>
                                <?php if ($row->active == 1) : ?>
                                    <span class="deactivate"><a href="admin.php?page=iphorm_forms&amp;action=deactivate&amp;id=<?php echo $row->id; ?>&amp;_wpnonce=<?php echo wp_create_nonce('iphorm_deactivate_form_' . $row->id); ?>" title="<?php esc_attr_e('Deactivate this form', 'iphorm'); ?>"><?php esc_html_e('Deactivate', 'iphorm'); ?></a> |</span>
                                <?php else : ?>
                                    <span class="activate"><a href="admin.php?page=iphorm_forms&amp;action=activate&amp;id=<?php echo $row->id; ?>&amp;_wpnonce=<?php echo wp_create_nonce('iphorm_activate_form_' . $row->id); ?>" title="<?php esc_attr_e('Activate this form', 'iphorm'); ?>"><?php esc_html_e('Activate', 'iphorm'); ?></a> |</span>
                                <?php endif; ?>
                                <span class="duplicate"><a href="admin.php?page=iphorm_forms&amp;action=duplicate&amp;id=<?php echo $row->id; ?>&amp;_wpnonce=<?php echo wp_create_nonce('iphorm_duplicate_form_' . $row->id); ?>" title="<?php esc_attr_e('Duplicate this form', 'iphorm'); ?>"><?php esc_html_e('Duplicate', 'iphorm'); ?></a> |</span>
                                <span class="export"><a href="admin.php?page=iphorm_export&amp;action=form&amp;id=<?php echo $row->id; ?>" title="<?php esc_attr_e('Export this form', 'iphorm'); ?>"><?php esc_html_e('Export', 'iphorm'); ?></a> |</span>
                                <span class="trash"><a class="submitdelete iphorm-delete-form" title="<?php esc_attr_e('Delete this form', 'iphorm'); ?>" href="admin.php?page=iphorm_forms&amp;action=delete&amp;id=<?php echo $row->id; ?>&amp;_wpnonce=<?php echo wp_create_nonce('iphorm_delete_form_' . $row->id); ?>"><?php esc_html_e('Delete', 'iphorm'); ?></a></span>
                            </div>
                        </td>
                        <td class="iphorm-entries">
                            <a href="<?php echo admin_url('admin.php?page=iphorm_entries&amp;id=' . $row->id); ?>">
                            <?php
                                $unreadCount = iphorm_get_form_entry_count($row->id, 1);
                                if ($unreadCount > 0) {
                                    echo '<span class="iphorm-forms-num-unread">' . sprintf(esc_html__('%d unread', 'iphorm'), $unreadCount) . '</span>';
                                } else {
                                	$count = iphorm_get_form_entry_count($row->id);
                                    printf(_n('%d entry', '%d entries', $count, 'iphorm'), $count);
                                }
                            ?>
                            </a>
                        </td>
                        <td class="iphorm-active">
                            <?php if ($row->active == 1) : ?>
                                <?php esc_html_e('Yes', 'iphorm'); ?>
                            <?php else : ?>
                                <?php esc_html_e('No', 'iphorm'); ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr class="no-items">
                    <td colspan="4" class="colspanchange"><p><?php printf(esc_html__('No forms found, %sclick here to create one%s.', 'iphorm'), '<a href="admin.php?page=iphorm_form_builder">', '</a>'); ?></p></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table> <!-- /.wp-list-table -->

    <div class="tablenav bottom">
        <div class="alignleft actions">
            <select id="iphorm-bulk-action2" name="bulk_action2">
                <option selected="selected" value="-1"><?php esc_html_e('Bulk Actions', 'iphorm'); ?></option>
                <option value="activate"><?php esc_html_e('Activate', 'iphorm'); ?></option>
                <option value="deactivate"><?php esc_html_e('Deactivate', 'iphorm'); ?></option>
                <option value="delete"><?php esc_html_e('Delete', 'iphorm'); ?></option>
            </select>
            <input type="submit" value="<?php esc_attr_e('Apply', 'iphorm'); ?>" class="button-secondary action iphorm-bulk-delete-go2" id="doaction2" name="" />
        </div>
        <br class="clear" />
    </div> <!-- /.tablenav bottom -->

    </form>
</div> <!-- /.wrap -->