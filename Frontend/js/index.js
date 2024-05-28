SNIPPET_CONTAINER_ID = 'snippet-container';
TAG_CONTAINER_ID = 'tags-container';

$.ajax({
    method: 'GET',
    url: BASE_URL + BASE_PATH_API + 'get_all_tags.php',
    xhrFields: {
        withCredentials: true
    },
    dataType: "text",
    success: function(data) {
        $('#' + TAG_CONTAINER_ID).append(data);
    }
});

$.ajax({
    method: 'GET',
    url: BASE_URL + BASE_PATH_API + 'all_snippet_data.php',
    xhrFields: {
        withCredentials: true
    },
    dataType: "text",
    success: function(data) {
        $('#' + SNIPPET_CONTAINER_ID).append(data);
    }
});