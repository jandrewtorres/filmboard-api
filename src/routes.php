<?php
// Routes

// EX gets horror names

$app->get('/', function ($request, $response, $args) {
   echo "hello";
});

$app->get('/{catname}', function ($request, $response, $args) {
   $catname = $request->getAttribute('catname');
   $sql = "SELECT * FROM $catname ORDER BY name";
   $stmt = $this->db->prepare($sql);
   $stmt->execute();
   $all = $stmt->fetchAll();
   return $this->response->withJson($all);
});

$app->post('/{catname}/add', function($request, $response) {
   $name = $request->getParam('name');
   $catname = $request->getAttribute('catname');
   $sql = "INSERT INTO $catname (name) VALUES (:name)";
   $stmt = $this->db->prepare($sql);
   $stmt->bindParam(':name', $name);
   $stmt->execute();
   echo '{"notice": {"text": "Customer Added"}}';
});

$app->post('/add/{catname}', function($request, $response) {
   $catname = $request->getAttribute('catname');
   $sql = "CREATE TABLE IF NOT EXISTS $catname(
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `name` varchar(100) DEFAULT NULL,
         PRIMARY KEY (`id`)
       ) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;";
   $stmt = $this->db->prepare($sql);
   $stmt->execute();
   try {
      $sql = "INSERT INTO categories (category) VALUES (:category)";
      $stmt2 = $this->db->prepare($sql);
      $stmt2->bindParam(':category', $catname);
      $stmt2->execute();
   }
   catch(Exception $e) {
      echo 'Message: ' .$e->getMessage();
   }
   echo '{"notice": {"text": "Table added"}}';
});
