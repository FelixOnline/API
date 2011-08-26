<?php
	/*
		Felix Online API
			Author: Jonathan Kim
			Date: 24/05/11
			Version: 0.1
	*/

	require_once("inc/config.inc.php");
	require_once("inc/functions.php");
	require_once("inc/const.php");
    require_once("inc/Rest.php");
    require_once("inc/XmlWriter.php"); // TODO: add this to classes?

    $data = RestUtils::processRequest();

    if(!$data->getRequestVars()) { // if there are aren't any request vars then show frontpage
        require_once('frontpage.php');
        die();
    } else {
        // check api key

        // check that there is a 'what'
        if(!isset($_GET['what'])){
            RestUtils::sendResponse(404);
        } else {
            // find out what it is requesting
            if(file_exists(getcwd().'/'.$_GET['what'].'.php')) {
                require_once($_GET['what'].'.php');
            } else {
                RestUtils::sendResponse(501);
            }
        }
    }

	// Functions
	function get_article() {
		if(isset($_GET['id'])) {

			$id = $_GET['id'];

			header("Content-type: text/xml");

			$xml = "<?xml version=\"1.0\" encoding=\"utf-8\" standalone=\"yes\"?>\n";
			$xml .= "<article_container>\n";

				// Article title
				$xml .= "<article_title>";
				$xml .= get_article_title($id);
				$xml .= "</article_title>";

				// Article teaser
				$xml .= "<article_teaser>";
				$xml .= get_article_teaser($id);
				$xml .= "</article_teaser>";

				// Article author
				$xml .= "<article_author>";
				$xml .= get_article_author_uname($id);
				$xml .= "</article_author>";

				// Article author full
				$xml .= "<article_author_full>";
				$xml .= get_article_author_vname($id);
				$xml .= "</article_author_full>";

				// Article category
				$xml .= "<article_category>";
				$xml .= get_article_category_cat($id);
				$xml .= "</article_category>";

				// Article category display
				$xml .= "<article_category_display>";
				$xml .= get_article_category($id);
				$xml .= "</article_category_display>";

				// Article date
				$xml .= "<article_date>";
				$xml .= get_article_publishdate($id);
				$xml .= "</article_date>";

				// Article image
				$xml .= "<article_image>";
				$xml .= //get_article_publishdate($id);
				$xml .= "</article_image>";

				// Article content
				$xml .= "<article_content>";
				$xml .= "<![CDATA[".clean_content2(get_article_text(($id)))."]]>";
				$xml .= "</article_content>";

				// Article url
				$xml .= "<article_url>";
				$xml .= STANDARD_URL.article_url($id);
				$xml .= "</article_url>";

				// Article comments
				$xml .= "<article_comments>";
				$xml .= article_url($id);
				$xml .= "</article_comments>";

			$xml .= "</article_container>\n";

			echo $xml;

		} else
			return false;
	}

?>
