<?php
namespace FelixOnline\API;

/*
 * Archive Controller
 */
class archiveController extends BaseController {
    function GET($matches) {
        if(array_key_exists('latest', $matches)) { // latest issue by publication id
            try {
                $manager = \FelixOnline\Core\BaseManager::build('FelixOnline\Core\ArchiveIssue', 'archive_issue');
                $issue = $manager->filter('publication = %i', array($matches['latest']))
                                 ->filter('inactive = 0')
                                 ->order('date', 'DESC')
                                 ->limit(0, 1)
                                 ->values();

                $issue = $issue[0];

                if($issue->getPublication()->getInactive()) {
                    throw new \Exception('No model in database');
                }

                $issue = new IssueHelper($issue);
            } catch(\Exception $e) {
                throw new \NotFoundException(
                    'The latest issue for this publication could not be found.',
                    $matches,
                    'API-ArchiveController'
                );
            }

            API::output(
                $issue->getExtendedOutput()
            );
        } else if(array_key_exists('id', $matches)) { // specific issue - by id
            try {
                $issue = new \FelixOnline\Core\ArchiveIssue($matches['id']);

                if($issue->getPublication()->getInactive() || $issue->getInactive()) {
                    throw new \Exception('No model in database');
                }

                $issue = new IssueHelper($issue);
            } catch(\Exception $e) {
                throw new \NotFoundException(
                    $e->getMessage(),
                    $matches,
                    'API-ArchiveController'
                );
            }

            API::output(
                $issue->getExtendedOutput()
            );
        } else if(array_key_exists('pub', $matches)) { // issues in a specific publication - all years
            try {
                $pub = new \FelixOnline\Core\ArchivePublication($matches['pub']);
            } catch(\Exception $e) {
                throw new \NotFoundException('This publication does not exist.', $matches, 'API-ArchiveController');
            }

            try {
                $manager = \FelixOnline\Core\BaseManager::build('FelixOnline\Core\ArchiveIssue', 'archive_issue');
                $pubs = $manager->filter('publication = %i', array($matches['pub']))
                                 ->filter('inactive = 0')
                                 ->order('date', 'DESC')
                                 ->values();
            } catch(\Exception $e) {
                throw new \NotFoundException('No issues found for this publication.', $matches, 'API-ArchiveController');
            }

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

            try {
                $manager = \FelixOnline\Core\BaseManager::build('FelixOnline\Core\ArchivePublication', 'archive_publication');
                $pubs = $manager->filter('inactive = 0')
                                 ->values();

                foreach($pubs as $id => $pub) {
                    $output[] = (new PublicationHelper($pub))->getOutput();
                }
            } catch(\Exception $e) {
                throw new \NotFoundException('No publications found.', $matches, 'API-archiveController');
            }

            API::output(
                $output
            );
        }
    }
}
?>
