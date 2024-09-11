
function ExpFirsttoggleAddForm() {
    var addForm = document.getElementById('ExpfirstAddform');
    addForm.classList.toggle('display-block');
}

function ExpFirstModalTable() {
    $(document).ready(function() {
        var tabId = $(".active-tab .TopTab").html();
        $.ajax({
            url: "_chartOfAccount.php",
            type: "POST",
            data: {
                tabId:tabId,
                chartOfAccountActionExp: "ExpFirstModalTbodyGet"
            },
            success: function(data) {
                // console.log(data)
                $("#expFirstModalTableBody").html(data)
            }
        })
    })

}
// ExpFirstModalTable();
$(document).ready(function() {
    $(document).on("click", ".firstExpEdit", function() {
        if ($(this).html() == 'Edit') {
            var btnName = $(this).html('Save');
            // Corrected line to find the closest 'tr' element
            var tr = $(this).closest('tr');

            var id = tr.find('.firstExpId').html();
            var nameInput = tr.find('.firstExpName');

            // Enable the input field
            nameInput.prop('disabled', false);

        } else {
            var btnName = $(this).html('Edit');
            var tr = $(this).closest('tr');

            var id = tr.find('.firstExpId').html();
            var nameInput = tr.find('.firstExpName');

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
                    chartOfAccountActionExp: "ExpFirstEditData"
                },
                success: function(data) {
                    // console.log(data)
                    if (data == 1) {
                        expFirstTbodyShow()
                        ExpFirstModalTable()
                        alert("Added Successfully")
                    } else {
                        alert("Error!")
                    }
                }
            })
        }
    });

    $(document).on("click", '.firstExpDelete', function() {
        // Corrected line to find the closest 'tr' element
        var tr = $(this).closest('tr');

        var id = tr.find('.firstExpId').html();
        if (confirm("Do you want to delete.")) {

            $.ajax({
                url: "_chartOfAccount.php",
                type: "POST",
                data: {
                    id: id,
                    chartOfAccountActionExp: "ExpFirstDeleteData"
                },
                success: function(data) {
                    // console.log(data)
                    if (data == 1) {
                        expFirstTbodyShow()
                        ExpFirstModalTable()
                        alert("Deleted Successfully")
                    } else {
                        alert("Error!")
                    }
                }
            })
        }
    })

})

function expFirstTbodyShow() {
    $(document).ready(function() {
        var tabId = $(".active-tab .TopTab").html();
        $.ajax({
            url: "_chartOfAccount.php",
            type: "POST",
            data: {
                // name: expNatureName,
                tabId:tabId,
                chartOfAccountActionExp: "ExpFirstTbodyGet"
            },
            success: function(data) {
                // console.log(data)
                $("#ExpFirstTbody").html(data)
            }
        })
    })
}
// expFirstTbodyShow();


$(document).ready(function() {

    $("#ExpFirstTbody").on("change", function() {
        // alert("YES")
        var headID = $(this).val()
        $("#expThirdAddOpenModal").prop('disabled', true)

        $("#expFirstSelectId").html(headID)
        var tabId = $(".active-tab .TopTab").html();
        $.ajax({
            url: "_chartOfAccount.php",
            type: "POST",
            data: {
                tabId:tabId,
                headID: headID,
                chartOfAccountActionExp: "ExpSecondTbody"
            },
            success: function(data) {
                // console.log(data)
                $("#ExpSecondTbody").html(data)
                $("#expThirdTbody").html('')
            }
        })
    })


})

