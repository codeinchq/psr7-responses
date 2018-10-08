<?php
//
// +---------------------------------------------------------------------+
// | CODE INC. SOURCE CODE                                               |
// +---------------------------------------------------------------------+
// | Copyright (c) 2018 - Code Inc. SAS - All Rights Reserved.           |
// | Visit https://www.codeinc.fr for more information about licensing.  |
// +---------------------------------------------------------------------+
// | NOTICE:  All information contained herein is, and remains the       |
// | property of Code Inc. SAS. The intellectual and technical concepts  |
// | contained herein are proprietary to Code Inc. SAS are protected by  |
// | trade secret or copyright law. Dissemination of this information or |
// | reproduction of this material is strictly forbidden unless prior    |
// | written permission is obtained from Code Inc. SAS.                  |
// +---------------------------------------------------------------------+
//
// Author:   Joan Fabrégat <joan@codeinc.fr>
// Date:     08/10/2018
// Project:  Psr7Responses
//
declare(strict_types=1);
namespace CodeInc\Psr7Responses;


/**
 * Class LocalFileResponse
 *
 * @package CodeInc\Psr7Responses
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class LocalFileResponse extends FileResponse
{
    /**
     * LocalFileResponse constructor.
     *
     * @param string $filePath
     * @param int $code
     * @param string $reasonPhrase
     * @param null|string $fileName
     * @param null|string $contentType
     * @param int|null $contentLength
     * @param bool $asAttachment
     * @param array $headers
     * @param string $version
     * @throws \CodeInc\MediaTypes\Exceptions\MediaTypesException
     */
    public function __construct(string $filePath, int $code = 200, string $reasonPhrase = '',
        ?string $fileName = null, ?string $contentType = null, ?int $contentLength = null,
        bool $asAttachment = true, array $headers = [], string $version = '1.1')
    {
        // opening the local file
        if (!is_file($filePath)) {
            throw new \RuntimeException(
                sprintf("The path \"%s\" is not a file or does not exist", $filePath)
            );
        }
        if (($handler = fopen($filePath, "r")) === false) {
            throw new \RuntimeException(
                sprintf("Unable to open the file \"%s\" for reading", $filePath)
            );
        }

        parent::__construct(
            $fileName ?? basename($filePath),
            $handler,
            $code,
            $reasonPhrase,
            $contentType,
            $contentLength ?? filesize($filePath),
            $asAttachment,
            $headers,
            $version
        );
    }
}