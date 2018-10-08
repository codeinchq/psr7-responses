<?php
//
// +---------------------------------------------------------------------+
// | CODE INC. SOURCE CODE                                               |
// +---------------------------------------------------------------------+
// | Copyright (c) 2018 - Code Inc. SAS - All Rights Reserved.           |
// | Visit https://www.codeinc.fr for more information about licensing.  |
// +---------------------------------------------------------------------+
// | NOTICE:  All information contained herein is, and remains the       |
// | property of Code Inc. SAS. The intellectual and technical concepts  |
// | contained herein are proprietary to Code Inc. SAS are protected by  |
// | trade secret or copyright law. Dissemination of this information or |
// | reproduction of this material is strictly forbidden unless prior    |
// | written permission is obtained from Code Inc. SAS.                  |
// +---------------------------------------------------------------------+
//
// Author:   Joan Fabrégat <joan@codeinc.fr>
// Date:     08/10/2018
// Project:  Psr7Responses
//
declare(strict_types=1);
namespace CodeInc\Psr7Responses;

/**
 * Class NotModifiedResponse
 *
 * @package CodeInc\Psr7Responses
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class NotModifiedResponse extends EmptyResponse
{
    /**
     * NotModifiedResponse constructor.
     *
     * @param int $code
     * @param string $reasonPhrase
     * @param array $headers
     * @param string $version
     */
    public function __construct(int $code = 304, string $reasonPhrase = '',
        array $headers = [], string $version = '1.1')
    {
        parent::__construct($code, $reasonPhrase, $headers, $version);
    }
}