<?php

namespace Mii;

class Request extends Rule
{
    /**
     * Stores query and post parameters.
     *
     * @var array<string, mixed>
     */
    public array $params = [];

    /**
     * Stores sanitized input parameters.
     *
     * @var array<string, mixed>
     */
    public array $input = [];

    /**
     * Retrieves the current request URI path.
     *
     * @return string The decoded URI path.
     */
    public function getPath(): string
    {
        return urldecode(
            parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
        );
    }

    /**
     * Retrieves the HTTP method used for the request.
     *
     * @return string The HTTP method in lowercase.
     */
    public function getMethod(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    /**
     * Checks if the request method is GET.
     *
     * @return bool True if the method is GET, false otherwise.
     */
    public function isGet(): bool
    {
        return $this->getMethod() === 'get';
    }

    /**
     * Checks if the request method is POST.
     *
     * @return bool True if the method is POST, false otherwise.
     */
    public function isPost(): bool
    {
        return $this->getMethod() === 'post';
    }

    /**
     * Retrieves all input data, sanitizing it based on the request method.
     *
     * @return array<string, mixed> Sanitized input data.
     */
    public function all(): array
    {
        $body = [];
        $inputSource = $this->getMethod() === 'get' ? $_GET : $_POST;

        foreach ($inputSource as $key => $value) {
            $body[$key] = filter_input(
                $this->getMethod() === 'get' ? INPUT_GET : INPUT_POST,
                $key,
                FILTER_SANITIZE_SPECIAL_CHARS
            );
        }

        return $body;
    }

    /**
     * Retrieves a specific input parameter or all input data.
     *
     * @param string $param The parameter to retrieve.
     * @return mixed The input value if the parameter exists, otherwise the whole input array.
     */
    public function input(string $param): mixed
    {
        // Populate the input array if it's empty
        if (empty($this->input)) {
            $this->input = $this->all();
        }

        return $this->input[$param] ?? $this->input;
    }

    /**
     * Checks if a specific parameter exists in the input data.
     *
     * @param string $param The parameter to check.
     * @return bool True if the parameter exists, false otherwise.
     */
    public function has(string $param): bool
    {
        // Populate the input array if it's empty
        if (empty($this->input)) {
            $this->input = $this->all();
        }

        return array_key_exists($param, $this->input);
    }

    /**
     * Sets route parameters for the request.
     *
     * @param array<string, mixed> $params The route parameters.
     * @return self The current instance.
     */
    public function setRouteParams(array $params): self
    {
        $this->params = $params;

        return $this;
    }

    /**
     * Retrieves the route parameters.
     *
     * @return array<string, mixed> The route parameters.
     */
    public function getRouteParams(): array
    {
        return $this->params;
    }

    /**
     * Retrieves a specific route parameter with an optional default value.
     *
     * @param string $param The route parameter to retrieve.
     * @param mixed $default The default value if the parameter does not exist.
     * @return mixed The route parameter value or the default value.
     */
    public function getRouteParam(string $param, mixed $default = null): mixed
    {
        return $this->params[$param] ?? $default;
    }
}
