.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _admin-manual:

Administrator Manual
====================

This chapter describes the intallation and a possible usage scenario.


.. _admin-installation:

Installation
------------

To install the Extension simply use the Extension manager in the Backend.

You can *optionally* include the static template that provides some examle
configuration. You must include the sample template **after**
css_styled_content.

You can also *optionally* enable the custom error handlers the Extension
provides in the Extension configuration

.. _admin-configuration:

Configuration
-------------

Custom error handlers
~~~~~~~~~~~~~~~~~~~~~

When you want to use the custom errors handlers the first step you need
to do is enable the `registerErrorHandlers` setting in the Extension
configuration in the Extension Manager.

Then custom error handlers are registered for the Frontend that will
improve the detection of 404 (Not found) and 403 (Forbidden) errors.

You can still configure your error handlers in the install tool for
400 and 503 errors like before.

Until 403 errors are imlemented in the core you need to configure the
in `AdditionalConfiguration.php` by hand:

::

    $GLOBALS['TYPO3_CONF_VARS']['FE']['pageForbidden_handling_statheader'] = 'HTTP/1.0 403 My custom header';
    $GLOBALS['TYPO3_CONF_VARS']['FE']['pageForbidden_handling'] = 'READFILE:fileadmin/my-custom-403-error-doc.html';

Custom error page template
~~~~~~~~~~~~~~~~~~~~~~~~~~

If you want to use a custom template for the TYPO3 Exception handler
you need to set the `errorPageTemplate` to a relative path to the
template you want to use. Available template markers are:

* `###CSS_CLASS###`: a CSS class depending on the severity of the error,
  can be:
  * `notice`
  * `information`
  * `ok`
  * `warning`
  * `error`
* `###TITLE###`: the title of the error
* `###BASEURL###`: Absolute URL to PATH_site
* `###TYPO3_mainDir###`: Relative path to typo3/
* `###MESSAGE###`:the error message
* `###TYPO3_copyright_year###` Value of the TYPO3_copyright_year constant

You can also have a look in
`sysext/t3skin/templates/errorpage-message.html` to see what is used there.