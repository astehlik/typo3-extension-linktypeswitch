<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

// We register our own error handlers but only if the current
// request is not made by the solr indexer.
if (
	TYPO3_MODE === 'FE'
	&& \Tx\Linktypeswitch\Utility\ConfigurationUtility::getInstance()->getRegisterErrorHandlers()
) {

	if (!isset($_SERVER['HTTP_X_TX_SOLR_IQ'])) {

		// Make sure the required configuration for 403 errors is available but do not override it when it was set.
		if (!isset($GLOBALS['TYPO3_CONF_VARS']['FE']['pageForbidden_handling_statheader'])) {
			$GLOBALS['TYPO3_CONF_VARS']['FE']['pageForbidden_handling_statheader'] = 'HTTP/1.0 403 Forbidden';
		}
		if (!isset($GLOBALS['TYPO3_CONF_VARS']['FE']['pageForbidden_handling'])) {
			$GLOBALS['TYPO3_CONF_VARS']['FE']['pageForbidden_handling'] = '';
		}

		$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Core\\Messaging\\ErrorpageMessage']['className'] = 'Tx\\Linktypeswitch\\Frontend\\StyledErrorpageMessage';

		// Backup the current handler configuration (see AdditionalConfiguration.php for pageForbidden_handling)
		$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['linktypeswitch']['pageNotFound_handling'] = $GLOBALS['TYPO3_CONF_VARS']['FE']['pageNotFound_handling'];
		$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['linktypeswitch']['pageUnavailable_handling'] = $GLOBALS['TYPO3_CONF_VARS']['FE']['pageUnavailable_handling'];
		$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['linktypeswitch']['pageForbidden_handling'] = $GLOBALS['TYPO3_CONF_VARS']['FE']['pageForbidden_handling'];

		// Overwrite the handlers with the linktypeswitch handlers.
		$GLOBALS['TYPO3_CONF_VARS']['FE']['pageNotFound_handling'] = 'USER_FUNCTION:Tx\\Linktypeswitch\\Frontend\\FrontendErrorHandler->handlePageNotFoundError';
		$GLOBALS['TYPO3_CONF_VARS']['FE']['pageUnavailable_handling'] = 'USER_FUNCTION:Tx\\Linktypeswitch\\Frontend\\FrontendErrorHandler->handlePageUnavailableError';
		$GLOBALS['TYPO3_CONF_VARS']['FE']['pageForbidden_handling'] = 'USER_FUNCTION:Tx\\Linktypeswitch\\Frontend\\FrontendErrorHandler->handlePageForbiddenError';

	} else {
		// For the solr indexer we need the defalut page not found handling.
		$GLOBALS['TYPO3_CONF_VARS']['FE']['pageNotFound_handling'] = '';
	}
}