<?php if (!defined('IPHORM_VERSION')) exit; ?><!DOCTYPE html>
<html lang="en-US">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Quform <?php esc_html_e('Preview', 'iphorm'); ?></title>

<link rel="stylesheet" href="<?php echo IPHORM_ADMIN_URL . '/css/preview.css'; ?>" type="text/css" />
<link rel="stylesheet" href="<?php echo IPHORM_PLUGIN_URL . '/css/styles.css'; ?>" type="text/css" />
<?php if (!get_option('iphorm_disable_qtip_output')) : ?>
<link rel="stylesheet" href="<?php echo IPHORM_PLUGIN_URL . '/js/qtip2/jquery.qtip.css'; ?>" type="text/css" />
<?php endif; ?>
<?php
if (!get_option('iphorm_disable_uniform_ouput')) {
    $allUniformThemes = iphorm_get_all_uniform_themes();
    foreach ($allUniformThemes as $uniformTheme) {
        echo '<link rel="stylesheet" href="' . IPHORM_PLUGIN_URL . "/js/uniform/themes/" . $uniformTheme['Folder'] . "/". $uniformTheme['Folder'] . '.css" type="text/css" />' . PHP_EOL;
    }
}
$allThemes = iphorm_get_all_themes();
foreach ($allThemes as $theme) {
    echo '<link rel="stylesheet" href="' . IPHORM_PLUGIN_URL . "/themes/" . $theme['Folder'] . "/" . $theme['Filename'] . '.css" type="text/css" />' . PHP_EOL;
}
if (file_exists(IPHORM_PLUGIN_DIR . '/css/custom.css')) {
    echo '<link rel="stylesheet" href="' . IPHORM_PLUGIN_URL . '/css/custom.css" type="text/css" />' . PHP_EOL;
}
?>

<?php wp_print_scripts(array('jquery', 'json2', 'swfupload-all')); ?>
<script type="text/javascript" src="<?php echo IPHORM_PLUGIN_URL . '/js/iphorm.js'; ?>"></script>
</head>
<body>
<div class="ip-outside">
    <div class="ip-header"><span class="ifb-info-message-icon"></span><?php esc_html_e('The preview does not include your WordPress theme CSS
    so it may look different when viewed on a page on your website.', 'iphorm'); ?>
    <a class="iphorm-refresh-preview-window" href="javascript:;" onclick="window.location.reload()"><?php esc_html_e('Refresh', 'iphorm'); ?></a></div>
    <div class="ip-loading">
        <?php esc_html_e('Loading form preview...', 'iphorm'); ?>
    </div>
    <div class="ip-sorry">
        <h3><?php esc_html_e('Sorry, there was a problem', 'iphorm'); ?></h3>
        <p><?php esc_html_e('The form preview could not be loaded, this could be due to one
        of the reasons below.', 'iphorm'); ?></p>
        <ul>
            <li><?php esc_html_e('The preview requires the form builder page to be open', 'iphorm'); ?></li>
            <li><?php esc_html_e('The form has been deleted', 'iphorm'); ?></li>
        </ul>
        <p><?php esc_html_e('Please address these issues and load the preview again.', 'iphorm'); ?></p>
    </div>
    <div class="ip-form-wrap"></div>
</div>
<?php if ($form != null) : ?>
<script type="text/javascript">
//<![CDATA[
var form = <?php echo iphorm_json_encode($form); ?>;
//]]>
</script>
<?php endif; ?>
<script type="text/javascript">
//<![CDATA[
var iphormPreviewL10n = <?php echo iphorm_json_encode($previewL10n); ?>;
//]]>
</script>
<script type="text/javascript">
//<![CDATA[
var iphormL10n = <?php echo iphorm_json_encode(iphorm_js_l10n()); ?>;
//]]>
</script>
<script type="text/javascript" src="<?php echo IPHORM_ADMIN_URL . '/js/iphorm-preview.js'; ?>"></script>
<?php if (version_compare(get_bloginfo('version'), '3.2') >= 0) : ?>
<?php wp_print_scripts(array('jquery-form')); ?>
<?php else : ?>
<script type="text/javascript" src="<?php echo IPHORM_PLUGIN_URL . '/js/jquery.form.js'; ?>"></script>
<?php endif; ?>
<script type="text/javascript" src="<?php echo IPHORM_PLUGIN_URL . '/js/jquery.iphorm.js'; ?>"></script>
<?php if (!get_option('iphorm_disable_smoothscroll_output')) : ?>
<script type="text/javascript" src="<?php echo IPHORM_PLUGIN_URL . '/js/jquery.smooth-scroll.min.js'; ?>"></script>
<?php endif; ?>
<?php if (!get_option('iphorm_disable_qtip_output')) : ?>
<script type="text/javascript" src="<?php echo IPHORM_PLUGIN_URL . '/js/qtip2/jquery.qtip.min.js'; ?>"></script>
<?php endif; ?>
<?php if (!get_option('iphorm_disable_uniform_ouput')) : ?>
<script type="text/javascript" src="<?php echo IPHORM_PLUGIN_URL . '/js/uniform/jquery.uniform.js'; ?>"></script>
<?php endif; ?>
<?php if (!get_option('iphorm_disable_infieldlabels_output')) : ?>
<script type="text/javascript" src="<?php echo IPHORM_PLUGIN_URL . '/js/jquery.infieldlabel.min.js'; ?>"></script>
<?php endif; ?>
<?php if (!get_option('iphorm_disable_jqueryui_output')) : ?>
<script type="text/javascript" src="<?php echo IPHORM_PLUGIN_URL . '/js/jqueryui/jquery.ui.core.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo IPHORM_PLUGIN_URL . '/js/jqueryui/jquery.ui.datepicker.min.js'; ?>"></script>
<?php endif; ?>
<?php
$allThemes = iphorm_get_all_themes();
foreach ($allThemes as $theme) {
    if (file_exists(IPHORM_PLUGIN_DIR . "/themes/" . $theme['Folder'] . "/" . $theme['Filename'] . ".js")) {
        echo '<script type="text/javascript" src="' . IPHORM_PLUGIN_URL . "/themes/" . $theme['Folder'] . "/" . $theme['Filename'] . '.js"></script>' . PHP_EOL;
	}
}
?>
</body>
</html>