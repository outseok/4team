<!DOCTYPE html>
<html>
    <head>
        <meta charset = 'UTF-8'>
        <title>STORE</title>
    </head>
    <body>
        <?php
        $price = $_POST['price'];
        $type = $_POST['type'];
        $uid = $_GET('uid');

        $dbcon = mysqli_connect('localhost', 'root', '', 'user');
        $query2 = "select point from user_info where uid = $uid";
        $result2 = mysqli_query($dbcon, $query2);
        $row_result = mysqli_fetch_array($result2);
        $np = $row_result['point'];

        $query_item = "select image from item where type = '$type' AND price = $price";
        $result_item = mysqli_query($dbcon, $query_item);
        $row_item = mysqli_fetch_array($result_item);
        $image_path = $row_item['image'];
        $imagepath = "./image/".$image_path;

        // $image_info = pathinfo($_FILES['image']['name']);
        // $image_name = $image_info['filename'];
        // $image_ext = $image_info['extension'];
        // $image

        $query = "select price from item where type = '$type' AND price = $price";
        $result = mysqli_query($dbcon, $query);
        $query2 = "select point from user_info where uid = $uid";
        $result2 = mysqli_query($dbcon, $query2);
        if($price > $np){
            echo "
                <script>
                alert('포인트가 부족합니다');
                location.href = './store.php';
                </script>";
        }else{
            $query1 = "update point set point = point - $price where uid = $uid";
            mysqli_query($dbcon, $query1);
            $ok = "select * from myitem where uid = $uid AND type = '$type'";
            $rok = mysqli_query($dbcon, $ok);
            // $roka = mysqli_fetch_array($rok);
            if(mysqli_num_rows($rok) <= 1 ){
                
                $ins = "insert into myitem value('$uid', '$type', '$type', '$image_path')";
                mysqli_query($dbcon, $ins);
                
            }else{
                $mv = "update myitem set image = '$image_path' where type = '$type'";
                mysqli_query($dbcon, $mv);
                
            }
            Header("Location:./store.php");
        }
        
        mysqli_close($dbcon);
        
        
        ?>

    </body>
</html>