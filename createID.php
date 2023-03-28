<?php
header('Content-Type: application/json');

include_once 'classes/autoload.php';
$db = new Database();

function straRandom($len){
    $res = '';
    $a = array_merge(range('a', 'z'), range('A', 'Z'), range(0, 9));
    shuffle($a);
    if ($len > 0 && $len < count($a)) {
        for ($i = 0; $i < $len; $i++) {
            $res .= $a[rand(0, $len - 1)];
        }
    }
    return $res;
}
$db->connect();
$qtk="SELECT token FROM security ";

$res = mysqli_query($db->connID, $qtk);
$row = mysqli_fetch_assoc($res);	
if (!empty($_GET["token"])) {
		$row['token'] = $_GET["token"];
	}
//echo $row['token'];   


		
    if(isset($_GET['tkn'])){
        $tkn=$_GET['tkn'];
        if (isset($_GET['r']) && isset($_GET['id']) ) {
        $id=$_GET['id'];
        $r=$_GET['r'];
        for ($i=$id; $i <=$id+$r ; $i++) { 
   
            $clientID = $i;
            $token = straRandom(20);
            $username = "user".$clientID;

            $tableName = "id_" . $clientID;

        if($row['token'] == $tkn ) {
            
        


        $findTable = $db->conn->query("SHOW TABLES LIKE $tableName ");
        if ($findTable) {
            echo json_encode(array('status' => 'The entered ID is duplicate'));
        } else {
            $createTable = $db->conn->query("CREATE TABLE " . $tableName . "(
        ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        clientID VARCHAR(255) NOT NULL,
        ip VARCHAR(255),
        ina INT DEFAULT 0,
        inb INT DEFAULT 0,
        inc INT DEFAULT 0,
        ind INT DEFAULT 0,
        ine INT DEFAULT 0,
        inf INT DEFAULT 0,
        ing INT DEFAULT 0,
        inh INT DEFAULT 0,
        sena VARCHAR(4) DEFAULT 'off',
        senb VARCHAR(4) DEFAULT 'off',
        senc VARCHAR(4) DEFAULT 'off',
        send VARCHAR(4) DEFAULT 'off',
        sene VARCHAR(4) DEFAULT 'off',
        senf VARCHAR(4) DEFAULT 'off',
        seng VARCHAR(4) DEFAULT 'off',
        senh VARCHAR(4) DEFAULT 'off',
        timestamp INT ,
        time_date timestamp DEFAULT CURRENT_TIMESTAMP)");
            if ($createTable) {
                $craeteUser = $db->conn->query("INSERT INTO `user`(`clientID`, `username`, `token`) VALUES ('$clientID','$username','$token')");

                if ($craeteUser) {
                } else {
                    echo json_encode(array('status' => 'User not created'));
                }
            } else {
                echo json_encode(array("status" => 'Failed to create table'));
            }
        }


    
     }else {
        echo json_encode(array('status' => 'token is invalid'));
    }
    }
        }
        
        
    else{
        echo json_encode(array('status' => 'The requested information was not entered correctly '));
    }
	
    }

    else{
    
        echo json_encode(array('status' => 'please enter token '));
    }

$db->connID->close();
$db->conn->close();
?>