.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _introduction:

Introduction
============


.. _what-it-does:

What does it do?
----------------

This Extension provides a user function that determines the link type.

Currently it can **only be used inside a parseFunc** call.

These link types are currently detected:

============================= ======================================================
Link type                     Description
============================= ======================================================
External                      Non page link (can also be email, file etc.)
PageNonExisting               Link to a page that does not exist
PageRestrictedAccessDenied    Link to a page, user is logged in and has no access
PageRestrictedAccessGranted   Link to a page, user is logged in and has acces.
PageRestrictedAccessUndecided Link to an access restricted page, no user logged in
PageUnrestricted              Link to a page with no access restrictions
============================= ======================================================

See also :php:`Tx\Linktypeswitch\Domain\Model\Enumeration\LinkType`.

.. _screenshots:

Screenshots
-----------

You can use the Extension to highlight links that point to access restricted pages.
It comes with examle styles that use some
`famfamfam silk <http://www.famfamfam.com/lab/icons/silk/>`_ icons:

.. figure:: ../Images/ScreenshotFrontendExample.png
   :width: 358px
   :alt: Frontend output example

The screenshot shows the example styles for two link types that are available if a user is logged in:

- link to a page to which the current user has no access
- link to a page to which the current user has access
