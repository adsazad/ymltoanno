<?php

require_once './vendor/autoload.php';

global $routingRootPath;
global $controllerRootPath;
global $newControllerRootPath;
global $resourceArray;
global $routes;

$routingRootPath = 'res/routings/';
$controllerRootPath = 'res/controllers/';
$newControllerRootPath = 'res/newControllers/';
$resourceArray = array();
$routes = array();

echo '<pre>';
ini_set('display_errors', 1);
$mainRoutingPath = $routingRootPath . 'routing.yml';
$mainRouting = \Symfony\Component\Yaml\Yaml::parseFile($mainRoutingPath);
foreach ($mainRouting as $k => $m) {
    if (isset($m['resource'])) {
        $array = array(
            'name' => $k,
            'prefix' => $m['prefix'],
            'resource' => $m['resource'],
        );
        $resourceArray[] = $array;
    }
    if (isset($m['path'])) {
        $array = array(
            'name' => $k,
            'prefix' => '/',
            'path' => $m['path'],
        );
        if (isset($m['defaults'])) {
            $array['controller'] = $m['defaults']['_controller'];
        }
        if (isset($m['methods'])) {
            $array['methods'] = $m['methods'];
        }
        $routes[] = $array;
    }
}

foreach ($resourceArray as $r) {
    $resource = $r['resource'];
    $ymlPath = $routingRootPath . str_replace('@AppBundle/Resources/config/', '', $resource);
    $innerArray = \Symfony\Component\Yaml\Yaml::parseFile($ymlPath);
    foreach ($innerArray as $k => $m) {

        if (isset($m['resource'])) {
            $array = array(
                'name' => $k,
                'prefix' => $r['prefix'],
                'resource' => $m['resource'],
            );
            getFromResource($array);
        }
        if (isset($m['path'])) {
            $array = array(
                'name' => $k,
                'prefix' => $r['prefix'],
                'path' => $m['path'],
            );
            if (isset($m['defaults'])) {
                $array['controller'] = $m['defaults']['_controller'];
            }
            if (isset($m['methods'])) {
                $array['methods'] = $m['methods'];
            }
            $routes[] = $array;
        }
    }
//    print_r($innerArray);
//    die;
}
//print_r($resourceArray);
//print_r($routes);


//  Making Function part

foreach ($routes as $r) {
    if (isset($r['controller'])) {
        $controller = $r['controller'];
        $controllerArray = explode(':', $controller);
//        print_r($controllerArray);
        $actionName = $controllerArray[2] . 'Action';
        $controllerPathOld = $controllerRootPath . $controllerArray[1] . 'Controller.php';
        $controllerPathNew = $newControllerRootPath . $controllerArray[1] . 'Controller.php';
        if (!file_exists($controllerPathNew)) {
            $controllerData = file_get_contents($controllerPathOld);
            $file = fopen($controllerPathNew, 'w') or die('no');
            fwrite($file, $controllerData);
            fclose($file);
        }
        $controllerData = file_get_contents($controllerPathNew) or die('no');
        $replace = array(
            'AppBundle' => 'App',
        );
        $controllerData = strtr($controllerData, $replace);
        $anno = trim(ytoa($r));
//        die;
        $controllerData = str_replace('public function ' . $actionName, $anno . chr(13) . 'public function ' . $actionName, $controllerData);
        file_put_contents($controllerPathNew, $controllerData);
//        die;
//        die;
//        die;
        //        print_r($controllerArray);
//        print_r($r
    }
}

function ytoa($array) {
//    print_r($array);
//    die;
    $ann = chr(13);
    $ann .= "/**\n";
    $route = '* @Route("' . $array['prefix'] . $array['path'] . '", name="' . $array['name'] . '"';
    if (isset($array['methods'])) {
        if (is_array($array['methods'])) {
            $route .= ', methods={"';
            $route .= implode('","', $array['methods']);
            $route .= '"}';
        } else {
            $route .= ', methods="';
            $route .= $array['methods'];
            $route .= '"';
        }
    }
    if (isset($array['options'])) {
        if (isset($array['options']['expose'])) {
            $route .= ',options={"expose"=true}';
        }
    }
    $route .= ')' . "\n";
    $ann .= $route;
    $ann .= "*/" . "\n";
    $ann .= "\n";

    return trim($ann);
}

function getFromResource($array) {
    $resource = $array['resource'];
    $ymlPath = 'res/routings/' . str_replace('@AppBundle/Resources/config/', '', $resource);
    $innerArray = \Symfony\Component\Yaml\Yaml::parseFile($ymlPath);
    foreach ($innerArray as $k => $m) {
        if (isset($m['resource'])) {
            $array = array(
                'name' => $k,
                'prefix' => $m['prefix'],
                'resource' => $m['resource'],
            );
            getFromResource($array);
        }
        if (isset($m['path'])) {
            $array = array(
                'name' => $k,
                'prefix' => '/',
                'path' => $m['path'],
            );
            if (isset($m['defaults'])) {
                $array['controller'] = $m['defaults']['_controller'];
            }
            if (isset($m['methods'])) {
                $array['methods'] = $m['methods'];
            }
            $GLOBALS['routes'][] = $array;
        }
    }
}


