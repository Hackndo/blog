<?php
    if( isset($_POST['upload']) ) // si formulaire soumis
    {
        $content_dir = 'img/'; // dossier où sera déplacé le fichier

        $tmp_file = $_FILES['fichier']['tmp_name'];
        $description = $_POST['description'];
        if( !is_uploaded_file($tmp_file) )
        {
            exit("Le fichier est introuvable");
        }

        // on copie le fichier dans le dossier de destination
        $name_file = $_FILES['fichier']['name'];

        if( !move_uploaded_file($tmp_file, $content_dir . $name_file) )
        {
            exit("Impossible de copier le fichier dans $content_dir");
        }
        $insert = "INSERT INTO pictures (picture, description) 
                VALUES (:picture, :description)";
        $stmt = $file_db->prepare($insert);
 
        // Bind parameters to statement variables
        $stmt->bindParam(':picture', $name_file);
        $stmt->bindParam(':description', $description);
        $stmt->execute();
    }
 
    // Select all data from memory db messages table 
    $result = $file_db->query('SELECT * FROM pictures');

    echo "<h1>Gallerie d'images</h1>";
 
    foreach($result as $row) {
      echo "<img src='./img/" . $row['picture'] . "' title='" . $row['description'] . "' style='width: 100px; height: auto; padding: 10px;' />";
    }

?>

<form method="post" enctype="multipart/form-data" action="">
<p>
<label>Image : </label>
<input type="file" name="fichier" size="30">
<br />
<label>Description : </label>
<input type="text" name="description" />
<br />
<input type="submit" name="upload" value="Envoyer">
</p>
</form>


<?php
    /**************************************
    * Close db connections                *
    **************************************/
 
    $file_db = null;
  }
  catch(PDOException $e) {
    // Print PDOException message
    echo $e->getMessage();
  }

