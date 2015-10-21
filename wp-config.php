<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier contient les réglages de configuration suivants : réglages MySQL,
 * préfixe de table, clefs secrètes, langue utilisée, et ABSPATH.
 * Vous pouvez en savoir plus à leur sujet en allant sur 
 * {@link http://codex.wordpress.org/Editing_wp-config.php Modifier
 * wp-config.php} (en anglais). C'est votre hébergeur qui doit vous donner vos
 * codes MySQL.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d'installation. Vous n'avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en "wp-config.php" et remplir les
 * valeurs.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define('DB_NAME', 'paix3');

/** Utilisateur de la base de données MySQL. */
define('DB_USER', 'paix3');

/** Mot de passe de la base de données MySQL. */
define('DB_PASSWORD', 'paix3');

/** Adresse de l'hébergement MySQL. */
define('DB_HOST', 'localhost');

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define('DB_CHARSET', 'utf8');

/** Type de collation de la base de données. 
  * N'y touchez que si vous savez ce que vous faites. 
  */
define('DB_COLLATE', '');

/**#@+
 * Clefs uniques d'authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant 
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clefs secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n'importe quel moment, afin d'invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         ';)z%#p==F%|0c1K&uaCzTDEC#C>c4%cc(BJF?`1_^D}|tlTd/cKAGv!w2&J2h?R*');
define('SECURE_AUTH_KEY',  '%4P>^[xDgBMpxW1<!{Cp:$7T8ke2y]GV6BQy)LF9@|qJ;A:s XGKVJ},_ChsOe!N');
define('LOGGED_IN_KEY',    'u9?NO1:pjJ:kx@aD+wQe: yDJ+Q&O/M<`/#1p{-^tbnP?KRI*.Fl#yqWGV-R5p#Z');
define('NONCE_KEY',        'r7x0_IjS%Z_osfr~V{-Xf-VEYPTiMeo|-lD/rd[<^+Xgq$xp(6v3)-QCRd142TRQ');
define('AUTH_SALT',        '0$L$A@2R*QFe1*sykp{Ud*$WKg7Fn]US9legg]1MV)tNafzZ9egwdpH+74u}6RdL');
define('SECURE_AUTH_SALT', '[+gc<F&u d3Mi|zIL*(`P##IX XU&h}:L<9G,!]NLhngT+.qMBy1:9$wkc;r~WFL');
define('LOGGED_IN_SALT',   '?C.?N1bolDfxj&FGv 8m`g/A-2(Qi}*u 1MNKBF>Nsv<A#_]ze4k+5@ub!2rG:-j');
define('NONCE_SALT',       '5p6-`/MN{FS$ZXNz?nWxA>Ry03Fi0:SED +IA$.kKJ1p-SFpb0V)]x8vI[M-^v%?');
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique. 
 * N'utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés!
 */
$table_prefix  = 'wp_';

/**
 * Langue de localisation de WordPress, par défaut en Anglais.
 *
 * Modifiez cette valeur pour localiser WordPress. Un fichier MO correspondant
 * au langage choisi doit être installé dans le dossier wp-content/languages.
 * Par exemple, pour mettre en place une traduction française, mettez le fichier
 * fr_FR.mo dans wp-content/languages, et réglez l'option ci-dessous à "fr_FR".
 */
define('WPLANG', 'fr_FR');

/** 
 * Pour les développeurs : le mode deboguage de WordPress.
 * 
 * En passant la valeur suivante à "true", vous activez l'affichage des
 * notifications d'erreurs pendant votre essais.
 * Il est fortemment recommandé que les développeurs d'extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de 
 * développement.
 */ 
define('WP_DEBUG', false); 

/* C'est tout, ne touchez pas à ce qui suit ! Bon blogging ! */

/** Chemin absolu vers le dossier de WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');