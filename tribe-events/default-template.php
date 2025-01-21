<?php
/**
 * Default Events Template
 * This file is the basic wrapper template for all the views if 'Default Events Template'
 * is selected in Events -> Settings -> Template -> Events Template.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/default-template.php
 *
 * @package TribeEventsCalendar
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

get_header();

$tribe_eventcategory = [];
if (isset($_GET['tribe_eventcategory'])) {
	$tribe_eventcategory = $_GET['tribe_eventcategory'];
	if (!is_array($tribe_eventcategory)) {
		$tibe_eventcategory = [];
	}
}
?>
<style>
	.calendar-active-category {
		color: #000000;
		text-decoration: none;
	}
	.calendar-active-category:hover {
		color: #000000;
		text-decoration: underline;
	}
	#main {
		padding-top: 30px;
	}
	
</style>
<script language="javascript">
jQuery(".title-heading-center").html("Upcoming Events");
</script>
<div class="calendar-header">
	<p style="text-align: center;"><a href="/events" class="<?php if (!isset($tribe_eventcategory[0]) || (isset($tribe_eventcategory[0]) && $tribe_eventcategory[0]=="")) { print "calendar-active-category"; } ?>">All Events</a> | <a href="/events/?tribe_eventcategory%5B%5D=91" class="<?php if ((isset($tribe_eventcategory[0]) && $tribe_eventcategory[0]=="91")) { print "calendar-active-category"; } ?>">Adult Programming</a> | <a href="/events/?tribe_eventcategory%5B%5D=80" class="<?php if ((isset($tribe_eventcategory[0]) && $tribe_eventcategory[0]=="80")) { print "calendar-active-category"; } ?>">Youth Services</a> | <a href="/events/?tribe_eventcategory%5B%5D=92" class="<?php if ((isset($tribe_eventcategory[0]) && $tribe_eventcategory[0]=="92")) { print "calendar-active-category"; } ?>">Bookmobile Programs</a></p>
</div>
<section id="content" <?php Avada()->layout->add_style( 'content_style' ); ?>>
	<div id="tribe-events-pg-template">
		<?php tribe_events_before_html(); ?>
		<?php tribe_get_view(); ?>
		<?php tribe_events_after_html(); ?>
	</div> <!-- #tribe-events-pg-template -->
</section>
<?php do_action( 'avada_after_content' ); ?>
<style>
@media print {
.fusion-main-menu { display: none !important; }
.fusion-page-title-bar { display: none !important; }
#tribe_events_filters_wrapper,tribe-events-filters-vertical { display: none !important; }
.tribe-filters-open .tribe-events-filters-vertical+#tribe-events-content, .tribe-filters-open .tribe-events-filters-vertical+.tribe-bar-disabled+#tribe-events-content { width: 100% !important; padding-left: 0px !important; float: none !important;}
footer { display: none !important; }
#tribe-events-bar { display: none !important; }
.calendar-header { display: none !important; }
.tribe-filters-open #tribe-events-content-wrapper #tribe_events_filters_wrapper.tribe-events-filters-vertical { display: none !important; }
}
</style>
<?php
get_footer();