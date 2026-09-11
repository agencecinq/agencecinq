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
	 * Returns GitHub repositories for the homepage hero (sorted by last push).
	 *
	 * @return array<int, array<string, mixed>>
	 */
	public function repositories(): array {
		return Repositories::all();
	}
}
