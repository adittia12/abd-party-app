"use strict";

$("[data-checkboxes]").each(function () {
    var me = $(this),
        group = me.data("checkboxes"),
        role = me.data("checkbox-role");

    me.change(function () {
        var all = $(
                '[data-checkboxes="' +
                    group +
                    '"]:not([data-checkbox-role="dad"])'
            ),
            checked = $(
                '[data-checkboxes="' +
                    group +
                    '"]:not([data-checkbox-role="dad"]):checked'
            ),
            dad = $(
                '[data-checkboxes="' + group + '"][data-checkbox-role="dad"]'
            ),
            total = all.length,
            checked_length = checked.length;

        if (role == "dad") {
            if (me.is(":checked")) {
                all.prop("checked", true);
            } else {
                all.prop("checked", false);
            }
        } else {
            if (checked_length >= total) {
                dad.prop("checked", true);
            } else {
                dad.prop("checked", false);
            }
        }
    });
});

$("#table-1").dataTable({
    columnDefs: [
        {
            sortable: false,
            targets: [2, 3],
            fixedHeader: true,
            responsive: true,
            dom: 'B<"top"flp>rti<"bottom"p><"clear">',
            buttons: [
                "copy",
                "csv",
                "excel",
                {
                    extend: "pdf",
                    text: "PDF",
                    orientation: "landscape",
                    exportOptions: {
                        columns: ":not(.no-export)", // Tambahkan kelas 'no-export' pada kolom 'Action' yang tidak ingin diekspor atau dicetak
                    }, // Tambahkan ini untuk orientasi landscape pada PDF
                },
                {
                    extend: "print",
                    exportOptions: {
                        columns: ":not(.no-export)",
                    },
                },
            ],
        },
    ],
});
$("#table-2").dataTable({
    columnDefs: [{ sortable: false, targets: [0, 2, 3] }],
});
