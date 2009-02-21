<?php
//PLACEHOLDERS...

class BaseModule extends Base {
    protected $cfg = array();

    function __construct($cfg) {
        parent::__construct($cfg);
        //$this->logger('BASE_MODULE', $this);
    }    
}


class WikiModule extends BaseModule {
    protected $cfg = array();

    function __construct($cfg) {
        parent::__construct($cfg);
        $this->logger('WIKI_MODULE', $this);
    }    
}

class TicketModule extends BaseModule {
    protected $cfg = array();

    function __construct($cfg) {
        parent::__construct($cfg);
        $this->logger('TICKET_MODULE', $this);
    }    
}

class ReportModule extends BaseModule {
    protected $cfg = array();

    function __construct($cfg) {
        parent::__construct($cfg);
        $this->logger('REPORT_MODULE', $this);
    }    
}

class NoModule extends BaseModule {
    protected $cfg = array();

    function __construct($cfg) {
        parent::__construct($cfg);
        $this->logger('NO_MODULE', $this);
    }    
}

?>
