.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _configuration:

Configuration
=============

The Extension comes with an examle TypoScript setup that shows the basic
concept how it can be used.

.. _configuration-typoscript:

TypoScript
----------

To use the link type detection feature of this extension call the
:php:`LinkTypeDetector->detectLinkType` in a :typoscript:`USER` object in you TypoScript
code:

::

  	myObject = USER
  	myObject.userFunc = Tx\Linktypeswitch\LinkTypeDetector->detectLinkType

You can replace the basic linking in the default parseFunc of ``css_styled_content``
and handle each link type individually:

::

  	lib.parseFunc_RTE.tags.link >
  	lib.parseFunc_RTE.tags.link = CASE
  	lib.parseFunc_RTE.tags.link {

  	  	// Normal links are generated as default typolink and wrappedn in a <span>
  	  	External = TEXT
  	  	External.current = 1
  	  	External.typolink.parameter.data = parameters : allParams
  	  	External.wrap = <span class="tx-linktypeswitch-link-external">|</span>

  	  	// Non existing pages are not linked at all and only the link text is rendered
  	  	PageNonExisting = TEXT
  	  	PageNonExisting.current = 1

  	  	// The link type will be used as key
  	  	key.cObject = USER
  	  	key.cObject.userFunc = Tx\Linktypeswitch\LinkTypeDetector->detectLinkType
  	}

A full example configuration can be found in ``Configuration/TypoScript/setup.txt``.