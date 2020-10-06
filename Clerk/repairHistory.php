<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/slider.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="./css/clerk.css">
    <link rel="stylesheet" href="./css/repairHistory.css">
    <script src="https://kit.fontawesome.com/2b554022ef.js" crossorigin="anonymous"></script>
    <title>Repair History</title>

</head>

<body>


    <?php include "./components/nav.php" ?>


    <div class="main_content">
        <header>
            <h1>Repair History</h1>
        </header>
        <div class="container1">
            <!-- searchbox -->
            <div class="searchbox">
                <input id="search" type="text" placeholder="Search..." name="search" class="search">
                <button class="btn-search"><i class="fas fa-search"></i></button>
            </div>


            <!-- repair list -->
            <?php
            require __DIR__ . '/../classes/Repair.php';
            $repair = new Repair();
            $list = $repair->getRepairs('a');

            while ($row = $list->fetch_assoc()) :
            ?>
                <div id="<?= $row['repair_id'] ?>" class="repair-item">

                    <div class="row1"><span>#<?= $row["lp_id"] ?></span>
                        <div class="address"><?= $row["division"] ?></div><span><?= $row["date"] ?></span>
                    </div>
                </div>

            <?php endwhile ?>

        </div>
    </div>

</body>

</html>