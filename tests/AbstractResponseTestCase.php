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
// Time:     12:33
// Project:  Psr7Responses
//
declare(strict_types=1);
namespace CodeInc\Psr7Responses\Tests;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;


/**
 * Class AbstractResponseTestCase
 *
 * @package CodeInc\Psr7Responses\Tests
 * @author Joan Fabrégat <joan@codeinc.fr>
 * @license MIT <https://github.com/CodeIncHQ/Psr7Responses/blob/master/LICENSE>
 * @link https://github.com/CodeIncHQ/Psr7Responses
 */
abstract class AbstractResponseTestCase extends TestCase
{
    /**
     * @param $response
     */
    public static function assertIsResponse($response):void
    {
        self::assertInstanceOf(ResponseInterface::class, $response,
            sprintf(
                "%s is not a valid response",
                is_object($response) ? get_class($response) : (string)$response
            ));
    }

    /**
     * @param $response
     */
    public static function assertIsNotResponse($response):void
    {
        self::assertNotInstanceOf(ResponseInterface::class, $response,
            sprintf(
                "%s is a valid response",
                is_object($response) ? get_class($response) : (string)$response
            ));
    }

    /**
     * @param int $expected
     * @param ResponseInterface $response
     */
    public static function assertResponseStatusCode(int $expected, ResponseInterface $response):void
    {
        self::assertEquals($response->getStatusCode(), $expected,
            sprintf("The response status code is invalid (%s expected instead of %s)",
                $expected, $response->getStatusCode()));
    }

    /**
     * @param int $expected
     * @param ResponseInterface $response
     */
    public static function assertResponseNotStatusCode(int $expected, ResponseInterface $response):void
    {
        self::assertEquals($response->getStatusCode(), $expected,
            sprintf("The response status code is invalid (must be different than %s)", $expected));
    }

    /**
     * @param ResponseInterface $response
     * @param bool $assertBodyLength
     */
    public static function assertResponseHasBody(ResponseInterface $response, bool $assertBodyLength = true):void
    {
        $body = self::getResponseBody($response);
        self::assertNotEmpty($body, "The response body is empty");
        if ($assertBodyLength) {
            self::assertNotNull($response->getHeaderLine('Content-Length'),
                "The response 'Content-Length' header is missing, unable to assert the response length");
            if ($response->getHeaderLine('Content-Length')) {
                self::assertEquals(strlen($body), $response->getHeaderLine('Content-Length'),
                    sprintf("The response body size %s is different from the 'Content-Length' header size %s",
                        strlen($body), $response->getHeaderLine('Content-Length')));
            }
        }
    }

    /**
     * @param ResponseInterface $response
     */
    public static function assertResponseNotHasBody(ResponseInterface $response):void
    {
        $body = self::getResponseBody($response);
        self::assertEmpty($body, "The response body is not empty");
    }

    /**
     * @param ResponseInterface $response
     * @return null|string
     */
    private static function getResponseBody(ResponseInterface $response):?string
    {
        // gets the stream
        self::assertNotNull($bodyStream = $response->getBody()->detach(),
            "Unable to detach response body stream");
        self::assertInternalType('resource', $bodyStream,
            sprintf("Invalid response body stream type: ", gettype($bodyStream)));

        // downloads the response's body
        self::assertNotFalse($body = stream_get_contents($bodyStream),
            "Unable to download the response body stream");

        // closes the stream
        self::assertTrue(fclose($bodyStream),
            "Error while closing the response stream");

        return $body ?? null;
    }
}