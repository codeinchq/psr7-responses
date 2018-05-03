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
use GuzzleHttp\Psr7\Response;
use function GuzzleHttp\Psr7\stream_for;


/**
 * Class HttpProxyResponse
 *
 * @see HttpProxyResponseTest
 * @package CodeInc\Psr7Responses
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class HttpProxyResponse extends Response
{
    protected const IMPORT_HEADERS = [
        'content-type',
        'content-length',
        'content-disposition',
        'date',
        'last-modified',
        'etag',
        'cache',
        'pragma',
        'expires',
        'cache-control'
    ];

    /**
     * ProxyResponse constructor.
     *
     * @param string $remoteUrl
     * @param int $status
     * @param array $headers
     * @param string $version
     * @param null|string $reason
     * @throws ResponseException
     */
    public function __construct(string $remoteUrl, int $status = 200, array $headers = [],
        string $version = '1.1', ?string $reason = null)
    {
        // checking the URL
        if (!filter_var($remoteUrl, FILTER_VALIDATE_URL)) {
            throw new ResponseException(
                sprintf("%s is not a valid URL", $remoteUrl),
                $this
            );
        }

        // downloading
        $context = stream_context_create(['http' => ['method' => 'GET']]);
        if (($f = fopen($remoteUrl, 'r', false, $context)) === false) {
            throw new ResponseException(
                sprintf("Unable to open the URL %s", $remoteUrl),
                $this
            );
        }

        // importing the headers
        foreach ($http_response_header as $header) {
            if (preg_match('/^([\\w-]+): +(.+)$/ui', $header, $matches)) {
                if (in_array(strtolower($matches[1]), self::IMPORT_HEADERS)) {
                    $headers[$matches[1]] = $matches[2];
                }
            }
        }

        parent::__construct($status, $headers, stream_for($f), $version, $reason);
    }

}