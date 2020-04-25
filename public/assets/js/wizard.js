
(function ($) {
    var sizeItem = ($('.item-elt-bar').length); /* nombre d'etape */
    var sizeTimelineVisible = 5 /* nombre d'etape */
    var widthItem = (1/(sizeTimelineVisible))*100;      /* largeur de chaque bloc timeline */
    var currentstape = parseInt($('#line-progress').data('stape')); /* etape courente */
    var widthCal = ((currentstape) * 100)/(sizeTimelineVisible); /* largeur de la progressbar */

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
        
        $('.item-elt-bar').css('width', widthItem+'%');
        currentstape = parseInt($('#line-progress').data('stape'));

        /* Zone d'animation de la timeline */
        if(currentstape <= sizeTimelineVisible ){
            widthCal = ((currentstape) * 100)/(sizeTimelineVisible); 
            if(widthCal > ((sizeTimelineVisible-1)/(sizeTimelineVisible))*100)
                $('#line-progress').css('width', widthCal+'%')
            else
                $('#line-progress').css('width', (widthCal-0.3)+'%')
            /*for (var i = 1; i < currentstape; i++) {
                $('.item-elt-bar').eq(i).addClass('completed');
            }*/
        }
    }
    procedStape();

    gotoNext = function(){
        $('#solution-popup .item-elt-bar').eq(currentstape-1).addClass('completed');
        var stapeNext = currentstape+1;
        if(stapeNext <= sizeItem){
            $('#line-progress').data('stape', stapeNext);
            $('#solution-popup .stape-item').removeClass('active');
            $('#solution-popup .item-elt-bar').removeClass('active');
            $('#solution-popup .stape-item').eq(stapeNext-1).addClass('active');
            $('#solution-popup .item-elt-bar').eq(stapeNext-1).addClass('active');
            if($('#solution-popup .stape-item').eq(4).hasClass('active'))
                $('#solution-popup .btn-next').text('Terminer');  

            procedStape();
        }
    }
    changeStape = function($evolution){
        if($evolution == "next"){
            gotoNext();
        }else{
            var stapePrev = currentstape-1;
            if(stapePrev >=1){
                $('#line-progress').data('stape', stapePrev);
                $('#solution-popup .stape-item').removeClass('active');
                $('#solution-popup .item-elt-bar').removeClass('active');
                $('#solution-popup .stape-item').eq(stapePrev-1).addClass('active');
                $('#solution-popup .item-elt-bar').eq(stapePrev-1).addClass('active');
                $('#solution-popup .btn-next').removeClass('end-stape');
                $('#solution-popup .btn-next').text('suivant');
                procedStape();
            }
        }
    }
    $('.stape-nav .content-nav-btn .btn-prev').click(function(){
        changeStape('prev');
    });
    $('.stape-nav .content-nav-btn .btn-next').click(function(){
        if ($('#solution-popup .btn-next').hasClass('end-stape')) {
            console.log("fin de l'inscription");
            return false;
        }
        validateStape(currentstape);
    });

    validateStape = function(stape){
        if(stape == 1){
            if($('.stape-nav .content-nav-btn .btn-next').hasClass('inscription-complete')){
                gotoNext();
                return true;
            }
            function validate(){
                try{
                    var validator = $('#infoPersonnelle').validate({
                        rules:{
                            prenom:{
                                required:true
                            },
                            second_name:{
                                required:true
                            },
                            nom_famille:{
                                required:true
                            },
                            nationalite:{
                                required:true
                            },
                            email:{
                                required:true,
                                email:true
                            },
                            telephone:{
                                required:true,
                            },
                            jour_naiss:{
                                required:true,
                                number:true
                            },
                            mois_naiss:{
                                required:true,
                            },
                            annee_naiss:{
                                required:true,
                                number:true
                            },
                            lieu_naiss:{
                                required:true,
                            },
                            ident_type:{
                                required:true,
                            },
                            ident_number:{
                                required:true,
                                number:true
                            },
                            pays_residence:{
                                required:true,
                            },
                            adresse:{
                                required:true,
                            },
                            province:{
                                required:true,
                            },
                            ville:{
                                required:true,
                            },
                            codepostal:{
                                required:true,
                            }
                        }
                    });
                    
                    var $validated = $('#infoPersonnelle').valid();
                    return $validated;
                }catch(error){
                    console.log(error)
                }
            }
            if( !validate()){
                toastr.error("Tous les champs sont obligatoires.");
                return false;
            }
            else{
                var form = document.forms.namedItem("infoPersonnelle");
                submitting("loading");
                oData = new FormData(form);
                var oReq = new XMLHttpRequest();
                oReq.open("POST", $('body').data('base-url')+'inscription/save-infos-pers', true);
                oReq.onload = function(oEvent) {
                    if (oReq.status == 200) {
                        toastr.success("Enregistrement reussi");
                        submitting("reset");
                        gotoNext();
                    } else {
                        toastr.error(oReq.response);
                        submitting("reset");
                        return false;
                    }
                };
                oReq.send(oData);  
            } 
        }
        else if(stape == 2){
            if($('.stape-nav .content-nav-btn .btn-next').hasClass('inscription-complete')){
                gotoNext();
                return true;
            }

            if($('form[name=apropos_vous] input:radio[name="statut_emploi"]:checked').val() == undefined ){
                toastr.error("Aucun choix fait pour le Statut d'emploi");
                return false;
            }
            else if($('form[name=apropos_vous] input:radio[name="revenue_annuel"]:checked').val() == undefined ){
                toastr.error("Aucun choix fait pour le Revenu annuel estimé");
                return false;
            }
            else if($('form[name=apropos_vous] input:radio[name="invest_economie"]:checked').val() == undefined ){
                toastr.error("Aucun choix fait pour l' Économies et investissements estimé");
                return false;
            }
            else if($('form[name=apropos_vous] input:radio[name="depot"]:checked').val() == undefined ){
                toastr.error("Aucun choix fait pour le Dépôt prévu estimé");
                return false;
            }
            else if($('form[name=apropos_vous] input:radio[name="source_fond"]:checked').val() == undefined ){
                toastr.error("Aucun choix fait pour la Source de fonds");
                return false;
            }
            else if($('form[name=apropos_vous] input:radio[name="nbr_transaction"]:checked').val() == undefined ){
                toastr.error("Aucun choix fait pour le Nombre de transactions par semaine");
                return false;
            }
            else if($('form[name=apropos_vous] input:radio[name="qte_echange"]:checked').val() == undefined ){
                toastr.error("Aucun choix fait pour la Quantité d'échange par semaine");
                return false;
            }
            else{
                var form = document.forms.namedItem("apropos_vous");
                submitting("loading");
                oData = new FormData(form);
                var oReq = new XMLHttpRequest();
                oReq.open("POST", $('body').data('base-url')+'inscription/save-apropos-vous', true);
                oReq.onload = function(oEvent) {
                    if (oReq.status == 200) {
                        toastr.success("Enregistrement reussi");
                        submitting("reset");
                        gotoNext();
                    } else {
                        toastr.error(oReq.response);
                        submitting("reset");
                        return false;
                    }
                };
                oReq.send(oData);  
            } 
        }
        else if(stape == 3){
            if($('.stape-nav .content-nav-btn .btn-next').hasClass('inscription-complete')){
                gotoNext();
                return true;
            }

            if($('.stape-nav .content-nav-btn .btn-next').hasClass('inscription-complete'))
                return true;

            if($('form[name=configurationCompte] input:radio[name="trading_plateform"]:checked').val() == undefined ){
                toastr.error("Choisissez la plateforme de trading");
                return false;
            }
            else if($('form[name=configurationCompte] input:radio[name="account_type"]:checked').val() == undefined ){
                toastr.error("Choisissez le type de compte");
                return false;
            }
            else if($('form[name=configurationCompte] input:radio[name="devise"]:checked').val() == undefined ){
                toastr.error("Choisissez la devise du compte");
                return false;
            }
            else if($('form[name=configurationCompte] input:checkbox[name="cgu"]:checked').val() == undefined ){
                toastr.error("Acceptez les Conditions generales d'utilisation");
                return false;
            }
            else{
                var form = document.forms.namedItem("configurationCompte");
                submitting("loading");
                oData = new FormData(form);
                var oReq = new XMLHttpRequest();
                oReq.open("POST", $('body').data('base-url')+'inscription/configuration-compte', true);
                oReq.onload = function(oEvent) {
                    if (oReq.status == 200) {
                        toastr.success("Enregistrement reussi");
                        submitting("reset");
                        gotoNext();
                    } else {
                        toastr.error(oReq.response);
                        submitting("reset");
                        return false;
                    }
                };
                oReq.send(oData);  
            } 
        }
        if(stape == 4){
            if($('.stape-nav .content-nav-btn .btn-next').hasClass('inscription-complete')){
                gotoNext();
                return true;
            }
            var identite = document.getElementsByClassName("input-identite")[0];
            var residence = document.getElementsByClassName("input-residence")[0];
            if (identite.files.length == 0){
                toastr.error("Telecharger le fichier d'identité");
                return false;
            }
            else if (residence.files.length == 0){
                toastr.error("Telecharger le fichier de residence");
                return false;
            }
            else{
                var form = document.forms.namedItem("identiteForm");
                submitting("loading");
                oData = new FormData(form);
                var oReq = new XMLHttpRequest();
                oReq.open("POST", $('body').data('base-url')+'inscription/confirmation-identite', true);
                oReq.onload = function(oEvent) {
                    if (oReq.status == 200) {
                        toastr.success("Enregistrement reussi");
                        submitting("reset");
                        gotoNext();
                    } else {
                        toastr.error(oReq.response);
                        submitting("reset");
                        return false;
                    }
                };
                oReq.send(oData);  
            }
        }
        else if(stape == 5){

            $('#solution-popup .btn-next').addClass('end-stape');
            return true;
        }
        return false;
    }

    submitting = function(state){
        if(state == "loading"){
            $('.lds-ripple').css('display','inline-block');
            $('.btn-next').addClass('no-click');
        }
        else if(state == "reset"){
            $('.lds-ripple').css('display','none');
            $('.btn-next').removeClass('no-click');
        }
    }

    /* ecouteur de selection d'option */
    $('form[name=problemForm]').on('change', 'input:radio[name="problem"]', function(e) {
        console.log(this.value);
        $that = $(this);
        $('form[name=problemForm] input:radio[name="problem"]').parent().removeClass('check');
        $that.parent().addClass('check');
    });
}(jQuery));
