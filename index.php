<?php
 if(isset($_POST["btn_zip"]))  
 {  
      $output = '';  
      if($_FILES['zip_file']['name'] != '')  
      {  
           $file_name = $_FILES['zip_file']['name'];  
           $array = explode(".", $file_name);  
           $name = $array[0];  
           $ext = $array[1];  
           if($ext == 'zip')  
           {  
                $path = 'upload/';  
                $location = $path . $file_name;  
                if(move_uploaded_file($_FILES['zip_file']['tmp_name'], $location))  
                {  
                     $zip = new ZipArchive;  
                     if($zip->open($location))  
                     {  
                          $zip->extractTo($path);  
                          $zip->close();  
                     }  
                     $files = scandir($path . $name);  
                     //$name is extract folder from zip file  
                     foreach($files as $file)  
                     {  
                          $tmp=explode(".", $file);
                          $file_ext = end($tmp);  
                          $allowed_ext = array('jpg', 'png','JPG','mp4','mp3','pdf');  
                          if(in_array($file_ext, $allowed_ext))  
                          {  
                               $new_name = md5(rand()).'.' . $file_ext;  
                               $output .= '<div class="col-md-12"><div style="padding:16px; border:1px solid #CCC;"><img src="upload/'.$new_name.'" width="170" height="240" /></div></div>
                              <div class="col-md-12"><div style="padding:16px; border:1px solid #CCC;"> 
                              <audio controls autoplay loop>
                <source src="upload/'.$new_name.'" type="audio/mpeg">   
            </audio><br></div></div>
           <div class="col-md-12"><div style="padding:16px; border:1px solid #CCC;">
            <video controls autoplay loop muted width="400px" height="400px" poster="img3.jfif">
               <source src="upload/'.$new_name.'" type="video/mp4">
           </video> </div></div>
                               ';  
                               copy($path.$name.'/'.$file, $path . $new_name);  
                               unlink($path.$name.'/'.$file);  
                          }       
                     }  
                     unlink($location);  
                    rmdir($path . $name);  
 
                }  
           }  
      }  
 }  
 ?>
<!DOCTYPE html>
<html>

<head>
    <title>Webslesson Tutorial | How to Extract a Zip File in Php</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>

<body>
    <br />
    <div class="container" style="width:500px;">
        <h3 align="">How to Extract a Zip File in Php</h3><br />
        <form method="post" enctype="multipart/form-data">
            <label>Please Select Zip File</label>
            <input type="file" name="zip_file" />
            <br />
            <input type="submit" name="btn_zip" class="btn btn-info" value="Upload" />
        </form>
        <br />
        <?php  
                if(isset($output))  
                {  
                     echo $output;  
                }  
                ?>
    </div>
    <br />
</body>

</html>