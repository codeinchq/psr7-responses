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
class JsonResponse extends Response
{
    public const DEFAULT_HEADERS = [
        'Content-Type' => 'application/json; charset=utf-8'
    ];

    /**
     * @var string
     */
	private $json;

    /**
     * JsonResponse constructor.
     *
     * @param string $json
     * @param int $code
     * @param string $reasonPhrase
     * @param array $headers
     * @param string $version
     */
	public function __construct(string $json, int $code = 200, string $reasonPhrase = '',
        array $headers = self::DEFAULT_HEADERS, string $version = '1.1')
	{
		$this->json = $json;
		parent::__construct($code, $headers, $json, $version, $reasonPhrase);
	}

    /**
     * @param array $array
     * @param int $code
     * @param string $reasonPhrase
     * @param array $headers
     * @param string $version
     * @return JsonResponse
     */
    public static function fromArray(array $array, int $code = 200, string $reasonPhrase = '',
        array $headers = self::DEFAULT_HEADERS, string $version = '1.1'):self
    {
        if (($json = json_encode($array)) === false) {
            throw new \RuntimeException("Error while encoding the array to JSON using json_encode().");
        }
        return new self($json, $code, $reasonPhrase, $headers, $version);
    }

    /**
     * @param object $object
     * @param int $code
     * @param string $reasonPhrase
     * @param array $headers
     * @param string $version
     * @return JsonResponse
     */
    public static function fromObject(object $object, int $code = 200, string $reasonPhrase = '',
        array $headers = self::DEFAULT_HEADERS, string $version = '1.1'):self
    {
        if (($json = json_encode($object)) === false) {
            throw new \RuntimeException("Error while encoding the object to JSON using json_encode().");
        }
        return new self($json, $code, $reasonPhrase, $headers, $version);
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
     */
    public function getDecodedJson():array
    {
        if (!($array = json_decode($this->json, true))) {
            throw new \RuntimeException("Unable to decode the response's JSON");
        }
        return json_decode($this->json, true);
    }
}