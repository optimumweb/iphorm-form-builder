<?php if (!defined('IPHORM_VERSION')) exit; ?><div class="wrap">
	<div class="iphorm-top-right">
        <div class="iphorm-information">
        	<span class="iphorm-copyright"><a href="http://www.themecatcher.net" onclick="window.open(this.href); return false;">www.themecatcher.net</a> &copy; <?php echo date('Y'); ?></span>
        	<span class="iphorm-bug-link"><a href="http://www.themecatcher.net/support.php" onclick="window.open(this.href); return false;"><?php esc_html_e('Report a bug', 'iphorm'); ?></a></span>
        	<span class="iphorm-help-link"><a href="<?php echo iphorm_help_link(); ?>" onclick="window.open(this.href); return false;"><?php esc_html_e('Help', 'iphorm'); ?></a></span>
        </div>
    </div>
    <?php screen_icon('iphorm'); ?>
    <h2 class="ifb-main-title"><span class="ifb-iphorm-title">Quform</span><?php esc_html_e('Import form', 'iphorm'); ?></h2>

    <?php iphorm_global_nav('import'); ?>

    <?php if (count($messages)) : ?>
        <?php foreach ($messages as $message) : ?>
            <?php if ($message['type'] == 'success') : ?>
                <div class="updated below-h2"><p><strong><?php echo $message['message']; ?></strong></p></div>
            <?php elseif ($message['type'] == 'error') : ?>
                <div class="error below-h2"><p><strong><?php echo $message['message']; ?></strong></p></div>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
    <div class="iphorm-import-content">
        <h3 class="ifb-export-sub-head"><?php esc_html_e('Import form data', 'iphorm'); ?></h3>
    	<p><?php printf(esc_html__('Paste in the data generated from the Quform export page into the box below to import a form.
    		Bear in mind that the email address set to receive emails will be set to the value that
    		it was in the website that the export was taken from. You can change this value after you
    		import by going to %1$sSettings &rarr; Email%2$s in the form builder.', 'iphorm'), '<span class="ifb-bold">', '</span>'); ?></p>
        <div class="iphorm-import-form">
            <form action="" method="post">
                <div><textarea name="form_config" rows="15" cols="100"></textarea></div>
                <button class="iphorm-import-button" type="submit"><span><?php esc_html_e('Import', 'iphorm'); ?></span></button>
            </form>
        </div>
    </div>
</div>