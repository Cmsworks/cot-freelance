$(document).on("change", "#locselectcountry", function(){
    var country = $(this).val();
    var region_id = 'locselectregion';
    var city_id = 'locselectcity';
    var Parent = $('#'+region_id).parent();

    var regionOptionFirst = $('#'+ region_id).find('option:first').text();
    var cityOptionFirst = $('#'+city_id).find('option:first').text();

    $('#'+ region_id).html('<option value="0">' + regionOptionFirst + '</option>');
    $('#'+city_id).html('<option value="0">' + cityOptionFirst + '</option>');

    $('#'+region_id).attr('disabled', 'disabled');
    $('#'+city_id).attr('disabled', 'disabled');

    $('#'+region_id+'_name').val('');
    $('#'+city_id+'_name').val('');

    $('#loading').remove();

    if (country != '0'){
        var loader_bg = $('<span>', {
            id: "loading",
            class: "loading"
        }).css('position', 'absolute').css('opacity', 0);
        loader_bg.html('<img src="./images/spinner.gif" alt="loading" alt="Loading...">');
        Parent.append(loader_bg).css('opacity', 0.5);
        $('#'+region_id).html('<option> --- </option>');

        $.get('index.php?r=locationselector', { country: country }, function(data) {
            var opts = '';
            $.each(data.regions, function(index, value) {
               opts = opts + '<option value="'+index+'">'+value+'</option>';
            });
            $('#'+region_id).html(opts);
            if (data.disabled == 0){
                $('#'+region_id).attr('disabled', null);
            }
            loader_bg.remove();
            Parent.css('opacity', 1);
        }, "json");
    }else{

    }
});

$(document).on("change", "#locselectregion", function(){
    var id = $(this).attr('id');
    var region = $(this).val();
    var city_id = 'locselectcity';

    var Parent = $('#'+city_id).parent();

    var cityOptionFirst = $('#'+city_id).find('option:first').text();
    $('#'+city_id).html('<option value="0">' + cityOptionFirst + '</option>');

    $('#'+ id +'_name').val($('#'+ id + ' option:selected').text());
    $('#'+city_id+'_name').val('');

    $('#loading').remove();

    $('#'+city_id).attr('disabled', 'disabled');

    if (region != '0'){
        var loader_bg = $('<span>', {
            id: "loading",
            class: "loading"
        }).css('position', 'absolute').css('opacity', 0);
        loader_bg.html('<img src="./images/spinner.gif" alt="loading" alt="Loading...">');
        Parent.append(loader_bg).css('opacity', 0.5);
        $('#'+city_id).html('<option> --- </option>');

        $.get('index.php?r=locationselector', { region: region }, function(data) {
            var opts = '';
            $.each(data.cities, function(index, value) {
                opts = opts + '<option value="'+index+'">'+value+'</option>';
            });
            $('#'+city_id).html(opts);
            if (data.disabled == 0){
                $('#'+city_id).attr('disabled', null);
            }
            loader_bg.remove();
            Parent.css('opacity', 1);
        }, "json");
    }else{

    }
});

$(document).on("change", "#locselectcity", function(){
    var id = $(this).attr('id');
    $('#'+ id +'_name').val($('#'+ id + ' option:selected').text());
});
