<?php namespace Arx\classes;

use Symfony\Component\HttpFoundation\Request;

class Route {

    /**
     * @var string
     */
    private $path = '/';

    /**
     * @var string
     */
    private $host = '';

    /**
     * @var array
     */
    private $schemes = array();

    /**
     * @var array
     */
    private $methods = array();

    /**
     * @var array
     */
    private $defaults = array();

    /**
     * @var array
     */
    private $requirements = array();

    /**
     * @var array
     */
    private $options = array();

    /**
     * @var null|RouteCompiler
     */
    private $compiled;

    /**
     * Constructor.
     *
     * Available options:
     *
     *  * compiler_class: A class name able to compile this route instance (RouteCompiler by default)
     *
     * @param string       $path         The path pattern to match
     * @param array        $defaults     An array of default parameter values
     * @param array        $requirements An array of requirements for parameters (regexes)
     * @param array        $options      An array of options
     * @param string       $host         The host pattern to match
     * @param string|array $schemes      A required URI scheme or an array of restricted schemes
     * @param string|array $methods      A required HTTP method or an array of restricted methods
     *
     * @api
     */
    public function __construct($path, array $defaults = array(), array $requirements = array(), array $options = array(), $host = '', $schemes = array(), $methods = array())
    {
        $this->setPath($path);
        $this->setDefaults($defaults);
        $this->setRequirements($requirements);
        $this->setOptions($options);
        $this->setHost($host);
        // The conditions make sure that an initial empty $schemes/$methods does not override the corresponding requirement.
        // They can be removed when the BC layer is removed.
        if ($schemes) {
            $this->setSchemes($schemes);
        }
        if ($methods) {
            $this->setMethods($methods);
        }
    }

    public function serialize()
    {
        return serialize(array(
            'path'         => $this->path,
            'host'         => $this->host,
            'defaults'     => $this->defaults,
            'requirements' => $this->requirements,
            'options'      => $this->options,
            'schemes'      => $this->schemes,
            'methods'      => $this->methods,
        ));
    }

    public function unserialize($data)
    {
        $data = unserialize($data);
        $this->path = $data['path'];
        $this->host = $data['host'];
        $this->defaults = $data['defaults'];
        $this->requirements = $data['requirements'];
        $this->options = $data['options'];
        $this->schemes = $data['schemes'];
        $this->methods = $data['methods'];
    }

    /**
     * Returns the pattern for the path.
     *
     * @return string The pattern
     *
     * @deprecated Deprecated in 2.2, to be removed in 3.0. Use getPath instead.
     */
    public function getPattern()
    {
        return $this->path;
    }

    /**
     * Sets the pattern for the path.
     *
     * This method implements a fluent interface.
     *
     * @param string $pattern The path pattern
     *
     * @return Route The current Route instance
     *
     * @deprecated Deprecated in 2.2, to be removed in 3.0. Use setPath instead.
     */
    public function setPattern($pattern)
    {
        return $this->setPath($pattern);
    }

    /**
     * Returns the pattern for the path.
     *
     * @return string The path pattern
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Sets the pattern for the path.
     *
     * This method implements a fluent interface.
     *
     * @param string $pattern The path pattern
     *
     * @return Route The current Route instance
     */
    public function setPath($pattern)
    {
        // A pattern must start with a slash and must not have multiple slashes at the beginning because the
        // generated path for this route would be confused with a network path, e.g. '//domain.com/path'.
        $this->path = '/'.ltrim(trim($pattern), '/');
        $this->compiled = null;

        return $this;
    }

    /**
     * Returns the pattern for the host.
     *
     * @return string The host pattern
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Sets the pattern for the host.
     *
     * This method implements a fluent interface.
     *
     * @param string $pattern The host pattern
     *
     * @return Route The current Route instance
     */
    public function setHost($pattern)
    {
        $this->host = (string) $pattern;
        $this->compiled = null;

        return $this;
    }

    /**
     * Returns the lowercased schemes this route is restricted to.
     * So an empty array means that any scheme is allowed.
     *
     * @return array The schemes
     */
    public function getSchemes()
    {
        return $this->schemes;
    }

