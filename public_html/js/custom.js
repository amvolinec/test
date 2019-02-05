(function ($) {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Tabs Navigate
    $(document).on({
        click: function () {

            // Get city id from navigation item
            var divId = '#' + $(this).attr('data-slug');
            var div = $(divId);

            // Check is div in DOM
            if (div.is('div')) {

                // Deactivate active menu item and hide current Tab
                $deactivate();

                // Activate selected menu item
                $(this).find('a.nav-link').addClass('active');

                // Show selected Tab
                div.removeClass('hidden');
            }
        }
    }, '.nav-item');

    // Validate form on Enter key pressed
    $('#testCity').keypress(function (e) {
        if (e.which == 13) {
            $(".btn-success").click();
            return false;
        }
    });

    // POST Ajax request
    $(".btn-success").click(function (e) {

        e.preventDefault();

        var apikey = $("input[name=apikey]").val();
        var city = $("input[name=city]").val();

        $.ajax({
            type: 'POST',
            url: '/ajaxApi',
            data: {apikey: apikey, city: city},
            success: function (response) {
                if (response.success) {

                    $('.alert').addClass('hidden');

                    // Add Item to the menu and create new Tab
                    $addItem(response.result);
                } else {
                    $alert(response.result);
                }
            }
        });
    });

    var $addItem = function (data) {

        // Create New Nav Item
        var li = '<li class="nav-item" data-slug="' + data.slug + '">' +
            '<a class="nav-link active" href="#">' + data.name + '</a>' +
            '</li>';

        var info = ' temperature from ' + data.temp_min + ' to ' + data.temp_max + ' °С, wind ' + data.speed
            + ' m/s., clouds ' + data.all + ' %, ' + data.humidity + '  hpa';

        var d = $('.tabs-inner #' + data.slug);

        // Deactivate active menu item and hide current Tab
        $deactivate();

        //  Check is Tab && Div NOT created
        if (!d.is('div')) {
            // Create New City div from empty div #emptyInner
            var div = $('#emptyInner').clone().attr('id', data.slug);

            // Prepend New Menu Item
            $('.nav-tabs').prepend(li);

            //Add new Tab
            $('.tabs-inner').prepend(div);

            d = $('.tabs-inner #' + data.slug);
        } else {
            var a = '.nav-item[data-slug="' + data.slug + '"] a.nav-link';
            console.log(a);
            $(a).addClass('active');
        }

        // Push Data to spans
        d.find('.city-temp').html(data.temp);
        d.find('.city-clouds').html(data.description);
        d.find('.city-info').html(info);
        d.find('.city-country').html(data.country);
        d.removeClass('hidden');
    };


    var $alert = function (text) {
        $('.alert').html(text).removeClass('hidden').addClass('alert-danger');
    };

    // Deactivate Tab
    var $deactivate = function () {

        // Remove class 'active' from menu item
        $('.active').removeClass('active');

        // Hide Other cities.
        $('.city-inner:not(".nidden")').addClass('hidden');
    }
})(jQuery);

