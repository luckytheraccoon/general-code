<?php

/* use DebugBar\StandardDebugBar;
  use DebugBar\DataCollector\PDO\TraceablePDO;
  use DebugBar\DataCollector\PDO\PDOCollector;
  use DebugBar\DataCollector\MyDbCollector; */

class Bootstrap {

    //objecto pdo - php data objects - definido numa global
    protected $pdo;
    //objecto pdo slave - php data objects - definido numa global
    protected $pdoSlave;
    //nome da classe que està a ser executada
    protected $className;
    //o module name é o nome da class sem a palavra Actions
    protected $moduleName;
    //objecto acl
    protected $acl;
    //variavel VARS do common config.php
    protected $vars;
    protected $varsClass;
    //id da entidade fornecedora ou compradora - vem da sessao
    protected $companyId;
    //id do user - definida numa global - vem da sessao
    protected $userId;
    //object adodb - definido numa global
    protected $adodb;
    protected $smarty;
    protected $request;
    protected $server;
    protected $action;
    protected $actionName;
    protected $appName = 'LandingPage';
    protected $defaultModule = 'default';
    protected $defaultAction;
    protected $smartyCaching;
    protected $smartyCachingLifeTime;
    protected $baseTPL;
    protected $basePopupTPL;
    protected $smartyCacheId;
    protected $language;
    protected $CLinkLanguage;
    protected $locale;
    //protected $generateTokenFiles = true;
    protected $ACCESS_GRANTER;
    protected $templateVariables;
    protected $in_prod;
    protected $userProfile;
    protected $appTemplateDir;

    protected function __construct($action = null) {
        $this->handleRequest();
        $this->loadDependencies();
        $this->defineActionToExecute($action);
        $this->presets();
        $this->executeRequestedAction();
    }

    private function loadDependencies() {
        $this->pdo = ServiceLocator::getInstance()->getService('pdoMaster');
        $this->pdoSlave = ServiceLocator::getInstance()->getService('pdoSlave');
        $this->pdo->query("set names 'utf8'");

        /* $repositoryClassName = get_class($this).'Repository';
          require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . get_parent_class($this) . DIRECTORY_SEPARATOR . $repositoryClassName .'.php';
          $this->repository = new $repositoryClassName(); */



        /* $this->StandardDebugBar = new DebugBar\StandardDebugBar();
          $this->StandardDebugBarRenderer = $this->StandardDebugBar->getJavascriptRenderer();

          $pdo = new TraceablePDO($this->pdo->getPdoObject());
          $this->StandardDebugBar->addCollector(new PDOCollector($pdo));
          $this->StandardDebugBar->addCollector(new MyDbCollector()); */
    }

    private function setLocale() {
        switch ($this->CLinkLanguage) {
            default:
            case 'pt':
                $this->locale = "pt_PT";
                break;
            case 'es':
                $this->locale = "es_ES";
                break;
            case 'en':
                $this->locale = "en_EN";
                break;
        }
    }

    private function presets() {
        global $db, $COMPANYID, $USERID, $smarty, $acl, $VARS, $env_production, $ACCESS_GRANTER;
        $this->setLocale();
        setlocale(LC_ALL, $this->locale . ".utf8");

        $this->smarty = $smarty;
        $this->acl = $acl;

        $this->ACCESS_GRANTER = $ACCESS_GRANTER;
        $this->className = get_class($this);
        $this->actionName = str_replace("Action", "", $this->action);
        $this->moduleName = str_replace("Actions", "", $this->className);
        $this->vars = $VARS;
        $this->in_prod = $env_production;

        $this->smarty->compile_check = true;
        $this->smarty->force_compile = false;

        $this->adodb = $db;

        $this->companyId = $COMPANYID;
        $this->userId = $USERID;
        if (isset($_SESSION['compraspublicas']['privilegio'])) {
            $this->userProfile = $_SESSION['compraspublicas']['privilegio'];
        }
        $this->varsClass = $this->vars['CLASS'];


        if (isset($this->smartyCachingDefault)) {
            $this->smarty->caching = $this->smartyCachingDefault;
        }

        if (isset($this->smartyCachingLifeTime) && !empty($this->smartyCachingLifeTime)) {
            $this->smarty->cache_lifetime = $this->smartyCachingLifeTime;
        } else {
            $this->smarty->cache_lifetime = 600; //seconds
        }

        $templateBasePath = dirname(__FILE__);

        $this->appTemplateDir = $templateBasePath . '/templates';
        $this->smarty->template_dir = $this->appTemplateDir;
        $this->smarty->cache_dir = $this->appTemplateDir . '/cache';
        $this->smarty->compile_dir = $this->appTemplateDir . '/compile';
        $this->baseTPL = $this->appTemplateDir . '/base.tpl';
        $this->basePopupTPL = $this->appTemplateDir . '/basePopup.tpl';


    }

    private function handleRequest() {
        $this->request = array_merge($_REQUEST, $_COOKIE);

        foreach ($this->request as $key => $value) {
            $setMethod = 'set' . ucfirst($key);
            if (method_exists($this, $setMethod)) {
                $reflection = new ReflectionMethod($this, $setMethod);
                if (!$reflection->isPrivate()) {
                    if (!$this->$setMethod($value) instanceof Bootstrap) {
                        $this->redirect("notFound");
                    }
                }
            }
        }
    }

    private function defineActionToExecute($action) {
        if ($action === null) {
            if (empty($this->defaultAction)) {
                $this->displayErrorPage();
            }
            $this->action = $this->defaultAction;
        } else {
            $this->action = $action . 'Action';
        }
    }

