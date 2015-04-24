<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

function verifier_option_sondage_dist($id_option_sondage, $options=array()) {
	$id_sondage = $options['id_sondage'];
	$verification = sql_countsel('spip_options_sondage', 'id_sondage='.intval($id_sondage).' AND id_option_sondage='.intval($id_option_sondage));
	if (!$verification)
		return _T('sondage:erreur_choix_inconnu');
	return '';
}

