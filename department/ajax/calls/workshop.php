<?php

    include "../../../config/config.php";
    session_start();

    if(isset($_POST['submit']))
    {
        $title = addslashes($_POST["title"]);
        $subtitle = addslashes($_POST["subtitle"]);
        $description = addslashes($_POST["description"]);
        $date = $_POST["date"];


        // gets information about target images file
        $target = "../../../uploads/images/";
        $target1 = $target . basename($_FILES["image1"]["name"]);
        $target2 = $target . basename($_FILES["image2"]["name"]);
        $target3 = $target . basename($_FILES["image3"]["name"]);
        $target4 = $target . basename($_FILES["image4"]["name"]);

        //gets information about report files
        $target_file = "../../../uploads/reports/";
        $target_report = $target_file . basename($_FILES["report"]["name"]);

        //gets information about images
        $file_name1 = basename($_FILES["image1"]["name"]);
        $file_name2 = basename($_FILES["image2"]["name"]);
        $file_name3 = basename($_FILES["image3"]["name"]);
        $file_name4 = basename($_FILES["image4"]["name"]);

        //gets information about report file
        $file_name5 = basename($_FILES["report"]["name"]);


        //writes the file to the server
        if((move_uploaded_file($_FILES['image1']['tmp_name'], $target1)) && (move_uploaded_file($_FILES['image2']['tmp_name'], $target2)) && (move_uploaded_file($_FILES['image3']['tmp_name'], $target3)) && (move_uploaded_file($_FILES['image4']['tmp_name'], $target4)) && (move_uploaded_file($_FILES['report']['tmp_name'], $target_report)))
        {

            //////////////////////////////////////////////////////////////////////////////////////////////////////
            // This is to change path in mysql database                                                         //
            //////////////////////////////////////////////////////////////////////////////////////////////////////


            // gets information about target images file
            $target = "uploads/images/";
            $target1 = $target . basename($_FILES["image1"]["name"]);
            $target2 = $target . basename($_FILES["image2"]["name"]);
            $target3 = $target . basename($_FILES["image3"]["name"]);
            $target4 = $target . basename($_FILES["image4"]["name"]);

            //gets information about report files
            $target_file = "uploads/reports/";
            $target_report = $target_file . basename($_FILES["report"]["name"]);

            //////////////////////////////////////////////////////////////////////////////////////////////////////
            // end                                                                                              //
            //////////////////////////////////////////////////////////////////////////////////////////////////////


            $sql = "insert into iqac.workshop values('','$title','$subtitle','$description','$date','$target_report' ,'$target1','$target2','$target3','$target4');";
            if($con->query($sql))
            {
                $lastid = $con->insert_id;
                $sql =  "insert into iqac.report values('','$lastid','". $_SESSION["dept"] ."',1,now(),'unapproved')";
                if($con->query($sql))
                {
                    echo "files uploaded successfully";
                    header("location: ../../../view/view.php?id=$lastid&type=1");
                }
            }
        }
        echo $con->error;
    }
?>