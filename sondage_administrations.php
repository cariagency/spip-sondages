<?php

if (!defined('_ECRIRE_INC_VERSION')) return;

function sondage_upgrade($nom_meta_base_version, $version_cible) {
	$maj = array();

	$maj['create'] = array(array('maj_tables', array('spip_sondages', 'spip_options_sondage', 'spip_reponses_sondage')));

	include_spip('base/upgrade');
	maj_plugin($nom_meta_base_version, $version_cible, $maj);
}

function sondage_vider_tables($nom_meta_base_version) {

	sql_drop_table("spip_sondages");
	sql_drop_table("spip_options_sondage");
	sql_drop_table("spip_reponses_sondage");

	effacer_meta($nom_meta_base_version);
}

