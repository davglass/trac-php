<?php

class WikiModule extends BaseModule {
    protected $cfg = array();
    private $db = null;
    private $env = null;
    private $req = null;
    private $defaultPage = 'WikiStart';

    function __construct($cfg) {
        parent::__construct($cfg);
        $this->req = $this->get('req');
        $this->env = $this->req->get('env');
        $this->db = $this->env->db;

        $this->setDefaultPage();

        //$this->logger('Request', $this->req);
        
        $txt = $this->fetchPage($this->defaultPage);
        $this->parseTxt($txt);
        $this->render($txt);
    }

    private function setDefaultPage() {
        $url = $this->req->get('url');
        if (substr($url, 0, 5) == 'wiki/') {
            $url = substr($url, 5);
        }
        $this->defaultPage = $url;
    }

    private function preParseTxt(&$txt) {
        //Here we will attempt to fix the Trac Wiki Syntax
        $txt = str_replace("'''", "**", $txt);
        $txt = str_replace("''", "//", $txt);
        $txt = str_replace("[[BR]]", "<br/>", $txt);
    }

    public function parseTxt(&$txt) {
        $this->preParseTxt($txt);

        require_once('Text/Wiki/Creole.php');
        $rules = array(
            'Prefilter',
            'Delimiter',
            'Preformatted',
            'Tt',
            'Trim',
            'Break',
            #'Raw',
            #'Box',
            #'Footnote',
            #'Newline',
            #'Deflist',
            #'Blockquote',
            #'Newline',
            #'Url',
            'Wikilink',
            #'Image',
            'Heading',
            #'Table',
            #'Center',
            #'Horiz',
            #'Deflist',
            'List',
            #'Address',
            #'Superscript',
            #'Subscript',
            #'Underline',
            #'Paragraph',
            'Emphasis',
            'Strong',
            #'Italic',
            #'Bold',
            'Tighten'
        );


        $parser = &new Text_Wiki_Creole($rules);
        
        $txt = $parser->transform($txt, 'Xhtml');

    }
    

    public function fetchPage($name, $version='') {
        $q = $this->db->query('select * from wiki where (name = "'.$name.'") order by version asc limit 0, 1');
        if ($rs = $this->db->fetch_object($q)) {
            //$this->logger('rs', $rs);
            return $rs->text;
        }
        return false;
    }
}

?>
