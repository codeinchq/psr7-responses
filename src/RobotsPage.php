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
// Time:     13:13
// Project:  lib-psr7responses
//
namespace CodeInc\Psr7Responses;


/**
 * Class RobotsPage
 *
 * @package CodeInc\Psr7Responses
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class RobotsPage extends AbstractPage {
	/**
	 * @var array
	 */
	protected $siteMaps = [];

	/**
	 * @var array
	 */
	protected $rules = [];

	/**
	 * @var string
	 */
	protected $charset = 'utf-8';

	/**
	 * @param string $siteMap
	 * @return bool
	 */
	protected function addSiteMap(string $siteMap):bool
	{
		if (!in_array($siteMap, $this->siteMaps)) {
			$this->siteMaps[] = $siteMap;
			return true;
		}
		return false;
	}

	/**
	 * @param string $allow
	 * @param string|null $userAgent
	 */
	protected function addAllowRule(string $allow, string $userAgent = null):void
	{
		$this->addRule('Allow', $allow, $userAgent);
	}

	/**
	 * @param string $allow
	 * @param string|null $userAgent
	 */
	protected function addDisallowRule(string $allow, string $userAgent = null):void
	{
		$this->addRule('Disallow', $allow, $userAgent);
	}

	/**
	 * @param string $type
	 * @param string $value
	 * @param string|null $userAgent
	 */
	protected function addRule(string $type, string $value, string $userAgent = null):void
	{
		$this->rules[$userAgent ?? '*'][$type][] = $value;
	}

	/**
	 * @inheritdoc
	 * @return TextResponse
	 */
	public function handle(ServerRequestInterface $request):ResponseInterface
	{
		$content = "";

		foreach ($this->rules as $userAgent => $rules) {
			$content .= "User-agent: $userAgent\n";
			foreach ($rules as $type => $value) {
				$content .= "$type: $value\n";
			}
		}
		foreach ($this->siteMaps as $siteMap) {
			$content .= "Sitemap: ".$siteMap."\n";
		}

		return new TextResponse($content, $this->charset);
	}
}