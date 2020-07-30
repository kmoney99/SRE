
<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

include_once(__DIR__."/partials/header.partial.php");

?>

<link rel="stylesheet" type="text/css" href="style.css">


<form method="POST">

	<label for="num">Title:
		<input type="text" id="d" name="title" />
	</label>
	
	
	<label for="num">Description:
		<input type="text" id="d" name="description" />
	</label>
	

	<label for="Status">Status:
  
		<select id="Category" name="title">
  
		<option value="Draft">Draft</option>
		<option value="Private">Private</option>
		<option value="Public">Public</option>
	
	</label>
	
	
	<input type="submit" name="created" value="Save"/>
  
		</select>


	
	
</form>

<?php

if(isset($_POST["created"])) {
    $title = "";
    $description = "";
	$visibility = "";
	$userId = "";
	$created = "";
	$modified = "";
	
    if(isset($_POST["title"]) && !empty($_POST["title"])){
        $title = $_POST["title"];
    }
	if(isset($_POST["description"]) && !empty($_POST["description"])){
        $description = $_POST["description"];
    }
	if(isset($_POST["visibility"]) && !empty($_POST["visibility"])){
        $visibility = $_POST["visibility"];
    }
	if (isset($_POST["userId"]) && !empty($_POST["userId"])){
        $userId = $_POST["userId"];
    }
	if (isset($_POST["created"]) && !empty($_POST["created"])){
        $created = $_POST["created"];
    }
	if (isset($_POST["modified"]) && !empty($_POST["modified"])){
        $modified = $_POST["modified"];
    }
    try {
        $query = file_get_contents(__DIR__ . "/sql/queries/INSERT_TABLE_SURVEY.sql");
        if(isset($query) && !empty($query)) {
			
			$sql = "Insert into SURVEY (title, description, visibility, userId, created, modified) values (:title, :description, :visibility, :userId, :created, :modified)";
			
			$stmt= execute ([":title" =>$title, ":description"=> $description, ":visibility"=>$visibility, ":userId" => $userId, ":created" =>$created, ":modified" => $modified]);
            
			$stmt = $common->getDB()->prepare($query);
            
			$result = $stmt->execute(array(
			    ":id" => $id,
                ":title" => $title,
                ":description" => $description,
				":visibility" => $visibility,
				":userId" => $userId,
                ":created" => $created,
				":modified" => $modified,
            ));
			
            $e = $stmt->errorInfo();
            if ($e[0] != "00000") {
                echo var_export($e, true);
            } else {
                if ($result) {
                    echo "Survey was sucessfully saved: " . $title;
                } else {
                    echo "Error inserting survey";
                }
            }
        }
        else{
            echo "Failed to find INSERT_TABLE_SURVEY.sql file";
        }
    }
    catch (Exception $e){
        echo $e->getMessage();
    }
}
?>	

