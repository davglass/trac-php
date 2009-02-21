<?php
class DB {
	private $dbType;
	private $oConn;
    private $env;
    private $info;

		function __construct($env) {
            $this->env = $env;
            $config = $env->get('trac');
            $this->_parseDB($config['trac']['database']);
            $this->connect();
		}
        private function _parseDB($str) {
            $data = explode(':', $str);
            $this->dbType = strtolower($data[0]);
            if ($this->dbType == 'mysql') {
                //Hackey..
                $info = Array();
                $info['user'] = str_replace('//', '', $data[1]);
                $tmp = explode('@', $data[2]);
                $info['pass'] = $tmp[0];
                $tmp = explode('/', $tmp[1]);
                $info['server'] = $tmp[0];
                $info['db'] = $tmp[1];
                $this->info = $info;
            } else {
                $this->info = array(
                    'server' => $this->env->get('path').$data[1]
                );
            }
        }
		private function connect() {
            $info = $this->info;
			if ($this->dbType == 'mysql') {
				$this->oConn = @mysql_connect($info['server'], $info['user'], $info['pass']) or die('No Connection!!');
                @mysql_select_db($info['db'], $this->oConn);
			} elseif ($this->dbType == 'sqlite') {
				$this->oConn = @sqlite_open($info['server']);
			}
            $this->info = Array();
		}
		public function query($dbSelect) {
			if ($this->dbType == 'mysql') {
                return @mysql_query($dbSelect, $this->oConn);
			}
		}
		public function fetch_object($dbObject) {
			if ($this->dbType == 'mysql') {
				return @mysql_fetch_object($dbObject);
			}
		}
		public function rows() {
			if ($this->dbType == 'mysql') {
				return @mysql_affected_rows($this->oConn);
			}
		}
		public function close() {
			if ($this->dbType == 'mysql') {
				return @mysql_close($this->oConn);
			}
		}
		public function free($cResult="") {
			if ($this->dbType == 'mysql') {
				return @mysql_free_result($cResult);
				return @pg_freeresult($cResult);
			}
		}
		public function num($cResult="") {
			if ($this->dbType == 'mysql') {
				return @mysql_num_rows($cResult);
			}
		}
		public function nextid($LinkID='') {
			if ($this->dbType == 'mysql') {
				return @mysql_insert_id($this->oConn);
			}
		}
}
?>