$(document).ready(function() {

    $("#ExpFirstAddNew").on("click", function() {
        var ExpNatureName = $("#ExpFirstNatureName").val()
        // alert(ExpNatureName)
        var tabId = $(".active-tab .TopTab").html();
        $.ajax({
            url: "_chartOfAccount.php",
            type: "POST",
            data: {
                tabId:tabId,
                name: ExpNatureName,
                chartOfAccountActionExp: "addExpFirstNature"
            },
            success: function(data) {
                if (data != 1) {
                    alert("Error!")
                } else {
                    alert("Added")
                }
                expFirstTbodyShow()
                ExpFirstModalTable()
            }
        })
    })
    $("#ExpSecondAddNew").on("click", function() {
        // alert("yes")
        var ExpNatureName = $("#ExpSecondNatureName").val()
        var ExpFirst = $("#expFirstSelectId").html()
        var tabId = $(".active-tab .TopTab").html();
        $.ajax({
            url: "_chartOfAccount.php",
            type: "POST",
            data: {
                tabId:tabId,
                r_id: ExpFirst,
                name: ExpNatureName,
                chartOfAccountActionExp: "addExpSecondNature"
            },
            success: function(data) {
                if (data != 1) {
                    alert("Error!")
                } else {
                    alert("Added")
                }
                $("#ExpFirstTbody").trigger("change")
                ExpSecondModalTable()
            }
        })
    })
    $("#ExpThirdAddNew").on("click", function() {
        // alert("yes")
        var tabId = $(".active-tab .TopTab").html();
        var r_id = $("#expFirstSelectId").html()
        var r1_id = $("#ExpSecondTbody").val()
        var name = $("#ExpThirdNatureName").val()
        var status = $("#ExpThirdNatureStatusName").val()
        $.ajax({
            url: "_chartOfAccount.php",
            type: "POST",
            data: {
                tabId:tabId,
                r_id:r_id,
                r1_id: r1_id,
                name: name,
                status: status,
                chartOfAccountActionExp: "addExpThirdNature"
            },
            success: function(data) {
                console.log(data)
                if (data != 1) {
                    alert("Error!")
                } else {
                    alert("Added")
                }
                $("#ExpSecondTbody").trigger("change")

            }
        })
    })

    // second modal open by click on dot 
    $("#expSecondDotImage").on("click", function() {
        ExpSecondModalTable();
    })


    $("#ExpSecondTbody").on("change", function() {
        var ExpSecond = $(this).val()
        var ExpFirst = $("#expFirstSelectId").html()
        var tabId = $(".active-tab .TopTab").html();
        $.ajax({
            url: "_chartOfAccount.php",
            type: "POST",
            data: {
                tabId:tabId,
                r_id: ExpFirst,
                r1_id: ExpSecond,
                chartOfAccountActionExp: "ExpThirdTbodyGet"
            },
            success: function(data) {
                // console.log(data)
                $("#expThirdTbody").html(data)
                if ($("#ExpSecondTbody").val() != '') {
                    $("#expThirdAddOpenModal").prop('disabled', false)
                } else {
                    $("#expThirdAddOpenModal").prop('disabled', true)
                }
            }
        })
    })

    $(document).on("click", ".thirdExpEdit", function() {
        if ($(this).html() == 'Edit') {
            var btnName = $(this).html('Save');
            // Corrected line to find the closest 'tr' element
            var tr = $(this).closest('tr');

            var id = tr.find('.thirdExpId').html();
            var nameInput = tr.find('.thirdExpName');
            var status = tr.find('.thirdExpStatus ');

            // Enable the input field
            nameInput.prop('disabled', false);
            status.prop('disabled', false);

        } else {
            var btnName = $(this).html('Edit');
            var tr = $(this).closest('tr');

            var id = tr.find('.thirdExpId').html();
            var nameInput = tr.find('.thirdExpName');
            var status = tr.find('.thirdExpStatus');

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
                    chartOfAccountActionExp: "ExpThirdEditData"
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

    $(document).on("click", '.thirdExpDelete', function() {
        // Corrected line to find the closest 'tr' element
        var tr = $(this).closest('tr');

        var id = tr.find('.thirdExpId').html();
        if (confirm("Do you want to delete.")) {

            $.ajax({
                url: "_chartOfAccount.php",
                type: "POST",
                data: {
                    id: id,
                    chartOfAccountActionExp: "ExpThirdDeleteData"
                },
                success: function(data) {
                    // console.log(data)
                    if (data == 1) {
                        $("#ExpSecondTbody").trigger("change")
                        alert("Deleted Successfully")
                    } else {
                        alert("Error!")
                    }
                }
            })
        }
    })

})

function ExpSecondtoggleAddForm() {
    var addForm = document.getElementById('ExpSecondAddform');
    addForm.classList.toggle('display-block');
}

function ExpSecondModalTable() {
    $(document).ready(function() {
        var expData = $("#expFirstSelectId").html()
        var tabId = $(".active-tab .TopTab").html();
        // console.log(expData)
        $.ajax({
            url: "_chartOfAccount.php",
            type: "POST",
            data: {
                tabId:tabId,
                expData: expData,
                chartOfAccountActionExp: "expSecondModalTableBodyDataGet"
            },
            success: function(data) {
                $("#expSecondModalTableBody").html(data)
            }
        })
    })

}

$(document).ready(function() {
    $(document).on("click", ".secondExpEdit", function() {
        if ($(this).html() == 'Edit') {
            var btnName = $(this).html('Save');
            // Corrected line to find the closest 'tr' element
            var tr = $(this).closest('tr');

            var id = tr.find('.secondExpId').html();
            var nameInput = tr.find('.secondExpName');

            // Enable the input field
            nameInput.prop('disabled', false);

        } else {
            var btnName = $(this).html('Edit');
            var tr = $(this).closest('tr');

            var id = tr.find('.secondExpId').html();
            var nameInput = tr.find('.secondExpName');

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
                    chartOfAccountActionExp: "ExpSecondEditData"
                },
                success: function(data) {
                    // console.log(data)
                    if (data == 1) {
                        $("#ExpSecondTbody").trigger("change")
                        $("#ExpFirstTbody").trigger("change")
                        ExpSecondModalTable()
                        alert("Added Successfully")
                    } else {
                        alert("Error!")
                    }
                }
            })
        }
    });

    $(document).on("click", '.secondExpDelete', function() {
        // Corrected line to find the closest 'tr' element
        var tr = $(this).closest('tr');

        var id = tr.find('.secondExpId').html();
        if (confirm("Do you want to delete.")) {

            $.ajax({
                url: "_chartOfAccount.php",
                type: "POST",
                data: {
                    id: id,
                    chartOfAccountActionExp: "ExpSecondDeleteData"
                },
                success: function(data) {
                    // console.log(data)
                    if (data == 1) {
                        $("#ExpSecondTbody").trigger("change")
                        $("#ExpFirstTbody").trigger("change")
                        ExpSecondModalTable()
                        alert("Deleted Successfully")
                    } else {
                        alert("Error!")
                    }
                }
            })
        }
    })

})
