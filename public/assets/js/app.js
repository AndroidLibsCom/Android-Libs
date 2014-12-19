init.push(function () {

    // Update libraries
    loadGitHubStats();

    // Initalize search functions
    searchLibraries();
    searchCategories();

    // Image functions
    suggestImage();
    setupSubmit();

    // Sharing functions
    prepareSharrreButtons();
    prepareSharrreCountersButtons();

    // Setup select boxes
    $('.enable-select2').select2();

    // Setup max-length inputs
    $('.max-length-input').maxlength({
        alwaysShow: true
     });

});



function loadGitHubStats()
{
    var libBox = $('.lib-row .box');
    libBox.each(function () {
        var curBox = $(this);
        var libId  = parseInt(curBox.attr('data-lib-id'));
        $.ajax({
            url: baseUrl + '/lib/get/stats',
            type: 'get',
            data: {
                id: libId
            },
            success: function(stats) {
                if(!stats.isGitHub) {
                    curBox.find('.gh-issues').html('&mdash;');
                    curBox.find('.gh-starred').html('&mdash;');
                    return false;
                }

                curBox.find('.gh-issues').html(stats.issues);
                curBox.find('.gh-starred').html(stats.starred);

            },
            error: function() {
                curBox.find('.gh-issues').html('<i class="fa fa-fw fa-exclamation-triangle"></i> ERROR');
                curBox.find('.gh-starred').html('<i class="fa fa-fw fa-exclamation-triangle"></i> ERROR');
            }
        });
    });
}

function searchLibraries()
{
    var input = $('.input-search');
    var btn   = $('.btn-search');
    var form  = $('.search-form');

    function libraryFormatResult(library) {
        var markup = "<table class='library-result'><tr>";
        if (library.img != null) {
            var image = JSON.parse(library.img)[0];
            markup += "<td class='library-image' style='vertical-align: top'><img src='" + baseUrl + '/assets/img/libs/' + image + '.png' + "' style='border: 1px solid #e7e7e7;max-width: 60px; display: inline-block; margin-right: 10px; margin-left: 10px;' /></td>";
        } else {
            markup += "<td class='library-image' style='vertical-align: top'><img src='" + baseUrl + '/assets/img/lib_placeholder.png' + "' style='border: 1px solid #e7e7e7;max-width: 60px; display: inline-block; margin-right: 10px; margin-left: 10px;' /></td>";
        }
        markup += "<td class='library-info'><div class='library-title' style='font-weight: 600; color: #000; margin-bottom: 6px;'>" + library.title + "</div>";
        if (library.categories != null) {
            markup += "<div class='library-category'>" + library.categories.name + "</div>";
        }
        markup += "</td></tr></table>";
        return markup;
    }

    function libraryFormatSelection(library) {
        return library.title;
    }




    // External source
    input.select2({
        placeholder: "Search for a library",
        minimumInputLength: 1,
        ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
            url: baseUrl + '/search/libraries/',
            type: 'post',
            dataType: 'json',
            data: function (term) {
                return {
                    query: term // search term
                };
            },
            results: function (data) { // parse the results into the format expected by Select2.
                // since we are using custom formatting functions we do not need to alter remote JSON data

                // Set the id to the slug to set the correct value
                $.each(data, function (key, val) {
                    val.id = val.slug;
                });
                return {results: data};
            }
        },
        initSelection: function(element) {
            // the input tag has a value attribute preloaded that points to a preselected movie's id
            // this function resolves that id attribute to an object that select2 can render
            // using its formatResult renderer - that way the movie name is shown preselected
            console.log(element);
        },
        formatResult: libraryFormatResult, // omitted for brevity, see the source of this page
        formatSelection: libraryFormatSelection,  // omitted for brevity, see the source of this page
        dropdownCssClass: "bigdrop", // apply css that makes the dropdown taller
        escapeMarkup: function (m) { return m; } // we do not want to escape markup since we are displaying html in results
    });

    input.on('change', function () {
        window.location.href = baseUrl + '/lib/' + input.val();
    });
}

function searchCategories()
{
    var select = $('.inputCategory');
    var btn    = $('.btn-category');
    var form   = $('.category-form');

    select.change(function () {
        if(select.find('option:selected').val().length > 0) {
            if(select.find('option:selected').val() == 'null') {
                // Show all libraries
                window.location.href = baseUrl;
            } else {
                // Normal redirect
                window.location.href = baseUrl + '/search/' + select.find('option:selected').val();
            }
        } else {
            alert("Please select a valid category.");
        }
    });
}

