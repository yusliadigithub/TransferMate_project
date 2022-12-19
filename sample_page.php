<?php
    include 'connection.php';
?>
<Html>    
<Head>  
    <title>Sample Page</title>  
    <h1>Sample Page</h1>  
    
    <style>
        .center {
            margin: auto;
            width: 50%;
            padding-top: 50px;
        }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 10px;
        }
        #toggle {
            width: 100px;
            height: 100px;
            background: #ccc;
        }
    </style>

    <script src="//code.jquery.com/jquery-1.12.4.js"></script>
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</Head>  
<Body>  
    <div class="center">
        <form action="sample_page.php" method="post">
            Search <input type="text" name="search"> 
            <input type ="submit">
        </form>
    </div>
</Body>  
</Html>  

<?php 
if(isset($_POST['search'])){
    
    // get the input word
    $search = $_POST['search'];

    // checking for the empty input and stop the execution
    if($search == ''){
        echo '<script type="text/javascript"> alert("Please key in any word.");</script>';
        exit();
    }

    //search for the data in table base on the input keyword
    $sql = "select authors.name as author_name, books.name as book_name from authors left join books on authors.id = books.author_id
    where authors.name ILIKE '%".$search."%'";

    $searchData = pg_query($connection,$sql);

    $searchResults = pg_fetch_all($searchData);
    $rows = pg_num_rows($searchData);

    if ($rows > 0){
        $table = "";
        $table .= "<div class='center'>";
        $table .= "<table width='100%'>";
        $table .= "<tr><th>Author Name</th><th>Book Name</th></tr>";
        
        foreach( $searchResults as $row ){
            $table .= "<tr><td>".$row['author_name']."</td><td>".$row['book_name']."</td></tr>";
        }
        $table .= "</table></div>";
        echo $table;

        // //start - the code for the record to slide but it is not working perfectly
        // $table = "";
        // $table .= "<div class='center'>";
        // $table .= "<table width='100%'>";
        // $table .= "<tr><th>Author Name</th><th>Book Name</th></tr>";
        
        // foreach( $searchResults as $row ){
        //     $table .= "<tr class='slide'><td>".$row['author_name']."</td><td>".$row['book_name']."</td></tr>";
        // }
        // $table .= "</table></div>";
        // echo $table;
        // //end 

    } else {
        $table = "";
        $table .= "<div class='center'>";
        $table .= "<p>0 records found</p></div>";
        echo $table;
    }
}
?>

<script>
    $( ".slide" ).toggle( "slide" , { direction: "right" }, 10000);
</script>