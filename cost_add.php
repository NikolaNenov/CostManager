<a href="index.php">Списък</a>
<br></br>

<?php
mb_internal_encoding('UTF-8');
//echo '<pre>'.print_r($_POST, true).'</pre>';

$today = date("m.d.Y");
$pageTitle='Добави разход';


include 'includes/header.php';

if($_POST){
    $date = $_POST['date'];
    $name = trim($_POST['name']);
    $name = str_replace('!','', $name);
    $price = trim($_POST['price']);
    $selectedType = (int)$_POST['type'];
    $error=false;

    if(mb_strlen($name)<4 || mb_strlen($name)>30){
        echo '<p style="color:red;"> Дължината на името трябва да е от 4 до 30 символа!</p>';
        $error=true;
    }

    if(!is_numeric($price) || ($price < 0)){
        echo '<p style="color:red;">Невалидна сума!</p>';
        $error=true;
    }
      
    if(!array_key_exists($selectedType, $types)){
        echo '<p style="color:red;">Невалиден вид на разхода!</p>';
        $error=true;
    }
    
     if(!$error){
        $result = $date.'|*|'.$name.'|*|'.round($price,2).'|*|'.$selectedType."\n";
        if(file_put_contents('data.txt', $result,FILE_APPEND))
        {
            echo '<p style="color:green;">Разхода е добавен.</p>';
        }
    }
        
}
?>


<form method="POST">
    <div><input type="hidden" name="date" value="<?php echo $today; ?>"/></div>
    <div>Име:<input type="text" name="name"/></div>
    <div>Сума:<input type="text" name="price"/></div>
    <div>Вид:
        <select name="type">
            <?php
            foreach($types as $key=>$value){
                echo '<option value="'.$key.'">'.$value.'</option>';
            }
            ?>
        
        </select>
    
    </div>
    <div><input type="submit" value="Добави"/></div>
</form>


<?php
include 'includes/footer.php';
?>