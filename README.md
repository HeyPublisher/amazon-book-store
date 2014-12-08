##Amazon Book Store
    Contributors     : Loudlever, Inc.
    Donate link      : https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=Y8SL68GN5J2PL
    Tags             : affiliate sales, Amazon, ASIN, Amazon Associate, monetize
    Requires at least: 2.8
    Tested up to     : 4.0.1
    Stable tag       : 1.1.1

Randomly display one or more Amazon products in the sidebar; products are selected from POST-specific pools, or from a 'default' pool that you define.

###Description

The Amazon Book Store (formerly 'Support Great Writers') Widget provides a very simple way to sell Amazon products via a sidebar widget on your blog, magazine, or other WordPress-powered website.  The widget can be instantiated multiple times, with different products being displayed in each instance.  

You can sell specific products on specific pages of your website, or define a 'pool' of products from which the widget will randomly chose from.  This allows you to quickly build up an Amazon store of products that are related to your individual POSTs.  

###About Us

Developed by the fine folks at [Loudlever, Inc.](http://www.loudlever.com), this plugin allows blog owners and WordPress publishers to monetize their content through [Amazon affiliate sales](http://associates.amazon.com).  We believe that it should be as easy for site owners to use our tools, so if you experience any difficulties getting things set up please email us at: wordpress@loudlever.com. 

###Installation

**Install the Widget**

Install the plugin, then activate it.  Once activated, configure the Widget:

* First, drag the 'Amazon Book Store' widget to your sidebar. 
* Where prompted, set the "Title" you want displayed above the widget
* Input your Amazon "Affiliate ID" and the Country representing the affiliate program you belong to.  (Default is 'United States')
* Select how many products you want to offer for sale at one time within the widget, 1 or 2.

**Configure the ASIN pool**

Navigate to 'Settings' -> 'Amazon Book Store' and add the ASINs for the products you want to be displayed in the widget.  See [What are ASINs](http://www.amazon.com/gp/seller/asin-upc-isbn-info.html) for more information.  There are two categorizations of settings:

* POST Specific:  When set, these products will be offered for sale when users read the associated POST.
* Default: If the request is to a POST that does not have specific ASINs defined, the widget will display products from this group.

**Wow - that was easy!**

Yes -- it's that easy.

###Frequently Asked Questions

**Can I Use This Widget More Than Once In My Sidebar?**
Yes.  Absolutely.  Each instance can be configured separately.  Give the widgets separate titles - even separate Affiliate IDs.  You **must** use the same Affiliate 'country' for each widget instance, however.

###Screenshots

1. Widget displayed in the Widget manager.
2. Widget displayed in the Side-Bar (your styling may differ)
3. Widget process flow, illustrating how the products are selected for display
4. ASIN pool configuration for POSTs and for Default pool

###Upgrade Notice

####1.1.2
* Upgraded to jQuery and made WordPress 4.x compatible.

####1.1.1
* Fixed problem with wrapping of form labels on the Settings page.

####1.1.0
* IMPORTANT: If you're upgrading from a previous version of the widget, please take note that the name of the widget has been changed from 'SupportGreatAuthors' to 'Amazon Book Store'.
* There is now a configuration management screen at 'Settings' -> 'Amazon Book Store' where you can define the default ASINs to display in the widget and/or associate specific ASINS to specific POSTs.
* This version delivers enhanced functionality and the ability to create a 'pool' of products which the widget will randomly select from.  Because of this functionality, when upgrading from a previous installed version, the plugin will do it's best to migrate your previous settings to the new configuration.  If you had multiple instances of the plugin installed in your sidebar, this migration may not work as smoothly as we'd hope.  Please check your configurations after installing.

