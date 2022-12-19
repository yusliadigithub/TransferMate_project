# TransferMate_project
This is Transfer Mate test 

Connection 
1. File : connection.php
2. This is the page for the database connnection using postgressql


Proccess XML
1. File : process_xml.php
2. In this page, include the connection file 
3. XML data was included in this page.
4. get the XML data using simplexml_load_string() function
5. loop the data. In the loop, there is the condition that need to be satified.
6. The condition will determine whether the data will be created new or update


Sample page
1. File : sample_page.php
2. In the HTML, add form for the searching
3. After click Search button, the keyword will be seach in the SQL query using ILIKE to search for small and capital letter in the data.
4. The search result will be loaded in the page.