<?php if (!defined('IPHORM_VERSION')) exit; ?><div class="wrap">
	<div class="iphorm-top-right">
        <div class="iphorm-information">
        	<span class="iphorm-copyright"><a href="http://www.themecatcher.net" onclick="window.open(this.href); return false;">www.themecatcher.net</a> &copy; <?php echo date('Y'); ?></span>
        	<span class="iphorm-bug-link"><a href="http://www.themecatcher.net/support.php" onclick="window.open(this.href); return false;"><?php esc_html_e('Report a bug', 'iphorm'); ?></a></span>
        	<span class="iphorm-help-link"><a href="<?php echo iphorm_help_link(); ?>" onclick="window.open(this.href); return false;"><?php esc_html_e('Help', 'iphorm'); ?></a></span>
        </div>
    </div>
    <?php screen_icon('iphorm'); ?>
    <?php if ($id > 0) : ?>
        <h2 class="ifb-main-title"><span class="ifb-iphorm-title">Quform</span><span class="ifb-iphorm-title-entries"><?php esc_html_e('Entries', 'iphorm'); ?></span><?php echo esc_html($config['name']); ?>
        <?php if (strlen($search))
            printf('<span class="subtitle">' . __('Search results for &#8220;%s&#8221;') . '</span>', esc_html($search)); ?></h2>
        <?php if (strlen($message)) : ?>
            <div id="message" class="updated below-h2">
                <p><?php echo $message; ?></p>
            </div>
        <?php endif; ?>
        <div class="iphorm-global-nav-wrap clearfix">
        	<ul class="iphorm-global-nav-ul">
            	<li><a href="admin.php?page=iphorm_forms"><span class="ifb-no-arrow"><?php esc_html_e('All Forms', 'iphorm'); ?></span></a></li>
                <li>
                <div class="iphorm-form-switcher">
                    <a id="iphorm-form-switcher-trigger" class="ifb-form-switcher-closed"><span class="ifb-arrow-down"><?php esc_html_e('Switch Form', 'iphorm'); ?></span></a>
                        <div class="iphorm-form-switcher-list">
                            <ul class="clearfix">
                                <li class="iphorm-create-new clearfix"><a title="<?php esc_attr_e('Create a new form', 'iphorm'); ?>" href="admin.php?page=iphorm_form_builder"><?php esc_html_e('Create a new form', 'iphorm'); ?><span class="ifb-add-icon"></span></a></li>
                                <?php if (count($allForms)) : ?>
                                    <?php foreach ($allForms as $allForm) : ?>
                                        <li class="clearfix"><a title="<?php echo esc_attr($allForm['name']); ?>" href="admin.php?page=iphorm_entries&amp;id=<?php echo $allForm['id']; ?>"><?php echo esc_html($allForm['name']); ?><span class="ifb-fade-overflow"></span></a></li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </li>
                <?php if (current_user_can('iphorm_build_form')) : ?>
                    <li>
                        <a id="iphorm-builder-to-entries-link" class="ifb-hide-if-new-form" href="<?php echo admin_url('admin.php?page=iphorm_form_builder&amp;id=' . $id); ?>"><span class="ifb-no-arrow"><?php esc_html_e('Edit Form', 'iphorm'); ?></span></a>
                    </li>
                    <li>
                        <a href="<?php echo admin_url('admin.php?page=iphorm_form_builder&amp;id=' . $id . '#ifb-settings-entries'); ?>"><span class="ifb-no-arrow"><?php esc_attr_e('Edit Table Layout', 'iphorm'); ?></span></a>
                	</li>
            	<?php endif; ?>
            </ul>
             <div class="iphorm-current-form">
                <span class="ifb-update-form-name"><?php echo esc_html($config['name']); ?></span><span class="ifb-update-form-id">(<?php echo $id; ?>)</span>
            </div>
        </div>

        <form id="iphorm-entries-filter" method="get" action="">
        <input type="hidden" name="id" value="<?php echo $id; ?>" />
        <input type="hidden" name="page" value="iphorm_entries" />
        <ul class="subsubsub">
            <li><a href="admin.php?page=iphorm_entries&amp;id=<?php echo $id; ?>" class="<?php if (!strlen($search)) echo 'current'; ?>"><?php esc_html_e('All', 'iphorm'); ?> (<?php echo $allItems; ?>)</a></li>
            <?php if (strlen($search)) : ?>
                <li>| <a href="admin.php?page=iphorm_entries&amp;id=<?php echo $id; ?>" class="<?php echo 'current'; ?>"><?php esc_html_e('Search results', 'iphorm'); ?> (<?php echo $totalItems; ?>)</a></li>
            <?php endif; ?>
        </ul>
        <p class="search-box entry-search-box-wrap">
            <input class="entry-search-box" type="text" value="<?php _admin_search_query(); ?>" name="s" />
            <input type="submit" value="<?php esc_attr_e('Search Entries', 'iphorm'); ?>" class="button entry-search-submit" name="" />
        </p>
        <div class="tablenav top">
            <div class="alignleft actions">
                <select id="iphorm-bulk-action" name="bulk_action">
                    <option selected="selected" value="-1"><?php esc_html_e('Bulk Actions', 'iphorm'); ?></option>
                    <option value="read"><?php esc_html_e('Mark as read', 'iphorm'); ?></option>
                    <option value="unread"><?php esc_html_e('Mark as unread', 'iphorm'); ?></option>
                    <option value="delete"><?php esc_html_e('Delete', 'iphorm'); ?></option>
                </select>
                <input type="submit" value="<?php esc_attr_e('Apply', 'iphorm'); ?>" class="button-secondary action iphorm-bulk-delete-entry-go" id="doaction" name="" />
                <select id="iphorm-filter-epp" name="epp">
                    <option value="10" <?php selected($limit, 10); ?>>10</option>
                    <option value="20" <?php selected($limit, 20); ?>>20</option>
                    <option value="40" <?php selected($limit, 40); ?>>40</option>
                    <option value="60" <?php selected($limit, 60); ?>>60</option>
                    <option value="80" <?php selected($limit, 80); ?>>80</option>
                    <option value="100" <?php selected($limit, 100); ?>>100</option>
                    <option value="1000000" <?php selected($limit, 1000000); ?>><?php esc_html_e('All', 'iphorm'); ?></option>
                </select>
                <span class="iphorm-entries-per-page"><?php esc_html_e('per page', 'iphorm'); ?></span>
            </div>
            <?php echo $topPagination; ?>
            <br class="clear" />
        </div> <!-- /.tablenav top -->

        <table cellspacing="0" class="wp-list-table widefat fixed iphorm-entries-list-table">
            <thead>
                <tr>
                    <th class="manage-column column-cb check-column" id="cb" scope="col">
                        <input type="checkbox" />
                    </th>
                    <?php ob_start(); ?>
                        <?php foreach ($columns as $column) :
                                $columnId = ($column['type'] == 'element') ? 'element_'.$column['id'] : $column['id'];
                            ?>
                            <?php if ($columnId == $orderby) : ?>
                                <th class="manage-column column-<?php echo $columnId; ?> sorted <?php echo $order; ?>" scope="col">
                                    <a href="<?php echo esc_url(add_query_arg(array('orderby' => $columnId, 'order' => strtolower($reverseOrder)))); ?>">
                            <?php else : ?>
                                <th class="manage-column column-<?php echo $columnId; ?> sortable desc" scope="col">
                                    <a href="<?php echo esc_url(add_query_arg(array('orderby' => $columnId, 'order' => 'asc'))); ?>">
                            <?php endif; ?>
                                    <span><?php echo esc_html($column['label']); ?></span>
                                    <span class="sorting-indicator"></span>
                                    </a>
                                </th>

                        <?php endforeach; ?>
                    <?php echo $headings = ob_get_clean(); ?>
                </tr>
            </thead>

            <tfoot>
                <tr>
                    <th class="manage-column column-cb check-column" scope="col">
                        <input type="checkbox" />
                    </th>
                    <?php echo $headings; ?>
                </tr>
            </tfoot>

            <tbody id="the-list">
                <?php if (count($entries)) : ?>
                    <?php $i = 1; ?>
                    <?php foreach ($entries as $entry) : ?>
                        <tr valign="top" class="<?php echo (++$i % 2 == 1) ? 'alternate' : ''; ?> <?php if ($entry->unread == 1) echo 'iphorm-unread-entry'; ?>" id="iphorm-<?php echo $entry->id; ?>">
                            <th class="check-column" scope="row">
                                <input type="checkbox" value="<?php echo $entry->id; ?>" name="entry[]" />
                            </th>
                            <?php $j = 0; foreach ($columns as $column) : ?>
                                <td class="iphorm-entry-cell iphorm-entry-cell-<?php echo $column['id']; ?>">
                                    <?php if ($j == 1) : ?>
                                        <a class="iphorm-row-title" title="<?php esc_attr_e('View this entry', 'iphorm'); ?>" href="<?php echo esc_url(add_query_arg(array('action' => 'entry', 'entry_id' => $entry->id, 'id' => $id))); ?>">
                                    <?php endif; ?>
                                    <?php
                                        if ($column['type'] == 'element') {
                                            $key = 'element_' . $column['id'];
                                            echo $entry->$key;
                                        } else {
                                            switch ($column['id']) {
                                                case 'date_added':
                                                    echo iphorm_format_date($entry->date_added, true);
                                                    break;
                                                case 'user_email':
                                                    if (strlen($entry->user_email)) {
                                                        echo '<a href="mailto:' . esc_attr($entry->user_email) . '">' . esc_html($entry->user_email) . '</a>';
                                                    }
                                                    break;
                                                default:
                                                    echo $entry->{$column['id']};
                                                    break;
                                            }
                                        }
                                    ?>
                                    <?php if ($j == 1) : ?>
                                        </a>
                                        <div class="row-actions">
                                            <span class="view"><a href="<?php echo esc_url(add_query_arg(array('action' => 'entry', 'entry_id' => $entry->id, 'id' => $id), $currentUrl)); ?>" title="<?php esc_attr_e('View this entry', 'iphorm'); ?>"><?php esc_html_e('View', 'iphorm'); ?></a> |</span>
                                            <?php if ($entry->unread == 1) : ?>
                                                <span class="mark-read"><a href="<?php echo esc_url(add_query_arg(array('action' => 'read', 'entry_id' => $entry->id, 'id' => $id, '_wpnonce' => wp_create_nonce('iphorm_entry_read_' . $entry->id)), $currentUrl)); ?>" title="<?php esc_attr_e('Mark as read', 'iphorm'); ?>"><?php esc_html_e('Mark as read', 'iphorm'); ?></a> |</span>
                                            <?php else : ?>
                                                <span class="mark-unread"><a href="<?php echo esc_url(add_query_arg(array('action' => 'unread', 'entry_id' => $entry->id, 'id' => $id, '_wpnonce' => wp_create_nonce('iphorm_entry_unread_' . $entry->id)), $currentUrl)); ?>" title="<?php esc_attr_e('Mark as unread', 'iphorm'); ?>"><?php esc_html_e('Mark as unread', 'iphorm'); ?></a> |</span>
                                            <?php endif; ?>
                                            <span class="trash"><a class="submitdelete iphorm-delete-entry" title="<?php esc_attr_e('Delete this entry', 'iphorm'); ?>" href="<?php echo esc_url(add_query_arg(array('action' => 'delete', 'entry_id' => $entry->id, 'id' => $id, '_wpnonce' => wp_create_nonce('iphorm_entry_delete_' . $entry->id)), $currentUrl)); ?>"><?php esc_html_e('Delete', 'iphorm'); ?></a></span>
                                        </div>
                                    <?php endif; ?>
                                </td>
                            <?php $j++; endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr class="no-items">
                        <td colspan="<?php echo (count($columns) + 1); ?>" class="colspanchange"><p><?php esc_html_e('No entries found.', 'iphorm'); ?></p></td>
                    </tr>
                <?php endif; ?>
                </tbody>
        </table> <!-- /.wp-list-table -->

        <div class="tablenav bottom">
            <div class="alignleft actions">
                <select id="iphorm-bulk-action2" name="bulk_action2">
                    <option selected="selected" value="-1"><?php esc_html_e('Bulk Actions', 'iphorm'); ?></option>
                    <option value="read"><?php esc_html_e('Mark as read', 'iphorm'); ?></option>
                    <option value="unread"><?php esc_html_e('Mark as unread', 'iphorm'); ?></option>
                    <option value="delete"><?php esc_html_e('Delete', 'iphorm'); ?></option>
                </select>
                <input type="submit" value="<?php esc_attr_e('Apply', 'iphorm'); ?>" class="button-secondary action iphorm-bulk-delete-entry-go2" id="doaction2" name="" />
            </div>
            <?php echo $bottomPagination; ?>
            <br class="clear" />
        </div> <!-- /.tablenav bottom -->

        </form>
    <?php else : ?>
        <h2 class="ifb-main-title"><span class="ifb-iphorm-title">Quform</span><?php esc_html_e('Entries', 'iphorm'); ?></h2>
        <?php echo '<div class="iphorm-admin-notice error"><p><strong>' . sprintf(esc_html__('I couldn\'t find any forms, do you want to %screate one%s?', 'iphorm'), '<a href="' . admin_url('admin.php?page=iphorm_form_builder') . '">', '</a>') . '</strong></p></div>'; ?>
    <?php endif; ?>
</div>