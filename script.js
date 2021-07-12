$(document).ready(function() {
    $("#frm-convert").submit(function(e) {
        $("#frm-convert button[type=submit]").html("<i class=\"fas fa-spin fa-sync-alt\"></i> Converting... Please wait");

        e.preventDefault();
        $.get($(this).attr("action"), { youtubelink: $('#link').val(), format: $('#format').val() },  function(data) {
            $("#convert-response pre").text(JSON.stringify(data, null, 4));
            $("#frm-convert button[type=submit]").html("<i class=\"fa fa-sync-alt\"></i> Convert");

            if(data.error) {
                $("#convert-response table tr:eq(0) td:last").html("<i class=\"fa fa-check\"></i>");
                $("#convert-response table tr:eq(1) td:last").text(data.message);
                $("#convert-response table tr:eq(2) td:last").text("-");
                $("#convert-response table tr:eq(3) td:last").text(0);
                $("#convert-response table tr:eq(4) td:last").text("-");
                $("#convert-response table tr:eq(5) td:last").text("-");
                
                $("#download").attr("href", "#").addClass("disabled");
                $("#remove").addClass("disabled");
            } else {
                $("#convert-response table tr:eq(0) td:last").html("<i class=\"fa fa-times\"></i>");
                $("#convert-response table tr:eq(1) td:last").text("-");
                $("#convert-response table tr:eq(2) td:last").text(data.title + " (" + data.alt_title + ")");
                $("#convert-response table tr:eq(3) td:last").text(data.duration);
                $("#convert-response table tr:eq(4) td:last").text(data.youtube_id);
                $("#convert-response table tr:eq(5) td:last").text(new Date(data.uploaded_at.date));

                $("#download").attr("href", data.file).removeClass("disabled");
                $("#remove").removeClass("disabled").data("id", data.youtube_id);
            }
        });
    });

    $("#remove").click(function() {
        $.get("convert.php", { delete: $(this).data("id") }, function(data) {
            alert(data.message);
        });
    });

    $('#frm-search').submit(function (e) {
        e.preventDefault();

        $.get($(this).attr('action'), { q: $('#q').val(), max_results: $('#max_results').val() }, function (data) {

            $("#search-response table tr:eq(2) td:last ul").empty();

            if(data.error) {
                $("#search-response table tr:eq(0) td:last").html("<i class=\"fa fa-check\"></i>");
                $("#search-response table tr:eq(1) td:last").html(data.message);
            } else {
                $("#search-response table tr:eq(0) td:last").html("<i class=\"fa fa-times\"></i>");
                $("#search-response table tr:eq(1) td:last").html('-');

                Array.from(data.results).forEach( el => {
                    var btn = $('<button>', { class: 'ms-3 btn btn-sm btn-outline-secondary', text: 'Convert',  onclick: '$("#link").val("' + el.full_link + '"); return false;' });
                    var a = $('<a>', { href: el.full_link, text: el.title});
                    var item = $('<li>');
                    a.appendTo(item);
                    btn.appendTo(item);

                    item.appendTo('#search-response table tr:eq(2) td:last ul');
                });
            }
        });
    });
});