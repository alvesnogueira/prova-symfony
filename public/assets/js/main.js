$(document).ready(function() {
// var url = "assets/js/json-estados.json";
//     $.getJSON(url, function(json){
//         var $select_elem = $("#uf");
//         $select_elem.empty();
//         $.each(json, function (idx, obj) {
//             $select_elem.append('<option value="' + obj.Sigla + '">' + obj.Nome + '</option>');
//         });
//         $select_elem.chosen({ width: "95%" });
// });

var url = "http://www.geonames.org/childrenJSON?geonameId=3469034";
$.getJSON(url, function(json){
    var $select_elem = $("#uf");
    $select_elem.empty();
    $.each(json.geonames, function (idx, obj) {
            console.log(obj.adminCodes1.ISO3166_2);
            $select_elem.append('<option value="' + obj.adminCodes1.ISO3166_2 + '">' + obj.adminName1 + '</option>');
    });
    $select_elem.chosen({ width: "95%" });
});


});