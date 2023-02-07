<head>
        <link rel="stylesheet" href="css/wantList.css">
        </head>
<nav>

    <a href="./wantList_now.php" style="text-decoration:none;">
        <img src="./images/tab_now.png" id="now" height="180">
    </a>
    
    <a href="./wantList_end_css.php" style="text-decoration:none;">
        <img src="./images/tab_past.png" id="past" height="180">
    </a>

</nav>

<script>
    function widthImage_half(){
        let outwidth=outerWidth;

        let image_now=document.getElementById('now');
        let image_past=document.getElementById('past');

        image_now.width=(outwidth/2)-(outwidth*0.05);
        image_past.width=(outwidth/2)-(outwidth*0.05);

        // image_now.style.cssFloat=left;
        // image_past.style.clear=both;

        // image_past.style.cssFloat=right;
        // image_now.float=left;
        }
    setInterval(widthImage_half,10);

    // function widthImage_half_past(){
    //     let outwidth=outerWidth;
    //     let image_now=document.getElementById('past');
    //     image_past.width=outwidth/2;
    //     }
    // setInterval(widthImage_half_past,10);

</script>
