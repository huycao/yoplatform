<?php
   // connect to mongodb
   $m = new MongoClient("mongodb://mongo1.yomedia.vn:27017,mongo2.yomedia.vn:27017/?replicaSet=rs0");
   echo "Connection to database successfully<br />";
   // select a database
   $db = $m->yomedia;
   echo "Database Yomedia selected<br />";
   $collection = $db->trackings_summary;
   echo "Collection trackings_summary selected succsessfully<br />";
   echo "Print _id <br />";
   $cursor = $collection->find();
   // iterate cursor to display title of documents
   foreach ($cursor as $document) {
      echo $document["_id"]."\n";
   }
?>
