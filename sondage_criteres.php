<?php

if (!defined('_ECRIRE_INC_VERSION')) return;

include_spip('sondage_fonctions');

function critere_sondages_en_cours($idb, &$boucles, $crit) {
	$maintenant = date('Y-m-d H:i:s');
	$boucle = &$boucles[$idb];
	$boucle->where[] = array("'<='", "'{$boucle->id_table}.date_debut'", "'\"".$maintenant."\"'");
	$boucle->where[] = array("'>='", "'{$boucle->id_table}.date_fin'", "'\"".$maintenant."\"'");
}

function critere_sondages_termines($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
	$boucle->where[] = array("'<'", "'{$boucle->id_table}.date_fin'", "'\"".date('Y-m-d H:i:s')."\"'");
}

function critere_sondages_a_venir($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
	$boucle->where[] = array("'>'", "'{$boucle->id_table}.date_debut'", "'\"".date('Y-m-d H:i:s')."\"'");
}


