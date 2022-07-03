/**
 *  Section appended onto drupal/core default.settings.php via "drupal-scaffold" in composer.json.
 */

// Let Drush use all the memory available.
if (PHP_SAPI === 'cli') {
  ini_set('memory_limit', '-1');
}

// Required when running Drupal behind a reverse proxy.
$settings['reverse_proxy'] = TRUE;
$settings['reverse_proxy_addresses'] = array($_SERVER['REMOTE_ADDR']);
$settings['reverse_proxy_trusted_headers'] = \Symfony\Component\HttpFoundation\Request::HEADER_X_FORWARDED_ALL;

/**
 * Private file path:
 *
 * A local file system path where private files will be stored. This directory
 * must be absolute, outside of the Drupal installation directory and not
 * accessible over the web.
 *
 * Note: Caches need to be cleared when this value is changed to make the
 * private:// stream wrapper available to the system.
 *
 * See https://www.drupal.org/documentation/modules/file for more information
 * about securing private files.
 */
$settings['file_private_path'] = '/var/www/drupal/private/';

// Shared configuration, config_split is used for any site specific differences.
$settings['config_sync_directory'] = '/var/www/drupal/config/sync';

// Content sync module.
global $content_directories;
$content_directories['sync'] = '/var/www/drupal/content/sync';

// Container environment variable path.
$path = "/var/run/s6/container_environment/";

// Some configurations are derived from environment variables.
$config['islandora.settings']['broker_url'] = file_get_contents($path . 'DRUPAL_DEFAULT_BROKER_URL');
$config['islandora.settings']['broker_user'] = file_exists($path . 'DRUPAL_DEFAULT_BROKER_USER') ? file_get_contents($path . 'DRUPAL_DEFAULT_BROKER_USER') : NULL;
$config['islandora.settings']['broker_password'] = file_exists($path . 'DRUPAL_DEFAULT_BROKER_PASSWORD') ? file_get_contents($path . 'DRUPAL_DEFAULT_BROKER_PASSWORD') : NULL;
$config['islandora_iiif.settings']['iiif_server'] = file_get_contents($path . 'DRUPAL_DEFAULT_CANTALOUPE_URL');
$config['matomo.settings']['url_http'] = file_get_contents($path . 'DRUPAL_DEFAULT_MATOMO_URL');
$config['matomo.settings']['url_https'] = file_get_contents($path . 'DRUPAL_DEFAULT_MATOMO_URL');
$config['openseadragon.settings']['iiif_server'] = file_get_contents($path . 'DRUPAL_DEFAULT_CANTALOUPE_URL');
$config['search_api.server.default_solr_server']['backend_config']['connector_config']['host'] = file_get_contents($path . 'DRUPAL_DEFAULT_SOLR_HOST');
$config['search_api.server.default_solr_server']['backend_config']['connector_config']['port'] = file_get_contents($path . 'DRUPAL_DEFAULT_SOLR_PORT');
$config['search_api.server.default_solr_server']['backend_config']['connector_config']['core'] = file_get_contents($path . 'DRUPAL_DEFAULT_SOLR_CORE');

// Some settings are derived from environment variables.
$settings['hash_salt'] = file_get_contents($path . 'DRUPAL_DEFAULT_SALT');
$settings['trusted_host_patterns'] = [
  0 => file_get_contents($path . 'DRUPAL_DEFAULT_SITE_URL'),
];

// Database settings are also derived from environment variables.
$databases['default']['default'] = [
  'database' => file_get_contents($path . 'DRUPAL_DEFAULT_DB_NAME'),
  'username' => file_get_contents($path . 'DRUPAL_DEFAULT_DB_USER'),
  'password' => file_get_contents($path . 'DRUPAL_DEFAULT_DB_PASSWORD'),
  'host' => file_get_contents($path . 'DB_MYSQL_HOST'),
  'port' => file_get_contents($path . 'DB_MYSQL_PORT'),
  'prefix' => '',
  'driver' => 'mysql',
  'namespace' => 'Drupal\\Core\\Database\\Driver\\mysql',
];

// Flysystem
$settings['flysystem']['fedora']['driver'] = 'fedora';
$settings['flysystem']['fedora']['config']['root'] = file_get_contents($path . 'DRUPAL_DEFAULT_FCREPO_URL');

// Change the php_storage settings in your setting.php. It is recommend that
// this directory be outside out of the docroot.
$settings['php_storage']['twig']['directory'] = $settings['file_private_path'] . '/php';
$settings['php_storage']['twig']['secret'] = $settings['hash_salt'];

/**
 *  End Section.
 */
