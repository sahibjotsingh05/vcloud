    <button class='collapser'>
        <img src="../../includes/media/icons/cross.svg">
    </button>
    <div class='aside_wrap'>
        <button class='feature aside_item margin' id='default' value="<?php echo $_SESSION['department']; ?>">Home</button>
        <button class='feature aside_item margin' id='fast_growth' value="<?php echo $_SESSION['department']; ?>">Trending</button>
        <button class='feature aside_item margin' id='latest' value="<?php echo $_SESSION['department']; ?>">Latest</button>
        <button class='feature aside_item margin' id='document' value="<?php echo $_SESSION['department']; ?>">Documents</button>
        <button class='feature aside_item margin' id='history' value="<?php echo $_SESSION['department']; ?>">History</button>
        <button class='feature aside_item margin' id='bookmark' value="<?php echo $_SESSION['department']; ?>">Bookmarks</button>
        <?php
        if (isset($_SESSION['hod_status'])) {
            echo "<a href='keyword_pending.php?show=" . $_SESSION['department'] . "&'>";
            echo "<button class='aside_item'>";
            echo "Keywords";
            echo "</button>";
            echo "</a>";
        }
        ?>
        <hr>
        <!-- FOR SUBJECT(s) -->
        <?php include_once 'process_subject.php'; ?>
        <!----------------->
    </div>