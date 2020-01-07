<?php

// server error
error_reporting(-1);
ini_set('display_errors', 1);

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';
require 'lib/autoload.php';

$app = new \Slim\App;
$db  = new \Database\Db;

// allow cross-origin 
$app->add(function ($req, $res, $next) {
  return $next($req, $res)->withHeader('Access-Control-Allow-Origin', '*')
                          ->withHeader('Access-Control-Allow-Headers', 'Content-Type')
                          ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

/**
 * @ROUTE (/)
 */
$app->get('/', function (Request $request, Response $response, array $args) use ($db) {
  // get number articles
  $number_articles = $db->count('articles');
  // get articles
  $articles = $db->get(
    'articles', null, $request->getParams()['limit'] ?? null
  );
  return $response->withStatus(400)->withHeader("Content-Type", "application / json; charset = utf-8")->withJson(array('total' => $number_articles['count'], 'articles' => $articles));
});

/**
 * @ROUTE (api/single/{id})
 */
$app->get('/single/{id}', function (Request $request, Response $response, array $args) use ($db) {
  return $response->withJson(
    $db->get('articles', array('id' => $args['id']))
  );
});

/**
 * @ROUTE (api/create)
 */
$app->post('/create', function($request, $response, $args) use ($db) {
  $validator = new \Validation\Validator($request);
  // params validation
  $validator->set_rules(
    array(
      'name' => 'required|min:3|max:30',
      'title' => 'required|min:3|max:100',
      'text' => 'required|min:3|max:500'
    )
  );
  // run params validation
  if($validator->run() === false)
  {
    return $response->withJson($validator->validation_response('Invalid Params.'));
  }
  // get params values required to insert
  $inserted = $db->create('articles', $validator->values(array('name','title','text'))) ? true : false;
  return $response->withJson(
    $validator->response($inserted, ( $inserted ? 'Record Inserted' : 'Failed Connect To Database'))
  );
});

/**
 * @ROUTE (api/update)
 */
$app->post('/update', function (Request $request, Response $response, array $args) use ($db) {
  $validator = new \Validation\Validator($request);
  // params validation
  $validator->set_rules(
    array(
      'id' => 'integer',
      'title' => 'required|min:3|max:100',
      'text' => 'required|min:3|max:500'
    )
  );
  // run params validation
  if($validator->run() === false)
  {
    return $response->withJson($validator->validation_response('Invalid Params.'));
  }
  $updated = $db->update('articles', $validator->values(array('id')), $validator->values(array('title','text'))) ? true : false;
  return $response->withJson(
    $validator->response($updated, ( $updated ? 'Record Updated.' : 'Failed Connect To Database' ))
  );
});

/**
 * @ROUTE (api/delete)
 */
// Delete item
$app->post('/delete', function (Request $request, Response $response, array $args) use ($db) {
  $validator = new \Validation\Validator($request);
  // params validation
  $validator->set_rules(array('id' => 'integer'));
  // run params validation
  if($validator->run() === false)
  {
    return $response->withJson($validator->validation_response('Invalid Params.'));
  }
  $updated = $db->delete('articles', $validator->values(array('id'))) ? true : false;
  return $response->withJson(
    $validator->response($updated, ( $updated ? 'Record Deleted.' : 'Failed Connect To Database' ))
  );
});

$app->run();
