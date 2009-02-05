<?php
//PLACEHOLDERS...

class WikiModule extends Base {
    protected $cfg = array();

    function __construct() {
        parent::__construct($cfg);
        $this->logger('WIKI_MODULE', $this);
    }    
}

class TicketModule extends Base {
    protected $cfg = array();

    function __construct() {
        parent::__construct($cfg);
        $this->logger('TICKET_MODULE', $this);
    }    
}

class NoModule extends Base {
    protected $cfg = array();

    function __construct() {
        parent::__construct($cfg);
        $this->logger('NO_MODULE', $this);
    }    
}

?>
