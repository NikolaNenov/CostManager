<?php
$pageTitle='Списък';
$sum=0;
function printTable($sum, $columns, $types){
     echo '<tr>
              <td>'.$columns[0].'</td>
              <td>'.$columns[1].'</td>
              <td>'.$columns[2].'</td>
              <td>'.$types[trim($columns[3])].'</td>    
           </tr>';
    return $sum;
    }

include 'includes/header.php';
//print_r($_POST);


?>
<a href="cost_add.php">Добави разход</a>

<form  method="POST" >
    
     <select name="selected_date">
        <option value="0">Всички</option>
        <?php
              if(file_exists('data.txt'))
                {
                    $result=  file('data.txt');           
                    foreach ($result as $value) 
                        {
                        $columns =  explode('|*|', $value);
                        
                        if($columns[0] !== $dates)
                            {
                            echo '<option>'.$columns[0].'</option>';
                            $dates = $columns[0];
                            }
                        }
                }
         ?> 
     </select>
    
    
    <select name="selected_type">
        <option value="0">Всички</option>
        <?php
        foreach($types as $key=>$value){
            echo '<option value="'.$key.'">'.$value.'</option>';
        }
        ?>
    </select>
    <input type="submit" value="Филтрирай">
</form>

<br></br>

<table border="1">
    <tr>
        <td>Дата</td>
        <td>Име</td>
        <td>Сума</td>
        <td>Вид</td>
    </tr>
 
<?php

 if(file_exists('data.txt'))
    {
        $result=  file('data.txt');           
        foreach ($result as $value) 
        {
            $columns=  explode('|*|', $value);
            
            if(!$_POST)
            {
                $sum=$sum+$columns[2];
                printTable($sum, $columns, $types);
            }
            
            else
                 {            
                 if($_POST['selected_type'] == 0)
                    {
                     
                     if($_POST['selected_date'] == 0)
                        {  
                          $sum=$sum+$columns[2];
                          printTable($sum, $columns, $types);
                        }
                        else 
                            {
                            if(trim($columns[0]) == $_POST['selected_date'])
                                {
                                  $sum=$sum+$columns[2];
                                  printTable($sum, $columns, $types);
                                }
                            }
                    }
                                                   
                  if(trim($columns[3]) == $_POST['selected_type'])
                    {                  
                     
                       if($_POST['selected_date'] == 0)
                            {
                                $sum=$sum+$columns[2];
                                printTable($sum, $columns, $types);
                            }
                             else 
                                {
                                 if(trim($columns[0]) == $_POST['selected_date'])
                                      {
                                        $sum=$sum+$columns[2];
                                        printTable($sum, $columns, $types);
                                      }
                                }                     
                    }                             
               }
         }            
    }      
         echo '<tr>
                   <td>---</td>
                   <td><b>Общо:</b></td>
                   <td><b>'.$sum.'</b></td>
                   <td>---</td>
                   </tr>';

include 'includes/footer.php';
?>