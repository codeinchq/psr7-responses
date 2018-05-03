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
use CodeInc\MediaTypes\MediaTypes;
use CodeInc\Psr7Responses\Tests\FileResponseTest;


/**
 * Class FileResponse
 *
 * @see FileResponseTest
 * @package CodeInc\Psr7Responses
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class FileResponse extends StreamResponse
{
	public const DEFAULT_MIME_TYPE = 'application/octet-stream';

    /**
     * FileResponse constructor.
     *
     * @param string $filePath
     * @param null|string $fileName
     * @param null|string $mimeType
     * @param bool $asAttachment
     * @param int $status
     * @param array $headers
     * @param string $version
     * @param null|string $reason
     * @throws ResponseException
     * @throws \CodeInc\MediaTypes\Exceptions\MediaTypesException
     */
	public function __construct(string $filePath, ?string $fileName = null, ?string $mimeType = null,
		bool $asAttachment = true, int $status = 200, array $headers = [],
		string $version = '1.1', ?string $reason = null)
	{
		if (!is_file($filePath)) {
			throw new ResponseException(
				sprintf("The path \"%s\" is not a file or does not exist", $filePath),
				$this
			);
		}
		if (($f = fopen($filePath, "r")) === false) {
			throw new ResponseException(
				sprintf("Unable to open the file \"%s\" for reading", $filePath),
				$this
			);
		}
		if (!$fileName) {
			$fileName = basename($filePath);
		}

		// looking up the mime type using
        if (!$mimeType && $fileName) {
		    $mimeType = MediaTypes::getFilenameMediaType($fileName);
        }

		parent::__construct(
			$f,
			$mimeType ?? self::DEFAULT_MIME_TYPE,
			filesize($filePath) ?: null,
			$fileName ?? basename($filePath),
			$asAttachment,
			$status,
			$headers,
			$version,
			$reason
		);
	}
}