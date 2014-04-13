$(function() {
    $(".results .delete").click(function() {
        // Gather elements
        var row = $(this).closest("tr");

        // Gather information
        var sqlTable = $(this).data("table");
        if (sqlTable == undefined) {
            console.error("Need to specify table.");
            return;
        }

        // Get arguments
        var args = {};
        row.find("td").each(function(i, element) {
            $element = $(element);

            // If it has the pk data element, add it as an argument
            var pk = $element.data("pk");
            if (pk != undefined) {
                args[pk] = $element.text();
            }
        });

        var allData = $(this).data();
        for (var key in allData) {
            if (key.substr(0, 2) === "pk" && key.length > 2) {
                args[key.substr(2).toLowerCase()] = allData[key];
            }
        }

        var data = {
            table: sqlTable,
            args: args
        };

        $.post("delete.php", data)
            .done(function(response) {
                if (response == "1") {
                    row.remove();
                } else {
                    alert("Could not delete.\n\n"+ response);
                }
            })
            .fail(function(event, status, response) {
                alert("Could not delete.\n\n"+ response);
            });
    });
});