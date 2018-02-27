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
// Project:  lib-psr7responses
//
declare(strict_types = 1);
namespace CodeInc\Psr7Responses;
use CodeInc\ErrorDisplay\HtmlErrorRenderer;


/**
 * Class ErrorResponse
 *
 * @package CodeInc\Psr7Responses
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class ErrorResponse extends HtmlResponse {
	/**
	 * ErrorResponse constructor.
	 *
	 * @param \Throwable $throwable
	 * @param null|string $charset
	 * @param int $status
	 * @param array $headers
	 * @param string $version
	 * @param null|string $reason
	 */
	public function __construct(\Throwable $throwable, ?string $charset = null, int $status = 200,
		array $headers = [], string $version = '1.1', ?string $reason = null)
	{
		parent::__construct((new HtmlErrorRenderer($throwable))->get(),
			$charset, $status, $headers, $version, $reason);
	}
}