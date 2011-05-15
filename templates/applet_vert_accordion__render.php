<?php
/*
Author: Lee Braiden
Author URI: http://www.kintassa.com
Copyright: Copyright (c) 2011 Kintassa.
License: All rights reserved.  Contact Kintassa should you wish to license this product.
*/

?>
<div id="<?php echo $unique_id; ?>" <?php echo $cls . " " . $sty; ?>>
	<?php
	$panels = $accordion->panels();

	$first = true;
	$even = false;

	?>

	<?php
	foreach($panels as $panel) {
		$classes = array();
		if ($first) {
			$classes[] = "first-panel";
			$first = false;
		}
		if ($even) {
			$classes[] = "even";
		} else {
			$classes[] = "odd";
		}
		$even = !$even;

		$classes[] = "kintassa-accordion-panel-{$panel->id}";
		$classes[] = "kintassa-accordion-panel";

		$cls = "class=\"" . implode(" ", $classes) . "\"";
		?>
		<div <?php echo $cls; ?>>
			<div class="content">
				<?php echo $panel->content; ?>
			</div>
		</div>
	<?php } ?>
</div>
