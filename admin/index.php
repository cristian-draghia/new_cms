<?php include 'includes/admin_header.php' ?>

    <div id="wrapper">

        <!-- Navigation -->

        <?php include 'includes/admin_navigation.php' ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to Admin 
                            <small><?php echo $_SESSION['user_name']; ?></small>
                        </h1>
            
                    </div>
                </div>
                <!-- /.row -->
                
                <div class="row">
                    <!-- Here ---->
                    <?php 
                    $var_array = array();
                    display_graph( $var_array, "Posts" );
                    display_graph( $var_array, "Comments" );
                    display_graph( $var_array, "Users" );
                    display_graph( $var_array, "Categories" );
                    ?>
                </div>
                <!-- /.row -->

                <?php

                ?>

                <div class="row">
                <script type="text/javascript">
                    google.charts.load('current', {'packages':['bar']});
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                        ['Data', 'Count'],

                        <?php
                        $chart_element_text = array(
                            'Published Posts',
                            'Draft Posts',
                            'Approved Comments',
                            'Unapproved Comments',
                            'Admin Users',
                            'Subscriber Users',
                        );

                        $chart_element_count = array(
                            $var_array[1],
                            $var_array[2],
                            $var_array[4],
                            $var_array[5],
                            $var_array[7],
                            $var_array[8],
                        ) ;

                        for( $i = 0; $i < sizeof( $chart_element_count ); $i++) {
                            echo "['$chart_element_text[$i]', $chart_element_count[$i]],";
                        }
                        ?>


                 
                        ]);

                        var options = {
                        chart: {
                            title: '',
                            subtitle: '',
                        }
                        };

                        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                        chart.draw(data, google.charts.Bar.convertOptions(options));
                    }
                </script>

                    
                    <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>


                
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

<?php include 'includes/admin_footer.php' ?>