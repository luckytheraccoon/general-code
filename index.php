<?php

$loader = require('vendor/autoload.php');

require_once 'common/common.php';
require_once $VARS['PATH'] . '/common/authenticate.php';
require_once $VARS['PATH'] . '/common/dbSession.class.php';

$ngLanguage = new ngLanguage();
$locale = $ngLanguage->getCurrentLocale();

new dbSession();

//this is so old links will still work:
$validOldLinks = array("inscricaoFornecedor", "showConcursosPublicos","erroFornecedor", "erroComprador");
if(isset($_REQUEST['a']) && in_array($_REQUEST['a'], $validOldLinks)) {
    header("Location:?action=".$_REQUEST['a']);
}
if(isset($_REQUEST['accao']) && in_array($_REQUEST['accao'], $validOldLinks)) {
    header("Location:?action=sessionExpired");
}
if(isset($_REQUEST['auth']) && $_REQUEST['auth'] == "1") {
    header("Location:?action=login");
}

$validApps = array("LandingPage");

//refatorizacao desejada - usar desta forma daqui para diante...
$defaultApp = 'LandingPage';
$app = isset($_REQUEST['app']) ? $_REQUEST['app'] : $defaultApp;
$module = isset($_REQUEST['module']) ? $_REQUEST['module'] : 'default';
$action = isset($_REQUEST['action']) && $_REQUEST['action'] != "" ? $_REQUEST['action'] : null;


try {
    
    $appPath = "apps/$app/";
    $modulePath = $appPath . "modules/$module/";
    
    if (!in_array($app, $validApps)) {
        throw new Exception("Provided app was not found.");
    }
    
    if (!@include_once($appPath . "bootstrap.php")) {
        throw new Exception("Failed to bootstrap.");
    }
    
    if (!@include_once($modulePath . "actions.php")) {
        throw new Exception("Failed to init module.");
    }
    
    $module = $module . "Actions";
    new $module($action);
    
} catch (Exception $ex) {
    include_once("apps/$defaultApp/bootstrap.php");
    include_once("apps/$defaultApp/modules/default/actions.php");
    $action = 'notFound';
    $x = new defaultActions($action);
}





/*use DebugBar\StandardDebugBar;

$debugbar = new StandardDebugBar();
$debugbarRenderer = $debugbar->getJavascriptRenderer();

$debugbar["messages"]->addMessage("hello world!");

<html>
    <head>
        <?php echo $debugbarRenderer->renderHead() ?>
    </head>
    <body>
        <?php echo $debugbarRenderer->render() ?>
    </body>
</html>
 * 
*/


