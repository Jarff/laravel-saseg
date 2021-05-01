// Default SortableJS
import Sortable from 'sortablejs';

export default (() => {
    document.addEventListener('DOMContentLoaded', () => {
        var data = {selected: '.row-sortable', index: 0};
        var element;
        waitForElClass(data, function(el) {
            element = el;
            console.log(element);
            if(element){
                let el = document.querySelector('.table-sortable .table.dataTable > tbody');
                var sortable = Sortable.create(el, {
                    animation: 150,
                    ghostClass: 'blue-background-class',
                });
            }
        }); 
    });
    var i =1;
    function waitForElClass(data, cb){
        var element = data.selected;
        var index = data.index;

        // var findEl = document.getElementsByClassName(element)[index];
        var findEl = document.querySelector(element);
        console.log(i);
        i++;
        var to = window.setInterval(function(){
            if(window.LaravelDataTables){
                cb(window.LaravelDataTables);
                window.clearInterval(to);
            }
        },500)
    }
})();