<?php
const AUTO_INCREMENT = "auto";
$MOBILE_GATEWAY = false;

abstract class resultMode
{
    const FETCH = 'FETCH';
    const JSON   = 'JSON';
}

class DB {
    private $host = "skynet.info-quick.fr";
    private $username = "root";
    private $password = "aioli21700";
    private $db;
    private $mobile_gateway = false;

    public function __construct($database,$host = "skynet.info-quick.fr", $username = "root", $password = "aioli21700") {
        try {
            $this->host = $host;
            $this->username = $username;
            $this->password = $password;
            $this->database = $database;
            $this->db = new PDO('mysql:host='.$this->host.';dbname='.$database,$this->username,$this->password,array(
                PDO::MYSQL_ATTR_INIT_COMMAND =>'SET NAMES UTF8',
                PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
                PDO::ATTR_EMULATE_PREPARES =>true
            ));
        }
        catch(PDOException $e)
        {
            echo "Unable to connect to the database server, check your credentials or contact your administrator.";
            print($e);
            exit();
        }
    }

    private function nextID($column,$table)
    {
        $id = -1;
        $next_id = $this->query("SELECT (COALESCE(MAX(".$column."), 0) + 1) as nb FROM ".$table);
        if(property_exists($next_id,"DATA"))
        {
            $id = $next_id->DATA[0]->nb;
        }
        return $id;
    }

