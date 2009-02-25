<?php
//PLACEHOLDERS...

class BaseModule extends Base {
    protected $cfg = array();

    function __construct($cfg) {
        parent::__construct($cfg);
        //$this->logger('BASE_MODULE', $this);
    }

    public function render($txt) {
        include('./templates/template.php');
        $template = new Template($this->get('req'));
        $template->render($txt);
    }
}

class ReportModule extends BaseModule {
    protected $cfg = array();

    function __construct($cfg) {
        parent::__construct($cfg);
        //$this->logger('REPORT_MODULE', $this);
        $this->render('<h2>REPORT_MODULE</h2>');
    }    
}

class TimelineModule extends BaseModule {
    protected $cfg = array();

    function __construct($cfg) {
        parent::__construct($cfg);
        $this->render('<h2>TIMELINE_MODULE</h2>');
    }    
}

class RoadmapModule extends BaseModule {
    protected $cfg = array();

    function __construct($cfg) {
        parent::__construct($cfg);
        $this->render('<h2>ROADMAP_MODULE</h2>');
    }    
}

class BrowserModule extends BaseModule {
    protected $cfg = array();

    function __construct($cfg) {
        parent::__construct($cfg);
        $this->render('<h2>BROWSER_MODULE</h2>');
    }    
}

class LoginModule extends BaseModule {
    protected $cfg = array();

    function __construct($cfg) {
        parent::__construct($cfg);
        $this->render('<h2>LOGIN_MODULE</h2>');
    }    
}

class PrefsModule extends BaseModule {
    protected $cfg = array();

    function __construct($cfg) {
        parent::__construct($cfg);
        $this->render('<h2>PREFS_MODULE</h2>');
    }    
}

class SearchModule extends BaseModule {
    protected $cfg = array();

    function __construct($cfg) {
        parent::__construct($cfg);
        $this->render('<h2>SEARCH_MODULE</h2>');
    }    
}

class NoModule extends BaseModule {
    protected $cfg = array();

    function __construct($cfg) {
        parent::__construct($cfg);
        $this->render('<h2>Error: Not Found</h2><p>No handler matched request to /'.$this->get('req')->get('url').'</p>');
    }    
}

?>
