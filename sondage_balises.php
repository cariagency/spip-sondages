<?php

if (!defined('_ECRIRE_INC_VERSION')) return;

include_spip('sondage_fonctions');

function balise_NB_REPONSES_dist($p) {
	$objet = interprete_argument_balise(1,$p);
	$id_objet = interprete_argument_balise(2,$p);
	$p->code = "calculer_NB_REPONSES($objet,$id_objet)";
	$p->interdire_scripts = false;
	return $p;
}

function calculer_NB_REPONSES($objet, $id_objet) {
	if ($objet == 'sondage') {
		$nb_reponses = sql_getfetsel('nb_reponses', 'spip_sondages', 'id_sondage='.intval($id_objet));
	} else if ($objet == 'option_sondage') {
		$nb_reponses = intval(sql_countsel('spip_reponses_sondage', 'id_option_sondage='.intval($id_objet)));
	}
	return $nb_reponses;
}

function balise_POURCENTAGE_OPTION_SONDAGE_dist($p) {
	$_id_sondage = champ_sql('id_sondage', $p);
	$_id_option_sondage = champ_sql('id_option_sondage', $p);
	if ($p->param && !$p->param[0][0]){
		$_precision = calculer_liste($p->param[0][1],
							$p->descr,
							$p->boucles,
							$p->id_boucle);
	} else {
		$_precision = '2';
	}
	$p->code = "calculer_POURCENTAGE_OPTION_SONDAGE($_id_sondage,$_id_option_sondage,$_precision)";
	$p->interdire_scripts = false;
	return $p;
}

function calculer_POURCENTAGE_OPTION_SONDAGE($id_sondage, $id_option_sondage, $precision) {
	$nb_reponses = sondage_calculer_nb_reponses_sondage($id_sondage);
	if ($nb_reponses) {
		$nb_reponses_option = intval(sql_countsel('spip_reponses_sondage', 'id_option_sondage='.intval($id_option_sondage)));
		$pourcentage = round(($nb_reponses_option / $nb_reponses) * 100, $precision);
		return $pourcentage;
	} else {
		return 0;
	}
}

function balise_URL_VOTER($p) {
	$_id_sondage = champ_sql('id_sondage', $p);
	$_id_option_sondage = champ_sql('id_option_sondage', $p);
	$_retour = interprete_argument_balise(1,$p);
	$p->code = "calculer_URL_VOTER($_id_sondage,$_id_option_sondage,$_retour)";
	$p->interdire_scripts = false;
	return $p;
}

function calculer_URL_VOTER($id_sondage, $id_option_sondage, $retour) {
	return generer_url_action('voter', 'id_sondage='.$id_sondage.'&id_option_sondage='.$id_option_sondage.'&retour='.urlencode($retour), true);
}

