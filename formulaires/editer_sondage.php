<?php

if (!defined('_ECRIRE_INC_VERSION')) return;

include_spip('inc/actions');
include_spip('inc/editer');
include_spip('inc/saisies');
include_spip('inc/formater');

function saisies_editer_sondage($id_sondage) {
	$saisies[] = array(
		'saisie' => 'input',
		'options' => array(
			'nom' => 'titre',
			'label' => _T('sondage:label_titre'),
			'obligatoire' => 'oui',
			'info_obligatoire' => '',
		)
	);
	$saisies[] = array(
		'saisie' => 'datetime',
		'options' => array(
			'nom' => 'date_debut',
			'label' => _T('sondage:label_date_debut'),
			'obligatoire' => 'oui',
			'info_obligatoire' => '',
		),
		'verifier' => array(
			'type' => 'datetime',
			'options' => array(
				'format' => 'jjmmaaaahhii'
			)
		),
		'formater' => array(
			'fonction' => 'datetime',
			'options' => array(
				'origine' => 'jjmmaaaahhii'
			)
		)
	);
	$saisies[] = array(
		'saisie' => 'datetime',
		'options' => array(
			'nom' => 'date_fin',
			'label' => _T('sondage:label_date_fin'),
			'obligatoire' => 'oui',
			'info_obligatoire' => '',
		),
		'verifier' => array(
			'type' => 'date_fin',
			'options' => array(
				'format' => 'jjmmaaaahhii',
				'debut' => 'date_debut'
			)
		),
		'formater' => array(
			'fonction' => 'datetime',
			'options' => array(
				'origine' => 'jjmmaaaahhii'
			)
		)
	);
	return $saisies;
}

function formulaires_editer_sondage_identifier_dist($id_sondage='new', $retour='', $lier_trad=0, $config_fonc='', $row=array(), $hidden='') {
	return serialize(array(intval($id_sondage)));
}

function formulaires_editer_sondage_charger_dist($id_sondage='new', $retour='', $lier_trad=0, $config_fonc='', $row=array(), $hidden='') {
	$valeurs = formulaires_editer_objet_charger('sondage', $id_sondage, '', $lier_trad, $retour, $config_fonc ,$row, $hidden);
	$valeurs['_saisies'] = saisies_editer_sondage($id_sondage);
	if (!intval($id_sondage)) {
		$valeurs['date_debut'] = date('Y-m-d H:i:s');
		$valeurs['date_fin'] = date('Y-m-d H:i:s', time() + 3600 * 24);
	}
	return $valeurs;
}

function formulaires_editer_sondage_verifier_dist($id_sondage='new', $retour='', $lier_trad=0, $config_fonc='', $row=array(), $hidden='') {
	$saisies = saisies_editer_sondage($id_sondage);
	return saisies_verifier($saisies);
}

function formulaires_editer_sondage_traiter_dist($id_sondage='new', $retour='', $lier_trad=0, $config_fonc='', $row=array(), $hidden='') {
	$saisies = saisies_editer_sondage($id_sondage);
	formater_saisies($saisies);

	return formulaires_editer_objet_traiter('sondage', $id_sondage, '', $lier_trad, $retour, $config_fonc, $row, $hidden);
}


