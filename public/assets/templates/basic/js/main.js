"user strict";

// Preloader
$(window).on("load", function () {
    $(".preloader").fadeOut(1000);
});

//Menu Dropdown
$("ul>li>.sub-menu").parent("li").addClass("has-sub-menu");

$(".menu li a").on("click", function () {
    var element = $(this).parent("li");
    if (element.hasClass("open")) {
        element.removeClass("open");
        element.find("li").removeClass("open");
        element.find("ul").slideUp(300, "swing");
    } else {
        element.addClass("open");
        element.children("ul").slideDown(300, "swing");
        element.siblings("li").children("ul").slideUp(300, "swing");
        element.siblings("li").removeClass("open");
        element.siblings("li").find("li").removeClass("open");
        element.siblings("li").find("ul").slideUp(300, "swing");
    }
});

// Responsive Menu
var headerTrigger = $(".header-trigger");
headerTrigger.on("click", function () {
    $(".menu").toggleClass("active");
    $(".overlay").toggleClass("active");
});

// Overlay Event
var over = $(".overlay");
over.on("click", function () {
    $(".overlay").removeClass("overlay-color");
    $(".overlay").removeClass("active");
    $(".menu, .header-trigger").removeClass("active");
    $(".header-top").removeClass("active");
});

// Sticky Menu
window.addEventListener("scroll", function () {
    var header = document.querySelector(".header");
    if (header) {
        header.classList.toggle("sticky", window.scrollY > 0);
    }
});

// Scroll To Top
var scrollTop = $(".scrollToTop");
$(window).on("scroll", function () {
    if ($(this).scrollTop() < 500) {
        scrollTop.removeClass("active");
    } else {
        scrollTop.addClass("active");
    }
});

//Click event to scroll to top
$(".scrollToTop").on("click", function () {
    $("html, body").animate(
        {
            scrollTop: 0,
        },
        300
    );
    return false;
});



//Faq
$(".faq-item__title").on("click", function (e) {
    var element = $(this).parent(".faq-item");
    if (element.hasClass("open")) {
        element.removeClass("open");
        element.find(".faq-item__content").removeClass("open");
        element.find(".faq-item__content").slideUp(300, "swing");
    } else {
        element.addClass("open");
        element.children(".faq-item__content").slideDown(300, "swing");
        element.siblings(".faq-item").children(".faq-item__content").slideUp(300, "swing");
        element.siblings(".faq-item").removeClass("open");
        element.siblings(".faq-item").find(".faq-item__content").slideUp(300, "swing");
    }
});

$(".user-thumb").on("click", function () {
    $(".dashboard__sidebar").addClass("active");
    $(".overlay").addClass("active");
});

$(".single-select").on("click", function () {
    $(".single-select").removeClass("active");
    $(this).addClass("active");
});

$(".btn-close, .overlay").on("click", function () {
    $(".overlay").removeClass("active");
    $(".menu").removeClass("active");
});



$(".how-item").on("mouseover", function () {
    $(".how-item").removeClass("active");
    $(this).addClass("active");
});

// Dashbaord Sidebar Icon
$(".dashboard-menu>li>.dashboard-submenu").parent("li").addClass("has-submenu");
$(".dashboard-menu>li>a").on("click", function () {
    $(this).siblings(".dashboard-submenu").slideToggle();
});

$(".dashboard-submenu li a.active").parent("li").addClass("d-block");

$(".dashboard-sidebar-toggler").on("click", function () {
    $(".dashboard-sidebar").addClass("active");
});

$(".sidebar-close").on("click", function () {
    $(".dashboard-sidebar").removeClass("active");
});

