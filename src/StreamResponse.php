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
// Time:     19:15
// Project:  Psr7Responses
//
declare(strict_types = 1);
namespace CodeInc\Psr7Responses;
use GuzzleHttp\Psr7\Response;
use function GuzzleHttp\Psr7\stream_for;


/**
 * Class StreamResponse
 *
 * @package CodeInc\Psr7Responses
 * @author Joan Fabrégat <joan@codeinc.fr>
 * @license MIT <https://github.com/CodeIncHQ/Psr7Responses/blob/master/LICENSE>
 * @link https://github.com/CodeIncHQ/Psr7Responses
 */
class StreamResponse extends Response
{
	/**
	 * StreamResponse constructor.
	 *
	 * @param $resource
	 * @param null|string $mimeType
	 * @param int|null $contentLength
	 * @param null|string $fileName
	 * @param bool $asAttachment
	 * @param int $status
	 * @param array $headers
	 * @param string $version
	 * @param null|string $reason
	 */
	public function __construct($resource, ?string $mimeType = null, ?int $contentLength = null,
		?string $fileName = null, bool $asAttachment = false, int $status = 200, array $headers = [],
		string $version = '1.1', ?string $reason = null)
	{
		$stream = stream_for($resource);

		// adding headers
		if ($mimeType) {
			$headers["Content-Type"] = $mimeType;
		}
		$headers["Content-Disposition"] = $asAttachment ? "attachment" : "inline";
		if ($fileName) {
			$headers["Content-Disposition"] .= sprintf("; filename=\"%s\"", $fileName);
		}
		if ($contentLength !== null || ($contentLength = $stream->getSize()) !== null) {
			$headers["Content-Length"] = $contentLength;
		}

		parent::__construct($status, $headers, $stream, $version, $reason);
	}
}