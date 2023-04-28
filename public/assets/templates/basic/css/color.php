<?php
header("Content-Type:text/css");
function checkhexcolor($color) {
    return preg_match('/^#[a-f0-9]{6}$/i', $color);
}

if (isset($_GET['color']) AND $_GET['color'] != '') {
    $color = "#" . $_GET['color'];
}

if (!$color OR !checkhexcolor($color)) {
    $color = "#336699";
}

?>
.text--base,.what-item__icon,.what-item:hover .title,.feature-item__icon,.faq-item.open .faq-item__title .title,.testimonial-item__thumb .quote-icon,.post-item:hover .title a,.social-links li a:hover,.footer-links li a:hover,.footer-contact li a:hover,.header-contact li a:hover,.forgot-pass:hover,.info-content a:hover,.post-share li a:hover,.date,.title a:hover,.dashboard-menu li a:hover,.account-submenu li a:hover,.dashboard-menu li a.active,.menu li a.active,.custom--checkbox input:checked~label::before{
    color:<?php echo $color ?> !important;
}
.video-button::before, .video-button::after,.video-button,.faq-item__title::before, .faq-item__title::after,.post-item__content .tag,.info-item .info-icon,.recent-post-wrapper > .title::before,.custom--card .card-header, .custom--card .card-footer,.bg--base,.table thead tr th,.scrollToTop,.header-trigger span::after, .header-trigger span::before,.header-trigger span{
    background:<?php echo $color ?> !important;
}
.slick-dots li button{
    background:<?php echo $color ?>4d !important;
}
.slick-dots li button::before{
    border:3px solid <?php echo $color ?>cc !important;
}
.btn--base{
    background-color: <?php echo $color ?> !important;
    border: 1px solid <?php echo $color ?> !important;
}
.account-btn{
    box-shadow: 0 5px 25px <?php echo $color ?>99 !important;
}
.form--control:focus{
    border: 2px solid <?php echo $color ?> !important;
}
.input-group:focus-within .input-group-text{
    border-color:<?php echo $color ?> !important;
}
.custom--card{
    box-shadow: 0 0 3px 0 <?php echo $color ?> !important;
}
.cmn--btn{
    background: <?php echo $color ?> !important;
    border: 2px solid <?php echo $color ?> !important;
}
.cmn--btn:hover{
    border: 2px solid <?php echo $color ?> !important;
}
.user .user-thumb{
    border:1px solid <?php echo $color ?> !important;
}
.account-submenu{
    box-shadow: 0 3px 8px <?php echo $color ?>4d !important;
}
.table{
    box-shadow: 0 0 5px 0 <?php echo $color ?>8a !important;
}
.pagination .page-item.active span, .pagination .page-item.active a, .pagination .page-item:hover span, .pagination .page-item:hover a{
    background:<?php echo $color ?> !important;
    border-color:<?php echo $color ?> !important;
}
.pagination .page-item a{
    color:<?php echo $color ?> !important;
    border-color:<?php echo $color ?>33 !important;
}

.coin .back,.coin .front_b,.coin .back_b,.coin:before{
    background:<?php echo $color ?> !important;
}
.coin .front_b:before,.coin .back:before {
    border:10px solid <?php echo $color ?> !important;
}
::-webkit-scrollbar-thumb,::-webkit-scrollbar-thumb:hover{
    background:<?php echo $color ?> !important;
}
.spinner{
    border-top-color: <?php echo $color ?> !important;
    border-bottom-color: <?php echo $color ?> !important;
}
.spinner .spinner-center{
    background: <?php echo $color ?> !important;
}

.dashboard-card__icon{
    color:<?php echo $color ?> !important;
}
.copied:after{
    background-color: <?php echo $color ?> !important;
}

.form--control::file-selector-button{
    background: <?php echo $color ?> !important;
}

.form--control:hover::file-selector-button {
    background: <?php echo $color ?> !important;
}