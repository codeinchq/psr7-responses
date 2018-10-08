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
 * Class TextResponse
 *
 * @package CodeInc\Psr7Responses
 * @author Joan Fabrégat <joan@codeinc.fr>
 * @license MIT <https://github.com/CodeIncHQ/Psr7Responses/blob/master/LICENSE>
 * @link https://github.com/CodeIncHQ/Psr7Responses
 * @version 2
 */
class TextResponse extends Response implements CharsetResponseInterface
{
    /**
     * @var string
     */
	private $text;

    /**
     * @var string
     */
	private $charset;

    /**
     * TextResponse constructor.
     *
     * @param string $text
     * @param int $code
     * @param string $reasonPhrase
     * @param string $charset
     * @param array $headers
     * @param string $version
     */
	public function __construct(string $text, int $code = 200, string $reasonPhrase = '',
        string $charset = 'utf-8', array $headers = [], string $version = '1.1')
	{
	    $this->charset = $charset;
		$headers['Content-Type'] = sprintf('text/plain; charset=%s', $charset);
		parent::__construct($code, $headers, $text, $version, $reasonPhrase);
	}

    /**
     * @return string
     */
    public function getText():string
    {
        return $this->text;
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