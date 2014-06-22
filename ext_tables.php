<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}
/** @var string $_EXTKEY The current Extension key. */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Link type switch (after css_styled_content!)');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/LoginRedirect', 'Redirect on 403');