    /**
     * Sets the schemes (e.g. 'https') this route is restricted to.
     * So an empty array means that any scheme is allowed.
     *
     * This method implements a fluent interface.
     *
     * @param string|array $schemes The scheme or an array of schemes
     *
     * @return Route The current Route instance
     */
    public function setSchemes($schemes)
    {
        $this->schemes = array_map('strtolower', (array) $schemes);

        // this is to keep BC and will be removed in a future version
        if ($this->schemes) {
            $this->requirements['_scheme'] = implode('|', $this->schemes);
        } else {
            unset($this->requirements['_scheme']);
        }

        $this->compiled = null;

        return $this;
    }

    /**
     * Returns the uppercased HTTP methods this route is restricted to.
     * So an empty array means that any method is allowed.
     *
     * @return array The schemes
     */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     * Sets the HTTP methods (e.g. 'POST') this route is restricted to.
     * So an empty array means that any method is allowed.
     *
     * This method implements a fluent interface.
     *
     * @param string|array $methods The method or an array of methods
     *
     * @return Route The current Route instance
     */
    public function setMethods($methods)
    {
        $this->methods = array_map('strtoupper', (array) $methods);

        // this is to keep BC and will be removed in a future version
        if ($this->methods) {
            $this->requirements['_method'] = implode('|', $this->methods);
        } else {
            unset($this->requirements['_method']);
        }

        $this->compiled = null;

        return $this;
    }

    /**
     * Returns the options.
     *
     * @return array The options
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Sets the options.
     *
     * This method implements a fluent interface.
     *
     * @param array $options The options
     *
     * @return Route The current Route instance
     */
    public function setOptions(array $options)
    {
        $this->options = array(
            'compiler_class' => 'Symfony\\Component\\routing\\RouteCompiler',
        );

        return $this->addOptions($options);
    }

    /**
     * Adds options.
     *
     * This method implements a fluent interface.
     *
     * @param array $options The options
     *
     * @return Route The current Route instance
     */
    public function addOptions(array $options)
    {
        foreach ($options as $name => $option) {
            $this->options[$name] = $option;
        }
        $this->compiled = null;

        return $this;
    }

    /**
     * Sets an option value.
     *
     * This method implements a fluent interface.
     *
     * @param string $name  An option name
     * @param mixed  $value The option value
     *
     * @return Route The current Route instance
     *
     * @api
     */
    public function setOption($name, $value)
    {
        $this->options[$name] = $value;
        $this->compiled = null;

        return $this;
    }

    /**
     * Get an option value.
     *
     * @param string $name An option name
     *
     * @return mixed The option value or null when not given
     */
    public function getOption($name)
    {
        return isset($this->options[$name]) ? $this->options[$name] : null;
    }

    /**
     * Checks if an option has been set
     *
     * @param string $name An option name
     *
     * @return Boolean true if the option is set, false otherwise
     */
    public function hasOption($name)
    {
        return array_key_exists($name, $this->options);
    }

    /**
     * Returns the defaults.
     *
     * @return array The defaults
     */
    public function getDefaults()
    {
        return $this->defaults;
    }

    /**
     * Sets the defaults.
     *
     * This method implements a fluent interface.
     *
     * @param array $defaults The defaults
     *
     * @return Route The current Route instance
     */
    public function setDefaults(array $defaults)
    {
        $this->defaults = array();

        return $this->addDefaults($defaults);
    }

    /**
     * Adds defaults.
     *
     * This method implements a fluent interface.
     *
     * @param array $defaults The defaults
     *
     * @return Route The current Route instance
     */
    public function addDefaults(array $defaults)
    {
        foreach ($defaults as $name => $default) {
            $this->defaults[$name] = $default;
        }
        $this->compiled = null;

        return $this;
    }

    /**
     * Gets a default value.
     *
     * @param string $name A variable name
     *
     * @return mixed The default value or null when not given
     */
    public function getDefault($name)
    {
        return isset($this->defaults[$name]) ? $this->defaults[$name] : null;
    }

    /**
     * Checks if a default value is set for the given variable.
     *
     * @param string $name A variable name
     *
     * @return Boolean true if the default value is set, false otherwise
     */
    public function hasDefault($name)
    {
        return array_key_exists($name, $this->defaults);
    }

    /**
     * Sets a default value.
     *
     * @param string $name    A variable name
     * @param mixed  $default The default value
     *
     * @return Route The current Route instance
     *
     * @api
     */
    public function setDefault($name, $default)
    {
        $this->defaults[$name] = $default;
        $this->compiled = null;

        return $this;
    }

