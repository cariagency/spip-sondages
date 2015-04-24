<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('sondage_fonctions');

function action_vider_reponses_sondage_dist() {
	$securiser_action = charger_fonction('securiser_action','inc');
	$id_sondage = $securiser_action();
	if (autoriser('viderreponses', 'sondage', $id_sondage))
		sondage_vider_reponses_sondage($id_sondage);
}

