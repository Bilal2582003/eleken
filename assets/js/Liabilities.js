
function LibFirsttoggleAddForm() {
    var addForm = document.getElementById('LibfirstAddform');
    addForm.classList.toggle('display-block');
}

function LibFirstModalTable() {
    $(document).ready(function() {
        var tabId = $(".active-tab .TopTab").html();
        $.ajax({
            url: "_chartOfAccount.php",
            type: "POST",
            data: {
                tabId:tabId,
                chartOfAccountActionLib: "LibFirstModalTbodyGet"
            },
            success: function(data) {
                // console.log(data)
                $("#libFirstModalTableBody").html(data)
            }
        })
    })

}
// LibFirstModalTable();
$(document).ready(function() {
    $(document).on("click", ".firstLibEdit", function() {
        if ($(this).html() == 'Edit') {
            var btnName = $(this).html('Save');
            // Corrected line to find the closest 'tr' element
            var tr = $(this).closest('tr');

            var id = tr.find('.firstLibId').html();
            var nameInput = tr.find('.firstLibName');

            // Enable the input field
            nameInput.prop('disabled', false);

        } else {
            var btnName = $(this).html('Edit');
            var tr = $(this).closest('tr');

            var id = tr.find('.firstLibId').html();
            var nameInput = tr.find('.firstLibName');

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
                    chartOfAccountActionLib: "LibFirstEditData"
                },
                success: function(data) {
                    // console.log(data)
                    if (data == 1) {
                        libFirstTbodyShow()
                        LibFirstModalTable()
                        alert("Added Successfully")
                    } else {
                        alert("Error!")
                    }
                }
            })
        }
    });

    $(document).on("click", '.firstLibDelete', function() {
        // Corrected line to find the closest 'tr' element
        var tr = $(this).closest('tr');

        var id = tr.find('.firstLibId').html();
        if (confirm("Do you want to delete.")) {

            $.ajax({
                url: "_chartOfAccount.php",
                type: "POST",
                data: {
                    id: id,
                    chartOfAccountActionLib: "LibFirstDeleteData"
                },
                success: function(data) {
                    // console.log(data)
                    if (data == 1) {
                        libFirstTbodyShow()
                        LibFirstModalTable()
                        alert("Deleted Successfully")
                    } else {
                        alert("Error!")
                    }
                }
            })
        }
    })

})

function libFirstTbodyShow() {
    $(document).ready(function() {
        var tabId = $(".active-tab .TopTab").html();
        $.ajax({
            url: "_chartOfAccount.php",
            type: "POST",
            data: {
                // name: libNatureName,
                tabId:tabId,
                chartOfAccountActionLib: "LibFirstTbodyGet"
            },
            success: function(data) {
                console.log(data)
                $("#LibFirstTbody").html(data)
            }
        })
    })
}



$(document).ready(function() {

    $("#LibFirstTbody").on("change", function() {
        var headID = $(this).val()
        $("#libThirdAddOpenModal").prop('disabled', true)

        $("#libFirstSelectId").html(headID)
        var tabId = $(".active-tab .TopTab").html();
        $.ajax({
            url: "_chartOfAccount.php",
            type: "POST",
            data: {
                tabId:tabId,
                headID: headID,
                chartOfAccountActionLib: "LibSecondTbody"
            },
            success: function(data) {
                // console.log(data)
                $("#LibSecondTbody").html(data)
                $("#libThirdTbody").html('')
            }
        })
    })


})

