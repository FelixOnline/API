<?php

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../DatabaseTestCase.php';
require_once __DIR__ . '/../utilities.php';

class ArticleTest extends DatabaseTestCase
{
    public $fixtures = array(
        'articles',
        'categories',
        'text_stories',
        'users',
        'article_authors',
        'comments',
        'comments_ext',
        'images',
        'api_keys',
    );

    public function setUp()
    {
        parent::setUp();
        create_app(array(
            'base_url' => 'http://localhost/'
        ));

        // Remove environment mode if set
        unset($_ENV['SLIM_MODE']);

        // Reset session
        $_SESSION = array();

        unset($this->app);
    }

    private function setRequest($path, $method = 'GET', $query = '', $headers = array())
    {
        // Prepare default environment variables
        \Slim\Environment::mock(array(
            'REQUEST_METHOD' => $method,
            'PATH_INFO' => $path, //<-- Virtual
            'QUERY_STRING' => $query,
        ) + $headers);

        $app = new \SlimController\Slim(array(
            'controller.class_prefix'    => '\\API\\Controller',
            'controller.method_suffix'   => 'Action',
        ));

        $app->view(new \JSONView());

        $app->addRoutes(array(
            '/' => 'Frontpage:index',
            '/v1/articles/' => 'Article:index',
            '/v1/articles/:id' => 'Article:article',
        ));

        $app->setName('default');

        $this->app = $app;
    }

    /**
     * Test render with template and data
     */
    public function testArticle()
    {
        $this->setRequest('/v1/articles/1');

        $s = \Slim\Slim::getInstance();
        $s->call();
        list($status, $header, $body) = $s->response()->finalize();
        $this->assertEquals(200, $status);
        $this->assertEquals($header->get('Content-Type'), 'application/json; charset=utf-8');

        $resp = json_decode($body, true);

        $this->assertEquals($resp['error'], false);
        $this->assertEquals($resp['status'], 200);

        $data = $resp['data'];

        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('title', $data);
        $this->assertArrayHasKey('short_title', $data);
        $this->assertArrayHasKey('category', $data);
        $this->assertArrayHasKey('date', $data);
        $this->assertArrayHasKey('url', $data);
        $this->assertArrayHasKey('authors', $data);
        $this->assertArrayHasKey('content_html', $data);
        $this->assertArrayHasKey('comment_num', $data);
        $this->assertArrayHasKey('comments', $data);

        $this->assertEquals($data['id'], 1);
        $this->assertEquals($data['title'], "Fighting for Libel Reform");
    }

    /**
     * Test render with template and data
     */
    public function testUpdateArticle()
    {
        $this->setRequest('/v1/articles/1', 'PATCH', 'key=111');

        $title = 'Foo Bar';

        $_POST['title'] = $title;

        $s = \Slim\Slim::getInstance();
        $s->call();
        list($status, $header, $body) = $s->response()->finalize();
        $this->assertEquals(200, $status);
        $this->assertEquals($header->get('Content-Type'), 'application/json; charset=utf-8');

        $resp = json_decode($body, true);

        $this->assertEquals($resp['error'], false);

        $data = $resp['data'];

        $this->assertEquals($data['id'], 1);
        $this->assertEquals($data['title'], $title);

        // query db
        $conn = $this->getConnection();
        $pdo = $conn->getConnection();

        $statement = $pdo->prepare("SELECT title FROM article WHERE id = :id");
        $statement->execute(array(':id' => "1"));
        $row = $statement->fetch();
        $this->assertEquals($row['title'], $title);
    }
}
