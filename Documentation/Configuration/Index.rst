.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _configuration:

Configuration
=============

The Extension comes with some examle TypoScript setup that shows the basic
concepts and how it can be used.

There are two different example configurations:

`Link type switch` is the examle configuration for modifying lib.parseFunc
to enable highlighting of links to protected pages. It must be included
**after** `css_styled_content`!

`Redirect on 403` is the configuration for the redirect handler that
will redirect the user to the login page when he tries to access a
protected page and is not logged in.


.. _configuration-typoscript:

TypoScript
----------

The following section describes the different TypoScript configurations
in more detail.


.. _configuration-typoscript-linktypeswitch:

Link type switch
~~~~~~~~~~~~~~~~

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


.. _configuration-typoscript-redirecton403:

Redirect on 403
~~~~~~~~~~~~~~~

Include this file to enable redirection when the user is not logged in
and accesses a protected page. Please make sure that you set the required
values in the `PLUGIN.TX_LINKTYPESWITCH` section in the constant editor.

With this default configuration the original URL will be appended in the
`redirect_url` GET parameter. This will work with the `felogin` core
Extension.

When you want to configure the URL manually you need to configure a
TypoScript content object in the `config` section:

::

    config.tx_linktypeswitch.loginPageUrl

For example to redirect the user to a static URL the configuration could
look like this:

::

    config.tx_linktypeswitch.loginPageUrl = TEXT
    config.tx_linktypeswitch.loginPageUrl.typolink {
        parameter = 123
        returnLast = url
        forceAbsoluteUrl = 1
    }
