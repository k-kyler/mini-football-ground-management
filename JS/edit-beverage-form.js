$(document).ready(function() {
    // Config and open dialog
    $("#editButton").click(function() {
        $("#editBeverageForm")
            .dialog({
                autoOpen: false,
                height: 280,
                width: 350,
                resizable: false,
                modal: true,
                draggable: false,
                hide: "fadeOut",
                show : "fadeIn"
            })
            .dialog("open");
    });

    // Create search box in select user real name
    $('#selectBeverageNameEdit').select2();

    // Get beverage data from hidden input
    let totalBeverages = $("#totalBeverages").val();
    let totalBeveragesList = [];

    for (let i = 1; i <= totalBeverages; i++) {
        let temp = [];
        let beverageName = $("#beverageName" + i).val();
        let beverageCost = $("#beverageCost" + i).val();
        let beverageNameAndCost = beverageName + ' - ' + beverageCost;

        temp.push(beverageNameAndCost);
        temp.push(beverageName);
        temp.push(beverageCost);

        totalBeveragesList.push(temp);
    }

    // Display edit data to edit form when choosing beverage
    $("#selectBeverageNameEdit").change(function() {
        for (let i = 0; i < totalBeveragesList.length; i++){
            if (totalBeveragesList[i][0] == $("#selectBeverageNameEdit").val()) {
                for (let j = 0; j < totalBeveragesList[i].length; j++) {
                    $("#editBeverageName").val(totalBeveragesList[i][1]);

                    $("#editBeverageCost").val(totalBeveragesList[i][2]);
                }
            }
        }
    });
}); 