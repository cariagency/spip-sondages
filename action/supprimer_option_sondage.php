<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('sondage_fonctions');

function action_supprimer_option_sondage_dist() {
	$securiser_action = charger_fonction('securiser_action','inc');
	$id_option_sondage = $securiser_action();
	if (autoriser('supprimer', 'optionsondage', $id_option_sondage))
		sondage_supprimer_option_sondage($id_option_sondage);
}

