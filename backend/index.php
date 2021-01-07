<?php

require('./bootstrap.php');
require('./src/utils/functions.php');

// Routing
$uri = strtolower(trim($_SERVER['REQUEST_URI'], '/'));

$isJSON = false;
$return = null;
$status = 200;

$route = substr($uri, 0, ($p = strpos($uri, '?')) === false ? strlen($uri) : $p);

if(empty($route)) $route = "admin.php";

if(file_exists($route) && $route !== basename(__FILE__)) {
    require($route);
    return;
}

switch($route) {

    case 'get-all':
        $isJSON = true;

        $page = $_GET["page"] ?? 1;
        if(!is_numeric($page) || $page < 0) {
            $status = 400;
            $return = ["message" => "page must be numeric and positive"];
            break;
        }

        $limit = $_GET["limit"] ?? 10;
        if(!is_numeric($page) || $page < 0) {
            $status = 400;
            $return = ["message" => "limit must be numeric and positive"];
            break;
        }


        $domain = $_GET["domain"] ?? null;
        if($domain) {
            $return = $app->getData()->getSubscriptionsWhereDomain($domain);
        } else {
            $return = $app->getData()->getAllSubscriptions();
        }

        $return = paginate($return, $limit, $page);
        break;

    case 'get-all-domains':

        $isJSON = true;
        $return = ["domains" => $app->getData()->getDomains()];

        break;

    case 'insert':
        $isJSON = true;

        $email = $_GET["email"] ?? null;
        if(empty($email) || $email === null) {
            $status = 400;
            $return = ["message" => "no email provided in request"];
            break;
        }

        $errors = $app->validateEmail($email);
        if(count($errors) > 0) {
            $status = 400;
            $return = ["message" => "given email failed validation", "errors" => $errors];
            break;
        }

        $app->getData()->insertNewSubscription($email);

        $return = ["message" => "ok"];

        break;
    case 'delete':
        $isJSON = true;

        $email = $_GET["email"] ?? null;
        if(empty($email) || $email === null) {
            $status = 400;
            $return = ["message" => "Email address is required"];
            break;
        }

        $app->getData()->deleteSubscription($email);

        $return = ["message" => "ok", "email" => $email];

        break;
    case 'view':

        break;
    default:
        $isJSON = true;
        $status = 404;
        $return = ["message" => "invalid route"];
        break;
}

if($isJSON) {
    header('Content-Type: application/json');
    $return = json_encode(array_merge($return, ["status" => $status]), JSON_PRETTY_PRINT);
}
http_response_code($status);

echo $return;