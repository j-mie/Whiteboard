<?php
//Moodle functions
include 'phpQuery.php';

function addDetails($username, $password, $id, $db)
{
    $query = '';
    $query_params = '';

    if (!is_null($password))
    {
            $query = "
            INSERT INTO moodleauth ( 
                id,
                username, 
                password
            ) VALUES ( 
                :id, 
                :username, 
                :password
            )
            ON DUPLICATE KEY UPDATE username= :username, password= :password
        ";
            $query_params = array( 
            ':id'   => $id,
            ':username' => $username,
            ':password' => $password
        ); 
    }

    else
    {
        $query = "
            INSERT INTO moodleauth ( 
                id,
                username
            ) VALUES ( 
                :id, 
                :username
            )
            ON DUPLICATE KEY UPDATE username= :username
        "; 

            $query_params = array( 
            ':id'   => $id,
            ':username' => $username,
            ':password' => $password
        ); 
    }

         
        try 
        { 
            // Execute the query to create the user 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            dieError($ex);
        }

        return $username;
}

function getPassword($username, $db)
{
    $query = " 
        SELECT 
            password
        FROM moodleauth 
        WHERE 
            username = :user 
    "; 
     
    // The parameter values 
    $query_params = array( 
        ':user' => $username
    ); 
     
    try 
    { 
        // Execute the query against the database 
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params); 
    } 
    catch(PDOException $ex) 
    { 
        dieError($ex);
    } 
     
    // Retrieve the user data from the database.  If $row is false, then the username 
    // they entered is not registered. 
    $row = $stmt->fetch(); 
    if($row) 
    {              
        return rot13decrypt($row['password']);
    } 
}

    function rot13encrypt ($str) {
    return str_rot13(base64_encode($str));
    }

    function rot13decrypt ($str) {
        return base64_decode(str_rot13($str));
    }

    function getMoodleDetails($id, $db)
    {
        $query = " 
            SELECT  
                id, 
                username, 
                password
            FROM moodleauth 
            WHERE 
                id = :id 
        "; 
         
        // The parameter values 
        $query_params = array( 
            ':id' => $id
        ); 
         
        try 
        { 
            // Execute the query against the database 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
        dieError("Moodle Username Lookup Failure");      
        }

        $details = $stmt->fetch(); 
        return $details;
    }

    function authwithMoodle($username, $authurl, $db)
    {
    
    $fields = array(
        'username' => urlencode($username),
        'password' => urlencode(getPassword($username, $db))
    );

    $fields_string = '';
    //url-ify the data for the POST
    foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
    rtrim($fields_string, '&');

    //cookies
    $ckfile = tempnam ("/tmp", getPassword($username, $db)); // :(


    //open connection
    $ch = curl_init();

    //set the url, number of POST vars, POST data
    curl_setopt($ch,CURLOPT_URL, $authurl);
    curl_setopt($ch,CURLOPT_POST, count($fields));
    curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt ($ch, CURLOPT_COOKIEJAR, $ckfile); 
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
        
    //execute post
    $result = curl_exec($ch);

    //close connection
    curl_close($ch);

    if (!is_null(strstr($result, "logout.php")))
    {
        return array("status" => "true", "tempnam" => $ckfile);
    }
    else
    {
        return false;
    }

    }

function getAllAssignmentLinks($url, $cookie)
{
$ch = curl_init ($url);
curl_setopt ($ch, CURLOPT_COOKIEFILE, $cookie); 
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec ($ch);
return $output;
}

function getFeedback($url, $cookie)
{
    $ch = curl_init ($url);
    curl_setopt ($ch, CURLOPT_COOKIEFILE, $cookie); 
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec ($ch);

    phpQuery::selectDocument(phpQuery::newDocumentHTML($output));
    foreach(pq('div') as $p)
    {
        if (strpos(pq($p)->attr('class'),'comment') !== false) {
            $output = strip_tags(pq($p)->html(), '<p>');
        }
    }
    return $output;
}
?>