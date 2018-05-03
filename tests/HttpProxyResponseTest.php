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
namespace CodeInc\Psr7Responses\Tests;
use CodeInc\Psr7Responses\HttpProxyResponse;


/**
 * Class HttpProxyResponseTest
 *
 * @uses HttpProxyResponse
 * @package CodeInc\Psr7Responses\Tests
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
final class HttpProxyResponseTest extends AbstractResponseTestCase
{
    private const TEST_TXT_URL = 'https://www.sample-videos.com/text/Sample-text-file-10kb.txt';
    private const TEST_IMG_URL = 'https://www.sample-videos.com/img/Sample-jpg-image-50kb.jpg';

    /**
     * @throws \CodeInc\Psr7Responses\ResponseException
     */
    public function testTxtResponse():void
    {
        $response = new HttpProxyResponse(self::TEST_IMG_URL);
        self::assertIsResponse($response);
        self::assertResponseStatusCode(200, $response);
        self::assertResponseHasBody($response);
    }
    /**
     * @throws \CodeInc\Psr7Responses\ResponseException
     */
    public function testImgResponse():void
    {
        $response = new HttpProxyResponse(self::TEST_TXT_URL);
        self::assertIsResponse($response);
        self::assertResponseStatusCode(200, $response);
        self::assertResponseHasBody($response);
    }
}