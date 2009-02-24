<?php

class Env extends Base {
    
    protected $cfg = array(
        'path' => '/var/lib/trac/project'
    );

    protected $dirs = array(
        'conf' => 'conf',
        'attachments' => 'attachments',
        'db' => 'db',
        'log' => 'log',
    );
    
    function __construct($path) {
        $cfg = array('path' => $path);
        parent::__construct($cfg);
        $this->_init();
    }

    private function _init() {
        if (!is_dir($this->get('path'))) {
            $this->logger('Env::init', 'Invalid Path to Environment');
        }
        if (!is_dir($this->get('path').$this->dirs['conf'])) {
            $this->logger('Env::init', 'Config Dir not found');
        }
        if (!is_file($this->get('path').$this->dirs['conf'].'/trac.ini')) {
            $this->logger('Env::init', 'Config file not found');
        } else {
            $this->parse($this->get('path').$this->dirs['conf'].'/trac.ini');
        }

    }

    public function parse($file) {
        //$this->logger('parse', $file);
        $data = array();
        $str = file($file);
        $title = false;
        $section = false;
        foreach ($str as $n => $line) {
            $line = trim($line);
            if (substr($line, 0, 1) != ';') {
                if (substr($line, 0, 1) == '[') {
                    $title = str_replace(array('[', ']'), '', $line);
                    $data[$title] = array();
                } elseif ($line != '' && $title) {
                    $pos = strpos($line, '=');
                    $k = trim(substr($line, 0, $pos));
                    $v = trim(substr($line, $pos + 1));
                    $this->_augmentArg($v);
                    $data[$title][$k] = $v;
                }
            }
        }
        $this->set('trac', $data);
        //$this->logger('Parsed: '. count($data). ' records', $data);
    }

    protected function _augmentArg(&$v) {
        switch ($v) {
            case 'False':
            case 'false':
                $v = false;
                break;
            case 'True':
            case 'true':
                $v = true;
                break;
        }
    }

}

?>
