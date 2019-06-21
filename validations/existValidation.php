<?php
function ifNotexists($connect,$table_name,$column_name,$value){

$sltquery="SELECT count({$column_name}) as countnum FROM {$table_name} WHERE {$column_name} = TRIM(:value)";
return existQuery($connect,$sltquery,$value);	
}

function ifNotexistsLock($connect,$table_name,$column_name,$value,$lockcolum,$lockval){
$sltquery="SELECT count({$column_name}) as countnum FROM {$table_name} WHERE {$column_name} = TRIM(:value) AND {$lockcolum} !={$lockval}";
return existQuery($connect,$sltquery,$value);	
}

function existQuery($connect,$query,$value){
	$statement = $connect->prepare($query);
	$statement->execute(array(':value'=>$value));
	$result = $statement->fetch(PDO::FETCH_ASSOC);
	if($result["countnum"]>0){
		
		return false;
	}else{
		return true;
	}
}
?>