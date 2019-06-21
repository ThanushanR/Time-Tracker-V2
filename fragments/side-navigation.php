<div class="col-md-2 col-sm-2 hidden-xs display-table-cell valign-top" id="side-menu">


    <div class="text-center">
        <?php
        include('database_config_dashboard.php');


        $query = "
        SELECT 
        user_profile.photo FROM user_profile INNER JOIN user ON user_profile.user_id=user.user_id
        WHERE user.user_id = '" . $_SESSION["user_id"] . "'
        ";

        //echo $query;

        $statement = $connect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $photo = '';
        foreach ($result as $row) {
            $photo = $row['photo'];
        }


        //echo $photo;
        $uid = $_SESSION["user_name"];
        echo "<a href='profile.php'><img src='images/profile/$photo' class='img-circle' style='width:110px;height:110px;border:2px solid gray;' alt='$uid'/></a> ";
        ?>
        <!-- https://via.placeholder.com/120 -->
    </div>
    <!-- Navigation Items -->
    <ul>
        <li class="link active">
            <a href="index.php">
                <span class="glyphicon glyphicon-th" aria-hidden="true"></span>
                <span class="hidden-sm hidden-xs">Dashboard</span>
            </a>
        </li>

        <?php
        if ($_SESSION['type'] === "1") {


            ?>



            <li class="link">
                <a href="#collapse-post" data-toggle="collapse" aria-controls="collapse-post">
                    <i class="fas fa-users"></i>
                    &nbsp;
                    <span class="hidden-sm hidden-xs">Manage Users </span>

                </a>
                <ul class="collapse collapseable" id="collapse-post">
                    <li><a href="userrole.php">User Role</a></li>
                    <li><a href="user.php">User List</a></li>
                </ul>
            </li>

            <li class="link">
                <a href="company.php">
                    <i class="far fa-building"></i>
                    &nbsp;
                    <span class="hidden-sm hidden-xs">Manage Company</span>
                </a>
            </li>

        <?php
    } else {
        ?>

            <li class="link">
                <a href="recruitment.php">
                    <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                    <span class="hidden-sm hidden-xs">Recruitment</span>
                </a>
            </li>

            <li class="link">
                <a href="projects.php">
                    <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>
                    <span class="hidden-sm hidden-xs">Projects</span>
                </a>
            </li>

            <li class="link">
                <a href="viewcalendar.php">
                    <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                    <span class="hidden-sm hidden-xs">Time Sheet</span>
                </a>
            </li>




            <li class="link">
                <a href="dashboard-leave.php">
                    <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>
                    <span class="hidden-sm hidden-xs">Adjustments</span>
                </a>
            </li>
        <?php
    }
    ?>


    </ul>
</div>