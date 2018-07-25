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
// Time:     22:13
// Project:  Psr7Responses
//
declare(strict_types = 1);
namespace CodeInc\Psr7Responses;
use CodeInc\ErrorRenderer\HtmlErrorRenderer;
use CodeInc\Psr7Responses\Tests\ErrorResponseTest;


/**
 * Class ErrorResponse
 *
 * @uses ErrorResponseTest
 * @package CodeInc\Psr7Responses
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class ErrorResponse extends HtmlResponse
{
    /**
     * @var \Throwable
     */
    private $error;

	/**
	 * ErrorResponse constructor.
	 *
	 * @param \Throwable $error
	 * @param null|string $charset
	 * @param int $status
	 * @param array $headers
	 * @param string $version
	 * @param null|string $reason
	 */
	public function __construct(\Throwable $error, ?string $charset = null,
        int $status = 500, array $headers = [], string $version = '1.1',
        ?string $reason = null)
	{
	    $this->error = $error;
		parent::__construct((new HtmlErrorRenderer($error))->get(),
			$charset, $status, $headers, $version, $reason);
	}

    /**
     * Returns the error (\Exception or \Throwable).
     *
     * @return \Throwable|\Exception
     */
    public function getError():\Throwable
    {
        return $this->error;
    }
}