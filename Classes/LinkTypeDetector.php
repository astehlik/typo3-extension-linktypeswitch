<?php
namespace Tx\Linktypeswitch;

/*                                                                        *
 * This script belongs to the TYPO3 Extension "linktypeswitch".           *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License, either version 3 of the   *
 * License, or (at your option) any later version.                        *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use Tx\Linktypeswitch\Domain\Model\Enumeration\LinkType;

/**
 * This class contains the detectLinkType() method that can be used in a
 * USER content object inside a parseFunc call.
 */
class LinkTypeDetector extends \TYPO3\CMS\Frontend\Plugin\AbstractPlugin {

	/**
	 * This group UID is used to grant any logged in user access.
	 *
	 * @const
	 */
	const GROUP_UID_ANY_USER = -2;

	/**
	 * This array will be filled by the pageHasAccessRestriction() method with
	 * the groups that are allowed to access the current page.
	 *
	 * @var array
	 */
	protected $requiredGroups;

	/**
	 * This method can be called as a user function inside a parseFunc run when the
	 * parameters['allParams'] array is filled (usually for the "link" tags).
	 *
	 * @param string $content
	 * @param array $config
	 * @return string The detected link type (see LinkType enumeration).
	 * @see Tx\Linktypeswitch\Domain\Model\Enumeration\LinkType
	 * @see \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer::_parseFunc()
	 */
	public function detectLinkType(
		/** @noinspection PhpUnusedParameterInspection */
		$content, $config
	) {
		$pageUid = $this->cObj->parameters['allParams'];
		if ($pageUid < 1) {
			return LinkType::EXTERNAL;
		}

		$frontendController = $this->getTypoScriptFrontendController();
		$page = $frontendController->sys_page->getPage($pageUid, TRUE);
		if (empty($page)) {
			return LinkType::PAGE_NON_EXISTING;
		}

		if (!$this->pageHasAccessRestriction($page)) {
			return LinkType::PAGE_UNRESTRICTED;
		}

		$userLoggedIn = FALSE;
		if (is_object($frontendController->fe_user) && $frontendController->fe_user->user['uid'] > 0) {
			$userLoggedIn = TRUE;
		}

		if (!$userLoggedIn) {
			return LinkType::PAGE_RESTRICTED_ACCESS_UNDECIDED;
		}

		if ($this->userIsMemberInAtLeastOneRequiredGroup($frontendController->fe_user)) {
			return LinkType::PAGE_RESTRICTED_ACCESS_GRANTED;
		} else {
			return LinkType::PAGE_RESTRICTED_ACCESS_DENIED;
		}
	}

	/**
	 * @return \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController
	 */
	protected function getTypoScriptFrontendController() {
		return $GLOBALS['TSFE'];
	}

	/**
	 * Checks if the given page has access restrictions and fills the requiredGroups
	 * class property with a comma seperated list of groups that are allowed to access
	 * this page.
	 *
	 * This method will also check if a parent page has any access restrictions up in
	 * the rootline.
	 *
	 * @param array $page The page record.
	 * @return bool TRUE if the given page is access restrictec.
	 */
	protected function pageHasAccessRestriction(array $page) {

		if ($this->pageHasAccessRestrictionSingle($page)) {
			$this->requiredGroups = $page['fe_group'];
			return TRUE;
		}

		$frontendController = $this->getTypoScriptFrontendController();
		$rootLine = $frontendController->sys_page->getRootLine($page['pid']);
		foreach ($rootLine as $rootLinePage) {
			if ($this->pageHasAccessRestrictionSingle($rootLinePage, TRUE)) {
				$this->requiredGroups = $rootLinePage['fe_group'];
				return TRUE;
			}
		}

		return FALSE;
	}

	/**
	 * Checks if the given page has access restrictions.
	 *
	 * If $upInRootline is TRUE the extendToSubpages property needs to be set to
	 * TRUE so that any access restriction is taken into account.
	 *
	 * @param array $page The page record as associative array.
	 * @param bool $upInRootline If TRUE the given page is not the one that should be
	 * accessed but is up in the rootline of the accessed page and extendToSubpages
	 * needs to be TRUE so that any access restrictions are respected.
	 * @return bool
	 */
	protected function pageHasAccessRestrictionSingle(array $page, $upInRootline = FALSE) {

		if ($upInRootline && !$page['extendToSubpages']) {
			return FALSE;
		}

		$groups = $page['fe_group'];
		$groups = \TYPO3\CMS\Core\Utility\GeneralUtility::intExplode(',', $groups, TRUE);
		foreach ($groups as $groupUid) {
			if ($groupUid > 0 || $groupUid === -2) {
				return TRUE;
			}
		}

		return FALSE;
	}

	/**
	 * Returns TRUE if the given user is member in at least one of the groups stored in
	 * the requiredGroups class property.
	 *
	 * @param \TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication $user
	 * @return bool
	 */
	protected function userIsMemberInAtLeastOneRequiredGroup($user) {
		$requiredGroups = \TYPO3\CMS\Core\Utility\GeneralUtility::intExplode(',', $this->requiredGroups, TRUE);
		foreach ($requiredGroups as $requiredGroupUid) {
			if ($requiredGroupUid === self::GROUP_UID_ANY_USER) {
				return TRUE;
			}
			if (isset($user->groupData['uid'][$requiredGroupUid])) {
				return TRUE;
			}
		}
		return FALSE;
	}
}
