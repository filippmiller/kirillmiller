<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('DB_NAME', 'timecafe_kirill');

/** Имя пользователя MySQL */
define('DB_USER', 'timecafe_kirill');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', 'mnlm843z');

/** Имя сервера MySQL */
define('DB_HOST', 'timecafe.mysql.tools');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8mb4');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '|iB@P9Hh_YBJij5Y3&t)K}Rqi%w6(o*^e-SxjKf%=y4t%Khq[qv3wF}1w&DFE/LN');
define('SECURE_AUTH_KEY',  'SS3zI(80xf$ hxfSz1enO@48ZcPJt>P]}UznPh 8r[J&^;k&@!<n|C;:&o%cDcp-');
define('LOGGED_IN_KEY',    'E$x{P*r_V70-kxD).j;>iX/MHtaL%&,]5AkcD6>p6=%g%E|,!+CyyioBED}Usu!b');
define('NONCE_KEY',        'M-J`*amb7OLIdvhRVGu%}UL!p!qZ5V~,wR4r]~SxFlukb/`CcY5kEkT,gVq!nLos');
define('AUTH_SALT',        'MB<$sh_>nMU=}]Xhb#;!JFa^lsIAY.dpl,^[IZ>@lQT;c<Aa- v S@a{D>JV`]b]');
define('SECURE_AUTH_SALT', 'D*Zpbx|x)8+lxm+*$u-]P-*I_HedJSfl4u_w}E&;5v^bd~]wC:uXKQt] s3I%`XY');
define('LOGGED_IN_SALT',   'PYjQk z{6]na_D*j>>YAQ~XidP|ZH^E+}!-/AB#b[55cG$Eov>PY0xWWy7VKH5]D');
define('NONCE_SALT',       'C9ZC7MEFcutBv%ZPUczA]ppEbY+K*2,&/s~Wg1uu>W[~V%VHuqJ7yZZ_h4Hz-/kF');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);
define('WP_MEMORY_LIMIT', '2048M');
/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');
