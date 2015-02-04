<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('sondage_fonctions');

function action_voter_dist() {
	$id_sondage = _request('id_sondage');
	$id_option_sondage = _request('id_option_sondage');
	$retour = _request('retour');

	if (autoriser('voter', 'sondage', $id_sondage))
		sondage_voter($id_sondage, $id_option_sondage);

	header('Location:'.str_replace('&amp;', '&', $retour));
	exit();
}

