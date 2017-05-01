<?php

namespace Mini\View;

use Mini\Support\Contracts\ArrayableInterface;
use Mini\Support\Contracts\RenderableInterface;
use Mini\View\Factory;

use ArrayAccess;
use BadMethodCallException;
use Closure;
use Exception;


class View implements ArrayAccess, RenderableInterface
{
    /**
     * The View Factory instance.
     *
     * @var \Nova\View\Factory
     */
    protected $factory;

    /**
     * @var string The given View name.
     */
    protected $view = null;

    /**
     * @var string The path to the View file on disk.
     */
    protected $path = null;

    /**
     * @var array Array of local data.
     */
    protected $data = array();

    /**
     * @var array Array of shared data.
     */
    protected static $shared = array();


    /**
     * Constructor
     *
     * @param mixed $path
     * @param array $data
     */
    public function __construct(Factory $factory, $view, $path, $data = array())
    {
        $this->factory = $factory;

        $this->view = $view;
        $this->path = $path;

        $this->data = ($data instanceof ArrayableInterface) ? $data->toArray() : (array) $data;
    }

    /**
     * Get the string contents of the View.
     *
     * @param  \Closure  $callback
     * @return string
     */
    public function render(Closure $callback = null)
    {
        $contents = $this->renderContents();

        $response = isset($callback) ? call_user_func($callback, $this, $contents) : null;

        return $response ?: $contents;
    }

    /**
     * Get the string contents of the View.
     *
     * @return string
     */
    protected function renderContents()
    {
        $__data = $this->gatherData();

        ob_start();

        // Extract the rendering variables.
        foreach ($__data as $__variable => $__value) {
            ${$__variable} = $__value;
        }

        unset($__variable, $__value);

        try {
            include $this->path;
        }
        catch (Exception $e) {
            ob_get_clean();

            throw $e;
        }

        return ltrim(ob_get_clean());
    }

    /**
     * Return all variables stored on local and shared data.
     *
     * @return array
     */
    protected function gatherData()
    {
        $data = array_merge(static::$shared, $this->data);

        // All nested Views are evaluated before the main View.
        foreach ($data as $key => $value) {
            if ($value instanceof View) {
                $data[$key] = $value->render();
            }
        }

        return $data;
    }

    /**
     * Add a view instance to the view data.
     *
     * @param  string  $key
     * @param  string  $view
     * @param  array   $data
     * @return View
     */
    public function nest($key, $view, $data = array())
    {
        return $this->with($key, $this->factory->make($view, $data));
    }

    /**
     * Add a key / value pair to the shared view data.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return void
     */
    public static function share($key, $value)
    {
        if (! is_array($key)) {
            static::$shared[$key] = $value;

            return;
        }

        foreach ($key as $innerKey => $innerValue) {
            static::share($innerKey, $innerValue);
        }
    }

    /**
     * Add a key / value pair to the shared view data.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return View
     */
    public function shares($key, $value)
    {
        static::share($key, $value);

        return $this;
    }

    /**
     * Add a key / value pair to the view data.
     *
     * Bound data will be available to the view as variables.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return View
     */
    public function with($key, $value = null)
    {
        if (is_array($key)) {
            $this->data = array_merge($this->data, $key);
        } else {
            $this->data[$key] = $value;
        }

        return $this;
    }

    /**
     * Implementation of the ArrayAccess offsetExists method.
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->data);
    }

    /**
     * Implementation of the ArrayAccess offsetGet method.
     */
    public function offsetGet($offset)
    {
        return isset($this->data[$offset]) ? $this->data[$offset] : null;
    }

    /**
      * Implementation of the ArrayAccess offsetSet method.
      */
    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }

    /**
     * Implementation of the ArrayAccess offsetUnset method.
     */
    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }

    /**
     * Magic Method for handling dynamic data access.
     */
    public function __get($key)
    {
        return isset($this->data[$key]) ? $this->data[$key] : null;
    }

    /**
     * Magic Method for handling the dynamic setting of data.
     */
    public function __set($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * Magic Method for checking dynamically set data.
     */
    public function __isset($key)
    {
        return isset($this->data[$key]);
    }

    /**
     * Get the evaluated string content of the View.
     *
     * @return string
     */
    public function __toString()
    {
        try {
            return $this->render();
        }
        catch (Exception $e) {
            return '';
        }
    }

    /**
     * Magic Method for handling dynamic functions.
     *
     * @param  string  $method
     * @param  array   $params
     * @return \Core\View|static|void
     *
     * @throws \BadMethodCallException
     */
    public function __call($method, $params)
    {
        // Add the support for the dynamic withX Methods.
        if (substr($method, 0, 4) == 'with') {
            $name = lcfirst(substr($method, 4));

            return $this->with($name, array_shift($params));
        }

        throw new BadMethodCallException("Method [$method] does not exist.");
    }
}

