<?php
minRole(3);

?>

<h1>Instellingen</h1>
<table>
    <th>sleutel</th>
    <th>waarde</th>
    <th>acties</th>
<?php
    $result = $mysqli->query("SELECT * FROM setting");
    while($setting = $result->fetch_object()){
 ?>   
    <tr>
        <td><?php echo $setting->key;?></td>
        <td><?php echo $setting->value;?></a></td>
        <td>
                <a href="/beheer/settings/edit/<?php echo $setting->key; ?>"><img src="/beheer/res/img/pencil90.png" alt="edit"/></a> |
                
            </td>
    </tr> 
    <?php
    }
    ?>
</table>