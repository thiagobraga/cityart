<?php
/** 
 * As configurações básicas do WordPress.
 *
 * Esse arquivo contém as seguintes configurações: configurações de MySQL, Prefixo de Tabelas,
 * Chaves secretas, Idioma do WordPress, e ABSPATH. Você pode encontrar mais informações
 * visitando {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. Você pode obter as configurações de MySQL de seu servidor de hospedagem.
 *
 * Esse arquivo é usado pelo script ed criação wp-config.php durante a
 * instalação. Você não precisa usar o site, você pode apenas salvar esse arquivo
 * como "wp-config.php" e preencher os valores.
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar essas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define('DB_NAME', 'bptadvogados');

/** Usuário do banco de dados MySQL */
define('DB_USER', 'root');

/** Senha do banco de dados MySQL */
define('DB_PASSWORD', 's0cio.br4g4,pa55');

/** nome do host do MySQL */
define('DB_HOST', 'localhost');

/** Conjunto de caracteres do banco de dados a ser usado na criação das tabelas. */
define('DB_CHARSET', 'utf8mb4');

/** O tipo de collate do banco de dados. Não altere isso se tiver dúvidas. */
define('DB_COLLATE', '');

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * Você pode alterá-las a qualquer momento para desvalidar quaisquer cookies existentes. Isto irá forçar todos os usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'w5z0Q(?o=ZB)(!$-Y~c%Tzt^V#qe@NFu Ik>Lwc/|:6_FNkmB,Y+R:NskfC7Q6)+');
define('SECURE_AUTH_KEY',  '`|-S-b<u[J4D>Ng+Lji(,1i4=23DhnOK0VM_~7zXP6hc{3L:WI8A.wJ/Z,HROReY');
define('LOGGED_IN_KEY',    '|>R%B~/$ktCj1]kzC_OEU^[C*+R:V8WQxxE,#?xvvR,V1LHU,EXi-b)/Qx9-!qa-');
define('NONCE_KEY',        '+~rA|p-VVP `NBK+/8UHH*.Zo|;=iev+,L{VeqmaXv:Jf-#5~)a?G|//^daSFSP.');
define('AUTH_SALT',        'qTD9dm.|H7t3CHzdaJYv:e-.V/[bnUhR|aoVV[QB}PNSTE7zdITWoJ<hpXkPa8v ');
define('SECURE_AUTH_SALT', 'JAHa.{A-ZUBXEWe2P*&~nF,o+A|d+j?K~.Ey2|b~(wevNa.;]_ZSXPzk;B<b|pAJ');
define('LOGGED_IN_SALT',   'Oza:-fJ`L?26RKWJ=^Z[=iN]^G@K6Z.KMAQ+t+tox7G|:m|2R Sv)jnEbQ]$4z|t');
define('NONCE_SALT',       'emO+..%@%|=Sa;5j,O1+S]:JI&H!E_1c}_SK6Z-m +/+GR#RdWZT3IGmck(A5vch');

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der para cada um um único
 * prefixo. Somente números, letras e sublinhados!
 */
$table_prefix  = 'wp_';


/**
 * Para desenvolvedores: Modo debugging WordPress.
 *
 * altere isto para true para ativar a exibição de avisos durante o desenvolvimento.
 * é altamente recomendável que os desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 */
define('WP_DEBUG', false);

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
	
/** Configura as variáveis do WordPress e arquivos inclusos. */
require_once(ABSPATH . 'wp-settings.php');
