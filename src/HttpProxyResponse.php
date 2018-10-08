<?php
//
// +---------------------------------------------------------------------+
// | CODE INC. SOURCE CODE                                               |
// +---------------------------------------------------------------------+
// | Copyright (c) 2017 - Code Inc. SAS - All Rights Reserved.           |
// | Visit https://www.codeinc.fr for more information about licensing.  |
// +---------------------------------------------------------------------+
// | NOTICE:  All information contained herein is, and remains the       |
// | property of Code Inc. SAS. The intellectual and technical concepts  |
// | contained herein are proprietary to Code Inc. SAS are protected by  |
// | trade secret or copyright law. Dissemination of this information or |
// | reproduction of this material  is strictly forbidden unless prior   |
// | written permission is obtained from Code Inc. SAS.                  |
// +---------------------------------------------------------------------+
//
// Author:   Joan Fabrégat <joan@codeinc.fr>
// Date:     03/05/2018
// Time:     11:43
// Project:  Psr7Responses
//
declare(strict_types=1);
namespace CodeInc\Psr7Responses;
use CodeInc\Psr7Responses\Tests\HttpProxyResponseTest;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;


/**
 * Class HttpProxyResponse
 *
 * @see HttpProxyResponseTest
 * @package CodeInc\Psr7Responses
 * @author Joan Fabrégat <joan@codeinc.fr>
 * @license MIT <https://github.com/CodeIncHQ/Psr7Responses/blob/master/LICENSE>
 * @link https://github.com/CodeIncHQ/Psr7Responses
 * @version 2
 */
class HttpProxyResponse extends Response
{
    /**
     * @var string
     */
    private $remoteUrl;

    /**
     * @var ResponseInterface
     */
    private $response;

    /**
     * @var string[]
     */
    private $acceptableProxyHeaders = [
        'Content-Type',
        'Content-Length',
        'Content-Disposition',
        'Date',
        'Last-Modified',
        'Etag',
        'Pragma',
        'Expires',
        'Cache-Control'
    ];

    /**
     * ProxyResponse constructor.
     *
     * @param string $remoteUrl
     * @param array $headers
     * @param string $version
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function __construct(string $remoteUrl, array $headers = [], string $version = '1.1')
    {
        if (!filter_var($remoteUrl, FILTER_VALIDATE_URL)) {
            throw new \RuntimeException(sprintf("%s is not a valid URL", $remoteUrl));
        }
        $this->remoteUrl = $remoteUrl;

        parent::__construct(
            $this->getResponse()->getStatusCode(),
            $this->getResponseHeaders() + $headers,
            $this->getResponse()->getBody(),
            $version,
            $this->getResponse()->getReasonPhrase()
        );
    }

    /**
     * Returns the HTTP response.
     *
     * @return ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getResponse():ResponseInterface
    {
        if (!$this->response) {
            $this->response = (new Client())->request('GET', $this->remoteUrl);
        }
        return $this->response;
    }

    /**
     * Returns all the imported headers from the HTTP response.
     *
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getResponseHeaders():array
    {
        $headers = [];
        foreach ($this->getResponse()->getHeaders() as $header => $values) {
            if (preg_grep('/^'.preg_quote($header, '$/').'/ui', $this->acceptableProxyHeaders)) {
                $headers[$header] = $values;
            }
        }
        return $headers;
    }

    /**
     * @return string[]
     */
    public function getAcceptableProxyHeaders():array
    {
        return $this->acceptableProxyHeaders;
    }

    /**
     * @param string[] $acceptableProxyHeaders
     */
    public function setAcceptableProxyHeaders(array $acceptableProxyHeaders):void
    {
        $this->acceptableProxyHeaders = $acceptableProxyHeaders;
    }

    /**
     * Returns the remote URL.
     *
     * @return string
     */
    public function getRemoteUrl():string
    {
        return $this->remoteUrl;
    }
}