    public function query($sql,$mode = resultMode::FETCH,$data = array())
    {
        try {
            $req = $this->db->prepare($sql);
            $res = [];
            $req -> execute($data);
            $db = null;
            switch($mode) {
                case resultMode::FETCH :
                    $res = $req->fetchAll(PDO::FETCH_OBJ);
                    break;
                case resultMode::JSON :
                    $res = json_encode($req->fetchAll(PDO::FETCH_OBJ),JSON_PRETTY_PRINT| JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                    break;
                default :
                    $res = $req->fetchAll(PDO::FETCH_OBJ);
            }
            return (object) ["SUCCESS" => true,
                             "SQL_QUERY_STRING" =>$sql,
                             "ROWS_COUNT" => intval($req->rowCount()),
                             "DATA" =>$res
                            ];
        }
        catch(PDOException $e) {
            return (object) [
                "SUCCESS" => false,
                "SQL_QUERY_STRING" => $sql,
                "ROWS_COUNT" =>0,
                "ERROR" =>(object) ["NO" => $e->errorInfo[1],
                                    "DESCRIPTION" => $e->errorInfo[2]
                                   ]
            ];
        }
    }

    public function add($table,$data = array())
    {
        try {
            // PREPARATION DE LA REQUETE TEXTUELLE
            $sql = "INSERT INTO ".$table." (";
            // LISTAGE DES CHAMPS
            $champs ="";
            $valeurs ="";
            foreach ($data as $key => $value)
            {
                $champs = $champs.",`".$key."`";
                if($value == "auto") {
                    $valeurs = $valeurs.",'".$this->nextID($key,$table)."'";
                }
                else
                {
                    $valeurs = $valeurs.",'".addslashes($value)."'";
                }
            }
            $champs = substr($champs,1,strlen($champs)-1);
            $sql = $sql.$champs.") VALUES (";
            //Listage des valeurs
            $valeurs = substr($valeurs,1,strlen($valeurs)-1);
            $sql = $sql.$valeurs.")";
            // nettoyage des columns champs
            $f = str_replace("`", "", $champs);
            $columns = explode(",",$f);
            $req = $this->db->prepare($sql);
            $req -> execute();
            $db = null;
            return (object) [
                "SUCCESS" => true,
                "NEXT_ID" => $this->nextID($columns[0],$table),
                "SQL_QUERY_STRING" => $sql
            ];
        }
        catch( PDOException $e ) {
            return (object) [
                "SUCCESS" => false,
                "SQL_QUERY_STRING" => $sql,
                "ERROR" =>(object) ["NO" => $e->errorInfo[1],
                                    "DESCRIPTION" => $e->errorInfo[2]
                                   ]
            ];
        }
    }

    public function update($table,$data = array(),$criteres = array())
    {
        $sql = "UPDATE `".$table."` SET ";
        foreach ($data as $key => $value)
        {
            $sql = $sql.$key." = '".addslashes($value)."',";
        }
        $sql = substr($sql,0,strlen($sql)-1).((count($criteres) > 0)?" WHERE ":"");
        foreach ($criteres as $key => $value)
        {
            $sql = $sql.$key." = '".addslashes($value)."' AND ";
        }
        if(count($criteres)>0)
        {
            $sql = substr($sql,0,strlen($sql)-4);
        }
        // GESTION DES ERREURS
        try {
            $req = $this->db->prepare($sql);
            $req -> execute();
            $db = null;
            return (object) [
                "SUCCESS" => true,
                "SQL_QUERY_STRING" => $sql
            ];
        }
        catch( PDOException $e ) {
            return (object) [
                "SUCCESS" => false,
                "SQL_QUERY_STRING" => $sql,
                "ERROR" =>(object) ["NO" => $e->errorInfo[1],
                                    "DESCRIPTION" => $e->errorInfo[2]
                                   ]
            ];
        }
    }

    public function delete($table,$criteres = array())
    {
        try {
            $sql = "DELETE FROM `".$table."`".((count($criteres)>0)?" WHERE ":"");
            foreach ($criteres as $key => $value)
            {
                $sql = $sql.$key." = '".addslashes($value)."'".((count($criteres)>1)?" AND ":"");
            }
            if(count($criteres)>1)
            {
                $sql = substr($sql,0,strlen($sql)-4);
            }
            $req = $this->db->prepare($sql);
            $req -> execute();
            $db = null;
            return (object) [
                "SUCCESS" => true,
                "SQL_QUERY_STRING" => $sql
            ];
        }
        catch(PDOException $e) {
            return (object) [
                "SUCCESS" => false,
                "SQL_QUERY_STRING" => $sql,
                "ERROR" =>(object) ["NO" => $e->errorInfo[1],
                                    "DESCRIPTION" => $e->errorInfo[2]
                                   ]
            ];
        }
    }

    public function storedProcedure($nameSp,$data = array())
    {
        try {
            $lesParam = "";
            foreach($data as $uneData)
            {
                $lesParam .= (($uneData == "null" || $uneData == "NULL")?"NULL,":"'".addslashes($uneData)."',");
            }
            $lesParam = substr($lesParam,0,strlen($lesParam)-1);
            $sql = "call ".$nameSp."(".$lesParam.")";
            $req = $this->db->prepare("call ".$nameSp."(".$lesParam.")");
            $req -> execute();
            $db = null;
            $r = @$req->fetchAll(PDO::FETCH_OBJ);



            return (object) [
                "SUCCESS" => json_encode(true),
                "RESPONSE" => ((count($r) > 0)?$r:json_encode(null)),
                "SQL_SP_STRING" => $sql
            ];
        }
        catch(PDOException $e) {
            return (object) [
                "SUCCESS" => json_encode(false),
                "SQL_SP_STRING" => $sql
            ];
        }
    }

        public function storedFunction($nameFunc,$data = array())
    {
        try {
            $lesParam = "";
            foreach($data as $uneData)
            {
                $lesParam .= (($uneData == "null" || $uneData == "NULL")?"NULL,":"'".addslashes($uneData)."',");
            }
            $lesParam = substr($lesParam,0,strlen($lesParam)-1);
            $sql = "select ".$nameFunc."(".$lesParam.")";
            $req = $this->db->prepare("select ".$nameFunc."(".$lesParam.") as RESULT");
            $req -> execute();
            $db = null;
            $r = @$req->fetchAll(PDO::FETCH_OBJ);



            return (object) [
                "SUCCESS" => json_encode(true),
                "RESPONSE" => ((count($r) > 0)?$r[0]->RESULT:json_encode(null)),
                "SQL_SP_STRING" => $sql
            ];
        }
        catch(PDOException $e) {
            return (object) [
                "SUCCESS" => json_encode(false),
                "SQL_SP_STRING" => $sql
            ];
        }
    }
  }





?>
