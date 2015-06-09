<?php

if (!defined('_ECRIRE_INC_VERSION')) return;

include_spip('sondage_fonctions');

function critere_sondages_en_cours($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
	$boucle->where[] = array("'<='", "'{$boucle->id_table}.date_debut'", "'NOW()'");
	$boucle->where[] = array("'>='", "'{$boucle->id_table}.date_fin'", "'NOW()'");
}

function critere_sondages_termines($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
	$boucle->where[] = array("'<'", "'{$boucle->id_table}.date_fin'", "'NOW()'");
}

function critere_sondages_a_venir($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
	$boucle->where[] = array("'>'", "'{$boucle->id_table}.date_debut'", "'NOW()'");
}

