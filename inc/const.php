<?php

	/*
		API Constants
		Author: Jonathan Kim
		Date: 04/06/2011
	*/

	/* SYSTEM */
	define('SESSION_LENGTH',7200);
	define('AUTHENTICATION_SERVER','dougal.union.ic.ac.uk');
	define('AUTHENTICATION_PATH','https://dougal.union.ic.ac.uk/media/felix/');
	define('ROOT_USERS','felix,cjb07,rsp07,jk708'); // separate with commas, no spaces
	define('DEFAULT_IMG_URI','img/felix_400x400.jpg');
	define('DEFAULT_ARTICLE_IMG_ID',183);
	define('ARTICLE_URL_ID_PREFIX',(STANDARD_URL.'?article='));
	define('TICKER_ARTICLES',10);
	define('MOST_POPULAR_INTERVAL',7); // commented - look at comments over previous ... days
	define('MOST_VIEWED_SEARCHBACK',500); // viewed
	define('POPULAR_ARTICLES',5); // used for commented and viewed
	define('MOST_COMMENTED_HEADING',"Most commented stories");
	define('MOST_VIEWED_HEADING',"Most viewed stories");
	define('FRONTPAGE_EXTRA_STORIES',2);
	define('ROTATOR_MAX_CHARS',50);
	define('EXTRANEWS_COLS',16); // do not exceed columns in top_extrapage_cat
	define('ONLINE_USERS_INTERVAL','60 MINUTE');
	define('ARTICLES_PER_CAT_PAGE',8);
	define('ARTICLES_PER_SECOND_CAT_PAGE',10);
	define('ARTICLES_PER_USER_PAGE',8);
	define('ARTICLES_PER_SECOND_USER_PAGE',10);
	define('NUMBER_OF_PAGES_IN_PAGE_LIST',14);
	define('NUMBER_OF_POPULAR_ARTICLES_USER',5);
	define('NUMBER_OF_POPULAR_COMMENTS_USER',5);

	/* Media Page */
	define('NUMBER_OF_ALBUMS_FRONT_PAGE',4);
	define('NUMBER_OF_ALBUMS_PER_FULL_PAGE',12);
	define('IMAGE_BASE_URL', '/home/www/htdocs/media/felix/gallery/gallery_images/images/');

	/* RSS */
	define('RSS_IMG',(STANDARD_URL.DEFAULT_IMG_URI));
	define('RSS_NAME','Felix Online RSS Feed');
	define('RSS_DESCRIPTION','Latest articles from Felix Online');
	define('RSS_COPYRIGHT',('Felix Online | '.date('Y')));
	define('RSS_AUTHOR','Felix');
	define('RSS_SUBJECT','News for students and staff at Imperial College London');
	define('RSS_ARTICLES',30);

	/* ARTICLE */
	define('PREVIEW_LENGTH',170); // characters in preview before truncation
	define('TEASER_LENGTH',200); // similar but article teaser field, not first part of text1
	define('POST_TAGS_ALLOWED','<b><i><u><blockquote><p>');
	define('MIN_ARTICLE_TITLE_LENGTH',7); //
	define('MIN_ARTICLE_SHORTTITLE_LENGTH',5); //
	define('MIN_ARTICLE_TEASER_LENGTH',20); //
	define('MIN_ARTICLE_SECT_LENGTH',4); //
	define('MAX_ARTICLE_SECT_LENGTH',100000); //

	/* IMAGE */
	define('IMG_QUALITY_PERCENT',100);
	define('SIDEBAR_TOP5_WIDTH',140);
	define('SIDEBAR_TOP5_HEIGHT',140);
	define('TWOCOL_TOP2_WIDTH',218);
	define('TWOCOL_TOP2_HEIGHT',100);
	define('BLURB_HEIGHT',100);
	define('BLURB_WIDTH',100);
	define('ROTATOR_WIDTH',650);
	define('ROTATOR_HEIGHT',280);
	define('ROTATOR_THUMB_WIDTH',50);
	define('ROTATOR_THUMB_HEIGHT',34);
	define('MAX_SIZE_KB',3072); // maximum uploaded image size (KB)
	define('ARTICLE_IMG1_WIDTH',300);
	define('ARTICLE_IMG2_WIDTH',300);
	define('IMG_EXPIRY_HOURS',12);

	/* POLL */
	define('POLL_TITLE_MIN_LENGTH',10);
	define('POLL_GRAPH_WIDTH',280);
	define('POLL_GRAPH_HEIGHT',270);
	define('POLL_EXT_GRAPH_WIDTH',280);
	define('POLL_EXT_GRAPH_HEIGHT',300);
	define('POLL_SUBMIT_VALUE','Vote Now!');
	define('POLL_TITLE_BREAK_LENGTH',28);

	/* EMAIL */
	define('EMAIL_FROM_ADDR','Felix Online <no-reply@imperial.ac.uk>'); // can't just 'make one up'... must be a valid address if @imperial.ac.uk!
	define('EMAIL_REPLYTO_ADDR','no-reply@imperial.ac.uk');
	define('EMAIL_UNAME_SUFFIX','@imperial.ac.uk');
	define('EMAIL_COMMENT_SUBJECT_PREFIX','New comment: ');
	define('EMAIL_COMMENT_AUTHOR',true);
	define('EMAIL_COMMENT_COMMENTERS',true);
	define('EMAIL_EXTCOMMENT_NOTIFYADDR','jk708@ic.ac.uk, felix@imperial.ac.uk'); // comma-separated list of addresses to notify when a new external comment needs approval

	/* SITE CONSTANTS */
	$icip = array('155.198','129.31.','146.169'); # 7 characters
	$d = array(
	"media.su.ic.ac.uk" => "Media group",
	"ad.ic.ac.uk" => "Administration",
	"ma.ic.ac.uk" => "Maths",
	"et.ic.ac.uk" => "Environmental Science & Technology",
	"ph.ic.ac.uk" => "Physics",
	"sc.ic.ac.uk" => "Physics",
	"ce.ic.ac.uk" => "Chemical Engineering",
	"cv.ic.ac.uk" => "Civil Engineering",
	"lib.ic.ac.uk" => "Library",
	"sk.med.ic.ac.uk" => "Medicine (South Kensington)",
	"med.ic.ac.uk" => "Medicine (all campuses except South Kensington)",
	"tanaka.ic.ac.uk" => "Business School",
	"mt.ic.ac.uk" => "Materials",
	"mdr.ic.ac.uk" => "Biology", #?
	"bio.ic.ac.uk" => "Biology",
	"ch.ic.ac.uk" => "Chemistry",
	"doc.ic.ac.uk" => "Computing",
	"hor.ic.ac.uk" => "Halls of Residence",
	"is.ic.ac.uk" => "Institute of Security, Science & Technology",
	"me.ic.ac.uk" => "Mechanical Engineering",
	"ee.ic.ac.uk" => "Electrical and Electronic Engineering",
	"net.ic.ac.uk" => "Network",
	"ae.ic.ac.uk" => "Aeronautical Engineering",
	"hu.ic.ac.uk" => "Humanities",
	"ese.ic.ac.uk" => "Earth Science & Engineering",
	"rsm.ic.ac.uk" => "Royal School of Mines",
	"saf.ic.ac.uk" => "Sir Alexander Fleming",
	"bc.ic.ac.uk" => "Molecular Biosciences",
	"union.ic.ac.uk" => "Union",
	"su.ic.ac.uk" => "Union",
	"vpn.ic.ac.uk" => "VPN",
	"wlan.ic.ac.uk" => "College Wireless"
	);

	/* ENGINE CONSTANTS */
	define('NUMBER_OF_ARTICLES_PER_PAGE',10);

?>