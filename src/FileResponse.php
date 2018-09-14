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
use Psr\Http\Message\StreamInterface;


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
     * @param StreamInterface $fileStream
     * @param null|string $fileName
     * @param null|string $contentType
     * @param bool $asAttachment
     * @param int $status
     * @param array $headers
     * @param string $version
     * @param null|string $reason
     * @throws \CodeInc\MediaTypes\Exceptions\MediaTypesException
     */
	public function __construct(StreamInterface $fileStream, string $fileName, ?string $contentType = null,
		bool $asAttachment = true, int $status = 200, array $headers = [],
		string $version = '1.1', ?string $reason = null)
	{
		parent::__construct(
			$fileStream,
			$contentType ?? MediaTypes::getFilenameMediaType($fileName, self::DEFAULT_MIME_TYPE),
			null,
			$fileName,
			$asAttachment,
			$status,
			$headers,
			$version,
			$reason
		);
	}
}