    private function executeRequestedAction() {
        $actionMethod = $this->action;

        if (method_exists($this, $actionMethod)) {

            $this->$actionMethod();
        } else {
            $this->smartyCacheId = $this->className . "_notFound";
            $this->displayErrorPage();
        }
    }

    private function generateTranslationFilesAction() {
        require_once($this->vars['CLASS'] . "/SmartyTools.php");
        $smartyTools = new SmartyTools();
        $smartyTools->object = $this->smarty->language;
        $smartyTools->language = $this->CLinkLanguage;
        $smartyTools->generateTranslationFiles();
    }

    protected function displayPage($forcedPage = null) {

        if (!$this->smartyCacheId) {
            $this->smartyCacheId = $this->className . "_" . $this->action;
        }

        if (isset($_SESSION['flashMessage'])) {
            $this->templateVariables["flashMessage"] = $_SESSION['flashMessage'];
            unset($_SESSION['flashMessage']);
        }

        $this->templateVariables["className"] = $this->className;

        if ($forcedPage == null) {
            if (isset($this->title)) {
                $this->templateVariables["title"] = $this->title;
            } else {
                //$this->smarty->assign("title", smartyTranslate(strtoupper($this->className."_".$this->action)));
            }
            $this->templateVariables["template"] = "../modules/$this->moduleName/templates/$this->action.tpl";
        } else {
            //$this->smarty->assign("title", smartyTranslate(strtoupper($forcedPage['title'])));

            if (isset($forcedPage['templateFileName'])) {
                $templateFileName = $forcedPage['templateFileName'];
                $this->templateVariables["template"] = "../modules/$this->moduleName/templates/$templateFileName.tpl";
            }

            if (isset($forcedPage['baseTemplateFileName'])) {
                $templateFileName = $forcedPage['baseTemplateFileName'];
                $this->templateVariables["template"] = "$templateFileName.tpl";
            }
        }

        $this->smarty->bootstrap = $this;

        $this->assignTemplateVariables($this->templateVariables);

        $this->smarty->display($this->baseTPL, null, $this->smartyCacheId);
    }

    protected function displayPopup($forcedPage = null) {
        $this->baseTPL = $this->basePopupTPL;
        $this->displayPage($forcedPage);
    }

    public function displayErrorPage() {
        $this->displayPage(array("title" => "NOTFOUND", "baseTemplateFileName" => "notFound"));
    }

    public function isThisTplCached() {
        if ($this->smarty->is_cached($this->baseTPL, $this->smartyCacheId)) {
            return true;
        } else {
            return false;
        }
    }

    protected function setLanguage($language) {
        if (isset($language)) {
            $this->language = $language;
        }
        return $this;
    }

    protected function setCLinkLanguage($CLinkLanguage) {
        if (isset($CLinkLanguage)) {
            $this->CLinkLanguage = $CLinkLanguage;
        }
        return $this;
    }

    public function changeLanguageAction() {
        $this->smarty->language->setCurrentLocale($this->language);

        $urlInfo = parse_url($_SERVER['HTTP_REFERER']);

        if (!isset($urlInfo['path'])) {
            $location = $this->vars['PROTOCOL'] . $_SERVER['SERVER_NAME'];
        } else {
            if (!isset($urlInfo['query'])) {
                $location = $this->vars['PROTOCOL'] . $_SERVER['SERVER_NAME'] . $urlInfo['path'];
            } else {
                $location = $this->vars['PROTOCOL'] . $_SERVER['SERVER_NAME'] . $urlInfo['path'] . '?' . $urlInfo['query'];
            }
        }
        header("Location:" . $location);
    }

    public function notFoundAction() {
        $this->displayErrorPage();
    }

    protected function assignTemplateVariables() {
        if (!empty($this->templateVariables)) {
            foreach ($this->templateVariables as $key => $val) {
                $this->smarty->assign($key, $val);
            }
        }
    }

    protected function setFlashMessage($msg) {
        if (isset($msg)) {
            $_SESSION['flashMessage'] = $msg;
        }
    }

    public function linkTo($parts) {

        if (!is_array($parts)) {
            $allParts = explode("/:", $parts);
            $parts = explode("/", ($allParts[0]));
        }

        if (count($parts) == 2) {
            $parts[2] = $parts[1];
            $parts[1] = $parts[0];
            $parts[0] = $this->appName;
        }

        if (count($parts) == 1 && !empty($parts[0])) {
            $parts[2] = $parts[0];
            $parts[1] = $this->moduleName;
            $parts[0] = $this->appName;
        }

        if (count($parts) == 1 && empty($parts[0])) {
            $parts[2] = $this->actionName;
            $parts[1] = $this->moduleName;
            $parts[0] = $this->appName;
        }
        
        if (isset($allParts)) {
            unset($allParts[0]);
            foreach ($allParts as $part) {
                $params = explode("/", $part);
                $parts[$params[0]] = $params[1];
            }
        }
        
        $url = "?app=" . $parts[0] . "&module=" . $parts[1] . "&action=" . $parts[2];

        unset($parts[0]);
        unset($parts[1]);
        unset($parts[2]);

        if (count($parts) > 0) {
            $params = "";
            foreach ($parts as $key => $val) {
                $params .= "&" . $key . "=" . $val;
            }
            $url .= $params;
        }
        return $url;
    }

    protected function redirect($parts, $msg = null) {
        $url = $this->linkTo($parts);
        $this->setFlashMessage($msg);
        header("Location: $url");
        exit();
    }

}
