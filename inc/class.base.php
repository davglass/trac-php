<?php
class Base {
    protected $config = array();

    function __construct($config) {
        if (!is_array($this->cfg)) {
            $this->cfg = array();
        }
        $this->setConfig($config);
    }

    protected function setConfig($cfg) {
        $config = array();
        foreach ($this->cfg as $k => $v) {
            $config[$k] = $v;
        }
        if ($cfg) {
            foreach ($cfg as $k => $v) {
                $config[$k] = $v;
            }
        }
        $this->config = $config;
    }
    
    public function get($k) {
        $item = $this->config[$k];
        if (!$item) {
            $item = null;
        }
        return $item;
    }

    public function set($k, $v) {
        $this->config[$k] = $v;
        return $v;
    }
    public function logger($title, $str='') {
        //TODO add output file.
        if (!$GLOBALS['debug']) {
            return;
        }
        $br = '<br>';
        //$br = "\n";
        $out = array();
        $out[] = '<div style="text-align:left; background-color: white; border: 1px solid black; padding: 10px; margin: 10px;">';
        $out[] = str_pad('', 100, '-+');
        $out[] = '<strong>Now</strong>: '.date('r');
        $out[] = '<strong>Class</strong>: '.get_class($this);
        if (!$str) {
            $out[] = '<strong>'.$title.'</strong>';
        } else {
            $out[] = '<strong>'.$title.'</strong>';
            $out[] = '<pre>'.print_r($str, 1).'</pre>';
        }
        $out []= str_pad('', 100, '-+');
        $out []= '</div>';

        echo(join($out, $br));
    }
}
?>
