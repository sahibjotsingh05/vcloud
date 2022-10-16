<div class='header_wrap'>
    <button class='un_collapser'><img src='../../includes/media/icons/menu.svg'></button>

    <div id="parent_logo">
        <img id="logo" src='../../includes/media/icons/logo.png'>
    </div>

    <div id="parent_search_bar">
        <input type="text" id="search_bar" placeholder="Search for video(s), PDF(s)">
        <div class='search_suggestion'></div>
    </div>

    <div id="profile_tools">
        <div class='side_down'>
            <div class="side_content">
                <span id='logged_name'><?php echo ucwords(str_replace('_', " ", $_SESSION['name'])); ?></span>
                <span id='logged_department'><?php echo ucfirst(str_replace('_', " ", $_SESSION['department'])); ?></span>
                <form method="POST" action="process_logout.php"><button name='log_out' type='submit' id='log_out'>Log Out</button></form>
            </div>
            <button class='user'><img src='../../includes/media/icons/user.svg'></button>
        </div>
    </div>
</div>
<!-- <script type="text/javascript" src='../js/search.js'></script> -->
<script defer type="text/javascript" src='../js/proceed.js'></script>