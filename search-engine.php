<!DOCTYPE html>
<html>
    <head>
        <title>BazaaR</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon and Touch Icons -->
        <link href="ABC.png" rel="shortcut icon" type="image/png">
        <link href="ABC.png" rel="apple-touch-icon" sizes="57x57">
        <link href="ABC.png" rel="apple-touch-icon" sizes="72x72">
        <link href="ABC.png" rel="apple-touch-icon" sizes="114x114">
        <link href="ABC.png" rel="apple-touch-icon" sizes="144x144">

    <!---- Link CSS for bootstrap ------->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/fontawesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    </head>
    <body>
<?php
    $servername = "localhost";
    $username = "root";
    $password = "";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=bazaar", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
               
        $input = strtolower($_POST['search-input']); 
        $inputLen=strlen($input);
        
        $getSelectedItems = $conn->prepare("SELECT * FROM items WHERE item_name LIKE '{$input}%' OR item_ram LIKE '%{$input}%' OR item_storage LIKE '%{$input}%' OR item_battery LIKE '{$input}%' OR item_resolution LIKE '%{$input}%'");
        $getSelectedItems->execute();
        $selectedItem = $getSelectedItems->fetch(PDO::FETCH_ASSOC);
        $selectedItems = $getSelectedItems->fetchAll(PDO::FETCH_ASSOC);
        
        $getAllItems = $conn->prepare("SELECT * FROM items");
        $getAllItems->execute();
        $allitems = $getAllItems->fetchAll(PDO::FETCH_ASSOC);
        
//        $countItems = $conn->prepare("SELECT COUNT(item_id) AS number-of-items FROM items");
//        $countItems->execute();
//        $numberOfItems = $countItems->fetch(PDO::FETCH_ASSOC);
                echo '<div id="results" class="card-columns col-md-10 col-sm-12">
                        <div class="container-fluid col-sm-12">';
        if ($input !== "") {
            foreach($selectedItems as $row => $value){
                
                echo       '<div class="card">
                            <a href="#"><img class="card-img-top results-item" src="'.$value['item_image'].'"></a>
                            <div class="card-body">
                            <h4 class="card-title text-center">'.$value['item_name'].'</h4>
                            <a href="#" class="card-link"><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9734;</span></a>
                            <p class="card-text">
                            <b>- ram: </b>'.$value['item_ram'].'<br>
                            <b>- resolution: </b>'.$value['item_resolution'].'<br>
                            <b>- battarey: </b>'.$value['item_battery'].'<br>
                            <b>- storage: </b>'.$value['item_storage'].'</p>
                            </div>
                            </div>';                        
                }
            $getAllItems->execute();
        }else {
            
        }
                echo '</dive>
                      </div>';
    }
    catch(PDOException $e){
        echo "Connection failed: " . $e->getMessage();
    }
?>
    </body>
</html>