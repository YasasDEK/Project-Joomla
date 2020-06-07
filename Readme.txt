HOW TO UPDATE 1.5.6 - 3.0.0 TO 3.1.0

1. Log in to PhpMyAdmin and make the backup of four FlippingBook tables: [prefix]_flippingbook_books, [prefix]_flippingbook_categories, [prefix]_flippingbook_config and [prefix]_flippingbook_pages.

2. Unpack the zip file with 3.1.0 version of the component to a folder on your PC.

3. Connect to your server through FTP. Copy flippingbook.xml to [joomla_root]/administrator/components/com_flippingbook/ folder.

4. Copy files from "/admin/language/en-GB/" folder to [joomla_root]/administrator/language/en-GB/ folder.

5. Copy files and folders (excluding "language") from "/admin/" to [joomla_root]/administrator/components/com_flippingbook/ folder.

6. Copy files from "/site/language/en-GB/" folder to [joomla_root]/language/en-GB/ folder.

7. Copy files and folders from "site" folder to [joomla_root]/components/com_flippingbook/ folder.

8. Open the component backend (top menu > Components > FlippingBook). You'll see "FlippingBook was updated to version 3.1.0" message.

9. If you updating Joomla 1.5, you should also move files and folders from /images/flippingbook/ to /images/ folder.


HOW TO UPDATE 1.5.5 OR AN EARLIER VERSION TO 3.1.0
For updating 1.5.5 and earlier versions to 3.1.0 version, you should reinstall the component and rebuild books.


CHANGELOG
3.1.0
- Some code fixes for compatibility with Joomla 3.1.

3.0.0
- The extension was rewritten for compatibility with Joomla 3.0.
- Minor bugfixes.

2.5.0
- Fixed the compatibility problem with Joomla 2.5.
- Deprecated function split() was replaced for compatibility with future PHP versions.
- Minor bugfixes.

1.5.13 / 1.6.4
- Dynamic scaling of the book. Now you can set sizes of the book in percents and the book will be stretched according to the Flash Player stage sizes.

1.6.3
- Fixed the problem with incorrect work of Batch Add Pages feature with "JPEG" extension.
- Solved the problem with PHP notices messages.
- jQuery.noConflict() function added into JQUery library for compatibility with another extensions.

1.6.2
- SEO version. HTML version for search engine indexing, non-flash computers and mobile devices.

1.6.1
- Fixed the problem with sorting books and categories when the component installed on Joomla 1.6.0 Stable or 1.6.1.

1.6.0
- The code of component was rewritten for compatibility with Joomla 1.6.
- Front-end texts was moved from the component configuration to the external [joomla root]\language\en-GB\en-GB.com_flippingbook.ini file.
- Added access management for books and categories.

1.5.10
- Ability to open books in a fullscreen popup window.
- Liquid height of flash object.

1.5.9
- RTL books support (book properties > Parameters (Basic) > Book Direction).
- Customizable border around pages (book properties > Parameters (Basic) > Frame Width, Frame Color).
- Ability to bind a desired page to a menu item.
- This version allows to place more than one book on the web page (uses module or plugin).
Notes:
If you are using previous versions for RTL books, you'll need to reverse pages order after updating to 1.5.9 version.
If you have links to specific pages, replace "firstpageNumber" parameter in URLs with "page".

1.5.8
- Image smoothing on pages.
- Sound On/Off button in navigation bar (book properties > Navigation Bar tab).
- Fullscreen hint (book properties > Parameters (Advanced) tab).
- Transparent pages parameter (book properties > Parameters (Advanced) tab).
- Show / Hide zoom hint parameter (book properties > Zoom Settings tab).
- Improvements in design of the navigation bar.

1.5.7
- Zooming in lightbox window.
- "Copy" button in the book manager.
- "Copy" button in the page manager.
- "Restore Default Settings" button in the component configuration.

1.5.6
- Hard cover.
- Dynamic centering of the book.
- Full-screen mode.
- New zooming method.
- Easily customizable flash navigation bar (you can download the source file from our site).