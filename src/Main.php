<?php
/*
 * VolkswAIgen - Adapt your responses when under AI training
 *
 * Copyright (C) 2024 VolkswAIgen-Team
 *
 * This program is free software: you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or (at your option) any later
 * version. This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
 * details.
 *
 * You should have received a copy of the GNU General Public License along with
 * this program. If not, see <http://www.gnu.org/licenses/>.
 */
declare(strict_types=1);

namespace VolkswAIgen\VolkswAIgen;

final class Main
{
	public function __construct(
		private readonly ListFetcher $listFetcher
	) {}

	public function isAiBot(string $userAgent, string $ipAddress): bool
	{
		/** @var array{
		 *     value: string,
		 *     type: 'user-agent'|'ip-address',
		 * }[] $list
		 */
		$list = $this->listFetcher->fetch();
		foreach ($list as $item) {
			$matcher = match ($item['type']) {
				'ip-address' => $ipAddress,
				'user-agent' => $userAgent,
			};
			if (true === preg_match(
					'/' . preg_quote($list['value'], '/') . '/',
					$matcher
				)) {
				return true;
			}
		}

		return false;
	}
}
