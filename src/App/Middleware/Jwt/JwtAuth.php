<?php
namespace App\Middleware\Jwt;

class JwtAuth extends \Slim\Middleware\JwtAuthentication
{
    protected $options = array(
        "secure" => true,
        "relaxed" => array("localhost", "127.0.0.1"),
        "environment" => "HTTP_AUTHORIZATION",
        "cookie" => "token",
        "path" => null,
        "callback" => null,
        "error" => null
    );

    /**
     * Create a new JwtAuth Instance
     */
    public function __construct($options = array())
    {
        parent::__construct($options);

        $this->options = $options;
    }

    /**
     * Call the middleware
     */
    public function call()
    {
        $app = $this->app;
        $environment = $this->app->environment;
        $scheme = $environment["slim.url_scheme"];

        /* If rules say we should not authenticate call next and return. */
        if (false === $this->shouldAuthenticate()) {
            $this->next->call();
            return;
        }

        /* HTTP allowed only if secure is false or server is in relaxed array. */
        if ("https" !== $scheme && true === $this->options["secure"]) {
            if (!in_array($environment["SERVER_NAME"], $this->options["relaxed"])) {
                $message = sprintf(
                    "Insecure use of middleware over %s denied by configuration.",
                    strtoupper($scheme)
                );
                throw new \RuntimeException($message);
            }
        }

        /* If token cannot be found return with 401 Unauthorized. */
        if (false === $token = $this->fetchToken()) {
            return $this->prepareJsonResponse($app, 401, array(
                'status' => 401,
                'error' => true,
                'msg'   => 'JWT token not found'
            ));
        }

        /* If token cannot be decoded return with 401 Unauthorized. */
        if (false === $decoded = $this->decodeToken($token)) {
            return $this->prepareJsonResponse($app, 401, array(
                'status' => 401,
                'error' => true,
                'msg'   => 'JWT token cannot be decoded'
            ));
        }

        /* If callback returns false return with 401 Unauthorized. */
        if (is_callable($this->options["callback"])) {
            $params = array("decoded" => $decoded, "app" => $this->app);
            if (false === $this->options["callback"]($params)) {
                return $this->prepareJsonResponse($app, 401, array(
                    'status' => 401,
                    'error' => true,
                    'msg'   => 'Callback returned false'
                ));
            }
        }

        /* Everything ok, call next middleware. */
        $this->next->call();
    }

    public function prepareJsonResponse($app, $status, array $response)
    {
        $app->response->status($status);
        $app->response()->header('Content-Type', 'application/json');
        $app->response()->body(json_encode($response, 0));
    }
}
