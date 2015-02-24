<?php
namespace FelixOnline\API;

/*
 * Archive Controller
 */
class archiveController extends BaseController {
    function GET($matches) {
        global $dba;
        global $db;


        $dbaname = ARCHIVE_DATABASE;

        $dba = new \ezSQL_mysqli();
        $dba->quick_connect(
            $db->dbuser,
            $db->dbpassword,
            $dbaname,
            $db->dbhost,
            3306,
            'utf8'
        );
        $this->safesql = new \SafeSQL_MySQLi($dba->dbh);
        $dba->cache_timeout = 24; // Note: this is hours
        $dba->use_disk_cache = true;
        $dba->cache_dir = 'inc/ezsql_cache'; // Specify a cache dir. Path is taken from calling script
        $dba->show_errors();

        if(array_key_exists('latest', $matches)) { // latest issue by publication id
            $pubs = new \FelixOnline\Core\IssueManager();

            $check = $pubs->getPublications();

            if(!array_key_exists($matches['latest'], $check)) {
                throw new \NotFoundException('This publication does not exist.', $matches, 'API-archiveController');
            }

            $pubs = $pubs->getLatestPublicationIssue($matches['latest']);
            $pubs = $pubs[0]; // above is an array

            $pubs = new IssueHelper($pubs);

            API::output(
                $pubs->getExtendedOutput()
            );
        } else if(array_key_exists('id', $matches)) { // specific issue - by id
            $issue = new \FelixOnline\Core\Issue($matches['id']);
            $issue = new IssueHelper($issue);


            API::output(
                $issue->getExtendedOutput()
            );
        } else if(array_key_exists('pub', $matches)) { // issues in a specific publication - all years
            $pubs = new \FelixOnline\Core\IssueManager();

            $check = $pubs->getPublications();

            if(!array_key_exists($matches['pub'], $check)) {
                throw new \NotFoundException('This publication does not exist.', $matches, 'API-archiveController');
            }

            $pubs = $pubs->getAllPublicationIssues($matches['pub']);

            $output = array();

            foreach($pubs as $pub) {
                $pub = new IssueHelper($pub);
                $output[] = $pub->getOutput();
            }

            API::output(
                $output
            );
        } else { // list of publications
            $output = array();

            $pubs = new \FelixOnline\Core\IssueManager();
            $pubs = $pubs->getPublications();

            $output = array();
            foreach($pubs as $id => $pub) {
                $output[] = array('id' => $id, 'title' => $pub);
            }

            API::output(
                $output
            );
        }
    }
}
?>
