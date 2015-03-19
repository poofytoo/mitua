<?php
class ClientCertificateAuthenticationOptionsPage {
	var $plugin;
	var $group;
	var $page;
	var $options;
	var $title;

	function ClientCertificateAuthenticationOptionsPage($plugin, $group, $page, $options, $title = 'Client Certificate Authentication') {
		$this->plugin = $plugin;
		$this->group = $group;
		$this->page = $page;
		$this->options = $options;
		$this->title = $title;

		add_action('admin_init', array($this, 'register_options'));
		add_action('admin_menu', array($this, 'add_options_page'));
	}

	/*
	 * Register the options for this plugin so they can be displayed and updated below.
	 */
	function register_options() {
		register_setting($this->group, $this->group, array($this, 'sanitize_settings'));

		$section = 'client_certificate_authentication_main';
		add_settings_section($section, 'Main Options', array($this, '_display_options_section'), $this->page);
		add_settings_field('client_certificate_authentication_allow_wp_auth', 'Allow WordPress authentication?', array($this, '_display_option_allow_wp_auth'), $this->page, $section, array('label_for' => 'client_certificate_authentication_allow_wp_auth'));
		add_settings_field('client_certificate_authentication_auth_label', 'Authentication label', array($this, '_display_option_auth_label'), $this->page, $section, array('label_for' => 'client_certificate_authentication_auth_label'));
		add_settings_field('client_certificate_authentication_login_uri', 'Login URI', array($this, '_display_option_login_uri'), $this->page, $section, array('label_for' => 'client_certificate_authentication_login_uri'));
		add_settings_field('client_certificate_authentication_logout_uri', 'Logout URI', array($this, '_display_option_logout_uri'), $this->page, $section, array('label_for' => 'client_certificate_authentication_logout_uri'));
		add_settings_field('client_certificate_authentication_auto_create_user', 'Automatically create accounts?', array($this, '_display_option_auto_create_user'), $this->page, $section, array('label_for' => 'client_certificate_authentication_auto_create_user'));
	}

	/*
	 * Set the database version on saving the options.
	 */
	function sanitize_settings($input) {
		$output = $input;
		$output['db_version'] = $this->plugin->db_version;
		$output['allow_wp_auth'] = isset($input['allow_wp_auth']) ? (bool) $input['allow_wp_auth'] : false;
		$output['auto_create_user'] = isset($input['auto_create_user']) ? (bool) $input['auto_create_user'] : false;

		return $output;
	}

	/*
	 * Add an options page for this plugin.
	 */
	function add_options_page() {
		add_options_page($this->title, $this->title, 'manage_options', $this->page, array($this, '_display_options_page'));
	}

	/*
	 * Display the options for this plugin.
	 */
	function _display_options_page() {
		if (! current_user_can('manage_options')) {
			wp_die(__('You do not have sufficient permissions to access this page.'));
		}
?>
<div class="wrap">
  <h2>Client Certificate Authentication Options</h2>
  <p>For the Login URI and Logout URI options, you can use the following variables to support your installation:</p>
  <ul>
    <li><code>%host%</code> - The current value of <code>$_SERVER['HTTP_HOST']</code></li>
    <li><code>%base%</code> - The base domain URL (everything before the path)</li>
    <li><code>%site%</code> - The WordPress home URI</li>
    <li><code>%redirect%</code> - The return URI provided by WordPress</li>
  </ul>
  <p>You can also use <code>%host_encoded%</code>, <code>%site_encoded%</code>, and <code>%redirect_encoded%</code> for URL-encoded values.</p>
  <form action="options.php" method="post">
    <?php settings_errors(); ?>
    <?php settings_fields($this->group); ?>
    <?php do_settings_sections($this->page); ?>
    <p class="submit">
      <input type="submit" name="Submit" value="<?php esc_attr_e('Save Changes'); ?>" class="button-primary" />
    </p>
  </form>
</div>
<?php
	}

	/*
	 * Display explanatory text for the main options section.
	 */
	function _display_options_section() {
	}

	/*
	 * Display the WordPress authentication checkbox.
	 */
	function _display_option_allow_wp_auth() {
		$allow_wp_auth = $this->options['allow_wp_auth'];
		$this->_display_checkbox_field('allow_wp_auth', $allow_wp_auth);
?>
Should the plugin fallback to WordPress authentication if none is found from the server?
<?php
		if ($allow_wp_auth && $this->options['login_uri'] == htmlspecialchars_decode(wp_login_url())) {
			echo '<br /><strong>WARNING</strong>: You must set the login URI below to your external authentication system. Otherwise you will not be able to login!';
		}
	}

	/*
	 * Display the authentication label field, describing the authentication system
	 * in use.
	 */
	function _display_option_auth_label() {
		$auth_label = $this->options['auth_label'];
		$this->_display_input_text_field('auth_label', $auth_label);
?>
Default is <code>HTTP authentication</code>; override to use the name of your single sign-on system.
<?php
	}


	/*
	 * Display the login URI field.
	 */
	function _display_option_login_uri() {
		$login_uri = $this->options['login_uri'];
		$this->_display_input_text_field('login_uri', $login_uri);
?>
Default is <code>%base%/wp-login.php</code>; override to direct users to a single sign-on system. See above for available variables.<br />
Example: <code>%base%/Shibboleth.sso/Login?target=%redirect_encoded%</code>
<?php
	}

	/*
	 * Display the logout URI field.
	 */
	function _display_option_logout_uri() {
		$logout_uri = $this->options['logout_uri'];
		$this->_display_input_text_field('logout_uri', $logout_uri);
?>
Default is <code>%site%</code>; override to e.g. remove a cookie. See above for available variables.<br />
Example: <code>%base%/Shibboleth.sso/Logout?return=%redirect_encoded%</code>
<?php
	}

	/*
	 * Display the automatically create accounts checkbox.
	 */
	function _display_option_auto_create_user() {
		$auto_create_user = $this->options['auto_create_user'];
		$this->_display_checkbox_field('auto_create_user', $auto_create_user);
?>
Should a new user be created automatically if not already in the WordPress database?<br />
Created users will obtain the role defined under &quot;New User Default Role&quot; on the <a href="options-general.php">General Options</a> page.
<?php
	}

	/*
	 * Display a text input field.
	 */
	function _display_input_text_field($name, $value, $size = 75) {
?>
<input type="text" name="<?php echo htmlspecialchars($this->group); ?>[<?php echo htmlspecialchars($name); ?>]" id="client_certificate_authentication_<?php echo htmlspecialchars($name); ?>" value="<?php echo htmlspecialchars($value) ?>" size="<?php echo htmlspecialchars($size); ?>" /><br />
<?php
	}

	/*
	 * Display a checkbox field.
	 */
	function _display_checkbox_field($name, $value) {
?>
<input type="checkbox" name="<?php echo htmlspecialchars($this->group); ?>[<?php echo htmlspecialchars($name); ?>]" id="client_certificate_authentication_<?php echo htmlspecialchars($name); ?>"<?php if ($value) echo ' checked="checked"' ?> value="1" /><br />
<?php
	}
}
?>
