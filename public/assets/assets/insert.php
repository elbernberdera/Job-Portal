<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>
    <input type="button" value="Go back" id="btn">

    <?php
        $hostname = "localhost";
        $username = "root";
        $password = "";
        $databaseName = "dbpdf";

        // get values form input text and number

        $Surname = $_GET['Surname'];
        $Firstname = $_GET['Firstname'];
        $MiddleName = $_GET['MiddleName'];
        $info = $_GET['info'];

        // connect to mysql database using mysqli

        $connect = mysqli_connect($hostname, $username, $password, $databaseName);

        // mysql query to insert data

        $query = "INSERT INTO `tblpdf`(`Surname`, `Firstname`, `MiddleName`, info) VALUES ('$Surname','$Firstname','$MiddleName', '$info')";

        $result = mysqli_query($connect,$query);

        // check if mysql query successful

        if($result)
        {
            echo 'Data Inserted';
        }

        else{
            echo 'Data Not Inserted';
        }
        mysqli_close($connect);
    ?>

    
        <script>
                let btn = document.getElementById('btn');

                let gotData1 = '<?php echo $_GET["Surname"]; ?>';
                let gotData2 = '<?php echo $_GET["Firstname"]; ?>';
                let gotData3 = '<?php echo $_GET["MiddleName"]; ?>';
                let gotData4 = '<?php echo $_GET["info"]; ?>';

                console.log(gotData1);
                console.log(gotData2);
                console.log(gotData3);
                console.log(JSON.parse(gotData4));

                btn.addEventListener('click', () => {
                    window.location = `../index.php`;
                });
        </script>
</body>
</html>