require(['jquery', 'sortable'], function ($, Sortable) {
    var el = document.getElementById('list-teams');
    var sortable = Sortable.create(el);
});