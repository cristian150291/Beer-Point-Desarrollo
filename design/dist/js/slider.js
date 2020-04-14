$(document).ready(function(){
    let imgItem = $('.slider li').length;
    let imgPos = 1;

    for(i = 1; i <= imgItem; i++){
        $('.pagination').append('<li><span class="icon-mug"></span></li>');
    }

    $('.slider li').hide();
    $('.slider li:first').show();
    $('.pagination li:first').css({'color': '#CD6E2E'});

    $('.pagination li').click(pagination);
    $('.right span').click(nextSlider);
    $('.left span').click(prevSlider);  
    
    setInterval(function(){
        nextSlider();
        clearInterval(nextSlider);
    },4000);


    function pagination(){
        let = paginationPos = $(this).index() + 1;

        $('.slider li').hide();
        $('.slider li:nth-child('+ paginationPos +')').fadeIn();

        $('.pagination li').css({'color': '#858585'});
        $(this).css({'color': '#CD6E2E'});
        

        imgPos = paginationPos;
    }

    function nextSlider(){
        if(imgPos >= imgItem){
            imgPos = 1;
        }else{
            imgPos++;
        }

        $('.pagination li').css({'color': '#858585'});
        $('.pagination li:nth-child('+ imgPos +')').css({'color': '#CD6E2E'});

        $('.slider li').hide();
        $('.slider li:nth-child('+ imgPos +')').fadeIn();
    }

    function prevSlider(){
        if(imgPos == 1){
            imgPos = imgItem;
        }else{
            imgPos--;
        }

        $('.pagination li').css({'color': '#858585'});
        $('.pagination li:nth-child('+ imgPos +')').css({'color': '#CD6E2E'});

        $('.slider li').hide();
        $('.slider li:nth-child('+ imgPos +')').fadeIn();
    }
});