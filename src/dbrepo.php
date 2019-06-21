<?php

class DBRepo{

    private $connection;

    public function __construct(){
        try
        {
                $this->connection=new PDO('mysql:host=localhost;dbname=sgic-user;charset=utf8', 'root', 'manager',array(PDO::ATTR_EMULATE_PREPARES => false));
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        }
        catch(Exception $e)
        {
                die('Error : '.$e->getMessage());
        }
    }

    public function executeInsertGetLastId($query,$array_param){
        try{
            $statement = $this->connection->prepare($query);
            $statement->execute($array_param);
                 return $this->connection->lastInsertId();
            }catch(PDOException $e)
            {
            echo ( $e->getMessage());
              return null;
            }

    }

    public function executeWitAffectedrows($query,$array_param){
        try{
                
            $statement = $this->connection->prepare($query);
                if($statement->execute($array_param))
                {
                    return $statement->rowCount();
                }
            }catch(PDOException $e)
            {
                echo ( $e->getMessage());
             return null;
            }
    }

    public function getConnection(){
        return $this->connection;
    }
   
    public function executeWithMsg($success_msg,$err_msg,$query,$array_param){
		$msg=null;
            try{
                
            $statement = $this->connection->prepare($query);
                if($statement->execute($array_param))
                {
                
                if($statement->rowCount()>0){
                    writeJsonMsg($success_msg,'success');
                }else if($statement->rowCount()==0){
                    writeJsonMsg($err_msg,'err');
                }else{
                    writeJsonMsg('error occured please check','err');
                }
                
            }
            }catch(PDOException $e)
            {
                writeJsonMsg( $e->getMessage(),'err');
            }
        
    }
        
    
        
    public function ifexists($table_name,$column_name,$value){

        $sltquery="SELECT count({$column_name}) as countnum FROM {$table_name} WHERE {$column_name} = TRIM(:value)";
        return $this->existQuery($sltquery,$value);	
        }
        
    public function ifexistsLock($table_name,$column_name,$value,$lockcolum,$lockval){
        $sltquery="SELECT count({$column_name}) as countnum FROM {$table_name} WHERE {$column_name} = TRIM(:value) AND {$lockcolum} !={$lockval}";
        return $this->existQuery($sltquery,$value);	
     }
        
    public function existQuery($query,$value){
            $statement = $this->connection->prepare($query);
            $statement->execute(array(':value'=>$value));
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            if($result["countnum"]>0){
                return true;
            }else{
                return false;
            }
        }

    public function existQueryWithParam($query,$param){
            $statement = $this->connection->prepare($query);
            $statement->execute($param);
            $result = $statement->fetch(PDO::FETCH_ASSOC);
           
            if($result["countnum"]>0){
                return true;
            }else{
                return false;
            }
        }

		function getSingleResult($query,$param){
			$statement = $this->connection->prepare($query);
            $statement->execute($param);
            return $result = $statement->fetch(PDO::FETCH_ASSOC);
		}

		function fetchAllResults($query,$param){
        
            $statement = $this->connection->prepare($query);
            $statement->execute($param);
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
		
		}
}

// $db=new DBRepo();
// var_dump($db);
?>