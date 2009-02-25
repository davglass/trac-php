<?php
class TicketModule extends BaseModule {
    protected $cfg = array();

    function __construct($cfg) {
        parent::__construct($cfg);
        //$this->logger('TICKET_MODULE', $this);
        $this->render('<h2>TICKET_MODULE</h2>');
    }    
}

class Ticket extends Base {
    protected $cfg = array();
    protected $fields = array();
    protected $diff = array();
    protected $history = array();

    function __construct($cfg) {
        parent::__construct($cfg);

        $this->db = $this->get('env')->db;
        $this->getTicket();
    }

    private function prepFields($rs = '') {
        if (!$rs) {
            $q = $this->db->query('show fields from ticket');
            if ($rs1 = $this->db->fetch_object($q)) {
                do {
                    $this->fields[$rs1->Field] = '';
                } while($rs1 = $this->db->fetch_object($q));
            }
        } else {
            foreach($rs as $k => $v) {
                $this->fields[$k] = $v;
            }
        }
    }

    private function getHistory() {
        $q = $this->db->query('select * from ticket_change where (ticket = '.$this->get('id').')');
        if ($rs = $this->db->fetch_object($q)) {
            do {
                $hist = array();
                foreach($rs as $k => $v) {
                    $hist[$k] = $v;
                }
                $this->history[] = $hist;
            } while($rs = $this->db->fetch_object($q));
        }
    }

    public function setField($name, $value) {
        if (array_key_exists($name, $this->fields)) {
            if ($value != $this->fields[$name]) {
                $this->diff[$name] = array(
                    'from' => $this->fields[$name],
                    'to' => $value
                );
                $this->fields[$name] = $value;
                $this->fields['changetime'] = mktime();
            }
        }
    }

    public function setFields($arr) {
        foreach($arr as $k => $v) {
            $this->setField($k, $v);
        }
    }

    public function save() {
        $this->logger('SAVE');
        $fields = array();
        if (sizeOf($this->fields)) {
            foreach($this->fields as $k => $v) {
                $fields[] = $k." = '".addslashes($v)."'";
            }
            $sql = 'update ticket set '.implode(', ', $fields).' where (id = '.$this->get('id').')';
            $this->db->query($sql);
            if (sizeOf($this->diff)) {
                foreach($this->diff as $k => $v) {
                    $sql = "insert into ticket_change (ticket, time, author, field, oldvalue, newvalue) values (".$this->get('id').", ".mktime().", '".$this->get('username')."', '".$k."', '".addslashes($v['from'])."', '".addslashes($v['to'])."')";
                    $this->db->query($sql);
                }
            }
        }
    }

    private function getTicket() {
        $id = (int) $this->get('id');
        if ($id) {
            $sql = "select * from ticket where (id = ".$id.")";
            $q = $this->db->query($sql);
            if ($rs = $this->db->fetch_object($q)) {
                $this->prepFields($rs);
                $this->getHistory();
                $this->logger('RS', $rs);
            }
        }
    }
}
?>
