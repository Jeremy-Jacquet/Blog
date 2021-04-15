<?php

namespace App\src\router;

use Exception;
use App\src\router\HTTPRequest;
use App\src\router\HTTPResponse;

/**
 * Router
 */
class Router
{    
    /**
     * @var HTTPRequest
     */
    private $httpRequest;

    /**
     * @var HTTPResponse
     */
    private $httpResponse;
    
    
    /**
     * construct Router
     *
     * @return void
     */
    public function __construct()
    {
        $this->httpRequest = new HTTPRequest();
        $this->httpResponse = new HTTPResponse(
                                                $this->httpRequest->getGet(),
                                                $this->httpRequest->getPost(),
                                                $this->httpRequest->getFile()
                                            );
    }
    
    /**
     * launch router
     *
     * @return void
     */
    public function run()
    {
        try {
            $this->httpResponse->displayView();
        }
        catch (Exception $e) {
        }
    }
}