    /**
     * Returns the requirements.
     *
     * @return array The requirements
     */
    public function getRequirements()
    {
        return $this->requirements;
    }

    /**
     * Sets the requirements.
     *
     * This method implements a fluent interface.
     *
     * @param array $requirements The requirements
     *
     * @return Route The current Route instance
     */
    public function setRequirements(array $requirements)
    {
        $this->requirements = array();

        return $this->addRequirements($requirements);
    }

    /**
     * Adds requirements.
     *
     * This method implements a fluent interface.
     *
     * @param array $requirements The requirements
     *
     * @return Route The current Route instance
     */
    public function addRequirements(array $requirements)
    {
        foreach ($requirements as $key => $regex) {
            $this->requirements[$key] = $this->sanitizeRequirement($key, $regex);
        }
        $this->compiled = null;

        return $this;
    }

    /**
     * Returns the requirement for the given key.
     *
     * @param string $key The key
     *
     * @return string|null The regex or null when not given
     */
    public function getRequirement($key)
    {
        return isset($this->requirements[$key]) ? $this->requirements[$key] : null;
    }

    /**
     * Checks if a requirement is set for the given key.
     *
     * @param string $key A variable name
     *
     * @return Boolean true if a requirement is specified, false otherwise
     */
    public function hasRequirement($key)
    {
        return array_key_exists($key, $this->requirements);
    }

    /**
     * Sets a requirement for the given key.
     *
     * @param string $key   The key
     * @param string $regex The regex
     *
     * @return Route The current Route instance
     *
     * @api
     */
    public function setRequirement($key, $regex)
    {
        $this->requirements[$key] = $this->sanitizeRequirement($key, $regex);
        $this->compiled = null;

        return $this;
    }

    /**
     * Compiles the route.
     *
     * @return CompiledRoute A CompiledRoute instance
     *
     * @throws \LogicException If the Route cannot be compiled because the
     *                         path or host pattern is invalid
     *
     * @see RouteCompiler which is responsible for the compilation process
     */
    public function compile()
    {
        if (null !== $this->compiled) {
            return $this->compiled;
        }

        $class = $this->getOption('compiler_class');

        return $this->compiled = $class::compile($this);
    }

    private function sanitizeRequirement($key, $regex)
    {
        if (!is_string($regex)) {
            throw new \InvalidArgumentException(sprintf('routing requirement for "%s" must be a string.', $key));
        }

        if ('' !== $regex && '^' === $regex[0]) {
            $regex = (string) substr($regex, 1); // returns false for a single character
        }

        if ('$' === substr($regex, -1)) {
            $regex = substr($regex, 0, -1);
        }

        if ('' === $regex) {
            throw new \InvalidArgumentException(sprintf('routing requirement for "%s" cannot be empty.', $key));
        }

        // this is to keep BC and will be removed in a future version
        if ('_scheme' === $key) {
            $this->setSchemes(explode('|', $regex));
        } elseif ('_method' === $key) {
            $this->setMethods(explode('|', $regex));
        }

        return $regex;
    }

    /**
     * The routing instance.
     *
     * @var  \Illuminate\routing\Router
     */
    protected $router;

    /**
     * The matching parameter array.
     *
     * @var array
     */
    protected $parameters;

    /**
     * The parsed parameter array.
     *
     * @var array
     */
    protected $parsedParameters;

    /**
     * Execute the route and return the response.
     *
     * @param  \Symfony\Component\HttpFoundation\Request  $request
     * @return mixed
     */
    public function run(Request $request)
    {
        $this->parsedParameters = null;

        // We will only call the routing callable if no "before" middlewares returned
        // a response. If they do, we will consider that the response to requests
        // so that the request "lifecycle" will be easily halted for filtering.
        $response = $this->callBeforeFilters($request);

        if ( ! isset($response))
        {
            $response = $this->callCallable();
        }

        // If the response is from a filter we want to note that so that we can skip
        // the "after" filters which should only run when the route method is run
        // for the incoming request. Otherwise only app level filters will run.
        else
        {
            $fromFilter = true;
        }

        $response = $this->router->prepare($response, $request);

        // Once we have the "prepared" response, we will iterate through every after
        // filter and call each of them with the request and the response so they
        // can perform any final work that needs to be done after a route call.
        if ( ! isset($fromFilter))
        {
            $this->callAfterFilters($request, $response);
        }

        return $response;
    }

