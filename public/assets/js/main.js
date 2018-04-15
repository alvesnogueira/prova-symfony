$(document).ready(function() {
var url = "assets/js/json-estados.json";
    $.getJSON(url, function(json){
        var $select_elem = $("#uf");
        $select_elem.empty();
        $.each(json, function (idx, obj) {
            console.log(obj);
            $select_elem.append('<option value="' + obj.Sigla + '">' + obj.Nome + '</option>');
        });
        $select_elem.chosen({ width: "95%" });
    });
});