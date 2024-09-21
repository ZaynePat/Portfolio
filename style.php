<?php 
    include 'dbconfig.php';
    
    function connectToDatabase() {
        $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }
    
    // Establish database connection
    $conn = connectToDatabase();
            
        // function fetchData($conn,$table,$column){
        //     $sql = "SELECT " . implode(', ', $column) . " FROM $table";

        //     $result = $conn->query($sql);
        //     $data = [];
        //     if($result->num_rows > 0){
        //         while($row = $result->fetch_assoc()){
        //             $data[] = $row;
        //         }
        //     }else{
        //         echo "0 results";
        //     }
        //     return $data;
        // }

        function fetchData($conn, $table, $columns) {
            $columnsList = implode(', ', $columns);
            $sql = "SELECT id, $columnsList FROM $table";  
        
            $result = $conn->query($sql);
            $data = [];
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
            } else {
                echo "0 results";
            }
            return $data;
        }
        

        function fetchAboutData($conn){
            return fetchData($conn, 'about', ['about_me_content','about_me_header']);
        }

        function fetchContactInfo($conn) {
            $sql = "SELECT facebook, twitter, gmail, linkedin FROM users LIMIT 1";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                return $result->fetch_assoc();
            } else {
                return null;
            }
        }

        function fetchHomeContent($conn) {
            $sql = "SELECT home_content, name, position FROM home LIMIT 1";
        
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                return $result->fetch_assoc();
            } else {
                echo "0 results";
                return null;
            }
        }

        function fetchSkillsData($conn) {
            $skills = [];
            $query = "SELECT property, value FROM skills";
            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $skills[$row['property']] = $row['value'];
                }
            }
            return $skills;
        }

        function fetchEducationData($conn){
            return fetchData($conn, 'education', ['id','year', 'school','school_content']);
        }
  

        $conn = connectToDatabase();

        $contactinfo = fetchContactInfo($conn);

        $aboutData = fetchAboutData($conn);

        $skillsData = fetchSkillsData($conn);

        $educationalData = fetchEducationData($conn);

        $homeContent = fetchHomeContent($conn);

        

       // $conn->close();
        
        // echo ":root {\n";
        // foreach ($skillsData as $property => $value) {
        //     echo "    --$property: $value;\n";
        // }
        // echo "}\n";


?>