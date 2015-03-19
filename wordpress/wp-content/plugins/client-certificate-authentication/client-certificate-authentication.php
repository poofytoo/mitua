<?php
/*
Plugin Name: Client Certificate Authentication
Version: 1.0.2
Plugin URI: http://wordpress.org/plugins/client-certificate-authentication/
Description: Authenticating with a SSL Client Certificate by using the email address. Optionally, new accounts can be created with the name from the certificate.
Author: Mario Lipinski
Author URI: http://wiki.cacert.org/Mario%20Lipinski
*/

require_once('options-page.php');

class ClientCertificateAuthenticationPlugin {

	var $db_version = 2;
	var $option_name = 'client_certificate_authentication_options';
	var $options;

	function ClientCertificateAuthenticationPlugin() {
		$this->options = get_option($this->option_name);

		if (is_admin()) {
			$options_page = new ClientCertificateAuthenticationOptionsPage($this, $this->option_name, __FILE__, $this->options);
			add_action('admin_init', array($this, 'check_options'));
		}

		add_action('login_head', array($this, 'add_login_css'));
		add_action('login_footer', array($this, 'add_login_link'));
		add_action('check_passwords', array($this, 'generate_password'), 10, 3);
		add_action('wp_logout', array($this, 'logout'));
		add_filter('login_url', array($this, 'bypass_reauth'));
		add_filter('show_password_fields', array($this, 'allow_wp_auth'));
		add_filter('allow_password_reset', array($this, 'allow_wp_auth'));
		add_filter('authenticate', array($this, 'authenticate'), 10, 3);
	}

	/*
	 * Check the options currently in the database and upgrade if necessary.
	 */
	function check_options() {
		if ($this->options === false || ! isset($this->options['db_version']) || $this->options['db_version'] < $this->db_version) {
			if (! is_array($this->options)) {
				$this->options = array();
			}

			$current_db_version = isset($this->options['db_version']) ? $this->options['db_version'] : 0;
			$this->upgrade($current_db_version);
			$this->options['db_version'] = $this->db_version;
			update_option($this->option_name, $this->options);
		}
	}

	/*
	 * Upgrade options as needed depending on the current database version.
	 */
	function upgrade($current_db_version) {
		$default_options = array(
			'allow_wp_auth' => false,
			'auth_label' => 'Client certificate authentication',
			'login_uri' => '%base%/wp-login.php',
			'logout_uri' => '%site%',
			'auto_create_user' => false,
		);

		if ($current_db_version < 1) {
			foreach ($default_options as $key => $value) {
				// Handle migrating existing options from before we stored a db_version
				if (! isset($this->options[$key])) {
					$this->options[$key] = $value;
				}
			}
		}
	}

