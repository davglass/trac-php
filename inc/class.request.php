<?php

class Request extends Base {
    protected $cfg = array(
        'args' => array(),
        'url' => 'wiki',
        'username' => 'anonymous',
        'perms' => array(),
        'realm' => '',
        'handler' => '',
        'env' => null
    );

    protected $handlers = array(
        'wiki' => 'WikiModule',
        'no' => 'NoModule'
    );
    
    function __construct($cfg) {
        parent::__construct($cfg);
        $tmp = $this->get('env')->get('trac');
        $this->set('handler', $tmp['trac']['default_handler']);
        $this->set('realm', $this->getRealm($tmp['trac']['default_handler']));
    }
    
    public function getHandler($realm) {
        return $this->handlers[$realm];
    }

    public function getRealm($handler) {
        $h = null;
        foreach ($this->handlers as $k => $v) {
            if ($v === $handler) {
                $h = $k;
            }
        }
        return $h;
    }

    protected function validate($realm, $handler) {
        $ret = false;
        if ($this->handlers[$realm]) {
            if (class_exists($handler)) {
                $ret = true;
            }
        }
        return $ret;
    }

    public function registerHandler($realm, $handler) {
        $this->handlers[$realm] = $handler;
    }

    public function respond() {
        $this->_filter();
        $handler = $this->get('handler');
        $class = new $handler(array('req' => $this));
    }

    private function _filter() {
        $url = $_SERVER['REDIRECT_URL'];
        $url = str_replace(ENV_PATH, '', $url);
        if (substr($url, -1) == '/') {
            $url = substr($url, 0, -1);
        }
        $query = $_SERVER['REDIRECT_QUERY_STRING'];
        $this->set('url', $url);
        $tmp = explode('/', $url);
        if ($tmp[0]) {
            $handler = $this->getHandler($tmp[0]);
            $realm = $tmp[0];
            if ($this->validate($realm, $handler)) {
                $this->set('realm', $realm);
                $this->set('handler', $handler);
            } else {
                $this->set('realm', 'no');
                $this->set('handler', 'NoModule');
            }
        }
        if ($query) {
            parse_str($query, $q);
            $this->set('args', $q);
        }
    }
    
}

?>
