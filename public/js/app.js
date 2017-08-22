(function() {
    var doPost = function(url, data, callback) {
        var request = new XMLHttpRequest();
        request.open('POST', url);
        request.setRequestHeader('content-type', 'application/json');
        request.timeout = 3000;
        request.onreadystatechange = function() {
            var isJsonResponse = /application\/json/.test(request.getResponseHeader('content-type'))
            if (request.readyState == 4 && isJsonResponse) {
                callback(JSON.parse(request.responseText));
            }
        };
        request.send(JSON.stringify(data));
    };

    document.addEventListener('DOMContentLoaded', function() {
        var formElement = document.querySelector('form.post-editor');
        var idElement = document.querySelector('form.post-editor input[name=id]');
        var contentElement = document.querySelector('form.post-editor textarea');

        var doSavePost = function() {
            var id = parseInt(idElement.value);
            var action = id > 0 ? 'update' : 'create';
            doPost('/?action='+action, {
                id: id,
                content: contentElement.value,
            }, function(response) {
                idElement.value = response.id;
            });
        };

        contentElement.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.key == 's') {
                doSavePost();
            }
        });

    }, false);
})();
