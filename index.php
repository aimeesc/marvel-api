<!DOCTYPE html>

<html>
<link rel="stylesheet" href="style.css">
<?php
    include 'marvel_api.php';
    $marvel = new marvel_api("8da8d49fc919680f0fbb7950fa352a2e", "8a1d05caa20a81a46b8cfe0e90e77aaa1522c43a", "spider-man" );    
?>

<header>
    <title> Spider-Man and the Fantastic Four </title>
</header>


<body>

<?php
        $marvel->init_main_char(); 
        //$marvel->list_story_char();

    ?>


    <div id="story">

    <?php
        $marvel->print_story(); 
         echo "<h1> ".$marvel->title ."</h1>"; 
         echo "<p> ".$marvel->description;


    ?>

    </div>

    <div id="char_container"> 
     <h2> Starring</h2>

     <?php
        $marvel->list_story_char();
    ?>
    </div>
   
    <div id="bottom">
    
    <?php echo $marvel->attribution;  ?>   
    
    </div>
    
</body>


</html>