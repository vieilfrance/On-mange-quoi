<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Router extends CI_Router {

	/**
	 *  Parse Routes
	 *
	 * This function matches any routes that may exist in
	 * the config/routes.php file against the URI to
	 * determine if the class/method need to be remapped.
	 *
	 * @access	private
	 * @return	void
	 */
	function _parse_routes()
	{
	// Turn the segment array into a URI string
		$uri = implode('/', $this->uri->segments);
		log_message('debug', 'Client sent : ' . $uri);
		
		// Get HTTP verb
		$http_verb = isset($_SERVER['REQUEST_METHOD']) ? strtolower($_SERVER['REQUEST_METHOD']) : 'cli';

		// Is there a literal match?  If so we're done
		if (isset($this->routes[$uri]))
		{
			// Check default routes format
			if (is_string($this->routes[$uri]))
			{
				log_message('debug', 'Route found : ' . $uri . '  --> ' . $this->routes[$uri]);
				log_message('debug', 'Redirecting to : ' . $uri . '  --> ' . $uri);
				$this->_set_request(explode('/', $this->routes[$uri]));
				return;
			}
			// Is there a matching http verb?
			elseif (is_array($this->routes[$uri]) && isset($this->routes[$uri][$http_verb]))
			{
				log_message('debug', 'Route found : ' . $uri . '  --> ' . $this->routes[$uri][$http_verb]);
				log_message('debug', 'Redirecting to : ' . $uri . '  --> ' . $uri .'/'.$http_verb);
				$this->_set_request(explode('/', $this->routes[$uri][$http_verb]));
				return;
			}
		}

		// Loop through the route array looking for wildcards
		foreach ($this->routes as $key => $val)
		{
			$original_key = $key;
			$original_val = $val;
			// Check if route format is using http verb
			if (is_array($val))
			{
				if (isset($val[$http_verb]))
				{
					$val = $val[$http_verb];
				}
				else
				{
					continue;
				}
			}

			// Convert wildcards to RegEx
			$key = str_replace(array(':any', ':num'), array('[^/]+', '[0-9]+'), $key);

			// Does the RegEx match?
			if (preg_match('#^'.$key.'$#', $uri, $matches))
			{
				// Are we using callbacks to process back-references?
				if ( ! is_string($val) && is_callable($val))
				{
					// Remove the original string from the matches array.
					array_shift($matches);

					// Execute the callback using the values in matches as its parameters.
					$val = call_user_func_array($val, $matches);
				}
				// Are we using the default routing method for back-references?
				elseif (strpos($val, '$') !== FALSE && strpos($key, '(') !== FALSE)
				{
					$val = preg_replace('#^'.$key.'$#', $val, $uri);
				}
				log_message('debug', 'Route found : ' . $original_key . '  --> ' . $original_val);
				log_message('debug', 'Redirecting to : ' . $uri . '  --> ' . $val);
				$this->_set_request(explode('/', $val));
				return;
			}
		}

		// If we got this far it means we didn't encounter a
		// matching route so we'll set the site default route
		log_message('debug', 'Redirecting to : DEFAULT ROUTE BABY ! ');
		$this->_set_request(array_values($this->uri->segments));	
	
	
	}

}