<?php

namespace App\Core;

use stdClass;

class Request extends Rule
{
    /**
     * @var		array	$params
     */
    public array $params = [];

    /**
     * @var  array	$params
     */
    public array $input = [];

    /**
     * getPath.
     *
     * @access	public
     * @return	mixed
     */
    public function getPath(): mixed
    {
        $uri = urldecode(
            parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
        );

        return $uri;
    }

    /**
     * getMethod.
     *
     * @access	public
     * @return	mixed
     */
    public function getMethod(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    /**
     * isGet.
     *
     * @return	bool
     */
    public function isGet(): bool
    {
        return $this->getMethod() === 'get';
    }

    /**
     * isPost.
     *
     * @return	bool
     */
    public function isPost(): bool
    {
        return $this->getMethod() === 'post';
    }

    /**
     * getBody.
     *
     * @access	public
     * @return	mixed
     */
    public function all()
    {
        $body = [];
        if ($this->getMethod() === 'get') {
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if ($this->getMethod() === 'post') {
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        return $body ?? [];
    }

    /**
     * input.
     *
     * @param	mixed	$param	
     * @return	mixed
     */
    public function input($param): mixed
    {
        if ($this->getMethod() === 'get') {
            foreach ($_GET as $key => $value) {
                $this->input[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if ($this->getMethod() === 'post') {
            foreach ($_POST as $key => $value) {
                $this->input[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if (!in_array($param, array_keys($this->input))) {
            return $this->input;
        }

        return $this->input[$param];
    }


    /**
     * has.
     *
     * @access	public
     * @param	mixed	$param	
     * @return	mixed
     */
    public function has($param): bool
    {
        if ($this->getMethod() === 'get') {
            foreach ($_GET as $key => $value) {
                $this->input[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if ($this->getMethod() === 'post') {
            foreach ($_POST as $key => $value) {
                $this->input[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        return array_key_exists($param, $this->input);
    }

    /**
     * @param $params
     * @return self
     */
    public function setRouteParams($params): Request
    {
        $this->params = $params;

        return $this;
    }

    /**
     * getRouteParams.
     *
     * @access	public
     * @return	mixed
     */
    public function getRouteParams(): mixed
    {
        return $this->params;
    }

    /**
     * getRouteParam.
     *
     * @access	public
     * @param	mixed	$param  	
     * @param	mixed	$default	Default: null
     * @return	mixed
     */
    public function getRouteParam($param, $default = null): mixed
    {
        return $this->params[$param] ?? $default;
    }
}
