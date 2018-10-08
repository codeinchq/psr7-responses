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
use CodeInc\Psr7Responses\Tests\LocalFileResponseTest;


/**
 * Class LocalFileResponse
 *
 * @see LocalFileResponseTest
 * @package CodeInc\Psr7Responses
 * @author Joan Fabrégat <joan@codeinc.fr>
 * @license MIT <https://github.com/CodeIncHQ/Psr7Responses/blob/master/LICENSE>
 * @link https://github.com/CodeIncHQ/Psr7Responses
 * @version 2
 */
class LocalFileResponse extends FileResponse
{
    /**
     * LocalFileResponse constructor.
     *
     * @param string $filePath Local file path
     * @param int $code
     * @param string $reasonPhrase
     * @param null|string $fileName File's name (determined from the local file path if not specified)
     * @param null|string $contentType File's content type (determined from the file's name if not specified)
     * @param bool $asAttachment Defines if the file should be sent as an attachment
     * @param array $headers
     * @param string $version
     * @throws \CodeInc\MediaTypes\Exceptions\MediaTypesException
     */
	public function __construct(string $filePath,  int $code = 200, string $reasonPhrase = '',
        ?string $fileName = null, ?string $contentType = null, bool $asAttachment = true,
        array $headers = [], string $version = '1.1')
	{
		parent::__construct(
			$filePath,
			$fileName ?? basename($filePath),
            $code,
            $reasonPhrase,
			$contentType,
			$asAttachment,
            $headers,
            $version
		);
	}
}