$(document).ready(function() {

    $("#LibFirstAddNew").on("click", function() {
        var LibNatureName = $("#LibFirstNatureName").val()
        var tabId = $(".active-tab .TopTab").html();
        // alert(LibNatureName)
        $.ajax({
            url: "_chartOfAccount.php",
            type: "POST",
            data: {
                tabId:tabId,
                name: LibNatureName,
                chartOfAccountActionLib: "addLibFirstNature"
            },
            success: function(data) {
                if (data != 1) {
                    alert("Error!")
                } else {
                    alert("Added")
                }
                libFirstTbodyShow()
                LibFirstModalTable()
            }
        })
    })
    $("#LibSecondAddNew").on("click", function() {
        // alert("yes")
        var LibNatureName = $("#LibSecondNatureName").val()
        var LibFirst = $("#libFirstSelectId").html()
        var tabId = $(".active-tab .TopTab").html();
        $.ajax({
            url: "_chartOfAccount.php",
            type: "POST",
            data: {
                tabId:tabId,
                r_id: LibFirst,
                name: LibNatureName,
                chartOfAccountActionLib: "addLibSecondNature"
            },
            success: function(data) {
                if (data != 1) {
                    alert("Error!")
                } else {
                    alert("Added")
                }
                $("#LibFirstTbody").trigger("change")
                LibSecondModalTable()
            }
        })
    })
    $("#LibThirdAddNew").on("click", function() {
        // alert("yes")
        var tabId = $(".active-tab .TopTab").html();
        var r_id = $("#libFirstSelectId").html()
        var r1_id = $("#LibSecondTbody").val()
        var name = $("#LibThirdNatureName").val()
        var status = $("#LibThirdNatureStatusName").val()
        $.ajax({
            url: "_chartOfAccount.php",
            type: "POST",
            data: {
                tabId:tabId,
                r_id:r_id,
                r1_id: r1_id,
                name: name,
                status: status,
                chartOfAccountActionLib: "addLibThirdNature"
            },
            success: function(data) {
                console.log(data)
                if (data != 1) {
                    alert("Error!")
                } else {
                    alert("Added")
                }
                $("#LibSecondTbody").trigger("change")

            }
        })
    })

    // second modal open by click on dot 
    $("#libSecondDotImage").on("click", function() {
        LibSecondModalTable();
    })


    $("#LibSecondTbody").on("change", function() {
        var LibSecond = $(this).val()
        var LibFirst = $("#libFirstSelectId").html()
        var tabId = $(".active-tab .TopTab").html();
        $.ajax({
            url: "_chartOfAccount.php",
            type: "POST",
            data: {
                tabId:tabId,
                r_id: LibFirst,
                r1_id: LibSecond,
                chartOfAccountActionLib: "LibThirdTbodyGet"
            },
            success: function(data) {
                // console.log(data)
                $("#libThirdTbody").html(data)
                if ($("#LibSecondTbody").val() != '') {
                    $("#libThirdAddOpenModal").prop('disabled', false)
                } else {
                    $("#libThirdAddOpenModal").prop('disabled', true)
                }
            }
        })
    })

    $(document).on("click", ".thirdLibEdit", function() {
        if ($(this).html() == 'Edit') {
            var btnName = $(this).html('Save');
            // Corrected line to find the closest 'tr' element
            var tr = $(this).closest('tr');

            var id = tr.find('.thirdLibId').html();
            var nameInput = tr.find('.thirdLibName');
            var status = tr.find('.thirdLibStatus ');

            // Enable the input field
            nameInput.prop('disabled', false);
            status.prop('disabled', false);

        } else {
            var btnName = $(this).html('Edit');
            var tr = $(this).closest('tr');

            var id = tr.find('.thirdLibId').html();
            var nameInput = tr.find('.thirdLibName');
            var status = tr.find('.thirdLibStatus');

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
                    chartOfAccountActionLib: "LibThirdEditData"
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

    $(document).on("click", '.thirdLibDelete', function() {
        // Corrected line to find the closest 'tr' element
        var tr = $(this).closest('tr');

        var id = tr.find('.thirdLibId').html();
        if (confirm("Do you want to delete.")) {

            $.ajax({
                url: "_chartOfAccount.php",
                type: "POST",
                data: {
                    id: id,
                    chartOfAccountActionLib: "LibThirdDeleteData"
                },
                success: function(data) {
                    // console.log(data)
                    if (data == 1) {
                        $("#LibSecondTbody").trigger("change")
                        alert("Deleted Successfully")
                    } else {
                        alert("Error!")
                    }
                }
            })
        }
    })

})

function LibSecondtoggleAddForm() {
    var addForm = document.getElementById('LibSecondAddform');
    addForm.classList.toggle('display-block');
}

function LibSecondModalTable() {
    $(document).ready(function() {
        var libData = $("#libFirstSelectId").html()
        // console.log(libData)
        var tabId = $(".active-tab .TopTab").html();
        $.ajax({
            url: "_chartOfAccount.php",
            type: "POST",
            data: {
                tabId:tabId,
                libData: libData,
                chartOfAccountActionLib: "libSecondModalTableBodyDataGet"
            },
            success: function(data) {
                $("#libSecondModalTableBody").html(data)
            }
        })
    })

}

$(document).ready(function() {
    $(document).on("click", ".secondLibEdit", function() {
        if ($(this).html() == 'Edit') {
            var btnName = $(this).html('Save');
            // Corrected line to find the closest 'tr' element
            var tr = $(this).closest('tr');

            var id = tr.find('.secondLibId').html();
            var nameInput = tr.find('.secondLibName');

            // Enable the input field
            nameInput.prop('disabled', false);

        } else {
            var btnName = $(this).html('Edit');
            var tr = $(this).closest('tr');

            var id = tr.find('.secondLibId').html();
            var nameInput = tr.find('.secondLibName');

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
                    chartOfAccountActionLib: "LibSecondEditData"
                },
                success: function(data) {
                    // console.log(data)
                    if (data == 1) {
                        $("#LibSecondTbody").trigger("change")
                        $("#LibFirstTbody").trigger("change")
                        LibSecondModalTable()
                        alert("Added Successfully")
                    } else {
                        alert("Error!")
                    }
                }
            })
        }
    });

    $(document).on("click", '.secondLibDelete', function() {
        // Corrected line to find the closest 'tr' element
        var tr = $(this).closest('tr');

        var id = tr.find('.secondLibId').html();
        if (confirm("Do you want to delete.")) {

            $.ajax({
                url: "_chartOfAccount.php",
                type: "POST",
                data: {
                    id: id,
                    chartOfAccountActionLib: "LibSecondDeleteData"
                },
                success: function(data) {
                    // console.log(data)
                    if (data == 1) {
                        $("#LibSecondTbody").trigger("change")
                        $("#LibFirstTbody").trigger("change")
                        LibSecondModalTable()
                        alert("Deleted Successfully")
                    } else {
                        alert("Error!")
                    }
                }
            })
        }
    })

})
