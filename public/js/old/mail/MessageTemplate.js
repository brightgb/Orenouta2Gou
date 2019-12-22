$(function(){
    $('.modal-mstemp-open').on('click',function(){
        openModal('modal-mstemp');
    });

    $('.mstemp-ins-btn').on('click',function(){
        $('textarea[name="mail_txt"]').val($(this).val());
        closeModal('modal-mstemp');
    });

    $('.mstemp-edit-btn').on('click',function(){
        window.location.href = $(this).val();
    });
});