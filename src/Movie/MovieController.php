<?php

namespace Kris3XIQ\Movie;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class MovieController implements AppInjectableInterface
{
    use AppInjectableTrait;


    // /**
    //  * @var string $db a sample member variable that gets initialised
    //  */
    // //private $db = "not active";


    // /**
    //  * The initialize method is optional and will always be called before the
    //  * target method/action. This is a convienient method where you could
    //  * setup internal properties that are commonly used by several methods.
    //  *
    //  * @return void
    //  */
    // public function initialize() : void
    // {
    //     // Use to initialise member variables.
    //     $this->db = "active";

    //     // Use $this->app to access the framework services.
    // }



    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function indexAction() : string
    {
        // Deal with the action and return a response.
        //return __METHOD__ . ", \$db is {$this->db}";
        return "INDEX!!";
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function debugAction() : string
    {
        // Deal with the action and return a response.
        //return __METHOD__ . ", \$db is {$this->db}";
        return "Debug my database!!";
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function initAction() : object
    {
        /**
         * Show all movies.
         */
        $response = $this->app->response;
        return $response->redirect("movie/library");
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function libraryActionGet() : object
    {
        $page = $this->app->page;
        $title = "Filmbibliotek";
        $db = $this->app->db;

        $db->connect();
        $sql = "SELECT * FROM movie;";
        $resultset = $db->executeFetchAll($sql);

        $page->add("movie/header");
        $page->add("movie/library", [
            "resultset" => $resultset,
        ]);
        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     * This is the searchTitle GET method
     *
     * @return string
     */
    public function searchTitleActionGet() : object
    {
        $page = $this->app->page;
        $title = "Sök efter titel";
        $resultset = null;
        $searchTitle = null;
        $doSearch = null;
        $data = [
            "resultset" => $resultset ?? null,
            "searchTitle" => $searchTitle ?? null,
            "doSearch" => $doSearch ?? null
        ];

        $page->add("movie/header");
        $page->add("movie/search-title", $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     * This is the searchTitle POST method
     *
     * @return string
     */
    public function searchTitleActionPost() : object
    {
        $page = $this->app->page;
        $request = $this->app->request;
        $db = $this->app->db;
        $title = "Sök efter titel";
        $doSearch = $request->getPost("doSearch");

        if ($doSearch) {
            $searchTitle = $request->getPost("searchTitle");
            $db->connect();
            $sql = "SELECT * FROM movie WHERE title LIKE ?;";
            $resultset = $db->executeFetchAll($sql, [$searchTitle]);
            $page->add("movie/header");
            $page->add("movie/search-title", [
                "resultset" => $resultset,
                "title" => $title
            ]);
            return $page->render([
                "title" => $title,
                
            ]);
        };
    }

    /**
     * This is the searchYear GET method
     *
     * @return string
     */
    public function searchYearActionGet() : object
    {
        $page = $this->app->page;
        $title = "Sök efter årtal";
        $resultset = null;
        $searchMin = null;
        $searchMax = null;
        $doSearch = null;
        $data = [
            "resultset" => $resultset ?? null,
            "searchMin" => $searchMin ?? null,
            "searchMax" => $searchMax ?? null,
            "doSearch" => $doSearch ?? null
        ];

        $page->add("movie/header");
        $page->add("movie/search-year", $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     * This is the searchYear POST method
     *
     * @return string
     */
    public function searchYearActionPost() : object
    {
        $db = $this->app->db;
        $page = $this->app->page;
        $request = $this->app->request;
        $title = "Sök efter årtal";
        $doSearch = $request->getPost("doSearch");
        if ($doSearch) {
            $searchMin = $request->getPost("searchMin");
            $searchMax = $request->getPost("searchMax");
            $this->app->db->connect();
            if ($searchMin && $searchMax) {
                $sql = "SELECT * FROM movie WHERE year >= ? AND year <= ?;";
                $resultset = $db->executeFetchAll($sql, [$searchMin, $searchMax]);
            } elseif ($searchMin) {
                $sql = "SELECT * FROM movie WHERE year >= ?;";
                $resultset = $db->executeFetchAll($sql, [$searchMin]);
            } elseif ($searchMax) {
                $sql = "SELECT * FROM movie WHERE year <= ?;";
                $resultset = $db->executeFetchAll($sql, [$searchMax]);
            };
        }

        $page->add("movie/header");
        $page->add("movie/search-year", [
            "resultset" => $resultset,
            "title" => $title
        ]);
        return $page->render([
            "title" => $title
        ]);
    }

    /**
     * This is the movieSelect GET method.
     *
     * @return string
     */
    public function movieSelectActionGet() : object
    {
        $page = $this->app->page;
        $db = $this->app->db;
        $title = "Lägg till/ändra en film";
        $resultset = null;
        $movieId = null;
        $doAdd = null;
        $doDelete = null;
        $doEdit = null;
        $db->connect();
        $sql = "SELECT * FROM movie;";
        $resultset = $db->executeFetchAll($sql);

        $data = [
            "resultset" => $resultset ?? null,
            "movieId" => $movieId ?? null,
            "doAdd" => $doAdd ?? null,
            "doDelete" => $doDelete ?? null,
            "doEdit" => $doEdit ?? null,
            "movies" => $resultset
        ];


        $page->add("movie/header");
        $page->add("movie/movie-select", $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     * This is the movieSelect POST method.
     *
     * @return string
     */
    public function movieSelectActionPost() : object
    {
        $db = $this->app->db;
        $page = $this->app->page;
        $response = $this->app->response;
        $session = $this->app->session;
        $request = $this->app->request;
        $doAdd = $request->getPost("doAdd");
        $doDelete = $request->getPost("doDelete");
        $doEdit = $request->getPost("doEdit");
        $movieId = $request->getPost("movieId");
        if ($doAdd) {
            $session->delete("movieId");
            return $response->redirect("movie/movieEdit");
        } elseif ($doDelete) {
            $db->connect();
            $sql = "DELETE FROM movie WHERE id = ?;";
            $db->execute($sql, [$movieId]);
            return $response->redirect("movie/library");
        } elseif ($doEdit) {
            $session->set("movieId", $movieId);
            return $response->redirect("movie/movieEdit");
        }

        $page->add("movie/header");
        $page->add("movie/movie-select", [
            "title" => $title
        ]);
        return $page->render([
            "title" => $title
        ]);
    }

    /**
     * This is the movieEdit GET method.
     *
     * @return string
     */
    public function movieEditActionGet() : object
    {
        $page = $this->app->page;
        $session = $this->app->session;
        $db = $this->app->db;
        $title = "Ändra info om filmen";
        $movieId = $session->get("movieId");
        if ($movieId) {
            $db->connect();
            $sql = "SELECT * FROM movie WHERE id = ?;";
            $movie = $db->executeFetchAll($sql, [$movieId]);
            $movie = $movie[0];
        }

        $page->add("movie/header");
        $page->add("movie/movie-edit");

        return $page->render([
            "title" => $title
        ]);
    }

    /**
     * This is the movieEdit POST method
     *
     * @return string
     */
    public function movieEditActionPost() : object
    {
        $request = $this->app->request;
        $response = $this->app->response;
        $session = $this->app->session;
        $db = $this->app->db;

        $doSave = $request->getPost("doSave");
        $doBack = $request->getPost("doBack");
        $movieId = $session->get("movieId");
        $movieTitle = $request->getPost("movieTitle");
        $movieYear = $request->getPost("movieYear");
        $movieImage = $request->getPost("movieImage");

        
        if ($doSave && $movieId) {
            $db->connect();
            $sql = "UPDATE movie SET title = ?, year = ?, image = ? WHERE id = ?;";
            $db->execute($sql, [$movieTitle, $movieYear, $movieImage, $movieId]);
            return $response->redirect("movie/library");
        } elseif ($doSave) {
            $db->connect();
            $sql = "INSERT INTO movie (title, year, image) VALUES (?, ?, ?);";
            $db->execute($sql, [$movieTitle, $movieYear, $movieImage]);
            $movieId = $db->lastInsertId();
            return $response->redirect("movie/library");
        } elseif ($doBack) {
            return $response->redirect("movie/movieSelect");
        }
    }

    // /**
    //  * This sample method dumps the content of $app.
    //  * GET mountpoint/dump-app
    //  *
    //  * @return string
    //  */
    // public function dumpAppActionGet() : string
    // {
    //     // Deal with the action and return a response.
    //     $services = implode(", ", $this->app->getServices());
    //     return __METHOD__ . "<p>\$app contains: $services";
    // }



    // /**
    //  * Add the request method to the method name to limit what request methods
    //  * the handler supports.
    //  * GET mountpoint/info
    //  *
    //  * @return string
    //  */
    // public function infoActionGet() : string
    // {
    //     // Deal with the action and return a response.
    //     return __METHOD__ . ", \$db is {$this->db}";
    // }



    // /**
    //  * This sample method action it the handler for route:
    //  * GET mountpoint/create
    //  *
    //  * @return string
    //  */
    // public function createActionGet() : string
    // {
    //     // Deal with the action and return a response.
    //     return __METHOD__ . ", \$db is {$this->db}";
    // }



    // /**
    //  * This sample method action it the handler for route:
    //  * POST mountpoint/create
    //  *
    //  * @return string
    //  */
    // public function createActionPost() : string
    // {
    //     // Deal with the action and return a response.
    //     return __METHOD__ . ", \$db is {$this->db}";
    // }



    // /**
    //  * This sample method action takes one argument:
    //  * GET mountpoint/argument/<value>
    //  *
    //  * @param mixed $value
    //  *
    //  * @return string
    //  */
    // public function argumentActionGet($value) : string
    // {
    //     // Deal with the action and return a response.
    //     return __METHOD__ . ", \$db is {$this->db}, got argument '$value'";
    // }



    // /**
    //  * This sample method action takes zero or one argument and you can use - as a separator which will then be removed:
    //  * GET mountpoint/defaultargument/
    //  * GET mountpoint/defaultargument/<value>
    //  * GET mountpoint/default-argument/
    //  * GET mountpoint/default-argument/<value>
    //  *
    //  * @param mixed $value with a default string.
    //  *
    //  * @return string
    //  */
    // public function defaultArgumentActionGet($value = "default") : string
    // {
    //     // Deal with the action and return a response.
    //     return __METHOD__ . ", \$db is {$this->db}, got argument '$value'";
    // }



    // /**
    //  * This sample method action takes two typed arguments:
    //  * GET mountpoint/typed-argument/<string>/<int>
    //  *
    //  * NOTE. Its recommended to not use int as type since it will still
    //  * accept numbers such as 2hundred givving a PHP NOTICE. So, its better to
    //  * deal with type check within the action method and throuw exceptions
    //  * when the expected type is not met.
    //  *
    //  * @param mixed $value with a default string.
    //  *
    //  * @return string
    //  */
    // public function typedArgumentActionGet(string $str, int $int) : string
    // {
    //     // Deal with the action and return a response.
    //     return __METHOD__ . ", \$db is {$this->db}, got string argument '$str' and int argument '$int'.";
    // }



    // /**
    //  * This sample method action takes a variadic list of arguments:
    //  * GET mountpoint/variadic/
    //  * GET mountpoint/variadic/<value>
    //  * GET mountpoint/variadic/<value>/<value>
    //  * GET mountpoint/variadic/<value>/<value>/<value>
    //  * etc.
    //  *
    //  * @param array $value as a variadic parameter.
    //  *
    //  * @return string
    //  */
    // public function variadicActionGet(...$value) : string
    // {
    //     // Deal with the action and return a response.
    //     return __METHOD__ . ", \$db is {$this->db}, got '" . count($value) . "' arguments: " . implode(", ", $value);
    // }



    // /**
    //  * Adding an optional catchAll() method will catch all actions sent to the
    //  * router. You can then reply with an actual response or return void to
    //  * allow for the router to move on to next handler.
    //  * A catchAll() handles the following, if a specific action method is not
    //  * created:
    //  * ANY METHOD mountpoint/**
    //  *
    //  * @param array $args as a variadic parameter.
    //  *
    //  * @return mixed
    //  *
    //  * @SuppressWarnings(PHPMD.UnusedFormalParameter)
    //  */
    // public function catchAll(...$args)
    // {
    //     // Deal with the request and send an actual response, or not.
    //     //return __METHOD__ . ", \$db is {$this->db}, got '" . count($args) . "' arguments: " . implode(", ", $args);
    //     return;
    // }
}
