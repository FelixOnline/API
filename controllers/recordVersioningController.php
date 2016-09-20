<?php
namespace FelixOnline\API;

/*
 * Record Version Controller
 */
class recordVersioningController extends BaseController {
	private function lookup($schema, $identifier) {
		$app = \FelixOnline\Core\App::getInstance();

		try {
			// We have to perform a raw query here - the audit_log is not provided for in Core

			// First, was this record ever deleted - if so stop here
			// There should not be any further update operations beyond a delete
			// but just in case
			$query = 'SELECT `timestamp`, `user` FROM audit_log WHERE `table` = "%s" AND `key` = "%s" AND `fields` = "{\"deleted\":{\"old\":false,\"new\":true}}"';
			$query = $app['safesql']->query($query, array($schema, $identifier));

			$results = $app['db']->get_row($query);

			if ($app['db']->last_error) {
				throw new \FelixOnline\Exceptions\SQLException($app['db']->last_error, $app['db']->captured_errors);
			}

			if (!is_null($results)) {
				API::output(array(
					'deleted' => true,
					'time' => strtotime($results->timestamp),
					'user' => $results->user));

				return;
			}

			// Not deleted - get data
			$query = 'SELECT `timestamp`, `user` FROM audit_log WHERE `table` = "%s" AND `key` = "%s" ORDER BY timestamp DESC';
			$query = $app['safesql']->query($query, array($schema, $identifier));

			$results = $app['db']->get_row($query);

			if ($app['db']->last_error) {
				throw new \FelixOnline\Exceptions\SQLException($app['db']->last_error, $app['db']->captured_errors);
			}

			if(is_null($results)) {
				throw new \NotFoundException(
					'No recorded events',
					$matches,
					'API-RecordVersioningController'
				);
			}

			API::output(array(
				'deleted' => false,
				'time' => strtotime($results->timestamp),
				'user' => $results->user));

			return;
		} catch (\Exception $e) {
			throw new \NotFoundException(
				$e->getMessage(),
				$matches,
				'API-RecordVersioningController'
			);
		}
	}

	function GET($matches) {
		if(array_key_exists('text', $matches) && array_key_exists('schema', $matches) && array_key_exists('identifier', $matches) && $matches['schema'] == 'article') {
			$app = \FelixOnline\Core\App::getInstance();

			try {
				// Get text_story ID

				$query = 'SELECT `text1` FROM article WHERE `id` = %i';
				$query = $app['safesql']->query($query, array($matches['identifier']));

				$results = $app['db']->get_row($query);

				if ($app['db']->last_error) {
					throw new \FelixOnline\Exceptions\SQLException($app['db']->last_error, $app['db']->captured_errors);
				}

				if(is_null($results)) {
					throw new \NotFoundException(
						'Article does not exist',
						$matches,
						'API-RecordVersioningController'
					);
				}

				$this->lookup('text_story', $results->text1);
			} catch (\Exception $e) {
				throw new \NotFoundException(
					$e->getMessage(),
					$matches,
					'API-RecordVersioningController'
				);
			}
		} elseif(array_key_exists('schema', $matches) && array_key_exists('identifier', $matches)) {
			$this->lookup($matches['schema'], $matches['identifier']);
		} else {
			throw new \NotFoundException(
				'Not implemented.',
				array(),
				'API-RecordVersioningController'
			);
		}
	}
}
?>
