<?php
  try {
    /**************************************
    * Create databases and                *
    * open connections                    *
    **************************************/
 
    $file_db = new PDO('sqlite:pictures.sqlite3');
    $file_db->setAttribute(PDO::ATTR_ERRMODE, 
                            PDO::ERRMODE_EXCEPTION);
 
 
    /**************************************
    * Create tables                       *
    **************************************/
 
    $file_db->exec("CREATE TABLE IF NOT EXISTS pictures (
                    id INTEGER PRIMARY KEY, 
                    picture TEXT, 
                    description TEXT)");
 
 
    /**************************************
    * Set initial data                    *
    **************************************/
 
    $pictures = array(
                  array('picture' => 'hello.png',
                        'description' => 'Hello World!'),
                  array('picture' => 'hackndo.png',
                        'description' => 'Le logo de Hackndo')
                );
 
 
    /**************************************
    * Play with databases and tables      *
    **************************************/
 
    $insert = "INSERT INTO pictures (picture, description) 
                VALUES (:picture, :description)";
    $stmt = $file_db->prepare($insert);
 
    $stmt->bindParam(':picture', $picture);
    $stmt->bindParam(':description', $description);
 
    foreach ($pictures as $p) {
      $picture = $p['picture'];
      $description = $p['description']; 
      $stmt->execute();
    }
?>
