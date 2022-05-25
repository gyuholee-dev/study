$(".menu>li").mouseover(function(){
    if($(".gnb_menu").is(":visible")){ 
        $(this).children(".submenu").stop().slideDown();
    }else{
        $(".submenu_back").stop().slideDown();
        $(".submenu").stop().slideDown();        
    }
})
$(".menu>li").mouseleave(function(){
    if($(".gnb_menu").is(":visible")){
        $(this).children(".submenu").stop().slideUp();
    }else{
        $(".submenu_back").stop().slideUp();
        $(".submenu").stop().slideUp();       
    }
})

$(".gnb_menu").click(function(){ 
    $("nav").css("display","block");
})

$(".btnClose").click(function(){
    $("nav").css("display","none");
    window.location.reload();
})

