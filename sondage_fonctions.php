<?php

if (!defined('_ECRIRE_INC_VERSION')) return;

include_spip('sondage_balises');
include_spip('sondage_criteres');

function sondage_voter($id_sondage, $id_option_sondage) {
	$verification = (intval($id_option_sondage) == 0 || sql_countsel('spip_options_sondage', 'id_sondage='.intval($id_sondage).' AND id_option_sondage='.intval($id_option_sondage)));
	if ($verification) {
		if (intval($id_option_sondage) > 0) {
			sql_insertq('spip_reponses_sondage', array('id_sondage' => $id_sondage, 'id_option_sondage' => $id_option_sondage));
			sondage_mettre_a_jour_nb_reponses_sondage($id_sondage);
		}
		spip_setcookie('sondage_'.$id_sondage, 1, time() + 3600 * 24 * 365); // 1 an
	}
}

function sondage_calculer_nb_reponses_sondage($id_sondage) {
	$nb_reponses = sql_countsel('spip_reponses_sondage', 'id_sondage='.intval($id_sondage));
	return $nb_reponses;
}

function sondage_mettre_a_jour_nb_reponses_sondage($id_sondage) {
	$nb_reponses = sondage_calculer_nb_reponses_sondage($id_sondage);
	sql_updateq('spip_sondages', array('nb_reponses' => $nb_reponses), 'id_sondage='.intval($id_sondage));
	include_spip('inc/invalideur');
	suivre_invalideur("id='sondage/$id_sondage'");
}

function sondage_monter_option_sondage($id_option_sondage) {
	$option_sondage = sql_fetsel('ordre', 'spip_options_sondage', 'id_option_sondage='.intval($id_option_sondage));
	$ordre = $option_sondage['ordre'] - 1;
	sondage_ordonner_option_sondage($id_option_sondage, $ordre);
}

function sondage_descendre_option_sondage($id_option_sondage) {
	$option_sondage = sql_fetsel('ordre', 'spip_options_sondage', 'id_option_sondage='.intval($id_option_sondage));
	$ordre = $option_sondage['ordre'] + 1;
	sondage_ordonner_option_sondage($id_option_sondage, $ordre);
}

function sondage_ordonner_option_sondage($id_option_sondage, $ordre) {
	$id_sondage = sql_getfetsel('id_sondage', 'spip_options_sondage', 'id_option_sondage='.intval($id_option_sondage));
	$autres_options = sql_allfetsel('id_option_sondage', 'spip_options_sondage', 'id_sondage='.intval($id_sondage).' AND id_option_sondage!='.intval($id_option_sondage), '', 'ordre');
	if (count($autres_options)) {
		$tableau_options = array();
		foreach ($autres_options as $option) {
			$tableau_options[] = $option['id_option_sondage'];
		}
		$tableau_ordonne = sondage_ordonner_tableau($tableau_options, $id_option_sondage, $ordre);
		include_spip('inc/invalideur');
		foreach ($tableau_ordonne as $cle => $valeur) {
			sql_updateq('spip_options_sondage', array('ordre' => $cle), 'id_option_sondage='.intval($valeur));
			suivre_invalideur("id='option_sondage/$valeur'");
		}
	}
}

function sondage_ordonner_tableau($tableau_sans_id_a_inserer, $id_a_inserer, $position) {
	// on réordonne
	if ($id_a_inserer == 0) {
		foreach ($tableau_sans_id_a_inserer as $id)
		 	$tableau_final[] = $id;
	} else if ($position === 'dernier') {
		$tableau = array();
		foreach ($tableau_sans_id_a_inserer as $id)
		 	$tableau[] = $id;
		$tableau_final = array_merge($tableau, array($id_a_inserer));
	} else if ($position == 0) {
		$tableau = array();
		foreach ($tableau_sans_id_a_inserer as $id)
			$tableau[] = $id;
		$tableau_final = array_merge(array($id_a_inserer), $tableau);
	} else {
		$i = 0;
		$tableau_avant = array();
		$tableau_apres = array();
		$deuxieme_tableau = false;
		foreach ($tableau_sans_id_a_inserer as $id) {
			if ($position == $i)
				$deuxieme_tableau = true;
			if ($deuxieme_tableau)
				$tableau_apres[] = $id;
			else
				$tableau_avant[] = $id;
			$tableau[] = $id;
			$i++;
		}
		$tableau_final = array_merge($tableau_avant, array($id_a_inserer), $tableau_apres);
	}
	// on retourne le tableau final
	return $tableau_final;
}


function sondage_vider_reponses_sondage($id_sondage) {
	sql_delete('spip_reponses_sondage', 'id_sondage='.intval($id_sondage));
	sql_updateq('spip_sondages', array('nb_reponses' => 0), 'id_sondage='.intval($id_sondage));
	include_spip('inc/invalideur');
	suivre_invalideur("id='sondage/$id_sondage'");
}

function sondage_supprimer_sondage($id_sondage) {
	sql_delete('spip_sondages', 'id_sondage='.intval($id_sondage));
	$options_sondage = sql_select('id_option_sondage', 'spip_options_sondage', 'id_sondage='.intval($id_sondage));
	if (sql_count($options_sondage) > 0) {
		while ($arr = sql_fetch($options_sondage)) {
			sondage_supprimer_option_sondage($arr['id_option_sondage'], false);
		}
	}
}

function sondage_supprimer_option_sondage($id_option_sondage, $mettre_a_jour_nb_reponses_sondage=true) {
	if ($mettre_a_jour_nb_reponses_sondage) {
		$id_sondage = sql_getfetsel('id_sondage', 'spip_options_sondage', 'id_option_sondage='.intval($id_option_sondage));
	}
	$reponses_sondage = sql_select('id_reponse_sondage', 'spip_reponses_sondage', 'id_option_sondage='.intval($id_option_sondage));
	if (sql_count($reponses_sondage) > 0) {
		while ($arr = sql_fetch($reponses_sondage)) {
			sondage_supprimer_reponse_sondage($arr['id_reponse_sondage']);
		}
	}
	sql_delete('spip_options_sondage', 'id_option_sondage='.intval($id_option_sondage));
	if ($mettre_a_jour_nb_reponses_sondage) {
		sondage_mettre_a_jour_nb_reponses_sondage($id_sondage);
	}
}

function sondage_supprimer_reponse_sondage($id_reponse_sondage) {
	sql_delete('spip_reponses_sondage', 'id_reponse_sondage='.intval($id_reponse_sondage));
}

