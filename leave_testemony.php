<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <title>themintrepair</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@600;700&family=Ubuntu:wght@400;500&display=swap" rel="stylesheet"> 

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    
    <?php include"navbar.php"?>
        <!-- leave testimony Start -->
        <div class="container-fluid bg-secondary booking my-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="row gx-5">
                <div class="col-lg-6 py-5">
                    <div class="py-5">
                        <h1 class="text-white mb-4">Certified and Award Winning Car Repair Service Provider</h1>
                        <p class="text-white mb-0">That's a title we wear with immense pride and responsibility. It signifies years of dedication to excellence, a relentless pursuit of perfection, and an unwavering commitment to our customers.</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="bg-primary h-100 d-flex flex-column justify-content-center text-center p-5 wow zoomIn" data-wow-delay="0.6s">
                        <h1 class="text-white mb-4">Leave a testimony</h1>
                        <form  method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" enctype="multipart/form-data" >
                            <div class="row g-3">
                                <div class="col-12 col-sm-6">
                                    <input type="text" class="form-control border-0" name="Uname" placeholder="Your Name" style="height: 55px;">
                                </div>
                                <div class="col-12 col-sm-6">
                                    <input type="email" class="form-control border-0" name="email" placeholder="Email" style="height: 55px;">
                                </div>
                                <div class="col-12">
                                    <textarea class="form-control border-0" name="testimony" placeholder="testimony"></textarea>
                                </div>
                                <div class="col-12">
                                    <input type="file" class="form-control border-0" name="image" style="height: 55px;">
                                </div>
                                <p class="text-white mb-0">please attach your pictures</p>
                                <div class="col-12">
                                    <input class="btn btn-secondary w-100 py-3" name="submit" type="submit" value="Leave a Testimony">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- testimony End -->
    <?php include"footer.php"?>    
</body>
</html>
<?php 
    if (isset($_POST['submit']) && isset($_FILES['image'])) {
        include "config/database.php";
        echo "<pre>";
        print_r($_FILES['image']);
        echo "</pre>";
        $Uname = $_POST['Uname'];
        $email = $_POST['email'];
        $testimony = $_POST['testimony'];

        $img_name = $_FILES['image']['name'];
        $img_size = $_FILES['image']['size'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $error = $_FILES['image']['error'];

        if ($error === 0) {
            if ($img_size > 12500000) {// 12MB limit (adjust as needed)
                $em = "Sorry, your file is too large.";
                header("Location: leave_testemony.php?error=$em");
            }else {
                $img_ex =  explode('.', $img_name);
                $img_ex_lc = strtolower(end($img_ex));

                $allowed_exs = array("jpg", "jpeg", "png"); 

                if (in_array($img_ex_lc, $allowed_exs ) ) { // 12MB limit (adjust as needed)
                    $new_img_name = uniqid() . '.' . $img_ex_lc;
                    $new_img_name1 = uniqid() . '.' . $img_ex_lc1;
                    $new_img_name2 = uniqid() . '.' . $img_ex_lc2;
                    
                    // Check if directory exists, create it if not
                    if (!file_exists('img/test_photo')) {
                        mkdir('img/test_photo', 0755, true);
                    }
                        
                    if (move_uploaded_file($tmp_name, 'img/test_photo/'. $new_img_name)) {
                        echo "File moved successfully!";
                        $image = $new_img_name;
                    }else {
                        echo "Error moving file" . error_get_last()['message'];
                        exit; // Stop script execution on error
                    }

                        // Insert into Database
                        $sql = "INSERT INTO testimony(Uname,email,testimony,image) 
                                VALUES('$Uname','$email','$testimony','$new_img_name')";
                        mysqli_query($conn, $sql);
                    
                    echo "<script>alert('thank you for the testimony')</script>";
                }else {
                    $em = "You can't upload files of this type";
                    header("Location: leave_testemony.php?error=$em");
                }
            }
        }else {
            $em = "unknown error occurred!";
            header("Location: leave_testemony.php?error=$em");
        }
    }else {
        header("Location: index.php");
    }
?>