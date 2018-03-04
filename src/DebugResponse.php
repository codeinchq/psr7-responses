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
// Date:     04/03/2018
// Time:     11:55
// Project:  lib-psr7responses
//
declare(strict_types = 1);
namespace CodeInc\Psr7Responses;


/**
 * Class DebugResponse
 *
 * @package CodeInc\Psr7Responses
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class DebugResponse extends HtmlResponse {
	/**
	 * DebugResponse constructor.
	 *
	 * @param $debugInfos
	 * @param null|string $charset
	 * @param int $status
	 * @param array $headers
	 * @param string $version
	 * @param null|string $reason
	 */
	public function __construct($debugInfos, ?string $charset = null, int $status = 200, array $headers = [], string $version = '1.1', ?string $reason = null)
	{
		ob_start();
		var_dump($debugInfos);
		parent::__construct(ob_get_clean(), $charset, $status, $headers, $version, $reason);
	}
}