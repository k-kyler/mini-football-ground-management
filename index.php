<style>
    <?php 
        require_once('./CSS/slider-main.css');
    ?>
</style>

<?php
    // Layout
    require_once('layout.php');

    // Config
    require_once('./Config/config.php');

    ?>
        <div class="wrapper">
            <!-- Header -->
            <?php
                require_once('header.php'); 
            ?>

            <!-- Index container -->
            <div class="container">
                <div class="row">
                    <div class="col-2">

                    </div>

                    <!-- Content -->
                    <div class="col-8 col-0">
                        <!-- Slider main -->
                        <div class="slider-container">
                            <div class="slider-main" id="sliderMain">
                                <!-- Slideshow images -->
                                <?php        
                                    $db = getDatabase();
                                    $res = getImages($db);

                                    if ($res != null && $res -> num_rows > 0) {
                                        while ($data = $res -> fetch_assoc()) {
                                            $imageSrc = $data['image_src'];
                                            $imageType = $data['image_type'];

                                            if ($imageType == "slide") {
                                                ?>
                                                    <div class="slide fade">
                                                        <img src="<?= $imageSrc ?>">
                                                    </div>
                                                <?php
                                            }
                                        }
                                    }
                                ?>

                                <!-- Slider navigation -->
                                <div class="slider-nav">
                                    <span class="nav-dot"></span>   
                                    <span class="nav-dot"></span>   
                                    <span class="nav-dot"></span>   
                                </div>
                            </div>
                        </div>
                        <!-- ----- -->

                        
                    </div>

                    <div class="col-2">

                    </div>
                </div>
            </div>
		</div>
    <?php

    // Footer
    require_once('footer.php');
?>

<script>
    <?php 
        require_once('./JS/slider-main.js'); 
    ?>
</script>