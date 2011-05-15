<?php
/*
Author: Lee Braiden
Author URI: http://www.kintassa.com
Copyright: Copyright (c) 2011 Kintassa.
License: All rights reserved.  Contact Kintassa should you wish to license this product.
*/

require_once(kin_accord_inc('config.php'));
require_once(kintassa_core('kin_page.php'));

class KintassaAccordionAboutPage extends KintassaPage {
	function content() {
		$product = __("Product");
		$company = __("Company");

		$author = __("Author");
		$author_email = "lee.b@kintassa.com";
		$email_subject = urlencode("Kintassa Accordions");
		$author_link = "mailto:{$author_email}?Subject={$email_subject}";

		$company_link = "http://www.kintassa.com/";
		$product_link = "http://www.kintassa.com/products/kintassa_accordions/";

		$copyright = __("Copyright");
		$license = __("Copyright &copy; 2011 Kintassa. All rights reserved. Contact Kintassa for licensing.");

		$overview = __("Overview");
		$overview_text = __(<<<HTML
Kintassa Accordions provides the ability to add an unlimited number of accordions
to a website.  Accordions have individual panels, all of which can be managed
through the admininistration pages, and presented to site visitors in various
ways.  For more information, please consult the product's website using the
link above.
HTML
);

		$about = __(<<<HTML
<table class="about-page">
	<tr>
		<th>{$product}</th>
		<td><a href="{$product_link}">Kintassa Accordions</a></td>
	</tr>
	<tr>
		<th>{$author}</th>
		<td><a href="{$author_link}">Lee Braiden ($author_email)</a></td>
	</tr>
	<tr>
		<th>{$company}</th>
		<td><a href="{$company_link}">Kintassa</a></td>
	</tr>
	<tr>
		<th>{$copyright}</th>
		<td>{$license}</td>
	</tr>
	<tr>
		<th>{$overview}</th>
		<td>{$overview_text}</td>
	</tr>
</table>
HTML
);

		echo($about);
	}
}

?>