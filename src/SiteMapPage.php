<?php
//
// +---------------------------------------------------------------------+
// | CODE INC. SOURCE CODE - CONFIDENTIAL                                |
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
// Date:     28/11/2017
// Time:     13:16
// Project:  lib-psr7responses
//
namespace CodeInc\Psr7Responses;
use CodeInc\Psr7Responses\XmlResponse;
use CodeInc\UI\Pages\AbstractPage;
use CodeInc\UI\Pages\Exceptions\PageException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


/**
 * Class SiteMapPage
 *
 * @package CodeInc\Psr7Responses
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class SiteMapPage extends AbstractPage {
	const CHANGE_FREQ_DAILY = 'daily';
	const CHANGE_FREQ_WEEKLY = 'weekly';
	const CHANGE_FREQ_MONTHLY = 'monthly';

	/**
	 * @var string
	 */
	protected $charset = "utf-8";

	/**
	 * @var array
	 */
	protected $pages = [];

	/**
	 * @param string $pageRoute
	 * @param float $priority
	 * @param int $lastModTimestamp
	 * @param string|null $changeFreq
	 */
	protected function addPage(string $pageRoute, float $priority, int $lastModTimestamp, string $changeFreq):void
	{
		$this->pages[$pageRoute] = [
			'priority' => $priority,
			'lastModTimestamp' => $lastModTimestamp,
			'changeFreq' => $changeFreq,
		];
	}

	/**
	 * @param string $pageRoute
	 * @param string $lang
	 * @param string $alternateURI
	 * @throws PageException
	 */
	protected function addPageAlternate(string $pageRoute, string $lang, string $alternateURI):void
	{
		if (!array_key_exists($pageRoute, $this->pages)) {
			throw new PageException(
				sprintf("The page %s is not registered, unable to add an alternate",
					$pageRoute), $this
			);
		}
		$this->pages[$pageRoute]['alternates'][$lang] = $alternateURI;
	}

	/**
	 * @inheritdoc
	 * @return XmlResponse
	 */
	public function handle(ServerRequestInterface $request):ResponseInterface
	{
		$content = '<?xml version="1.0" encoding="UTF-8"?>'."\n"
			.'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" '
			.'xmlns:xhtml="http://www.w3.org/1999/xhtml">'."\n";
		foreach ($this->pages as $URI => $infos) {
			$content .= "\t<url>\n"
				."\t\t<loc>".htmlspecialchars($URI)."</loc>\n"
				."\t\t<lastmod>".date('Y-m-d', $infos['lastModTimestamp'])."</lastmod>\n"
				."\t\t<changefreq>".$infos['changeFreq']."</changefreq>\n"
				."\t\t<priority>".$infos['priority']."</priority>\n";
			if (is_array($infos['alternates']) && $infos['alternates']) {
				foreach ($infos['alternates'] as $lang => $URI) {
					$content .= "\t\t".'<xhtml:link rel="alternate" hreflang="'.$lang.'" '
						.'href="'.htmlspecialchars($URI).'" />'."\n";
				}
			}
			$content .= "\t</url>\n";
		}
		$content .= "</urlset>\n";

		return new XmlResponse($content, $this->charset);
	}
}