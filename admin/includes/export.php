<?php if (!defined('IPHORM_VERSION')) exit; ?><div class="wrap">
	<div class="iphorm-top-right">
        <div class="iphorm-information">
        	<span class="iphorm-copyright"><a href="http://www.themecatcher.net" onclick="window.open(this.href); return false;">www.themecatcher.net</a> &copy; <?php echo date('Y'); ?></span>
        	<span class="iphorm-bug-link"><a href="http://www.themecatcher.net/support.php" onclick="window.open(this.href); return false;"><?php esc_html_e('Report a bug', 'iphorm'); ?></a></span>
        	<span class="iphorm-help-link"><a href="<?php echo iphorm_help_link(); ?>" onclick="window.open(this.href); return false;"><?php esc_html_e('Help', 'iphorm'); ?></a></span>
        </div>
    </div>
    <?php screen_icon('iphorm'); ?>
    <h2 class="ifb-main-title"><span class="ifb-iphorm-title">Quform</span>
    <?php
    if ($action === 'form') {
        esc_html_e('Export form', 'iphorm');
    } else {
        esc_html_e('Export entries', 'iphorm');
    }
    ?>
    </h2>

    <?php iphorm_global_nav('export'); ?>

    <div class="iphorm-global-sub-nav-wrap clearfix">
        <ul class="iphorm-global-sub-nav-ul">
            <li><a href="admin.php?page=iphorm_export&amp;action=entries" class="<?php if ($action === 'entries') echo 'current'; ?>"><span class="ifb-no-arrow"><?php esc_html_e('Export Entries', 'iphorm'); ?></span></a></li>
            <li><a href="admin.php?page=iphorm_export&amp;action=form" class="<?php if ($action === 'form') echo 'current'; ?>"><span class="ifb-no-arrow"><?php esc_html_e('Export Form', 'iphorm'); ?></span></a></li>
        </ul>
    </div>

    <div class="iphorm-export-content">
        <?php if ($action === 'entries') : ?>
            <div class="iphorm-export-entries">
                <form action="" method="post">
                    <input type="hidden" name="page" value="iphorm_export" />
                    <input type="hidden" name="action" value="entries" />
                    <?php if (count($allForms)) : ?>
                        <div class="iphorm-export-entries-inner clearfix">
                        	<div class="iphorm-export-entries-left">
                                <h3 class="ifb-export-sub-head"><?php esc_html_e('Select a form', 'iphorm'); ?></h3>
                                <div class="clearfix">
                                    <select id="export_entries_form_id" name="form_id">
                                        <option value=""><?php esc_html_e('Please select', 'iphorm'); ?></option>
                                        <?php foreach ($allForms as $allForm) : ?>
                                            <option value="<?php echo $allForm['id']; ?>"><?php echo esc_html($allForm['name']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="iphorm-export-entries-loading"></div>
                                </div>
                                <div id="iphorm-export-entries-fields-wrap">
                                    <h3 class="ifb-export-sub-head"><?php esc_html_e('Choose which fields to export', 'iphorm'); ?></h3>
                                    <div class="iphorm-export-all-fields"><label for="export_all_fields"><input type="checkbox" id="export_all_fields" /> <?php esc_html_e('Tick all', 'iphorm'); ?></label></div>
                                    <div id="iphorm-export-entries-fields"></div>
                                    <div class="iphorm-export-entries-date-wrap">
                                        <h3 class="ifb-export-sub-head"><?php esc_html_e('Date range (optional)', 'iphorm'); ?></h3>
                                        <label for="from"><?php esc_html_e('From', 'iphorm'); ?></label>
                                        <div><input type="text" name="from" id="from" /></div>
                                        <label for="to"><?php esc_html_e('To', 'iphorm'); ?></label>
                                        <div><input type="text" name="to" id="to" /></div>
                                        <p class="description"><?php esc_html_e('Click the fields to show a calendar', 'iphorm'); ?></p>
                                    </div>
                                    <div class="iphorm-export-entries-buttons">
                                        <button class="iphorm-export-entries-button" type="submit" name="iphorm_do_entries_export" value="1"><span><?php esc_html_e('Download', 'iphorm'); ?></span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else : ?>
                        <div id="message" class="updated below-h2">
                            <p><?php printf(esc_html__('No forms found, %sclick here to create one%s.', 'iphorm'), '<a href="admin.php?page=iphorm_form_builder">', '</a>'); ?></p>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
        <?php elseif ($action === 'form') : ?>
            <div class="iphorm-export-form">
                <form action="" method="get">
                    <input type="hidden" name="page" value="iphorm_export" />
                    <input type="hidden" name="action" value="form" />
                    <?php if (count($allForms)) : ?>
                        <h3 class="ifb-export-sub-head"><?php esc_html_e('Select a form to export', 'iphorm'); ?></h3>
                        <p>
                            <select name="id">
                                <?php $id = isset($_GET['id']) ? absint($_GET['id']) : 0; ?>
                                <?php foreach ($allForms as $allForm) : ?>
                                    <option value="<?php echo $allForm['id']; ?>" <?php selected($id, $allForm['id']); ?>><?php echo esc_html($allForm['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button class="iphorm-export-button" type="submit"><span><?php esc_html_e('Export', 'iphorm'); ?></span></button>
                        </p>
                    <?php else : ?>
                        <div id="message" class="updated below-h2">
                            <p><?php printf(esc_html__('No forms found, %sclick here to create one%s.', 'iphorm'), '<a href="admin.php?page=iphorm_form_builder">', '</a>'); ?></p>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
            <?php if (strlen($exportData)) : ?>
                <h3 class="ifb-export-sub-head"><?php esc_html_e('Form export data', 'iphorm'); ?></h3>
                <div class="iphorm-export-data">
                    <ul>
                        <li><?php esc_html_e('Click inside the box to select all text', 'iphorm'); ?></li>
                        <li><?php esc_html_e('Copy the text inside the box and paste it into the box on the Quform Import page on another website', 'iphorm'); ?></li>
                    </ul>
                    <div><textarea rows="15" cols="100"><?php echo esc_html($exportData); ?></textarea></div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>