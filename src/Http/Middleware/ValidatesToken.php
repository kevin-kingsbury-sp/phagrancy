<?php

/**
 * @file
 * Contains Phagrancy\Http\Middleware\ValidatesToken
 */

namespace Phagrancy\Http\Middleware;

use Phagrancy\Http\Response\NotAuthorized;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Validates that the request is using the proper access_token
 *
 * @package Phagrancy\Http\Middleware
 */
trait ValidatesToken
{
	/**
	 * @var string|null The token used for validation
	 */
	private $token;

	/**
	 * @param Request $request
	 * @return string The token if it exists
	 */
	private function getTokenFromRequest(Request $request)
	{
		$token = $request->getQueryParam('access_token', '');
		if (empty($token) && !empty($token = $request->getHeaderLine('Authorization'))) {
			$tmp   = explode(' ', $token, 2);
			$token = $tmp[1];
		}

		return $token;
	}

	/**
	 * @param Request $request
	 * @return bool True if the token is not set or the access_token query param matches
	 */
	private function validateToken(Request $request)
	{
		if ($this->token === null) {
			return true;
		}

		return $this->getTokenFromRequest($request) === $this->token;
	}
}