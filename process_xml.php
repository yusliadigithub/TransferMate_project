<?php
    include 'connection.php';
    
    libxml_use_internal_errors(true);

    //example XML
    $myXMLData =
    "<?xml version='1.0' encoding='UTF-8'?>
    <document>
        <book>
            <author>James</author>
            <name>Test 1</name>
        </book>
        <book>
            <author>Isak Azimov</author>
            <name>End of spirit</name>
        </book>
        <book>
            <author>Pavel Vejinov</author>
            <name>Book 1</name>
        </book>
        <book>
            <author>Pavel Vejinov</author>
            <name>Book 2</name>
        </book>
        <book>
            <author>Ivan Penev</author>
            <name>Book test</name>
        </book>
        <book>
            <author>Ivan Penev</author>
            <name>Book test 11</name>
        </book>
        <book>
            <author>Uchiha</author>
            <name>Book of life</name>
        </book>
    </document>";

    $xml = simplexml_load_string($myXMLData);
    if ($xml === false) {
    echo "Failed loading XML: ";
        foreach(libxml_get_errors() as $error) {
            echo "<br>", $error->message;
        }
    } else {
        foreach($xml as $xml_key => $xml_val){
            $xml_array = get_object_vars($xml_val);

            //search existing author
            $authorSearch = pg_query(
                $connection,"SELECT * FROM authors aut WHERE aut.name = '".$xml_array['author']."'"
            );
            $authorData = pg_fetch_all($authorSearch);

            // check if author exist
            if(!empty($authorData[0])){
                $bookSearch = pg_query(
                    $connection,"SELECT * FROM books WHERE name = '".$xml_array['name']."' and author_id = '".$authorData[0]['id']."'"
                );
                $bookData = pg_fetch_all($bookSearch);
                if(empty($bookData)){
                    // add books
                    $insertBook = pg_query(
                        $connection,"INSERT INTO books (name, author_id) VALUES ('".($xml_array['name']?$xml_array['name']:'')."','".$authorData[0]['id']."')"
                    );
                }
            }else{
                //insert new author
                $authorinsert = pg_query(
                    $connection,"INSERT INTO authors (name) VALUES ('".$xml_array['author']."')"
                );
                
                //get last inserted id
                $last_id_query = pg_query($connection,"SELECT currval('authors_id_seq')");
                $last_id_results = pg_fetch_assoc($last_id_query);
                $last_inserted_id = $last_id_results['currval'];
                
                // check for last_inserted_id
                if($last_inserted_id){
                    // add books
                    $insertBook = pg_query(
                        $connection,"INSERT INTO books (name, author_id) VALUES ('".($xml_array['name']?$xml_array['name']:'')."','".$last_inserted_id."')"
                    );
                }
            }
        }
    }
?>