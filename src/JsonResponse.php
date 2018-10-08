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
// Time:     17:52
// Project:  Psr7Responses
//
declare(strict_types = 1);
namespace CodeInc\Psr7Responses;
use GuzzleHttp\Psr7\Response;


/**
 * Class JsonResponse
 *
 * @package CodeInc\Psr7Responses
 * @author Joan Fabrégat <joan@codeinc.fr>
 * @license MIT <https://github.com/CodeIncHQ/Psr7Responses/blob/master/LICENSE>
 * @link https://github.com/CodeIncHQ/Psr7Responses
 * @version 2
 */
class JsonResponse extends Response implements CharsetResponseInterface
{
    /**
     * @var string
     */
	private $json;

    /**
     * @var string
     */
	private $charset;

    /**
     * TextResponse constructor.
     *
     * @param string $json
     * @param int $code
     * @param string $reasonPhrase
     * @param string $charset
     * @param array $headers
     * @param string $version
     */
	public function __construct(string $json, int $code = 200, string $reasonPhrase = '',
        string $charset = 'utf-8', array $headers = [], string $version = '1.1')
	{
		$this->json = $json;
		$this->charset = $charset;
		$headers['Content-Type'] = sprintf('application/json; charset=%s', $charset);
		parent::__construct($code, $headers, $json, $version, $reasonPhrase);
	}

    /**
     * Returns the raw JSON string
     *
     * @return string
     */
    public function getJson():string
    {
        return $this->json;
    }

    /**
     * Returns the decoded JSON string.
     *
     * @uses json_decode()
     * @return array
     * @throws ResponseException
     */
    public function getDecodedJson():array
    {
        if (!($array = json_decode($this->json, true))) {
            throw new ResponseException("Unable to decode the response's JSON", $this);
        }
        return json_decode($this->json, true);
    }

    /**
     * @inheritdoc
     * @return string
     */
    public function getCharset():string
    {
        return $this->charset;
    }


}