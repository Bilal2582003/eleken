
function CapFirsttoggleAddForm() {
    var addForm = document.getElementById('CapfirstAddform');
    addForm.classList.toggle('display-block');
}

function CapFirstModalTable() {
    $(document).ready(function() {
        var tabId = $(".active-tab .TopTab").html();
        $.ajax({
            url: "_chartOfAccount.php",
            type: "POST",
            data: {
                tabId:tabId,
                chartOfAccountActionCap: "CapFirstModalTbodyGet"
            },
            success: function(data) {
                // console.log(data)
                $("#capFirstModalTableBody").html(data)
            }
        })
    })

}
// CapFirstModalTable();
$(document).ready(function() {
    $(document).on("click", ".firstCapEdit", function() {
        if ($(this).html() == 'Edit') {
            var btnName = $(this).html('Save');
            // Corrected line to find the closest 'tr' element
            var tr = $(this).closest('tr');

            var id = tr.find('.firstCapId').html();
            var nameInput = tr.find('.firstCapName');

            // Enable the input field
            nameInput.prop('disabled', false);

        } else {
            var btnName = $(this).html('Edit');
            var tr = $(this).closest('tr');

            var id = tr.find('.firstCapId').html();
            var nameInput = tr.find('.firstCapName');

            // Enable the input field
            nameInput.prop('disabled', true);
            // Get the value of the input field
            var name = nameInput.val();
            $.ajax({
                url: "_chartOfAccount.php",
                type: "POST",
                data: {
                    name: name,
                    id: id,
                    chartOfAccountActionCap: "CapFirstEditData"
                },
                success: function(data) {
                    // console.log(data)
                    if (data == 1) {
                        capFirstTbodyShow()
                        CapFirstModalTable()
                        alert("Added Successfully")
                    } else {
                        alert("Error!")
                    }
                }
            })
        }
    });

    $(document).on("click", '.firstCapDelete', function() {
        // Corrected line to find the closest 'tr' element
        var tr = $(this).closest('tr');

        var id = tr.find('.firstCapId').html();
        if (confirm("Do you want to delete.")) {

            $.ajax({
                url: "_chartOfAccount.php",
                type: "POST",
                data: {
                    id: id,
                    chartOfAccountActionCap: "CapFirstDeleteData"
                },
                success: function(data) {
                    // console.log(data)
                    if (data == 1) {
                        capFirstTbodyShow()
                        CapFirstModalTable()
                        alert("Deleted Successfully")
                    } else {
                        alert("Error!")
                    }
                }
            })
        }
    })

})

function capFirstTbodyShow() {
    $(document).ready(function() {
        var tabId = $(".active-tab .TopTab").html();
        $.ajax({
            url: "_chartOfAccount.php",
            type: "POST",
            data: {
                tabId:tabId,
                // name: capNatureName,
                chartOfAccountActionCap: "CapFirstTbodyGet"
            },
            success: function(data) {
                console.log(data)
                $("#CapFirstTbody").html(data)
            }
        })
    })
}
// capFirstTbodyShow();


$(document).ready(function() {

    $("#CapFirstTbody").on("change", function() {
        var headID = $(this).val()
        $("#capThirdAddOpenModal").prop('disabled', true)

        $("#capFirstSelectId").html(headID)
        var tabId = $(".active-tab .TopTab").html();
        $.ajax({
            url: "_chartOfAccount.php",
            type: "POST",
            data: {
                tabId:tabId,
                headID: headID,
                chartOfAccountActionCap: "CapSecondTbody"
            },
            success: function(data) {
                // console.log(data)
                $("#CapSecondTbody").html(data)
                $("#capThirdTbody").html('')
            }
        })
    })


})

