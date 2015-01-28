<?php

if (!defined('_ECRIRE_INC_VERSION')) return;

include_spip('inc/actions');
include_spip('inc/editer');
include_spip('inc/config');
include_spip('inc/saisies');
include_spip('inc/formater');

function saisies_editer_option_sondage($id_option_sondage) {
	if (intval($id_option_sondage) == 0) {
		$id_sondage = _request('id_sondage');
	} else {
		$id_sondage = sql_getfetsel('id_sondage', 'spip_options_sondage', 'id_option_sondage='.intval($id_option_sondage));
	}
	$saisies[] = array(
		'saisie' => 'hidden',
		'options' => array(
			'nom' => 'id_sondage'
		)
	);
	$saisies[] = array(
		'saisie' => 'input',
		'options' => array(
			'nom' => 'titre',
			'label' => _T('option_sondage:label_titre'),
			'obligatoire' => 'oui',
			'info_obligatoire' => ''
		)
	);
	$champs_meme_parent = sql_select('id_option_sondage, ordre, titre', 'spip_options_sondage', 'id_sondage='.intval($id_sondage).' AND id_option_sondage!='.intval($id_option_sondage), '', 'ordre');
	if (sql_count($champs_meme_parent) > 0) {
		$ordre[0] = _T('option_sondage:option_en_premier');
		while ($arr = sql_fetch($champs_meme_parent)) {
			$i = $arr['ordre'] + 1;
			$ordre[$i] = _T('option_sondage:option_apres', array('titre' => $arr['titre']));
		}
		$saisies[] = array(
			'saisie' => 'selection',
			'options' => array(
				'nom' => 'ordre',
				'label' => _T('option_sondage:label_ordre'),
				'obligatoire' => 'oui',
				'cacher_option_intro' => 'oui',
				'info_obligatoire' => '',
				'datas' => $ordre
			)
		);
	}
	return $saisies;
}

function formulaires_editer_option_sondage_charger_dist($id_option_sondage='new', $retour='', $associer_objet='', $lier_trad=0, $config_fonc='', $row=array(), $hidden='') {
	$valeurs = formulaires_editer_objet_charger('option_sondage', $id_option_sondage, '', $lier_trad, $retour, $config_fonc, $row, $hidden);
	$valeurs['_saisies'] = saisies_editer_option_sondage($id_option_sondage);
	if (intval($id_option_sondage) == 0) {
		$valeurs['id_sondage'] = _request('id_sondage');
		$ordre = sql_getfetsel('MAX(ordre) as ordre', 'spip_options_sondage', 'id_sondage='.intval($valeurs['id_sondage']));
		$valeurs['ordre'] = $ordre + 1;
	}
	return $valeurs;
}

function formulaires_editer_option_sondage_verifier_dist($id_option_sondage='new', $retour='', $associer_objet='', $lier_trad=0, $config_fonc='', $row=array(), $hidden='') {
	$saisies = saisies_editer_option_sondage($id_option_sondage);
	return saisies_verifier($saisies);
}

function formulaires_editer_option_sondage_traiter_dist($id_option_sondage='new', $retour='', $associer_objet='', $lier_trad=0, $config_fonc='', $row=array(), $hidden='') {
	$saisies = saisies_editer_option_sondage($id_option_sondage);
	formater_saisies($saisies);

	$id_sondage = _request('id_sondage');
	$res = formulaires_editer_objet_traiter('option_sondage', $id_option_sondage, '', $lier_trad, $retour, $config_fonc, $row, $hidden);

	$res['redirect'] = generer_url_ecrire('sondage', 'id_sondage='.$id_sondage);
	return $res;
}


