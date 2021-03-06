<?php
// Routes

// Home Message
$app->get('/', function ($request, $response, $args) {
   $sql = "SHOW TABLES";
   $stmt = $this->db->prepare($sql);
   $stmt->execute();
   $result = $stmt->fetchAll();
   $number = 0;
   foreach($result as $t_name) {
      $clean_name = $t_name['Tables_in_heroku_05056c3a834e8cd'];
      $sql = "SELECT * FROM `$clean_name`";
      $stmt2 = $this->db->prepare($sql);
      $stmt2->execute();
      $res = $stmt2->fetchAll();
      $tableNames[$number]['name'] = $clean_name;
      $tableNames[$number]['movies'] = $res;
      $number++;
   }
   return $this->response->withJson($tableNames);
});

// GET category entries
$app->get('/{catname}', function ($request, $response, $args) {
   $catname = $request->getAttribute('catname');
   $sql = "SELECT * FROM `$catname` ORDER BY `name`";
   $stmt = $this->db->prepare($sql);
   $stmt->execute();
   $all = $stmt->fetchAll();
   return $this->response->withJson($all);
});

// POST entry to category
$app->post('/{catname}/add/', function($request, $response) {
   $name = $request->getParam('name');
   $catname = $request->getAttribute('catname');
   $sql = "INSERT INTO `$catname` (name) VALUES (:name)";
   $stmt = $this->db->prepare($sql);
   $stmt->bindParam(':name', $name);
   $stmt->execute();
   echo '{"notice": {"text": "added entry to category"}}';
});

// POST add new category/table, adds category to categories table
$app->post('/add/{catname}', function($request, $response) {
   $catname = $request->getAttribute('catname');
   $sql = "CREATE TABLE IF NOT EXISTS `$catname` (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `name` varchar(100) DEFAULT NULL,
         PRIMARY KEY (`id`)
       ) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;";
   $stmt = $this->db->prepare($sql);
   $stmt->execute();

   echo '{"notice": {"text": "Table added"}}';
});

$app->delete('/{catname}', function ($request) {
    //Delete book identified by $id
   $catname = $request->getAttribute('catname');
   $sql = "DROP TABLE IF EXISTS `$catname`;";
   $stmt = $this->db->prepare($sql);
   $stmt->execute();

   echo ("deleted $catname");
});

$app->delete('/{catname}/{movie}', function ($request) {
    //Delete book identified by $id
   $catname = $request->getAttribute('catname');
   $movie = $request->getAttribute('movie');
   $sql = "DELETE FROM `$catname` WHERE name=`$movie`;";
   $stmt = $this->db->prepare($sql);
   $stmt->execute();

   echo ("deleted $movie from $catname");
});