<?php
namespace FelixOnline\API;

/*
 * Archive Controller
 */
class archiveController extends BaseController {
    function GET($matches) {
        $paginatorWrapper = new \FelixOnline\API\PaginatorWrapper();

        if(array_key_exists('year_pub', $matches)) { // all years for a specific publication
            $publicationManager = \FelixOnline\Core\BaseManager::build('FelixOnline\Core\ArchivePublication', 'archive_publication');
            $publicationManager->filter('inactive = 0')
                               ->filter('id = %i', array($matches['year_pub']));

            $manager = \FelixOnline\Core\BaseManager::build('FelixOnline\Core\ArchiveIssue', 'archive_issue');
            $end = $manager->filter('inactive = 0')
                    ->order('date', 'DESC')
                    ->limit(0, 1)
                    ->join($publicationManager, null, 'publication')
                    ->values();

            $end = (int) date('Y', $end[0]->getDate());

            $manager = \FelixOnline\Core\BaseManager::build('FelixOnline\Core\ArchiveIssue', 'archive_issue');
            $start = $manager->filter('inactive = 0')
                    ->order('date', 'ASC')
                    ->limit(0, 1)
                    ->join($publicationManager, null, 'publication')
                    ->values();

            $start = (int) date('Y', $start[0]->getDate());

            $years = array();

            for($i = $start; $i < $end; $i++) {
                $years[] = $i;
            }

            $years[] = $end;

            API::output(
                $years
            );
        } else if(array_key_exists('years', $matches)) { // all years with publications
            $publicationManager = \FelixOnline\Core\BaseManager::build('FelixOnline\Core\ArchivePublication', 'archive_publication');
            $publicationManager->filter('inactive = 0');

            $manager = \FelixOnline\Core\BaseManager::build('FelixOnline\Core\ArchiveIssue', 'archive_issue');
            $end = $manager->filter('inactive = 0')
                    ->order('date', 'DESC')
                    ->limit(0, 1)
                    ->join($publicationManager, null, 'publication')
                    ->values();

            $end = (int) date('Y', $end[0]->getDate());

            $manager = \FelixOnline\Core\BaseManager::build('FelixOnline\Core\ArchiveIssue', 'archive_issue');
            $start = $manager->filter('inactive = 0')
                    ->order('date', 'ASC')
                    ->limit(0, 1)
                    ->join($publicationManager, null, 'publication')
                    ->values();

            $start = (int) date('Y', $start[0]->getDate());

            $years = array();

            for($i = $start; $i < $end; $i++) {
                $years[] = $i;
            }

            $years[] = $end;

            API::output(
                $years
            );
        } else if(array_key_exists('latest', $matches)) { // latest issue by publication id
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
        } else if(array_key_exists('pub', $matches) && array_key_exists('year', $matches)) { // all issues by year for a publication
            try {
                $issueManager = \FelixOnline\Core\BaseManager::build('FelixOnline\Core\ArchiveIssue', 'archive_issue');

                $issueManager = $issueManager
                    ->filter('inactive = 0')
                    ->filter('publication = %i', array($matches['pub']))
                    ->filter('date LIKE "%i-%"', array($matches['year']))
                    ->order('date', 'ASC');

                $publicationManager = \FelixOnline\Core\BaseManager::build('FelixOnline\Core\ArchivePublication', 'archive_publication');

                $publicationManager->filter('inactive = 0');

                $issueManager->join($publicationManager, null, 'publication');

                $values = $paginatorWrapper->setManager($issueManager)->values();
            } catch(\Exception $e) {
                throw new \NotFoundException(
                    $e->getMessage(),
                    $matches,
                    'API-ArchiveController'
                );
            }

            $output = array();

            foreach($values as $pub) {
                $pub = new IssueHelper($pub);
                $output[] = $pub->getOutput();
            }

            API::output(
                $output,
                $paginatorWrapper->since(),
                $paginatorWrapper->max()
            );
        } else if(array_key_exists('year', $matches)) { // all issues by year
            try {
                $issueManager = \FelixOnline\Core\BaseManager::build('FelixOnline\Core\ArchiveIssue', 'archive_issue');

                $issueManager = $issueManager
                    ->filter('inactive = 0')
                    ->filter('date LIKE "%i-%"', array($matches['year']))
                    ->order('date', 'ASC');

                $publicationManager = \FelixOnline\Core\BaseManager::build('FelixOnline\Core\ArchivePublication', 'archive_publication');

                $publicationManager->filter('inactive = 0');

                $issueManager->join($publicationManager, null, 'publication');

                $values = $paginatorWrapper->setManager($issueManager)->values();
            } catch(\Exception $e) {
                throw new \NotFoundException(
                    $e->getMessage(),
                    $matches,
                    'API-ArchiveController'
                );
            }

            $output = array();

            foreach($values as $pub) {
                $pub = new IssueHelper($pub);
                $output[] = $pub->getOutput();
            }

            API::output(
                $output,
                $paginatorWrapper->since(),
                $paginatorWrapper->max()
            );
        } else if(array_key_exists('pub', $matches) && array_key_exists('issue', $matches)) { // specific issue by issue no in specific publication
            try {
                $pub = new \FelixOnline\Core\ArchivePublication($matches['pub']);

                if($pub->getInactive()) {
                    throw new \Exception('Inactive');
                }
            } catch(\Exception $e) {
                throw new \NotFoundException('This publication does not exist.', $matches, 'API-ArchiveController');
            }

            try {
                $manager = \FelixOnline\Core\BaseManager::build('FelixOnline\Core\ArchiveIssue', 'archive_issue');
                $pubs = $manager->filter('publication = %i', array($matches['pub']))
                                ->filter('issue = %i', array($matches['issue']))
                                ->filter('inactive = 0')
                                ->order('date', 'DESC')
                                ->values();
            } catch(\Exception $e) {
                throw new \NotFoundException('This issue does not exist in this publication.', $matches, 'API-ArchiveController');
            }

            $output = array();

            foreach($pubs as $pub) {
                $pub = new IssueHelper($pub);
                $output[] = $pub->getExtendedOutput();
            }

            API::output(
                $output
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
                                 ->order('date', 'DESC');
                $pubs = $paginatorWrapper->setManager($manager)->values();
            } catch(\Exception $e) {
                throw new \NotFoundException('No issues found for this publication.', $matches, 'API-ArchiveController');
            }

            $output = array();

            foreach($pubs as $pub) {
                $pub = new IssueHelper($pub);
                $output[] = $pub->getOutput();
            }

            API::output(
                $output,
                $paginatorWrapper->since(),
                $paginatorWrapper->max()
            );
        } else { // list of publications
            $output = array();

            try {
                $manager = \FelixOnline\Core\BaseManager::build('FelixOnline\Core\ArchivePublication', 'archive_publication');
                $pubs = $manager->filter('inactive = 0');
                $pubs = $paginatorWrapper->setManager($manager)->values();

                foreach($pubs as $id => $pub) {
                    $output[] = (new PublicationHelper($pub))->getOutput();
                }
            } catch(\Exception $e) {
                throw new \NotFoundException('No publications found.', $matches, 'API-archiveController');
            }

            API::output(
                $output,
                $paginatorWrapper->since(),
                $paginatorWrapper->max()
            );
        }
    }
}
?>
