<?php
if (!defined('IPHORM_VERSION')) exit;

$newline = "\r\n";
echo $mailer->Subject . $newline . $newline;

foreach ($form->getElements() as $element) {
    if (!$element->isHidden()) {
        echo $element->getAdminLabel() . $newline;
        echo '------------------------' . $newline;
        echo $element->getValuePlain();
    }

    echo $newline . $newline;
}