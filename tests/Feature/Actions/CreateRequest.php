<?php

namespace Tests\Feature\Actions;

use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Illuminate\Http\Request;

trait CreateRequest{

    public function createRequest($method, $uri, $parameters = [], $cookies = [], $files = [], $server = [], $content = null)
    {

        $files = array_merge($files, $this->extractFilesFromDataArray($parameters));

        $symfonyRequest = SymfonyRequest::create(
            $this->prepareUrlForRequest($uri), $method, $parameters,
            $cookies, $files, array_replace($this->serverVariables, $server), $content
        );

        $request = Request::createFromBase($symfonyRequest);

        return $request;
    }
}