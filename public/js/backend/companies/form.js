$(function(){
    
    // init: side menu for current page
    $('li#menu-users').addClass('menu-open active');
    $('li#menu-users').find('.treeview-menu').css('display', 'block');
    $('li#menu-users').find('.treeview-menu').find('.edit-users a').addClass('sub-menu-active');

    $('#user-form').validationEngine('attach', {
        promptPosition : 'topLeft',
        scroll: false
    });

    // init: show tooltip on hover
    $('[data-toggle="tooltip"]').tooltip({
        container: 'body'
    });

});