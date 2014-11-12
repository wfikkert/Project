<?php
    
    minRole(3);
    /**
     * @param Het klant ID
     * @return Geeft het project van de klant terug
     */
    $id = urlSegment(3);
    $result = ""; 
    function getProject($id){
        global $mysqli;
        $result = $mysqli->query('SELECT title FROM project WHERE uid = '. $id. '');
        if(!$result || $result->num_rows < 1) return 40334;
        return $result;        
    }
    
    /**
     * @param Het idee van de klant
     * @return ID van het gekoppelde project
     */ 
    function getProjectById($id){
        global $mysqli;
        if(isKlantId($id)){
            return $mysqli->query('SELECT id FROM project WHERE uid = '. $id);
        }
    }
    /**
     *  @param Het klant ID
     *  @return Naam en achternaam van de klant
     */ 
    function getName($id){
        global $mysqli;
        if(isKlantId($id)){
            return $mysqli->query('SELECT name, surname FROM user WHERE id = '. $id. '')->fetch_object()->name;
        }
    }
    /**
     *  @param Het ID van de klant
     *  @return true als de klant bestaat
     */ 
    function isKlantId($id){
        global $mysqli;
        $result = $mysqli->query('SELECT id FROM user WHERE id = '. $id);
        if(!$result || $result->num_rows < 1) return false;
        return true; 
    }
    /**
     *  @param Het ID van het project
     *  @return true als het project bestaat
     */
    function isProjectId($projectId){
        global $mysqli;
        $result = $mysqli->query('SELECT id FROM project WHERE id = '. $projectId);
        if(!$result || $mysqli->numRows() < 1) return false;
        return true;
    }
    /**
     *  @param Het klant ID
     *  @return void
     */ 
    function removeUser($id, $clearData){
        global $mysqli;
        if(!isKlantId($id)) return 43334;
        $mysqli->query('DELETE FROM user WHERE id = '. $id);
        if($clearData){
            $mysqli->query('DELETE FROM photo WHERE pid = '. getProjectById($id));
            $mysqli->query('DELETE FROM project WHERE uid = '.$id);
        }
        return; 
    }
    
    /**
     * @param project ID
     * <p>
     * Geeft het project id '0', of ook wel gezegd, naar het archief.
     */ 
    function saveData($ProjectId){
       global $mysqli;
       if(isProjectId($ProjectId)){
            $mysqli->query('UPDATE project SET uid = 0 WHERE id = '. $ProjectId);
       }    
    }
    
    if(isset($_POST['delete_req'])){
        if(isset($_POST['saveData'])){
            saveData(getProjectById($id)); 
            removeUser($id, false);  
        }else{
            removeUser($id, true);
        }
    }
    
?>

<form method="POST" action="index.php">
    Klant: <?php echo getName($id); ?><br />
    Project: <?php echo getProject($id);?> <br />
    Ik wil deze data Archiveren <input type='checkbox' name='saveData'/><br />
    <input type="submit" name="delete_req" value="Verwijder"/><br />
    <?php echo $result;?>
    
</form>