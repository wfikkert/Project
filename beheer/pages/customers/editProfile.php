<?php
    minRole(2);
    $id = user_data('id');
    
    $name = "";
    $surname = "";
    $address = "";
    $email = "";
    $zipcode = "";
    $city = "";
    $telephone = "";
    $result = $mysqli->query('SELECT * FROM user WHERE id = '.$id);

  

    while($row = $result->fetch_array()){
        $name = $row['name'];
        $surname = $row['surname'];
        $address = $row['address'];
        $zipcode = $row['zipcode'];
        $city = $row['city'];
        $email = $row['email'];
        $telephone = $row['telephone'];
    }

    $value_email = set_value('email', $email);
    $value_naam = set_value('name', $name);
    $value_achternaam = set_value('surname', $surname);
    $value_adres = set_value('address', $address);
    $value_postcode = set_value('zipcode', $zipcode);
    $value_woonplaats = set_value('city', $city);
    $value_telnr = set_value('telephone', $telephone);
    
    if(isset($_POST['form_submit'])){
        foreach($_POST as $arrayName => $value){
            if($arrayName == "form_submit") continue;
            if(empty($value)){
                $value = set_value($arrayName, $name);
            }else{
                $mysqli->query('UPDATE user SET '.$arrayName.' = "'.$value.'" WHERE id = '.$id);
                if($mysqli->error) die ($mysqli->error);
            }
        }
        redirect('/beheer/customers/editProfile');
    }
	
	if(isset($_POST['wachtwoord_submit'])){
		if(sha1($_POST['huidig_wachtwoord'])== user_data('password')){
			if($_POST['nieuw_wachtwoord']!= $_POST['Bevestig_wachtwoord']){
				$error= "De nieuwe wachtwoorden zijn niet gelijk";
		}else{
			if($mysqli->error){
				echo $mysqli->error;
			}
			$mysqli->query('UPDATE user SET password = "'.sha1(post('nieuw_wachtwoord')).'" WHERE id = '.$id);
			setMessage("Uw wachtwoord is succesvol gewijzigd");
			redirect('/beheer/customers/editProfile');
			
		}
	}else{
		$error= "Uw huidige wachtwoord is niet correct ingevoerd";
	}
}

	
?>


<a href="/beheer/dashboard" class="button">Terug naar overzicht</a>
<h1>Wijzigen van <?php echo $name. ' '. $surname;?></h1>
<?php
	if(isset($error)) {
    echo '<div class="alert-error">' . @$error . '</div>';
	}
?>
<section class="half">
    <form method="POST">
        <label>Naam:</label> <input type="text" name="name" value="<?php echo $value_naam;?>"/><br />
        <label>Achternaam:</label> <input type="text" name="surname" value="<?php echo $value_achternaam;?>"/><br />
        <label>Adres:</label> <input type="text" name="address" value="<?php echo $value_adres;?>"/><br />
        <label>Postcode:</label><input type="text" name="zipcode" value="<?php echo $value_postcode;?>"/><br />
        <label>Woonplaats:</label><input type="text" name="city" value="<?php echo $value_woonplaats;?>"/><br />
        <label>Telefoonnummer:</label><input type="text" name="telephone" value="<?php echo $value_telnr;?>"/><br />
        <label>Email:</label><input type="text" name="email" value="<?php echo $value_email;?>"/> <br /><br/>
        <input type="submit" name="form_submit" value="Wijzig"/> <br/>

    </form>
</section>

<section class="half">
    <form method="POST">
        <label>Huidig wachtwoord:</label><input type="password" name="huidig_wachtwoord"/>
        <label>Nieuw wachtwoord:</label><input type="password" name="nieuw_wachtwoord"/>
        <label>Bevestig nieuw wachtwoord:</label><input type="password" name="Bevestig_wachtwoord"/><br/><br/>
        <input type="submit" name="wachtwoord_submit" value="Wijzig wachtwoord"/>
    </form>
</section>