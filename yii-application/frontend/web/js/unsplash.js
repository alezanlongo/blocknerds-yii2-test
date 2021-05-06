$(".add_to_collection").click(function() {
    var unsplash_id = $(this).data('unsplash-id');
    $("[name='unsplash_id']").val(unsplash_id);
});

$(".save_to_collection").click(function() {
    $('#modal_collection').modal('toggle');
    var id = $("[name='unsplash_id']").val();
    $.ajax({
            url: '/image/ajax',
            type: 'post',
            data: {
                '_csrf-frontend': csrf,
                'Image': {
                    collection_id: $("#collection-id").val(),
                    author: $("[name='author_" + id + "']").val(),
                    description: $("[name='title_" + id + "']").val(),
                    url: $("[name='url_" + id + "']").val()
                }
            },
            success: function(data) {
                console.log(data);
            },
        }).done(function() {
            alert('Image added successfully to your collection!');
        })
        .fail(function() {
            alert("Something went wrong try again later =(.");
        });
});