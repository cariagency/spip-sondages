<?php

if (!defined('_ECRIRE_INC_VERSION')) return;

include_spip('inc/cookie');
spip_setcookie('sondage_test', 'test', time() + 60 * 60 * 24 * 90);


