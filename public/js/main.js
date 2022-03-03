console.log('first');
$('#logout-button').on('click',function(){
    console.log('second');
    $('#logout').submit();
   
})
$('.navbar .fa-bars').click(function(){
    $('.smart').toggleClass('visible');
    $('.modal__bg').toggleClass('visible');
})