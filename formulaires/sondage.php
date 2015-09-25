<?php

if (!defined('_ECRIRE_INC_VERSION')) return;

include_spip('inc/actions');
include_spip('inc/editer');
include_spip('inc/config');
include_spip('inc/saisies');
include_spip('inc/cookie');

function saisies_sondage($id_sondage) {
	$titre = sql_getfetsel('titre', 'spip_sondages', 'id_sondage='.intval($id_sondage));
	$saisies[] = array(
		'saisie' => 'option_sondage',
		'options' => array(
			'nom' => 'id_option_sondage',
			'label' => $titre,
			'obligatoire' => 'oui',
			'info_obligatoire' => '',
			'id_sondage' => $id_sondage,
			'erreur_obligatoire' => _T('sondage:erreur_choix_obligatoire')
		),
		'verifier' => array(
			'type' => 'option_sondage',
			'options' => array(
				'id_sondage' => $id_sondage
			)
		)
	);
	return $saisies;
}

function formulaires_sondage_identifier_dist($id_sondage) {
	return serialize(array(intval($id_sondage)));
}

function formulaires_sondage_charger_dist($id_sondage) {
	include_spip('inc/cookie');
	spip_setcookie('sondage_test', 'test', time() + 60 * 60 * 24 * 90);
	$valeurs = array();
	$maintenant = date('Y-m-d H:i:s');
	$verification = sql_countsel('spip_sondages', 'date_debut<='.sql_quote($maintenant).' AND date_fin>='.sql_quote($maintenant));
	if ($verification) {
		$valeurs['_saisies'] = saisies_sondage($id_sondage);
		$valeurs['id_sondage'] = $id_sondage;
		if (isset($_COOKIE['sondage_'.$id_sondage])) {
			$valeurs['editable'] = false;
			$valeurs['afficher_resultats'] = 'oui';
		}
	} else {
		$valeurs['editable'] = false;
	}
	return $valeurs;
}

function formulaires_sondage_verifier_dist($id_sondage) {
	$saisies = saisies_sondage($id_sondage);
	$erreurs = saisies_verifier($saisies);
	return $erreurs;
}

function formulaires_sondage_traiter_dist($id_sondage) {
	if (!isset($_COOKIE['sondage_test'])) {
		$res['message_erreur'] = _T('sondage:erreur_cookie');
	} else {
		$id_option_sondage = intval(_request('id_option_sondage'));
		sondage_voter($id_sondage, $id_option_sondage);
		$res['message_ok'] = ' ';
		$res['editable'] = false;
	}
	return $res;
}


