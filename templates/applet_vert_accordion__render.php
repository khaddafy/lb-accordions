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
			$classes[] = "first-panel first-panel";
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
		$classes[] = "set";

		$cls = "class=\"" . implode(" ", $classes) . "\"";
		?>
		<div <?php echo $cls; ?>>
			<div class="title">
				<?php
					if (strlen($panel->title) >= 0) {
						echo do_shortcode($panel->title);
					} else {
						echo $panel->name;
					}
				?>
			</div>
			<div class="content">
				<?php echo do_shortcode($panel->content); ?>
			</div>
		</div>
	<?php } ?>
</div>
<script type="text/javascript">
	jQuery(document).ready(
		function () {
			jQuery("#<?php echo $unique_id; ?>").msAccordion({defaultid:0, vertical:true});
		}
	);
</script>