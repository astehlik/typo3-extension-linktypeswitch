<?php
namespace Tx\Linktypeswitch\Domain\Model\Enumeration;

/*                                                                        *
 * This script belongs to the TYPO3 Extension "linktypeswitch".           *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License, either version 3 of the   *
 * License, or (at your option) any later version.                        *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use TYPO3\CMS\Core\Type\Enumeration;

/**
 * The different link types detected by the link type detector.
 */
class LinkType extends Enumeration {

	/**
	 * The link is not a link to a page (e.g. an external URL a an e-mail address).
	 *
	 * @const
	 */
	const EXTERNAL = 'External';

	/**
	 * The link is a page link that points to a non existing page.
	 *
	 * @const
	 */
	const PAGE_NON_EXISTING = 'PageNonExisting';

	/**
	 * The link is a page link that points to a page with access restrictions
	 * and the current user has no access.
	 *
	 * @const
	 */
	const PAGE_RESTRICTED_ACCESS_DENIED = 'PageRestrictedAccessDenied';

	/**
	 * The link is a page link that points to a page with access restrictions
	 * and the current use has access.
	 *
	 * @const
	 */
	const PAGE_RESTRICTED_ACCESS_GRANTED = 'PageRestrictedAccessGranted';

	/**
	 * The link is a page link that points to a page with access restrictions
	 * and no user is logged in so we do not know if he has access.
	 */
	const PAGE_RESTRICTED_ACCESS_UNDECIDED = 'PageRestrictedAccessUndecided';

	/**
	 * The link is a page link that points to a page with no access restrictions.
	 *
	 * @const
	 */
	const PAGE_UNRESTRICTED = 'PageUnrestricted';
} 