$(document).ready(function() {

    $("#CapFirstAddNew").on("click", function() {
        var CapNatureName = $("#CapFirstNatureName").val()
        // alert(CapNatureName)
        var tabId = $(".active-tab .TopTab").html();
        $.ajax({
            url: "_chartOfAccount.php",
            type: "POST",
            data: {
                tabId:tabId,
                name: CapNatureName,
                chartOfAccountActionCap: "addCapFirstNature"
            },
            success: function(data) {
                if (data != 1) {
                    alert("Error!")
                } else {
                    alert("Added")
                }
                capFirstTbodyShow()
                CapFirstModalTable()
            }
        })
    })
    $("#CapSecondAddNew").on("click", function() {
        // alert("yes")
        var CapNatureName = $("#CapSecondNatureName").val()
        var CapFirst = $("#capFirstSelectId").html()
        var tabId = $(".active-tab .TopTab").html();
        $.ajax({
            url: "_chartOfAccount.php",
            type: "POST",
            data: {
                tabId:tabId,
                r_id: CapFirst,
                name: CapNatureName,
                chartOfAccountActionCap: "addCapSecondNature"
            },
            success: function(data) {
                if (data != 1) {
                    alert("Error!")
                } else {
                    alert("Added")
                }
                $("#CapFirstTbody").trigger("change")
                CapSecondModalTable()
            }
        })
    })
    $("#CapThirdAddNew").on("click", function() {
        // alert("yes")
        var tabId = $(".active-tab .TopTab").html();
        var r_id = $("#capFirstSelectId").html()
        var r1_id = $("#CapSecondTbody").val()
        var name = $("#CapThirdNatureName").val()
        var status = $("#CapThirdNatureStatusName").val()
        $.ajax({
            url: "_chartOfAccount.php",
            type: "POST",
            data: {
                tabId:tabId,
                r_id:r_id,
                r1_id: r1_id,
                name: name,
                status: status,
                chartOfAccountActionCap: "addCapThirdNature"
            },
            success: function(data) {
                console.log(data)
                if (data != 1) {
                    alert("Error!")
                } else {
                    alert("Added")
                }
                $("#CapSecondTbody").trigger("change")

            }
        })
    })

    // second modal open by click on dot 
    $("#capSecondDotImage").on("click", function() {
        CapSecondModalTable();
    })


    $("#CapSecondTbody").on("change", function() {
        var CapSecond = $(this).val()
        var CapFirst = $("#capFirstSelectId").html()
        var tabId = $(".active-tab .TopTab").html();
        $.ajax({
            url: "_chartOfAccount.php",
            type: "POST",
            data: {
                tabId:tabId,
                r_id: CapFirst,
                r1_id: CapSecond,
                chartOfAccountActionCap: "CapThirdTbodyGet"
            },
            success: function(data) {
                // console.log(data)
                $("#capThirdTbody").html(data)
                if ($("#CapSecondTbody").val() != '') {
                    $("#capThirdAddOpenModal").prop('disabled', false)
                } else {
                    $("#capThirdAddOpenModal").prop('disabled', true)
                }
            }
        })
    })

    $(document).on("click", ".thirdCapEdit", function() {
        if ($(this).html() == 'Edit') {
            var btnName = $(this).html('Save');
            // Corrected line to find the closest 'tr' element
            var tr = $(this).closest('tr');

            var id = tr.find('.thirdCapId').html();
            var nameInput = tr.find('.thirdCapName');
            var status = tr.find('.thirdCapStatus ');

            // Enable the input field
            nameInput.prop('disabled', false);
            status.prop('disabled', false);

        } else {
            var btnName = $(this).html('Edit');
            var tr = $(this).closest('tr');

            var id = tr.find('.thirdCapId').html();
            var nameInput = tr.find('.thirdCapName');
            var status = tr.find('.thirdCapStatus');

            // Enable the input field
            nameInput.prop('disabled', true);
            status.prop('disabled', true);
            // Get the value of the input field
            var name = nameInput.val();
            var status = status.val();
            $.ajax({
                url: "_chartOfAccount.php",
                type: "POST",
                data: {
                    name: name,
                    status: status,
                    id: id,
                    chartOfAccountActionCap: "CapThirdEditData"
                },
                success: function(data) {
                    // console.log(data)
                    if (data == 1) {
                        alert("Added Successfully")
                    } else {
                        alert("Error!")
                    }
                }
            })
        }
    });

    $(document).on("click", '.thirdCapDelete', function() {
        // Corrected line to find the closest 'tr' element
        var tr = $(this).closest('tr');

        var id = tr.find('.thirdCapId').html();
        if (confirm("Do you want to delete.")) {

            $.ajax({
                url: "_chartOfAccount.php",
                type: "POST",
                data: {
                    id: id,
                    chartOfAccountActionCap: "CapThirdDeleteData"
                },
                success: function(data) {
                    // console.log(data)
                    if (data == 1) {
                        $("#CapSecondTbody").trigger("change")
                        alert("Deleted Successfully")
                    } else {
                        alert("Error!")
                    }
                }
            })
        }
    })

})

function CapSecondtoggleAddForm() {
    var addForm = document.getElementById('CapSecondAddform');
    addForm.classList.toggle('display-block');
}

function CapSecondModalTable() {
    $(document).ready(function() {
        var capData = $("#capFirstSelectId").html()
        // console.log(capData)
        var tabId = $(".active-tab .TopTab").html();
        $.ajax({
            url: "_chartOfAccount.php",
            type: "POST",
            data: {
                tabId:tabId,
                capData: capData,
                chartOfAccountActionCap: "capSecondModalTableBodyDataGet"
            },
            success: function(data) {
                $("#capSecondModalTableBody").html(data)
            }
        })
    })

}

$(document).ready(function() {
    $(document).on("click", ".secondCapEdit", function() {
        if ($(this).html() == 'Edit') {
            var btnName = $(this).html('Save');
            // Corrected line to find the closest 'tr' element
            var tr = $(this).closest('tr');

            var id = tr.find('.secondCapId').html();
            var nameInput = tr.find('.secondCapName');

            // Enable the input field
            nameInput.prop('disabled', false);

        } else {
            var btnName = $(this).html('Edit');
            var tr = $(this).closest('tr');

            var id = tr.find('.secondCapId').html();
            var nameInput = tr.find('.secondCapName');

            // Enable the input field
            nameInput.prop('disabled', true);
            // Get the value of the input field
            var name = nameInput.val();
            $.ajax({
                url: "_chartOfAccount.php",
                type: "POST",
                data: {
                    name: name,
                    id: id,
                    chartOfAccountActionCap: "CapSecondEditData"
                },
                success: function(data) {
                    // console.log(data)
                    if (data == 1) {
                        $("#CapSecondTbody").trigger("change")
                        $("#CapFirstTbody").trigger("change")
                        CapSecondModalTable()
                        alert("Added Successfully")
                    } else {
                        alert("Error!")
                    }
                }
            })
        }
    });

    $(document).on("click", '.secondCapDelete', function() {
        // Corrected line to find the closest 'tr' element
        var tr = $(this).closest('tr');

        var id = tr.find('.secondCapId').html();
        if (confirm("Do you want to delete.")) {

            $.ajax({
                url: "_chartOfAccount.php",
                type: "POST",
                data: {
                    id: id,
                    chartOfAccountActionCap: "CapSecondDeleteData"
                },
                success: function(data) {
                    // console.log(data)
                    if (data == 1) {
                        $("#CapSecondTbody").trigger("change")
                        $("#CapFirstTbody").trigger("change")
                        CapSecondModalTable()
                        alert("Deleted Successfully")
                    } else {
                        alert("Error!")
                    }
                }
            })
        }
    })

})
