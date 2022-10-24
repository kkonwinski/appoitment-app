// ajax GET to  https://ui-avatars.com/
$(function () {
    //get value span from user-fullname class
    let fullName = $('.user-fullname').text();


    var url = 'https://ui-avatars.com/api/?name=' + fullName + '&background=random';
    console.log(url);
    $('.img-profile').attr('src', url);
});

