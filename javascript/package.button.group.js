jQuery(document).ready(function() {
    buttongroup.loadEvents();
});

var buttongroup = {
    recordId: null,
    actions: {
        'create': function (obj, button) {
            return obj.defaultAction();
        },
        'read': function (obj, button) {
            var url = $(button).attr('data-url');
            obj.readAction(url);
        },
        'update': function (obj, button) {
            return 'update';
        },
        'delete': function (obj, button) {
            var url = $(button).attr('data-url');
            obj.deleteAction(url);
        },
        'default': function (action) {
            alert('Unknown action type [' + action + ']');
            console.log('Unknown action type [' + action + ']');
            return false;
        }
    },
    loadEvents: function () {
        var listItem = $("li.list-item a");
        if (!listItem[0]) return false;

        var self = this;

        listItem.on('click', function(e) {
            e.preventDefault();
            var action = $(this).attr('data-action');
            var recordId = $(this).attr('data-id');
            if (!recordId && action !== 'new') {
                console.log('Row id is undefined. Please look into the package documentation');
                alert('Row id is undefined. Please look into the package documentation');
                return false;
            }
            self.recordId = recordId;
            //if action is in actions object
            if (self.actions[action]) {
                fn =  self.actions[action];
                fn(self, this);
            } else {
                //if not we call default action
                fn =  self.actions['default'];
                fn(action);
            }

        });
    },
    createAction : function (event, elem) {
        var firstInpuName = $(elem).closest('tr').find('td').each(function() {
            console.log($(this).data('id'));
            console.log($(this).data('name'));
        });
        console.log(firstInpuName);
    },
    readAction : function (url) {
        if(!url) {
            url = location.pathname;
        }
        window.location.href = [location.protocol, '//', location.host, url, '/', this.recordId].join('');
    },
    deleteAction : function(url) {
        $.ajax({
            type: "POST",
            url: url,
            data: { id: this.recordId , '_method': 'delete', '_token': window.Laravel.csrfToken},
            dataType: "json",
            success: function(response)
            {

            }
        });
    },
    defaultAction : function (event, element) {
        return 'default';
    }
};



