<?php
/**
 * Front Page Model
 *
 * @package AgenceCinq
 * @subpackage AgenceCinq/Models
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Models;

use AgenceCinq\GitHub\Repositories;
use Timber\{ Post };

/**
 * Class FrontPage
 *
 * @package AgenceCinq\Models
 */
class FrontPage extends Post {

	/**
	 * Returns the latest GitHub repositories for the homepage hero.
	 *
	 * @return array<int, array<string, mixed>>
	 */
	public function repositories(): array {
		return Repositories::all();
	}
}
