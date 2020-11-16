(function() {
   document.addEventListener("DOMContentLoaded", function () {
       let select = document.getElementById("mollie_select_zones");
       let hidden = document.getElementById("mollie_selected_zones");
       select.addEventListener("change", function () {
           let options = select.options;
           let selectedZones = "";
           for (let i = 0; i < options.length; i++) {
               if (options[i].selected) {
                   selectedZones += options[i].value + ",";
               }
           }

           hidden.value = selectedZones;
       })

   });
})();