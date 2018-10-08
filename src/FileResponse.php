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
use CodeInc\MediaTypes\MediaTypes;
use function GuzzleHttp\Psr7\stream_for;


/**
 * Class FileResponse
 *
 * @package CodeInc\Psr7Responses
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class FileResponse extends StreamResponse
{
    /**
     * FileResponse constructor.
     *
     * @param string $fileName
     * @param $data
     * @param int $code
     * @param string $reasonPhrase
     * @param null|string $contentType
     * @param int|null $contentLength
     * @param bool $asAttachment
     * @param array $headers
     * @param string $version
     * @throws \CodeInc\MediaTypes\Exceptions\MediaTypesException
     */
    public function __construct(string $fileName, $data, int $code = 200, string $reasonPhrase = '',
        ?string $contentType = null, ?int $contentLength = null, bool $asAttachment = true,
        array $headers = [], string $version = '1.1')
    {
        $stream = stream_for($data);

        // adding headers
        if (!isset($headers['Content-Type']) && $contentType) {
            $headers['Content-Type'] = $contentType
                ?? MediaTypes::getFilenameMediaType($fileName)
                ?? 'application/octet-stream';
        }
        if (!isset($headers['Content-Disposition'])) {
            $headers['Content-Disposition'] = sprintf('%s; filename="%s"',
                ($asAttachment ? 'attachment' : 'inline'), $fileName);
        }
        if (!isset($headers['Content-Length']) && ($contentLength !== null || ($contentLength = $stream->getSize()) !== null)) {
            $headers['Content-Length'] = $contentLength;
        }

        parent::__construct($stream, $code, $reasonPhrase, $headers, $version);
    }
}