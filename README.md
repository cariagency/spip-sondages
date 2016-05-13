# Plugin Sondage

Création de sondages dans SPIP.



# Installation

Ce plugin s'installe comme tous les autres plugins : en plaçant le dossier `sondage/` dans le répertoire `plugins/` du site SPIP.

Il est compatible avec SPIP 3.0.16.

Ses dépendances :

- le plugin saisies (spip-zone)
- le plugin verifier (spip-zone)
- le plugin [saisies_maiis](https://github.com/studiomaiis/saisies_maiis)
- le plugin [formater](https://github.com/studiomaiis/formater)



# Présentation

Ce plugin crée dans l'espace privé de SPIP une nouvelle entrée au menu Edition : Sondages. Les administrateurs et rédacteurs ont les mêmes autorisations : ils peuvent créer, modifier et supprimer des sondages.

Chaque sondage possède : un titre (pouvant servir de question) ; une date de début ; et une date de fin. Il dispose ensuite d'options, qui sont présentées comme des choix de réponse possibles à l'internaute sondé.




# La boucle SONDAGES

Une boucle de sondages se code en plaçant entre parenthèses `SONDAGES` (avec un « s ») :

```
<BOUCLEn(SONDAGES){critères...}>
```

Les éléments contenus dans une telle boucle sont des sondages.


## Les critères de sélection

On utilisera l’un ou autre des critères suivants pour indiquer comment on sélectionne les éléments.

- `{id_sondage}` sélectionne le sondage dont l’identifiant est `id_sondage`. Comme l’identifiant de chaque sondage est unique, ce critère ne retourne qu’une ou zéro réponse.

- `{recherche}` sélectionne les sondages correspondant aux mots indiqués dans l’interface de recherche (moteur de recherche incorporé à SPIP).

- `{sondages_en_cours}` sélectionne les sondages en cours. Un sondage en cours est un sondage dont la date du jour est englobée par les dates de début et de fin.

- `{sondages_a_venir}` sélectionne les sondages dont la date de début se situe dans le futur.

- `{sondages_termines}` sélectionne les sondages dont la date de fin est passée

Les critères communs à toutes les boucles s’appliquent évidemment.


## Les balises de cette boucle

### Les balises tirées de la base de données

Les balises suivantes correspondent aux éléments directement tirés de la base de données. Vous pouvez les utiliser également en tant que critère de classement (par exemple : `{par titre}`).

- `#ID_SONDAGE` affiche l’identifiant unique du sondage.

- `#TITRE` affiche le titre du sondage.

- `#DATE_DEBUT` affiche la date de début.

- `#DATE_FIN` affiche la date de fin.

Si vous avez besoin de champs supplémentaires, utilisez le plugin Champs Extra pour en ajouter. Le formulaire d'édition prend en charge ce plugin.

### Balises calculées par SPIP

- `#URL_SONDAGE` affiche l’URL de la page du sondage. Le squelette `sondage.html` n'est pas fourni.

- `#FORMULAIRE_SONDAGE{#ID_SONDAGE}` affiche le formulaire du sondage. Veuillez à le placer dans une boucle ayant le critère `{sondages_en_cours}` sinon rien ne sera affiché. Vous pouvez entourer le formulaire d'un `<div class="ajax">...</div>` pour bénéficier d'une validation ajax du formulaire.

### Balise spéciale

- `#NB_REPONSES{sondage,#ID_SONDAGE}` affiche le nombre de réponses du sondage

### Critère spécial

- `{par nb_reponses}` peut être utilisé pour trier les sondages par nombre de réponses.

### Les logos

- `#LOGO_SONDAGE` affiche le logo du sondage, éventuellement avec la gestion du survol.

Les logos s’installent de la manière suivante : `[(#LOGO_SONDAGE|alignement|adresse)]`

L’alignement peut être `left` ou `right`. L’adresse est l’URL de destination du lien de ce logo (par exemple `#URL_SONDAGE`). Si l’on n’indique pas d’adresse, le bouton n’est pas cliquable.

Par ailleurs deux balises permettent de récupérer un seul des deux logos :
- `#LOGO_SONDAGE_NORMAL` affiche le logo sans survol ;
- `#LOGO_SONDAGE_SURVOL` affiche le logo de survol.

## Intégration

### Squelettes

La première solution consiste à créer les boucles nécessaires à l'intégration de sondages dans vos squelettes.

Si vous connaissez l'`id_sondage` du sondage et que ce paramètre est passé depuis une boucle ou en argument :

```
<BOUCLE_sondage_en_particulier(SONDAGES) {id_sondage}>
#FORMULAIRE_SONDAGE{#ID_SONDAGE}
</BOUCLE_sondage_en_particulier>
```

Exemple pour afficher un sondage en cours au hasard :

```
<BOUCLE_sondage_au_hasard(SONDAGES) {sondages_en_cours} {par hasard} {0,1}>
#FORMULAIRE_SONDAGE{#ID_SONDAGE}
</BOUCLE_sondage_au_hasard>
```

Exemple pour afficher les sondages terminés :

```
<BOUCLE_sondages_terminees(SONDAGES) {sondages_termines} {par nb_reponses}>
#TITRE
...
</BOUCLE_sondages_terminees>
```

### Contenu d'article ou de rubrique

Il est possible d'insérer un sondage dans les contenus. Le code à insérer est `<formulaire|sondage|id_sondage=XX>` où `XX` correspond à l'identifiant du sondage.

### Saisie sondage

Si vous utilisez les champs extras, vous pouvez ajouter un champ de type sondage (à une rubrique par exemple).




# La boucle OPTIONS_SONDAGE

Une option de sondage est un choix possible de réponse.

Une boucle d'options de sondage se code en plaçant entre parenthèses `OPTIONS_SONDAGE` (avec un « s » à option mais pas à sondage) :

```
<BOUCLEn(OPTIONS_SONDAGE){critères...}>
```

Les éléments contenus dans une telle boucle sont des options de sondage.

## Les critères de sélection

On utilisera l’un ou autre des critères suivants pour indiquer comment on sélectionne les éléments.

- `{id_option_sondage}` sélectionne l'option de sondage dont l’identifiant est `id_option_sondage`.

- `{id_sondage}` sélectionne les options de sondage du sondage dont l’identifiant est `id_sondage`.

- `{par ordre}` ordonnera les options selon l'ordre défini dans l'espace privé.

## Les balises de cette boucle

### Les balises tirées de la base de données

Les balises suivantes correspondent aux éléments directement tirés de la base de données. Vous pouvez les utiliser également en tant que critère de classement (par exemple : `{par titre}`).

- `#ID_OPTION_SONDAGE` affiche l’identifiant unique de l'option de sondage.

- `#ID_SONDAGE` affiche l’identifiant unique du sondage parent.

- `#TITRE` affiche le titre de l'option de sondage.

- `#ORDRE` affiche l'ordre de l'option (le compteur débute à 0).

### Balises spéciales

- `#NB_REPONSES{option_sondage,#ID_OPTION_SONDAGE}` affiche le nombre de réponses qu'a obtenu l'option

- `#POURCENTAGE_OPTION_SONDAGE` affiche le pourcentage de réponse que représente cette option. Cette balise accepte un argument précision, qui vaut 2 si omis. Cet argument permet donc d'arrondir le pourcentage calculé. Si aucune décimale ne vous intéresse : utilisez `#POURCENTAGE_OPTION_SONDAGE{0}`.

## Intégration

Voici un exemple de squelette :

```
<BOUCLE_sondages_terminees(SONDAGES) {sondages_termines} {par date_fin} {inverse}>
<dl>
<dt>#TITRE</dt>
<BOUCLE_options(OPTIONS_SONDAGE) {id_sondage} {par ordre}>
<dd>#TITRE : [(#NB_REPONSES{option_sondage,#ID_OPTION_SONDAGE})]</dd>
</BOUCLE_options>
</dl>
</BOUCLE_sondages_terminees>
```



# La boucle REPONSES_SONDAGE

Usage limité, on préférera utiliser la balise spéciale `#NB_REPONSES{objet,id_objet}`.

Une boucle de réponses de sondage se code en plaçant entre parenthèses `REPONSES_SONDAGE` (avec un « s » à reponse mais pas à sondage) :

```
<BOUCLEn(REPONSES_SONDAGE){critères...}>
```

Les éléments contenus dans une telle boucle sont des réponses de sondage.

## Les critères de sélection

On utilisera l’un ou autre des critères suivants pour indiquer comment on sélectionne les éléments.

- `{id_reponse_sondage}` sélectionne la réponse de sondage dont l’identifiant est `id_reponse_sondage`.

- `{id_option_sondage}` sélectionne les réponses qui ont pour valeur `id_option_sondage`.

- `{id_sondage}` sélectionne les réponses du sondage dont l’identifiant est `id_sondage`.



# Autre intégration

Il est possible de ne pas utiliser de formulaire CVT pour faire voter les internautes, dans ce cas il faut utiliser la balise `#URL_VOTER{retour}` placée dans une boucle `OPTIONS_SONDAGE` :

```
<BOUCLE_sondages(SONDAGES) {sondages_en_cours}>
<p>
#TITRE<br />
<BOUCLE_test(CONDITION) {si #AUTORISER{voter,sondage,#ID_SONDAGE}}>
<BOUCLE_options(OPTIONS_SONDAGE) {id_sondage} {par ordre}>
<a href="#URL_VOTER{#URL_SITE_SPIP}">#TITRE</a>
</BOUCLE_options>
</BOUCLE_test>
<BOUCLE_resultats(OPTIONS_SONDAGE) {id_sondage} {par ordre}>
<span>#TITRE : #POURCENTAGE_OPTION_SONDAGE%</span>
</BOUCLE_resultats>
<//B_test>
</p>
</BOUCLE_sondages>
```

Une boucle de test sur l'autorisation de voter est nécessaire.

