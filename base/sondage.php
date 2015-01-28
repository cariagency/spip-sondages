<?php

if (!defined('_ECRIRE_INC_VERSION')) return;

function sondage_declarer_tables_interfaces($interfaces) {

	$interfaces['table_des_tables']['sondages'] = 'sondages';
	$interfaces['table_des_tables']['options_sondage'] = 'options_sondage';
	$interfaces['table_des_tables']['reponses_sondage'] = 'reponses_sondage';

	return $interfaces;
}

function sondage_declarer_tables_objets_sql($tables) {

	$tables['spip_sondages'] = array(
		'type' => 'sondage',
		'principale' => "oui",
		'field'=> array(
			"id_sondage"         => "bigint(21) NOT NULL",
			"titre"              => "varchar(255) NOT NULL DEFAULT ''",
			"date_debut"         => "datetime NOT NULL DEFAULT '0000-00-00 00:00:00'",
			"date_fin"           => "datetime NOT NULL DEFAULT '0000-00-00 00:00:00'",
			"nb_reponses"        => "bigint(21) NOT NULL DEFAULT 0",
			"maj"                => "TIMESTAMP"
		),
		'key' => array(
			"PRIMARY KEY"        => "id_sondage",
		),
		'titre' => "titre AS titre, '' AS lang",
		'champs_editables'  => array('titre', 'date_debut', 'date_fin'),
		'rechercher_champs' => array('titre' => 10),
	);

	$tables['spip_options_sondage'] = array(
		'type' => 'option_sondage',
		'principale' => "oui", 
		'field'=> array(
			"id_option_sondage"  => "bigint(21) NOT NULL",
			"id_sondage"         => "bigint(21) NOT NULL",
			"titre"              => "varchar(255) NOT NULL DEFAULT ''",
			"ordre"              => "int(1) NOT NULL DEFAULT 0",
			"maj"                => "TIMESTAMP"
		),
		'key' => array(
			"PRIMARY KEY"        => "id_option_sondage",
			"KEY id_sondage"	 => "id_sondage",
		),
		'titre' => "titre AS titre, '' AS lang",
		'champs_editables'  => array('id_sondage', 'titre', 'ordre'),
	);

	$tables['spip_reponses_sondage'] = array(
		'type' => 'reponse_sondage',
		'principale' => "oui", 
		'field'=> array(
			"id_reponse_sondage" => "bigint(21) NOT NULL",
			"id_sondage"         => "bigint(21) NOT NULL",
			"id_option_sondage"  => "bigint(21) NOT NULL",
			"maj"                => "TIMESTAMP"
		),
		'key' => array(
			"PRIMARY KEY"           => "id_reponse_sondage",
			"KEY id_sondage"		=> "id_sondage",
			"KEY id_option_sondage"	=> "id_option_sondage",
		),
		'titre' => "'' AS titre, '' AS lang",
	);

	return $tables;
}


