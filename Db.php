<?php
class Db {
  private $db;

  public function __construct() {
      $serverName = "DESKTOP-05GSLBK\\SQLEXPRESS";
      $connectionInfo = array("Database"=>"AutoWorkShop", "UID"=>"sa", "PWD"=>"password",
          "MultipleActiveResultSets"=>true,"CharacterSet"  => 'UTF-8');
      $this->db = sqlsrv_connect($serverName, $connectionInfo);
  }

  public function getMechanics() {
    $data = [];
    $res = sqlsrv_query($this->db, "select m.code, surname, name, father_name, sl.description salary_level,
            salary from mechanics m inner join salary_levels sl on sl.code = salary_level");
    while ($row = sqlsrv_fetch_array($res)) {
      $data[] = $row;
    }
    return $data;
  }

  public function addMechanic($surname, $name, $father_name, $level, $salary) {
      sqlsrv_query($this->db,"insert into mechanics(surname, name, father_name, salary_level, salary) 
                values('$surname', '$name', '$father_name', $level, $salary)");
  }

  public function deleteMechanic($code) {
      sqlsrv_query($this->db, "delete from mechanics where code=" . $code);
  }

  public function getMechanic($code) {
    $data = [];
    $res = sqlsrv_query($this->db, "select * from mechanics where code=" . $code);

      while ($row = sqlsrv_fetch_array($res)) {
          $data[] = $row;
      }
      return $data;
  }

  public function getMostValuableMech() {
      return sqlsrv_fetch_array(sqlsrv_query($this->db, "exec MostValuableMechanic"));
  }

  public function editMechanic($code, $surname, $name, $father_name, $level, $salary) {
    sqlsrv_query($this->db,"update mechanics set surname='$surname', name='$name',
                     father_name='$father_name', salary_level=$level, salary=$salary where code=$code");
  }

    public function getInvoices(){
        $data = [];
        $sql = "select i.code, i.date, r.surname receiver_code, m.surname mechanic_code, wt.type work_code,
                p.name part_code, i.price from invoices i
                inner join recievers r on i.receiver_code = r.code
                inner join mechanics m on i.mechanic_code = m.code
                inner join work_types wt on i.work_code = wt.code
                inner join parts p on i.part_code = p.code";
        $res = sqlsrv_query($this->db, $sql);

        while ($row = sqlsrv_fetch_array($res)) {
            $data[] = $row;
        }
        return $data;
    }

    public function addInvoice($rc, $mc, $wc, $pc, $price) {
        sqlsrv_query($this->db,"exec addInvoice @rc=" . $rc . ",@mc=" . $mc . ",@wc=" . $wc .
            ",@pc=" . $pc . ",@price=" . $price);
    }

    public function deleteInvoice($code) {
        sqlsrv_query($this->db, "delete from invoices where code=" . $code);
    }

    public function getInvoice($code) {
        $data = [];
        $res = sqlsrv_query($this->db, "select * from invoices where code=" . $code);

        while ($row = sqlsrv_fetch_array($res)) {
            $data[] = $row;
        }
        return $data;
    }

    public function editInvoice($code, $rc, $mc, $wc, $pc, $price) {
        sqlsrv_query($this->db,"update invoices set receiver_code=$rc, mechanic_code=$mc,
                    work_code=$wc, part_code=$pc, price=$price where code=$code");
        sqlsrv_query($this->db, "exec updateInvoiceTime @code=" . $code);
    }

    public function getRecievers() {
        $data = [];
        $res = sqlsrv_query($this->db, "select * from recievers");
        while ($row = sqlsrv_fetch_array($res)) {
            $data[] = $row;
        }
        return $data;
    }

    public function getWorks() {
        $data = [];
        $res = sqlsrv_query($this->db, "select * from work_types");
        while ($row = sqlsrv_fetch_array($res)) {
            $data[] = $row;
        }
        return $data;
    }

    public function getParts() {
        $data = [];
        $res = sqlsrv_query($this->db, "select * from parts");
        while ($row = sqlsrv_fetch_array($res)) {
            $data[] = $row;
        }
        return $data;
    }
}