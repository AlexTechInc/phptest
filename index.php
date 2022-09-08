


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

    <title>Import page</title>

    <script>
        window.onload = function() {
            var uploadField = document.getElementById("import_csv_file");

            uploadField.onchange = function() {
                if(this.files[0].size > 1048576) {
                    alert("File is too big! Max size is up to 1 MB");
                    this.value = "";
                };
            };
        }
        
    </script>
</head>
<body>
    <?php

    if (isset($_POST["action"])) {
        $action = $_POST["action"];

        switch ($action) {
            case "import":
                if (isset($_FILES["import_csv_file"])) {
                    $file = $_FILES["import_csv_file"];

                    $file_name = $file["name"];
                    $file_tmp_name = $file["tmp_name"];
                    $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);

                    if ($file_extension == "csv") {
                        $file_stream = fopen($file_tmp_name, "r");
                        
                        $file_contents = fread($file_stream, filesize($file_tmp_name));
                        
                        echo "<pre>" . print_r(str_getcsv($file_contents)) . "</pre>";
                    }
                    
                    echo "file uploaded <br>";

                    echo "ext " . $file_extension;
                } else {
                    echo "file is not uploaded";

                    echo print_r($_FILES);
                }

                break;

            default:
                echo "Unknown action " . $action; 

        }
    } else {
        echo "no action";
    }

    ?>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" accept="text/csv" id="import_csv_file" name="import_csv_file">
        <input type="hidden" name="action" value="import">
        <input type="submit" name="Import" value="Import">
    </form>
</body>
</html>