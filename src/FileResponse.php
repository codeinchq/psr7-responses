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
     * @var string
     */
	private $filePath;

    /**
     * @var string
     */
	private $fileName;

    /**
     * FileResponse constructor.
     *
     * @param string|StreamInterface $file Path to the file or stream of its content
     * @param null|string $fileName
     * @param null|string $contentType
     * @param bool $asAttachment
     * @param int $status
     * @param array $headers
     * @param string $version
     * @param null|string $reason
     * @throws ResponseException
     * @throws \CodeInc\MediaTypes\Exceptions\MediaTypesException
     */
	public function __construct($file, ?string $fileName = null, ?string $contentType = null,
		bool $asAttachment = true, int $status = 200, array $headers = [],
		string $version = '1.1', ?string $reason = null)
	{
        if (!$file instanceof StreamInterface) {
            if (!is_file($file)) {
                throw new ResponseException(
                    sprintf("The path \"%s\" is not a file or does not exist", $file),
                    $this
                );
            }
            if (($f = fopen($file, "r")) === false) {
                throw new ResponseException(
                    sprintf("Unable to open the file \"%s\" for reading", $file),
                    $this
                );
            }
            $file = $f;
        }
		if (!$fileName) {
			$fileName = basename($file);
		}

		// looking up the mime type using
        if (!$contentType && $fileName) {
		    $contentType = MediaTypes::getFilenameMediaType($fileName);
        }

        $this->fileName = $fileName;
		$this->filePath = $file;

		parent::__construct(
			$file,
			$contentType ?? self::DEFAULT_MIME_TYPE,
			filesize($file) ?: null,
			$fileName ?? basename($file),
			$asAttachment,
			$status,
			$headers,
			$version,
			$reason
		);
	}

    /**
     * Returns the file name.
     *
     * @return string
     */
    public function getFileName():string
    {
        return $this->fileName;
    }

    /**
     * Returns the file path.
     *
     * @return string
     */
    public function getFilePath():string
    {
        return $this->filePath;
    }
}