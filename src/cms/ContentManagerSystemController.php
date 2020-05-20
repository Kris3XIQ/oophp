<?php


namespace Kris3XIQ\CMS;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;
use \Kris3XIQ\TextFilter\MyTextFilter;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

include __DIR__."/../functions/slugify.php";
//include __DIR__."/../TextFilter/MyTextFilter.php";

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 * @SuppressWarnings(PHPMD.NPathComplexity)
 */
class ContentManagerSystemController implements AppInjectableInterface
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
        return $response->redirect("cms/posts");
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function postsActionGet() : object
    {
        $page = $this->app->page;
        $title = "Alla inlägg";
        $db = $this->app->db;

        $db->connect();
        $sql = "SELECT * FROM content;";
        $resultset = $db->executeFetchAll($sql);

        $page->add("cms/header");
        $page->add("cms/posts", [
            "resultset" => $resultset
        ]);
        return $page->render([
            "title" => $title
        ]);
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function adminActionGet() : object
    {
        $page = $this->app->page;
        $title = "Redigera Inlägg";
        $db = $this->app->db;
        $id = null;
        $doDelete = null;
        $doEdit = null;
        $db->connect();
        $sql = "SELECT * FROM content;";
        $resultset = $db->executeFetchAll($sql);

        $data = [
            "resultset" => $resultset ?? null,
            "id" => $id ?? null,
            "doEdit" => $doEdit ?? null,
            "doDelete" => $doDelete ?? null,
            "content" => $resultset
        ];
        
        $page->add("cms/header");
        $page->add("cms/admin", $data);
    
        return $page->render([
            "title" => $title
        ]);
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function adminActionPost() : object
    {
        $page = $this->app->page;
        $session = $this->app->session;
        $request = $this->app->request;
        $response = $this->app->response;
        $db = $this->app->db;
        $title = "Redigera inlägg";
        $doEdit = $request->getPost("doEdit");
        if ($doEdit) {
            $contentId = $request->getPost("doEdit");
            $db->connect();
            $sql = "SELECT * FROM content WHERE id = ?;";
            $resultset = $db->executeFetchAll($sql, [$contentId]);
            $session->set("content", $resultset[0]);
            $session->set("adminid", $contentId);
            $pretitle = $resultset[0]->title;
            $title = slugify($pretitle);
            return $response->redirect("cms/edit/{$title}");
        }

        $page->add("cms/header");
        $page->add("cms/admin", [
            "resultset" => $resultset
        ]);
        
        return $page->render([
            "title" => $title
        ]);
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @return string
     */
    public function editActionGet($slug) : object
    {
        $title = "Ändra ${slug}";
        $page = $this->app->page;
        $session = $this->app->session;
        $db = $this->app->db;

        $contentId = $session->get("adminid");
        $db->connect();
        $sql = "SELECT * FROM content WHERE id = ?;";
        $resultset = $db->executeFetchAll($sql, [$contentId]);
        if ($resultset) {
            $content = $resultset[0];
        } else {
            $db->connect();
            $contentId = $session->get("adminid");
            $sql = "SELECT * FROM content WHERE id = ?;";
            $resultset = $db->executeFetchAll($sql, [$contentId]);
            $session->delete("adminid");
            $content = $resultset[0];
            //$content = $session->get("content");
        }

        $data = [
            "content" => $content,
            "contentTitle" => $content->title,
            "contentPath" => $content->path,
            "contentSlug" => $content->slug,
            "contentData" => $content->data,
            "contentType" => $content->type,
            "contentFilter" => $content->filter,
            "contentPublish" => $content->published,
            "contentId" => $content->id
        ];

        //$page->add("cms/header");
        if (isset($_SESSION["existError"])) {
            $page->add("cms/alreadyexist");
            $session->delete("existError");
        }
        $page->add("cms/edit", $data);
        return $page->render([
            "title" => $title
        ]);
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @return string
     */
    public function editActionPost($slug) : object
    {
        $db = $this->app->db;
        $filter = new MyTextFilter();
        $response = $this->app->response;
        $request = $this->app->request;
        $session = $this->app->session;
        $title = "Ändra ${slug}";
        $doSave = $request->getPost("doSave");
        $doDelete = $request->getPost("doDelete");
        $doBack = $request->getPost("doBack");
        $params = [
            "contentTitle" => $request->getPost("contentTitle"),
            "contentPath" => $request->getPost("contentPath"),
            "contentSlug" => $request->getPost("contentSlug"),
            "contentData" => $request->getPost("contentData"),
            "contentType" => $request->getPost("contentType"),
            "contentFilter" => $request->getPost("contentFilter"),
            "contentPublish" => $request->getPost("contentPublish"),
            "contentId" => $request->getPost("contentId")
        ];

        if (isset($doSave)) {
            $db->connect();
            $sql = "SELECT slug, id FROM content;";
            $slugs = $db->executeFetchAll($sql);
            if (!$params["contentPath"]) {
                $params["contentPath"] = null;
            }
            if (!$params["contentSlug"]) {
                $params["contentSlug"] = slugify($params["contentTitle"]);
                foreach ($slugs as $s) {
                    if ($s->slug == $params["contentSlug"] && $s->id != (int)$params["contentId"]) {
                        $session->set("existError", true);
                        $session->set("title", $params["contentTitle"]);
                        $session->set("adminid", $params["contentId"]);
                        return $response->redirect("cms/edit/${slug}");
                    }
                }
            }
            if ($params["contentSlug"]) {
                foreach ($slugs as $s) {
                    if ($s->slug == $params["contentSlug"] && $s->id != $params["contentId"]) {
                        $session->set("existError", true);
                        $session->set("title", $params["contentTitle"]);
                        $session->set("adminid", $params["contentId"]);
                        return $response->redirect("cms/edit/${slug}");
                    }
                }
            }
            if ($params["contentFilter"]) {
                $text = $params["contentData"];
                $filters = explode(",", $params["contentFilter"]);
                $filteredText = $filter->parse($text, $filters);
                $params["contentData"] = $filteredText;
            }
            $db->connect();
            $sql = "UPDATE content SET title=?, path=?, slug=?, data=?, type=?, filter=?, published=? WHERE id = ?;";
            $db->execute($sql, array_values($params));
            return $response->redirect("cms/admin");
        } elseif (isset($doDelete)) {
            $db->connect();
            $sql = "UPDATE content SET deleted=NOW() WHERE id=?;";
            $db->execute($sql, [$params["contentId"]]);
            return $response->redirect("cms/admin");
        } elseif (isset($doBack)) {
            return $response->redirect("cms/admin");
        }
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function createActionGet() : object
    {
        $page = $this->app->page;
        $session = $this->app->session;
        $title = "Skapa en sida eller ett bloginlägg";

        $page->add("cms/header");
        if (isset($_SESSION["existError"])) {
            $page->add("cms/alreadyexist");
            $session->delete("existError");
        }
        $page->add("cms/create");
        return $page->render([
            "title" => $title
        ]);
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @return string
     */
    public function createActionPost() : object
    {
        $request = $this->app->request;
        $session = $this->app->session;
        $response = $this->app->response;
        $title = $request->getPost("contentTitle");
        $doCreate = $request->getPost("doCreate");
        $db = $this->app->db;
        $db->connect();
        $sql = "SELECT title FROM content";
        $titles = $db->executeFetchAll($sql);

        if (isset($doCreate)) {
            foreach ($titles as $t) {
                if ($t->title == $title) {
                    $session->set("existError", true);
                    return $response->redirect("cms/create");
                }
            }
            $db->connect();
            $sql = "INSERT INTO content (title) VALUES (?);";
            $db->execute($sql, [$title]);
            $contentId = $db->lastInsertId();
            $slug = slugify($title);
            $session->set("adminid", $contentId);
            return $response->redirect("cms/edit/${slug}");
        }
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function allpagesActionGet() : object
    {
        $page = $this->app->page;
        $title = "Alla pages i databasen";
        $db = $this->app->db;

        $db->connect();
        $sql = <<<EOD
SELECT
    *,
    CASE 
        WHEN (deleted <= NOW()) THEN "isDeleted"
        WHEN (published <= NOW()) THEN "isPublished"
        ELSE "notPublished"
    END AS status
FROM content
WHERE type=?
;
EOD;
        $resultset = $db->executeFetchAll($sql, ["page"]);

        $page->add("cms/header");
        $page->add("cms/allpages", [
            "resultset" => $resultset
        ]);
        return $page->render([
            "title" => $title
        ]);
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function pageActionGet($route) : object
    {
        $page = $this->app->page;
        $title = "Page: ${route}";
        $db = $this->app->db;
        $filter = new MyTextFilter();

        $db->connect();
        $sql = <<<EOD
SELECT
    *,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS modified_iso8601,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS modified
FROM content
WHERE
    path = ?
    AND type = ?
    AND (deleted IS NULL OR deleted > NOW())
    AND published <= NOW()
;
EOD;
        $content = $db->executeFetch($sql, [$route, "page"]);
        if ($content->filter) {
            $text = $content->data;
            $filters = explode(",", $content->filter);
            $filteredText = $filter->parse($text, $filters);
            $content->data = $filteredText;
        }
        $page->add("cms/page", [
            "content" => $content
        ]);
        return $page->render([
            "title" => $title
        ]);
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function allblogpostsActionGet() : object
    {
        $page = $this->app->page;
        $title = "Alla posts i databasen";
        $db = $this->app->db;

        $db->connect();
        $sql = <<<EOD
SELECT
    *,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
FROM content
WHERE type=?
ORDER BY published DESC
;
EOD;
        $resultset = $db->executeFetchAll($sql, ["post"]);

        $page->add("cms/header");
        $page->add("cms/allblogposts", [
            "resultset" => $resultset
        ]);
        return $page->render([
            "title" => $title
        ]);
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function blogpostActionGet($slug) : object
    {
        $page = $this->app->page;
        $title = "BlogPost: ${slug}";
        $db = $this->app->db;
        $filter = new MyTextFilter();

        $db->connect();
        $sql = <<<EOD
SELECT
    *,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
FROM content
WHERE 
    slug = ?
    AND type = ?
    AND (deleted IS NULL OR deleted > NOW())
    AND published <= NOW()
ORDER BY published DESC
;
EOD;
        $content = $db->executeFetch($sql, [$slug, "post"]);
        if (!($content)) {
            $page->add("cms/404");
        } elseif ($content->filter) {
            $text = $content->data;
            $filters = explode(",", $content->filter);
            $filteredText = $filter->parse($text, $filters);
            $content->data = $filteredText;
        }
        $page->add("cms/blogpost", [
            "content" => $content
        ]);
        return $page->render([
            "title" => $title
        ]);
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