	function add_login_css() {
?>
<style type="text/css">
p#client-certificate-authentication-link {
  width: 100%;
  height: 4em;
  text-align: center;
  margin-top: 2em;
}
p#client-certificate-authentication-link a {
  margin: 0 auto;
  float: none;
}
</style>
<?php
	}

	/*
	 * Add a link to the login form to initiate external authentication.
	 */
	function add_login_link() {
		global $redirect_to;

		$login_uri = $this->_generate_uri($this->options['login_uri'], wp_login_url($redirect_to));
		$auth_label = $this->options['auth_label'];

		echo "\t" . '<p id="client-certificate-authentication-link"><a class="button-primary" href="' . htmlspecialchars($login_uri) . '">Log In with ' . htmlspecialchars($auth_label) . '</a></p>' . "\n";
	}

	/*
	 * Generate a password for the user. This plugin does not require the
	 * administrator to enter this value, but we need to set it so that user
	 * creation and editing works.
	 */
	function generate_password($username, $password1, $password2) {
		if (! $this->allow_wp_auth()) {
			$password1 = $password2 = wp_generate_password();
		}
	}

	/*
	 * Logout the user by redirecting them to the logout URI.
	 */
	function logout() {
		$logout_uri = $this->_generate_uri($this->options['logout_uri'], home_url());

		wp_redirect($logout_uri);
		exit();
	}

	/*
	 * Remove the reauth=1 parameter from the login URL, if applicable. This allows
	 * us to transparently bypass the mucking about with cookies that happens in
	 * wp-login.php immediately after wp_signon when a user e.g. navigates directly
	 * to wp-admin.
	 */
	function bypass_reauth($login_url) {
		$login_url = remove_query_arg('reauth', $login_url);

		return $login_url;
	}

	/*
	 * Can we fallback to built-in WordPress authentication?
	 */
	function allow_wp_auth() {
		return (bool) $this->options['allow_wp_auth'];
	}

	/*
	 * Authenticate the user, first using the external authentication source.
	 * If allowed, fall back to WordPress password authentication.
	 */
	function authenticate($user, $username, $password) {
		$user = $this->check_remote_user();

		if (! is_wp_error($user)) {
			// User was authenticated via REMOTE_USER
			$user = new WP_User($user->ID);
		}
		else {
			if (! $this->allow_wp_auth()) {
				// Bail with the WP_Error when not falling back to WordPress authentication
				wp_die($user);
			}

			// Fallback to built-in hooks (see wp-includes/user.php)
		}

		return $user;
	}

	/*
	 * If the SSL_CLIENT_S_DN_Email evironment variable is set, use it
	 * as the login. This assumes that you have externally authenticated the user.
	 */
	function check_remote_user() {
		$username = '';
		$user = false;

		$server_keys = $this->_get_server_keys();
		foreach ($server_keys as $server_key) {
			if (! empty($_SERVER[$server_key])) {
				$username = $_SERVER[$server_key];
				$user = get_user_by('email', $username);
				if ($user) {
					break;
				}
			}
		}

		if (! $username) {
			return new WP_Error('empty_username', '<strong>ERROR</strong>: No user found for your provided credentials.');
		}

		$cn = '';
		foreach ($server_keys as $server_key) {
			if (! empty($_SERVER[$server_key])) {
				$username = $_SERVER[$server_key];
				if (! empty($_SERVER['SSL_CLIENT_S_DN_CN'])) {
					$cn = $_SERVER[SSL_CLIENT_S_DN_CN];
				}
				break;
			}
		}

		// Create new users automatically, if configured
		if (! $user)  {
			if ((bool) $this->options['auto_create_user']) {
				$user = $this->_create_user(array('email' => $username, 'cn' => $cn));
			}
			else {
				// Bail out to avoid showing the login form
				$user = new WP_Error('authentication_failed', __('<strong>ERROR</strong>: Authentication failed.'));
			}
		}

		return $user;
	}

	/*
	 * Return the list of $_SERVER keys that we will check for a email. These are all
	 * keys beginning with SSL_CLIENT_S_DN_Email.
	 */
	function _get_server_keys() {
		$server_keys = array();

		foreach (array_keys($_SERVER) as $key) {
			if (preg_match('/^SSL_CLIENT_S_DN_Email/', $key)) {
				$server_keys[] = $key;
			}
		}

		return $server_keys;
	}

	/*
	 * Create a new WordPress account for the specified username and email.
	 */
	function _create_user($info) {
		$password = wp_generate_password();

		$username = $info['cn'];
		$user = get_user_by('login', $username);
		$i = 0;
		while ($user) {
			$username = $info['cn'] . ++$i;
	                $user = get_user_by('login', $username);
		}
		$user_id = wp_create_user($username, $password, $info['email']);
		$user = get_user_by('id', $user_id);

		return $user;
	}

	/*
	 * Fill the specified URI with the site URI and the specified return location.
	 */
	function _generate_uri($uri, $redirect_to) {
		// Support tags for staged deployments
		$base = $this->_get_base_url();

		$tags = array(
			'host' => $_SERVER['HTTP_HOST'],
			'base' => $base,
			'site' => home_url(),
			'redirect' => $redirect_to,
		);

		foreach ($tags as $tag => $value) {
			$uri = str_replace('%' . $tag . '%', $value, $uri);
			$uri = str_replace('%' . $tag . '_encoded%', urlencode($value), $uri);
		}

		// Support previous versions with only the %s tag
		if (strstr($uri, '%s') !== false) {
			$uri = sprintf($uri, urlencode($redirect_to));
		}

		return $uri;
	}

	/*
	 * Return the base domain URL based on the WordPress home URL.
	 */
	function _get_base_url() {
		$home = parse_url(home_url());

		$base = home_url();
		foreach (array('path', 'query', 'fragment') as $key) {
			if (! isset($home[$key])) continue;
			$base = str_replace($home[$key], '', $base);
		}

		return $base;
	}
}

// Load the plugin hooks, etc.
$client_certificate_authentication_plugin = new ClientCertificateAuthenticationPlugin();
?>
