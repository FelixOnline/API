<?php
	
/* 
	API functions
	
	Author: Jonathan Kim
	
	Date: 04/06/2011
	
*/

/* ---------------------------------------------------------- */
/* General api functions */
/* ---------------------------------------------------------- */

/* Generate random api key */	
function gen_random_string() {
    $length = 20;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $string = '';    
    for ($p = 0; $p < $length; $p++) {
        $string .= $characters[mt_rand(0, strlen($characters))];
    }
    return $string;
}

/* ---------------------------------------------------------- */
/* END of general functions */
/* ---------------------------------------------------------- */

/* ---------------------------------------------------------- */
/* Article functions */
/* ---------------------------------------------------------- */

/* Get article title from id */
function get_article_title($id) { 
	global $dbok,$cid;
	if ($dbok) {
		$sql = "SELECT title FROM `article` WHERE id=$id";
		return mysql_result(mysql_query($sql,$cid),0);
	}
}

/* Get short article title from id. If no short article title then return full title */
function get_short_article_title($id) { 
	global $dbok,$cid;
	if ($dbok) {
		$sql = "SELECT short_title FROM `article` WHERE id=$id";
		if ($title = mysql_result(mysql_query($sql,$cid),0))
			return $title;
		else
			return get_article_title($id);
	}
}

/* Get article teaser from id */
function get_article_teaser($id) { 
	global $cid;
	$sql = "SELECT teaser,content AS text1 FROM `article` INNER JOIN `text_story` ON (article.text1=text_story.id) WHERE article.id=$id";
	list($teaser,$content) = mysql_fetch_array(mysql_query($sql,$cid));
	if ($teaser)
		return str_replace('<br/>','',strip_tags($teaser));
	else {
		return trim(substr(strip_tags($content),0,strrpos(substr(strip_tags($content),0,TEASER_LENGTH),' '))).'...';
	}
}

/* Get article author's username from article id */
function get_article_author_uname($id) {
	global $cid;
	$sql = "SELECT author FROM `article` WHERE id=$id";
	return mysql_result(mysql_query($sql,$cid),0);
}

/* Get article author's full name from article id */
function get_article_author_vname($id) {
	global $cid;
	$sql = "SELECT ln.name FROM `article` AS a INNER JOIN `user` AS ln ON (a.author=ln.user) WHERE id=$id";
	return mysql_result(mysql_query($sql,$cid),0);
}

/* Get article's full category name from article id */
function get_article_category($id) {
	global $cid;
	$sql = "SELECT label FROM `article` INNER JOIN `category` ON (article.category=category.id) WHERE article.id=$id";
	return mysql_result(mysql_query($sql,$cid),0);
}

/* Get article's short category name from article id */
function get_article_category_cat($id) {
	global $cid;
	$sql = "SELECT cat FROM `article` INNER JOIN `category` ON (article.category=category.id) WHERE article.id=$id";
	return mysql_result(mysql_query($sql,$cid),0);
}

/* Get article's publish date from id (returns Unix timestamp) */
function get_article_publishdate($id) {
	global $dbok,$cid;
	if ($dbok) {
		$sql = "SELECT UNIX_TIMESTAMP(published) FROM `article` WHERE id=$id";
		return mysql_result(mysql_query($sql,$cid),0);
	}
}

/* Get article content from id (unfiltered) */
function get_article_text($id,$text=1) { // Article DONE
	global $dbok,$cid;
	if ($dbok) {
		$sql = "SELECT content FROM `article` INNER JOIN `text_story` ON (article.text$text=text_story.id) WHERE article.id=$id";
		$content = mysql_result(mysql_query($sql,$cid),0);
		return $content;
	}
}

/* Clean html content to remove extra styling */
function clean_content2($text) {
	$result = strip_tags($text, '<p><a><div><b><i><br><blockquote><object><param><embed><li><ul><ol><strong><img><h1><h2><h3><h4><h5><h6><em><iframe><strike>'); // Gets rid of html tags except certain exceptions
	$result = preg_replace('#<div[^>]*(?:/>|>(?:\s|&nbsp;)*</div>)#im', '', $result); // Removes empty html div tags
	$result = preg_replace('#<span*(?:/>|>(?:\s|&nbsp;)[^>]*</span>)#im', '', $result); // Removes empty html div tags
	$result = preg_replace('#<p[^>]*(?:/>|>(?:\s|&nbsp;)*</p>)#im', '', $result); // Removes empty html p tags
	//$result = preg_replace("/<(\/)*div[^>]*>/", "<\\1p>", $result); // Changes div tags into <p> tags
	return $result;
}

/* Get formatted article url from id */
function article_url($article) {
	$cat = get_article_category_cat($article);
	$title = get_article_title($article);
	
	$title = strtolower($title); // Make title lowercase
	$title= preg_replace('/[^\w\d_ -]/si', '', $title); // Remove special characters
	$dashed = str_replace( " ", "-", $title); // Replace spaces with hypens
	
	$output = $cat.'/'.$article.'/'.$dashed.'/';
	return $output;
}

/* ---------------------------------------------------------- */
/* END of article api functions */
/* ---------------------------------------------------------- */

?>