    /**
     * Call the callable Closure attached to the route.
     *
     * @return mixed
     */
    protected function callCallable()
    {
        $variables = array_values($this->getParametersWithoutDefaults());

        return call_user_func_array($this->getOption('_call'), $variables);
    }

    /**
     * Call all of the before filters on the route.
     *
     * @param  \Symfony\Component\HttpFoundation\Request   $request
     * @return mixed
     */
    protected function callBeforeFilters(Request $request)
    {
        $before = $this->getAllBeforeFilters($request);

        $response = null;

        // Once we have each middlewares, we will simply iterate through them and call
        // each one of them with the request. We will set the response variable to
        // whatever it may return so that it may override the request processes.
        foreach ($before as $filter)
        {
            $response = $this->callFilter($filter, $request);

            if ( ! is_null($response)) return $response;
        }
    }

    /**
     * Get all of the before filters to run on the route.
     *
     * @param  \Symfony\Component\HttpFoundation\Request  $request
     * @return array
     */
    protected function getAllBeforeFilters(Request $request)
    {
        $before = $this->getBeforeFilters();

        return array_merge($before, $this->router->findPatternFilters($request));
    }

    /**
     * Call all of the "after" filters for a route.
     *
     * @param  \Symfony\Component\HttpFoundation\Request  $request
     * @param  \Symfony\Component\HttpFoundation\Response  $response
     * @return void
     */
    protected function callAfterFilters(Request $request, $response)
    {
        foreach ($this->getAfterFilters() as $filter)
        {
            $this->callFilter($filter, $request, array($response));
        }
    }

    /**
     * Call a given filter with the parameters.
     *
     * @param  string  $name
     * @param  \Symfony\Component\HttpFoundation\Request  $request
     * @param  array   $params
     * @return mixed
     */
    public function callFilter($name, Request $request, array $params = array())
    {
        if ( ! $this->router->filtersEnabled()) return;

        $merge = array($this->router->getCurrentRoute(), $request);

        $params = array_merge($merge, $params);

        // Next we will parse the filter name to extract out any parameters and adding
        // any parameters specified in a filter name to the end of the lists of our
        // parameters, since the ones at the beginning are typically very static.
        list($name, $params) = $this->parseFilter($name, $params);

        if ( ! is_null($callable = $this->router->getFilter($name)))
        {
            return call_user_func_array($callable, $params);
        }
    }

    /**
     * Parse a filter name and add any parameters to the array.
     *
     * @param  string  $name
     * @param  array   $parameters
     * @return array
     */
    protected function parseFilter($name, $parameters = array())
    {
        if (str_contains($name, ':'))
        {
            // If the filter name contains a colon, we will assume that the developer
            // is passing along some parameters with the name, and we will explode
            // out the name and paramters, merging the parameters onto the list.
            $segments = explode(':', $name);

            $name = $segments[0];

            // We will merge the arguments specified in the filter name into the list
            // of existing parameters. We'll send them at the end since any values
            // at the front are usually static such as request, response, route.
            $arguments = explode(',', $segments[1]);

            $parameters = array_merge($parameters, $arguments);
        }

        return array($name, $parameters);
    }

    /**
     * Get a parameter by name from the route.
     *
     * @param  string  $name
     * @param  mixed   $default
     * @return string
     */
    public function getParameter($name, $default = null)
    {
        return array_get($this->getParameters(), $name, $default);
    }

    /**
     * Get the parameters to the callback.
     *
     * @return array
     */
    public function getParameters()
    {
        // If we have already parsed the parameters, we will just return the listing
        // that we already parsed as some of these may have been resolved through
        // a binder that uses a database repository and shouldn't be run again.
        if (isset($this->parsedParameters))
        {
            return $this->parsedParameters;
        }

        $variables = $this->compile()->getVariables();

        // To get the parameter array, we need to spin the names of the variables on
        // the compiled route and match them to the parameters that we got when a
        // route is matched by the routing, as routes instances don't have them.
        $parameters = array();

        foreach ($variables as $variable)
        {
            $parameters[$variable] = $this->resolveParameter($variable);
        }

        return $this->parsedParameters = $parameters;
    }

