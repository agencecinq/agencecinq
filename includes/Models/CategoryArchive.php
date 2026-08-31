<?php
/**
 * Category Archive Model
 *
 * Custom model for category archive pages.
 *
 * @package WordPress
 * @subpackage AgenceCinq/Models
 */

namespace AgenceCinq\Models;

use Timber\Term;
use AgenceCinq\Traits\ArchivePost;

/**
 * Class CategoryArchive
 *
 * Represents the custom model for the category archive pages.
 * Extends Timber\Term and uses ArchivePost to provide additional functionality for category archives.
 */
class CategoryArchive extends Term {
	use ArchivePost;
}
