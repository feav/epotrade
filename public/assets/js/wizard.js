
(function ($) {
    var sizeItem = ($('.item-elt-bar').length); /* nombre d'etape */
    var sizeTimelineVisible = 6 /* nombre d'etape */
    var widthItem = (1/(sizeTimelineVisible -1))*100;      /* largeur de chaque bloc timeline */
    var currentstape = parseInt($('#line-progress').data('stape')); /* etape courente */
    var widthCal = ((currentstape) * 100)/(sizeTimelineVisible -1); /* largeur de la progressbar */

    procedStape = function(){
        if($('#solution-popup .stape-item').eq(0).hasClass('active')){
            if(!$('#infoPerso').hasClass('is_connect'))
                $('#solution-popup .prenom-content').css('display','none');
            $('#solution-popup .btn-prev').css('display', 'none');
        }
        else{
            $('#solution-popup .btn-prev').css('display', 'block');
            $('#solution-popup .prenom-content').css('display', 'inline-block');
        }

        if($('#solution-popup .stape-item').eq(5).hasClass('active')){
            $('#solution-popup .btn-next').text('Terminer');   
            $('#solution-popup .btn-next').removeClass('payment-end');
        }else{
            $('#solution-popup .btn-next').text('suivant');
        }
        
        
        $('.item-elt-bar').css('width', widthItem+'%');
        currentstape = parseInt($('#line-progress').data('stape'));

        /* Zone d'animation de la timeline */
        if(currentstape <= sizeTimelineVisible ){
            widthCal = ((currentstape) * 100)/(sizeTimelineVisible -1); 
            if(widthCal > ((sizeTimelineVisible-2)/(sizeTimelineVisible -1))*100)
                $('#line-progress').css('width', widthCal+'%')
            else
                $('#line-progress').css('width', (widthCal)+'%')
            /*for (var i = 1; i < currentstape; i++) {
                $('.item-elt-bar').eq(i).addClass('completed');
            }*/
        }
    }
    procedStape();

    gotoNext = function(){
        var stapeNext = currentstape+1;
        if(stapeNext <= sizeItem){
            $('#line-progress').data('stape', stapeNext);
            $('#solution-popup .stape-item').removeClass('active');
            $('#solution-popup .item-elt-bar').removeClass('active');
            $('#solution-popup .stape-item').eq(stapeNext-1).addClass('active');
            $('#solution-popup .item-elt-bar').eq(stapeNext-1).addClass('active');
            procedStape();
        }
    }

    $('.stape-nav .content-nav-btn .btn-prev').click(function(){
        var stapePrev = currentstape-1;
        if(stapePrev >=1){
            $('#line-progress').data('stape', stapePrev);
            $('#solution-popup .stape-item').removeClass('active');
            $('#solution-popup .item-elt-bar').removeClass('active');
            $('#solution-popup .stape-item').eq(stapePrev-1).addClass('active');
            $('#solution-popup .item-elt-bar').eq(stapePrev-1).addClass('active');
            procedStape();
        }
    });
    $('.stape-nav .content-nav-btn .btn-next').click(function(){
        if ($('#solution-popup .btn-next').hasClass('end-stape')) {
            console.log("fin de l'inscription");
            return false;
        }

        if(validateStape(currentstape)){
            $('.lds-ripple').css('display','inline-block');
            setTimeout(function(){
                $('.lds-ripple').css('display','none');
                $('.item-elt-bar').eq(currentstape-1).addClass('completed');
                var stapeNext = currentstape+1;
                if(stapeNext <= sizeItem){
                    $('#line-progress').data('stape', stapeNext);
                    $('#solution-popup .stape-item').removeClass('active');
                    $('#solution-popup .item-elt-bar').removeClass('active');
                    $('#solution-popup .stape-item').eq(stapeNext-1).addClass('active');
                    $('#solution-popup .item-elt-bar').eq(stapeNext-1).addClass('active');
                    procedStape();
                }
            },2000)
        }
    });

    validateStape = function(stape){
        if(stape == 1){
            return true;
        }
        else if(stape == 2){
            return true;
        }
        else if(stape == 3){
           return true;
        }
        if(stape == 4){
           return true;
        }
        else if(stape == 5){
            return true;
        }
        return false;
    }

    /* ecouteur de selection d'option */
    $('form[name=problemForm]').on('change', 'input:radio[name="problem"]', function(e) {
        console.log(this.value);
        $that = $(this);
        $('form[name=problemForm] input:radio[name="problem"]').parent().removeClass('check');
        $that.parent().addClass('check');
    });
}(jQuery));
