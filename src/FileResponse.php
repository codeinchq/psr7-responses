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
use function GuzzleHttp\Psr7\stream_for;
use Psr\Http\Message\StreamInterface;


/**
 * Class FileResponse
 *
 * @see FileResponseTest
 * @package CodeInc\Psr7Responses
 * @author Joan Fabrégat <joan@codeinc.fr>
 * @license MIT <https://github.com/CodeIncHQ/Psr7Responses/blob/master/LICENSE>
 * @link https://github.com/CodeIncHQ/Psr7Responses
 * @version 2
 */
class FileResponse extends StreamResponse
{
    /**
     * FileResponse constructor.
     *
     * @param string|resource|StreamInterface $file
     * @param string $fileName
     * @param int $code
     * @param string $reasonPhrase
     * @param null|string $contentType
     * @param bool $asAttachment
     * @param array $headers
     * @param string $version
     * @throws \CodeInc\MediaTypes\Exceptions\MediaTypesException
     */
	public function __construct($file, string $fileName, int $code = 200, string $reasonPhrase = '',
        ?string $contentType = null, bool $asAttachment = true, array $headers = [], string $version = '1.1')
	{
	    if (is_string($file)) {
            if (!is_file($file)) {
                throw new ResponseException(
                    sprintf("The path \"%s\" is not a file or does not exist", $file),
                    $this
                );
            }
            if (($handler = fopen($file, "r")) === false) {
                throw new ResponseException(
                    sprintf("Unable to open the file \"%s\" for reading", $file),
                    $this
                );
            }
            $stream = stream_for($handler);
        }
        else {
            $stream = stream_for($file);
        }

		parent::__construct(
			$stream,
			$code,
			$reasonPhrase,
			$contentType ?? MediaTypes::getFilenameMediaType($fileName, 'application/octet-stream'),
			null,
			$fileName,
			$asAttachment,
			$headers,
			$version
		);
	}
}