function suggestImage()
{
    var img         = $('.suggest-image-preview');
    var btn         = $('.btn-suggest-image');
    var input       = $('.suggest-image-input');
    var urlInput    = $('.suggest-image-url-input');
    var form        = $('.suggest-image-form');
    input.on('change', function () {
        previewImg(this, img);
    });

    //Submit
    btn.click(function (e) {
        e.preventDefault();
        var valid = false;

        // Clear errors
        setSuggestErrors(false, '', urlInput, input);

        // Check if both inputs are filled
        if( urlInput.val().length > 0 && input.val().length > 0 ) {
            setSuggestErrors(true, 'You can not fill both fields.', urlInput, input);
        }
        else if( urlInput.val().length == 0 && input.val().length == 0 ) {
            // No input given
            setSuggestErrors(true, 'Please fill at least one input.', urlInput, input);
        }
        else {
            valid = true;
        }

        // Submit form
        if(valid) {
            form.submit();
        }

    })
}

function prepareSharrreCountersButtons()
{
    var shareBtns = $('.sharrre-counters');
    shareBtns.each(function() {
        $(this).click(function (e) {
            e.preventDefault();
        });

        var isFb = $(this).hasClass('facebook');
        var isTw = $(this).hasClass('twitter');
        var isGp = $(this).hasClass('gplus');
        if(isFb)
        {
            $(this).sharrre({
                share: {
                    facebook: true
                },
                enableTracking: true,
                click: function(api) {
                    api.simulateClick();
                    api.openPopup('facebook');
                },
                template: '<i class="fa fa-fw fa-facebook"></i> Facebook <span class="badge badge-default pull-right">{total}</span>'
            });
        }
        else if(isTw)
        { 
            $(this).sharrre({
                share: {
                    twitter: true
                },
                enableTracking: true,
                click: function(api) {
                    api.simulateClick();
                    api.openPopup('twitter');
                },
                template: '<i class="fa fa-fw fa-twitter"></i> Twitter <span class="badge badge-default pull-right">{total}</span>'
            });
        }
        else if(isGp)
        {
            $(this).sharrre({
                share: {
                    googlePlus: true
                },
                enableTracking: true,
                click: function(api) {
                    api.simulateClick();
                    api.openPopup('googlePlus');
                },
                template: '<i class="fa fa-fw fa-google-plus"></i> Google+ <span class="badge badge-default pull-right">{total}</span>'
            });
        }
    });
}

function prepareSharrreButtons()
{
    var shareBtns = $('.sharrre');
    shareBtns.each(function() {
        $(this).click(function (e) {
            e.preventDefault();
        });

        var isFb = $(this).hasClass('facebook');
        var isTw = $(this).hasClass('twitter');
        var isGp = $(this).hasClass('gplus');
        if(isFb)
        {
            $(this).sharrre({
                share: {
                    facebook: true
                },
                enableTracking: true,
                click: function(api) {
                    api.simulateClick();
                    api.openPopup('facebook');
                },
                template: '<span class="btn-label icon fa fa-facebook"></span> Facebook'
            });
        }
        else if(isTw)
        {
            $(this).sharrre({
                share: {
                    twitter: true
                },
                enableTracking: true,
                click: function(api) {
                    api.simulateClick();
                    api.openPopup('twitter');
                },
                template: '<span class="btn-label icon fa fa-twitter"></span> Twitter'
            });
        }
        else if(isGp)
        {
            $(this).sharrre({
                share: {
                    googlePlus: true
                },
                enableTracking: true,
                click: function(api) {
                    api.simulateClick();
                    api.openPopup('googlePlus');
                },
                template: '<span class="btn-label icon fa fa-google-plus"></span> Google+'
            });
        }
    });
}

function setupSubmit()
{
    var input = $('.inputImage');
    var img   = $('.add-prev-img');
    input.on('change', function () {
        previewImg(this, img);
    });
}


window.PixelAdmin.start(init);


//"private" functions
function previewImg(input, img) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function () {
            img.attr('src', reader.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

function setSuggestErrors(setError, message, urlInput, input) {
    if(setError) {
        urlInput.closest('div.form-group').addClass('has-error');
        input.closest('div.form-group').addClass('has-error');
        urlInput.closest('div.form-group').find('.help-block').html(message).show();
        input.closest('div.form-group').find('.help-block').html(message).show();
    } else {
        urlInput.closest('div.form-group').removeClass('has-error');
        input.closest('div.form-group').removeClass('has-error');
        urlInput.closest('div.form-group').find('.help-block').hide();
        input.closest('div.form-group').find('.help-block').hide();
    }
}