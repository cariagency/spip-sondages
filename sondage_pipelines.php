<?php

if (!defined('_ECRIRE_INC_VERSION')) return;

include_spip('sondage_fonctions');

function sondage_post_edition($flux) {
	// options_sondage
	if ($flux['args']['action'] == 'modifier' AND $flux['args']['table'] == 'spip_options_sondage') {
		$id_option_sondage = $flux['args']['id_objet'];
		if (isset($flux['data']['ordre'])) {
			$ordre = $flux['data']['ordre'];
			sondage_ordonner_option_sondage($id_option_sondage, $ordre);
		}
	}
	return $flux;
}