    /**
     * Resolve a parameter value for the route.
     *
     * @param  string  $key
     * @return mixed
     */
    protected function resolveParameter($key)
    {
        $value = $this->parameters[$key];

        // If the parameter has a binder, we will call the binder to resolve the real
        // value for the parameters. The binders could make a database call to get
        // a User object for example or may transform the input in some fashion.
        if ($this->router->hasBinder($key))
        {
            return $this->router->performBinding($key, $value, $this);
        }

        return $value;
    }

    /**
     * Get the route parameters without missing defaults.
     *
     * @return array
     */
    public function getParametersWithoutDefaults()
    {
        $parameters = $this->getParameters();

        foreach ($parameters as $key => $value)
        {
            // When calling functions using call_user_func_array, we don't want to write
            // over any existing default parameters, so we will remove every optional
            // parameter from the list that did not get a specified value on route.
            if ($this->isMissingDefault($key, $value))
            {
                unset($parameters[$key]);
            }
        }

        return $parameters;
    }

    /**
     * Determine if a route parameter is really a missing default.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return bool
     */
    protected function isMissingDefault($key, $value)
    {
        return $this->isOptional($key) and is_null($value);
    }

    /**
     * Determine if a given key is optional.
     *
     * @param  string  $key
     * @return bool
     */
    public function isOptional($key)
    {
        return array_key_exists($key, $this->getDefaults());
    }

    /**
     * Get the keys of the variables on the route.
     *
     * @return array
     */
    public function getParameterKeys()
    {
        return $this->compile()->getVariables();
    }

    /**
     * Force a given parameter to match a regular expression.
     *
     * @param  string  $name
     * @param  string  $expression
     * @return \Illuminate\Routing\Route
     */
    public function where($name, $expression = null)
    {
        if (is_array($name)) return $this->setArrayOfWheres($name);

        $this->setRequirement($name, $expression);

        return $this;
    }

    /**
     * Force a given parameters to match the expressions.
     *
     * @param  array $wheres
     * @return \Illuminate\Routing\Route
     */
    protected function setArrayOfWheres(array $wheres)
    {
        foreach ($wheres as $name => $expression)
        {
            $this->where($name, $expression);
        }

        return $this;
    }

    /**
     * Set the default value for a parameter.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return \Illuminate\Routing\Route
     */
    public function defaults($key, $value)
    {
        $this->setDefault($key, $value);

        return $this;
    }

    /**
     * Set the before filters on the route.
     *
     * @param  dynamic
     * @return \Illuminate\Routing\Route
     */
    public function before()
    {
        $this->setBeforeFilters(func_get_args());

        return $this;
    }

    /**
     * Set the after filters on the route.
     *
     * @param  dynamic
     * @return \Illuminate\Routing\Route
     */
    public function after()
    {
        $this->setAfterFilters(func_get_args());

        return $this;
    }

    /**
     * Get the name of the action (if any) used by the route.
     *
     * @return string
     */
    public function getAction()
    {
        return $this->getOption('_uses');
    }

    /**
     * Get the before filters on the route.
     *
     * @return array
     */
    public function getBeforeFilters()
    {
        return $this->getOption('_before') ?: array();
    }

    /**
     * Set the before filters on the route.
     *
     * @param  string  $value
     * @return void
     */
    public function setBeforeFilters($value)
    {
        $filters = is_string($value) ? explode('|', $value) : (array) $value;

        $this->setOption('_before', array_merge($this->getBeforeFilters(), $filters));
    }

    /**
     * Get the after filters on the route.
     *
     * @return array
     */
    public function getAfterFilters()
    {
        return $this->getOption('_after') ?: array();
    }

    /**
     * Set the after filters on the route.
     *
     * @param  string  $value
     * @return void
     */
    public function setAfterFilters($value)
    {
        $filters = is_string($value) ? explode('|', $value) : (array) $value;

        $this->setOption('_after', array_merge($this->getAfterFilters(), $filters));
    }

    /**
     * Set the matching parameter array on the route.
     *
     * @param  array  $parameters
     * @return void
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Set the Router instance on the route.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return \Illuminate\Routing\Route
     */
    public function setRouter(Router $router)
    {
        $this->router = $router;

        return $this;
    }

}