<?php
  class MySQL {
    private $con;
    function __construct ($host, $user, $pass, $db) {
      $this->con = mysql_connect($host, $user, $pass);
      if ($this->con) {
        if (!mysql_select_db($db)) {
          throw (new Exception("Invalid Database"));
        }
      } else {
        throw (new Exception("MySQL Error: Couldn't connect."));
      }
    }
    function query($q) {
      //echo($q."<br>");
      return new sqlResult(mysql_query($q,$this->con),$this->con,$q);
    }
  }
  class sqlResult {
    private $result;
    private $query;
    public $affected_rows;
    public $insert_id;
    public $error;
    function __construct($res,$con,$q = "") {
      if ($res) {
        $this->result = $res;
        $this->query = $q;
        $this->affected_rows = @mysql_affected_rows($con);
        $this->insert_id = @mysql_insert_id($con);
        $this->error = @mysql_error();
      } else {
        $this->error = @mysql_error();
        throw new Exception("Invalid Query: $q | Error: $this->error");
      }
    }
    function fetchRow() {
      return mysql_fetch_row($this->result);
    }
    function fetchArray() {
      return mysql_fetch_array($this->result);
    }
    function fetchObject() {
      return mysql_fetch_object($this->result);
    }
    function __deconstruct() {
      mysql_free_result($this->result);
    }
  }
  function sql_escape($string) {
    return mysql_real_escape_string($string);
  }    