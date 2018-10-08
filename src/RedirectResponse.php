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
// Date:     23/02/2018
// Time:     21:41
// Project:  Psr7Responses
//
declare(strict_types = 1);
namespace CodeInc\Psr7Responses;
use GuzzleHttp\Psr7\Response;


/**
 * Class RedirectResponse
 *
 * @package CodeInc\Psr7Responses
 * @author Joan Fabrégat <joan@codeinc.fr>
 * @license MIT <https://github.com/CodeIncHQ/Psr7Responses/blob/master/LICENSE>
 * @link https://github.com/CodeIncHQ/Psr7Responses
 * @version 2
 */
class RedirectResponse extends Response
{
    /**
     * @var string
     */
    private $url;

    /**
     * RedirectResponse constructor.
     *
     * @param string $url
     * @param int $code
     * @param string $reasonPhrase
     * @param array $headers
     * @param string $version
     */
	public function __construct(string $url, int $code = 302, string $reasonPhrase = '',
        array $headers = [], string $version = '1.1')
	{
	    $this->url = $url;
		$headers["Location"] = $url;
		parent::__construct($code, $headers, $version, $reasonPhrase);
	}

    /**
     * Returns the URL to be redirected to.
     *
     * @return string
     */
    public function getUrl():string
    {
        return $this->url;
    }
}