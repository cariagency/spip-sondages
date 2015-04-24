<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('sondage_fonctions');

function action_supprimer_sondage_dist() {
	$securiser_action = charger_fonction('securiser_action','inc');
	$id_sondage = $securiser_action();
	if (autoriser('supprimer', 'sondage', $id_sondage))
		sondage_supprimer_sondage($id_sondage);
}

