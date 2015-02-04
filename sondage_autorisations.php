<?php

if (!defined('_ECRIRE_INC_VERSION')) return;

function sondage_autoriser() {}

// -----------------
// Objet sondages

function autoriser_sondages_menu_dist($faire, $type, $id, $qui, $opt) {
	return true;
} 

function autoriser_sondagecreer_menu_dist($faire, $type, $id, $qui, $opt) {
	return false;
} 

function autoriser_sondage_creer_dist($faire, $type, $id, $qui, $opt) {
	return in_array($qui['statut'], array('0minirezo', '1comite')); 
}

function autoriser_sondage_voir_dist($faire, $type, $id, $qui, $opt) {
	return true;
}

function autoriser_sondage_modifier_dist($faire, $type, $id, $qui, $opt) {
	return in_array($qui['statut'], array('0minirezo', '1comite'));
}

function autoriser_sondage_supprimer_dist($faire, $type, $id, $qui, $opt) {
	return in_array($qui['statut'], array('0minirezo', '1comite')); 
}

function autoriser_sondage_viderreponses_dist($faire, $type, $id, $qui, $opt) {
	$test = sql_countsel('spip_reponses_sondage', 'id_sondage='.intval($id));
	if ($test)
		return in_array($qui['statut'], array('0minirezo', '1comite')); 
	return false;
}

function autoriser_sondage_voter_dist($faire, $type, $id, $qui, $opt) {
	if (isset($_COOKIE['sondage_'.$id])) {
		return false;
	} else {
		return true;
	}
}

// -----------------
// Objet option_sondage

function autoriser_optionsondage_creer_dist($faire, $type, $id, $qui, $opt) {
	return in_array($qui['statut'], array('0minirezo', '1comite')); 
}

function autoriser_optionsondage_voir_dist($faire, $type, $id, $qui, $opt) {
	return true;
}

function autoriser_optionsondage_modifier_dist($faire, $type, $id, $qui, $opt) {
	return in_array($qui['statut'], array('0minirezo', '1comite'));
}

function autoriser_optionsondage_supprimer_dist($faire, $type, $id, $qui, $opt) {
	return in_array($qui['statut'], array('0minirezo', '1comite'));
}

function autoriser_optionsondage_ordonner_dist($faire, $type, $id, $qui, $opt) {
	return in_array($qui['statut'], array('0minirezo', '1comite'));
}

// -----------------
// Objet reponses_sondage

function autoriser_reponsessondage_creer_dist($faire, $type, $id, $qui, $opt) {
	return false;
}

function autoriser_reponsessondage_voir_dist($faire, $type, $id, $qui, $opt) {
	return false;
}

function autoriser_reponsessondage_modifier_dist($faire, $type, $id, $qui, $opt) {
	return false;
}

function autoriser_reponsessondage_supprimer_dist($faire, $type, $id, $qui, $opt) {
	return false;
}


