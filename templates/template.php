<?php

class Template {

    protected $req;
    
    function __construct($req) {
        $this->req = $req;
    }

    public function render($txt) {
        $this->header();
        $this->body($txt);
        $this->footer();
    }

    private function header() {
        $config = $this->req->get('env')->get('trac');
        $project = $config['project'];
        $logo = $config['header_logo'];
        $url = $project['url'];
        $size = 'height="'.$logo['height'].'" width="'.$logo['width'].'"';
        
print <<<END
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <title>{$project['name']}</title>
        <link rel="stylesheet" href="{$url}assets/css/trac.css" type="text/css" />
  </head>
<body>
<div id="banner">
    <div id="header">
        <a id="logo" href="{$logo['link']}"><img src="{$logo['src']}" alt="{$logo['alt']}" {$size} /></a>
    </div>
    <form id="search" action="search" method="get">
        <div>
            <label for="proj-search">Search:</label>
            <input type="text" id="proj-search" name="q" size="18" value="" />
            <input type="submit" value="Search" />
        </div>
    </form>
    <div id="metanav" class="nav">
        <ul>
            <li class="first"><a href="{$url}login">Login</a></li>
            <li><a href="{$url}prefs">Preferences</a></li>
            <li><a href="{$url}wiki/TracGuide">Help/Guide</a></li>
            <li class="last"><a href="{$url}about">About Trac</a></li>
        </ul>
    </div>
</div>
<div id="mainnav" class="nav">
    <ul>
        <li class="first"><a href="{$url}wiki">Wiki</a></li>
        <li><a href="{$url}timeline">Timeline</a></li>
        <li><a href="{$url}roadmap">Roadmap</a></li>
        <li><a href="{$url}browser">Browse Source</a></li>
        <li><a href="{$url}report">View Tickets</a></li>
        <li class="last"><a href="{$url}search">Search</a></li>
    </ul>
</div>
END;
    }

    private function body($txt) {
        $config = $this->req->get('env')->get('trac');
        $project = $config['project'];
        $url = $project['url'];
print <<<END
<div id="main">
    <div id="ctxtnav" class="nav">
        <h2>Context Navigation</h2>
        <ul>
            <li class="first "><a href="{$url}wiki/WikiStart">Start Page</a></li>
            <li><a href="{$url}wiki/TitleIndex">Index</a></li>
            <li><a href="{$url}wiki/WikiStart?action=history">History</a></li>
            <li class="last"><a href="{$url}wiki/WikiStart?action=diff&amp;version=1">Last Change</a></li>
        </ul>
        <hr />
    </div>
    <div id="content" class="{$this->req->get('realm')}">
    {$txt}
    </div>
</div>
END;
    }

    private function footer() {
        $config = $this->req->get('env')->get('trac');
        $project = $config['project'];
        $url = $project['url'];
print <<<END
<div id="altlinks">
    <h3>Download in other formats:</h3>
    <ul>
        <li class="last first">
            <a rel="nofollow" href="{$url}wiki/WikiStart?format=txt">Plain Text</a>
        </li>
    </ul>
</div>
<div id="footer">
    <hr />
    Footer
</div>
</body>
</html>
END;
    }
}
?>
