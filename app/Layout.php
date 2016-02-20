<?php namespace App;

// Deps
use Request;
use Route;

/**
 * Helper methods designed to be called through a Facade and used within views.
 */
class Layout {

	/**
	 * Injected body classes
	 *
	 * @var array
	 */
	protected $body_classes = [];

	/**
	 * Injected meta tag gasg
	 *
	 * @var array
	 */
	protected $meta = [];

	/**
	 * Injected title value
	 *
	 * @var string
	 */
	protected $title;

	/**
	 * Contains the parsed webpack manifest.json
	 *
	 * @var stdObject
	 */
	protected $webpack_manifest;

	/**
	 * ---------------------------------------------------------------------------
	 * Views
	 */

	/**
	 * Helper method for nesting a view into the default layout
	 *
	 * @param  $view string The name of the view file, like "home.index"
	 * @param  $vars array Key-val pairs of data to pass to the view
	 * @return Illuminate\View\Factory
	 */
	public function nest($view, $vars = []) {
		return view('layouts.default')->nest('content', $view, $vars);
	}

	/**
	 * ---------------------------------------------------------------------------
	 * Asset tags
	 */

	/**
	 * Generate either a script (js) or link (css) tag using the manifest.json
	 * file output by json.
	 *
	 * @param  string $name The webpack entry point name for the asset with it's
	 *                      suffix.  For instance, if your entry config has
	 *                      `app: 'bott.coffee'`, you would pass this function
	 *                      'app.js'
	 * @return string|void  Either a script or link HTML string.  Or nothing if
	 *                      the the $name coudln't be found.
	 *
	 * @throws Bkwld\Camo\Exceptions\ManifestNotFound;
	 */
	public function webpackAssetTag($name) {

		// Load the manifest
		if (!$this->webpack_manifest) {
			$manifest_path = public_path('dist/manifest.json');
			if (!file_exists($manifest_path)) throw new Exception('Manifest not found! Run webpack.');
			$this->webpack_manifest = json_decode(file_get_contents($manifest_path));
		}

		// If the manifest contains a reference, generate a tag for it.  Otherwise
		// just use an empty string
		list($key, $type) = explode('.', $name);
		$tag = empty($this->webpack_manifest->$key->$type) ? ''
			: $this->assetTag($type, $this->webpack_manifest->$key->$type);

		// Cache and return the tag
		return $tag;
	}

	/**
	 * Generate a script or link tag for the provided URL
	 *
	 * @param  string $type "js" or "css"
	 * @param  string $url  URL to an asset
	 * @return string       An HTML tag linking to the URL
	 */
	public function assetTag($type, $url) {
		switch($type) {
			case 'js': return "<script src='$url' charset='utf-8'></script>";
			case 'css': return "<link href='$url' rel='stylesheet'>";
		}
	}

	/**
	 * ---------------------------------------------------------------------------
	 * Title tag
	 */

	/**
	 * Set and return the page title
	 *
	 * @param  string $title
	 * @return string
	 */
	public function title($title = null) {
		if ($title) $this->setTitle($title);
		return $this->getTitle();
	}

	/**
	 * Set the page title
	 *
	 * @param  string $title
	 * @return $this
	 */
	public function setTitle($title) {
		$this->title = $title;
		return $this;
	}

	/**
	 * Concatenate site and titke
	 *
	 * @return string
	 */
	public function getTitle() {

		// Get the site name
		$site = config('site.name');
		if (is_callable($site)) $site = call_user_func($site);

		// Make the title
		if ($site && $this->title) return $this->title . ' | ' . $site;
		else if ($site) return $site;
		else return $this->title;
	}


	/**
	 * ---------------------------------------------------------------------------
	 * Meta tags
	 */

	/**
	 * Make the body class
	 */

	/**
	 * Set and return the meta tags for a site
	 *
	 * @param  array $config
	 * @return string HTML
	 */
	public function meta($meta = null) {
		if (is_array($meta)) $this->setMeta($meta);
		return $this->getMeta();
	}

	/**
	 * Set the page meta tags
	 *
	 * @param  array $data
	 * @return $this
	 */
	public function setMeta($meta) {
		$this->meta = $data;
		return $this;
	}

	/**
	 * Merge config and injected value together and render a series of meta tags
	 *
	 * @return  string HTML
	 */
	public function getMeta() {

		// Get general site config values that have valid keys for meta tags
		$config = array_intersect_key(config('site'), array_flip(array(
			'og:title',
			'description',
			'og:description',
			'og:image',
		)));

		// Convert any closures in the config to strings
		$config = array_map(function($value) {
			return is_callable($value) ? call_user_func($value) : $value;
		}, $config);

		// Generate default og:title
		if (config('site.name') && empty($config['og:title'])) {
			$config['og:title'] = $this->title;
		}

		// Merge passed meta data into site config
		$meta = array_merge($config, $this->meta);

		// Make an explicit og:description if not defined because that makes the
		// Facebook linter happy.
		if (!empty($meta['description']) && empty($meta['og:description'])) {
			$meta['og:description'] = $meta['description'];
		}

		// Create all tags
		$html = '';
		foreach($meta as $key => $val) {
			$val = htmlspecialchars($val, ENT_QUOTES);
			if (strpos($key, 'og:') === 0) $html .= "<meta property='$key' content='$val' />";
			else $html .= "<meta name='$key' content='$val' />";
		}
		return $html;
	}

	/**
	 * ---------------------------------------------------------------------------
	 * Body class
	 */

	/**
	 * Append body classes
	 *
	 * @param string $class
	 * @return $this
	 */
	public function addBodyClass($class) {
		$this->body_classes[] = $class;
		return $this;
	}

	/**
	 * Set or return the injected body class
	 *
	 * @param string args
	 * @return html
	 */
	public function bodyClass() {
		$args = func_get_args();
		if (isset($args[0]) && is_array($args[0])) $this->setBodyClass($args);
		elseif (count($args)) $this->setBodyClass($args);
		return $this->getBodyClass();
	}

	/**
	 * Set the body classes array
	 *
	 * @param array $classes
	 * @return $this
	 */
	public function setBody($classes) {
		$this->classes = $classes;
		return $this;
	}

	/**
	 * Return string of all body classes
	 *
	 * @return string
	 */
	public function getBodyClass() {
		$classes = $this->body_classes;

		// Add controller to body class
		if ($class = $this->makeClassFromController()) {
			foreach(explode(' ', $class) as $class) {
				$classes[] = 'body-'.$class;
			}
		}

		// Add route to body class
		if ($class = $this->makeClassFromNamedRoute()) {
			$classes[] = 'body-'.$class;
		}

		// Return all classes
		return implode(' ', $classes);
	}

	/**
	 * Make the classes from controller and action
	 *
	 * @return string
	 */
	public function makeClassFromController() {
		if (!$action = Route::currentRouteAction()) return;

		// Strip restful prefixes and suffices
		preg_match('#(\w+)Controller@(?:get|post)?(\w+)#i', $action, $matches);

		// Make an action for missing methods
		if ($matches[2] == 'missingMethod') $matches[2] = implode(' ', Request::segments());

		// Combine controller and action to make class
		return str_snake($matches[1], '-').' '.Str::snake($matches[2], '-');
	}

	/**
	 * Make the body class from a named route
	 *
	 * @return string
	 */
	public function makeClassFromNamedRoute() {
		return Route::currentRouteName();
	}

}
