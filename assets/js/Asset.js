
function AssetFirsttoggleAddForm() {
    var addForm = document.getElementById('AssetfirstAddform');
    addForm.classList.toggle('display-block');
}

function AssetFirstModalTable() {
    $(document).ready(function() {
        var tabId = $(".active-tab .TopTab").html();
        $.ajax({
            url: "_chartOfAccount.php",
            type: "POST",
            data: {
                tabId:tabId,
                chartOfAccountActionAsset: "AssetFirstModalTbodyGet"
            },
            success: function(data) {
                console.log(data)
                $("#assetFirstModalTableBody").html(data)
            }
        })
    })

}
// AssetFirstModalTable();
$(document).ready(function() {
    $(document).on("click", ".firstAssetEdit", function() {
        if ($(this).html() == 'Edit') {
            var btnName = $(this).html('Save');
            // Corrected line to find the closest 'tr' element
            var tr = $(this).closest('tr');

            var id = tr.find('.firstAssetId').html();
            var nameInput = tr.find('.firstAssetName');

            // Enable the input field
            nameInput.prop('disabled', false);

        } else {
            var btnName = $(this).html('Edit');
            var tr = $(this).closest('tr');

            var id = tr.find('.firstAssetId').html();
            var nameInput = tr.find('.firstAssetName');

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
                    chartOfAccountActionAsset: "AssetFirstEditData"
                },
                success: function(data) {
                    // console.log(data)
                    if (data == 1) {
                        assetFirstTbodyShow()
                        AssetFirstModalTable()
                        alert("Added Successfully")
                    } else {
                        alert("Error!")
                    }
                }
            })
        }
    });

    $(document).on("click", '.firstAssetDelete', function() {
        // Corrected line to find the closest 'tr' element
        var tr = $(this).closest('tr');

        var id = tr.find('.firstAssetId').html();
        if (confirm("Do you want to delete.")) {

            $.ajax({
                url: "_chartOfAccount.php",
                type: "POST",
                data: {
                    id: id,
                    chartOfAccountActionAsset: "AssetFirstDeleteData"
                },
                success: function(data) {
                    // console.log(data)
                    if (data == 1) {
                        assetFirstTbodyShow()
                        AssetFirstModalTable()
                        alert("Deleted Successfully")
                    } else {
                        alert("Error!")
                    }
                }
            })
        }
    })

})

function assetFirstTbodyShow() {
    $(document).ready(function() {
        var tabId = $(".active-tab .TopTab").html();
        $.ajax({
            url: "_chartOfAccount.php",
            type: "POST",
            data: {
                tabId: tabId,
                chartOfAccountActionAsset: "AssetFirstTbodyGet"
            },
            success: function(data) {
                console.log(data)
                $("#AssetFirstTbody").html(data)
            }
        })
    })
}



$(document).ready(function() {

    $("#AssetFirstTbody").on("change", function() {
        var headID = $(this).val()
        $("#assetThirdAddOpenModal").prop('disabled', true)

        $("#assetFirstSelectId").html(headID)
        var tabId = $(".active-tab .TopTab").html();
        $.ajax({
            url: "_chartOfAccount.php",
            type: "POST",
            data: {
                tabId:tabId,
                headID: headID,
                chartOfAccountActionAsset: "AssetSecondTbody"
            },
            success: function(data) {
                // console.log(data)
                $("#AssetSecondTbody").html(data)
                $("#assetThirdTbody").html('')
            }
        })
    })


})

$(document).ready(function() {

    $("#AssetFirstAddNew").on("click", function() {
        var AssetNatureName = $("#AssetFirstNatureName").val()
        var tabId = $(".active-tab .TopTab").html();
        $.ajax({
            url: "_chartOfAccount.php",
            type: "POST",
            data: {
                tabId:tabId,
                name: AssetNatureName,
                chartOfAccountActionAsset: "addAssetFirstNature"
            },
            success: function(data) {
                if (data != 1) {
                    alert("Error!")
                } else {
                    alert("Added")
                }
                assetFirstTbodyShow()
                AssetFirstModalTable()
            }
        })
    })
    $("#AssetSecondAddNew").on("click", function() {
        // alert("yes")
        var AssetNatureName = $("#AssetSecondNatureName").val()
        var AssetFirst = $("#assetFirstSelectId").html()
        var tabId = $(".active-tab .TopTab").html();
        $.ajax({
            url: "_chartOfAccount.php",
            type: "POST",
            data: {
                tabId:tabId,
                r_id: AssetFirst,
                name: AssetNatureName,
                chartOfAccountActionAsset: "addAssetSecondNature"
            },
            success: function(data) {
                if (data != 1) {
                    alert("Error!")
                } else {
                    alert("Added")
                }
                console.log(data)
                $("#AssetFirstTbody").trigger("change")
                AssetSecondModalTable()
            }
        })
    })
    $("#AssetThirdAddNew").on("click", function() {
        // alert("yes")
        var tabId = $(".active-tab .TopTab").html();
        var r_id = $("#assetFirstSelectId").html()
        var r1_id = $("#AssetSecondTbody").val()
        var name = $("#AssetThirdNatureName").val()
        var status = $("#AssetThirdNatureStatusName").val()
        $.ajax({
            url: "_chartOfAccount.php",
            type: "POST",
            data: {
                tabId:tabId,
                r_id:r_id,
                r1_id: r1_id,
                name: name,
                status: status,
                chartOfAccountActionAsset: "addAssetThirdNature"
            },
            success: function(data) {
                console.log(data)
                if (data != 1) {
                    alert("Error!")
                } else {
                    alert("Added")
                }
                $("#AssetSecondTbody").trigger("change")

            }
        })
    })

    // second modal open by click on dot 
    $("#assetSecondDotImage").on("click", function() {
        AssetSecondModalTable();
    })


    $("#AssetSecondTbody").on("change", function() {
        var AssetSecond = $(this).val()
        var AssetFirst = $("#assetFirstSelectId").html()
        var tabId = $(".active-tab .TopTab").html();
        // alert(AssetFirst+' '+AssetSecond+' '+tabId)
        $.ajax({
            url: "_chartOfAccount.php",
            type: "POST",
            data: {
                tabId:tabId,
                r_id: AssetFirst,
                r1_id: AssetSecond,
                chartOfAccountActionAsset: "AssetThirdTbodyGet"
            },
            success: function(data) {
                // console.log(data)
                $("#assetThirdTbody").html(data)
                if ($("#AssetSecondTbody").val() != '') {
                    $("#assetThirdAddOpenModal").prop('disabled', false)
                } else {
                    $("#assetThirdAddOpenModal").prop('disabled', true)
                }
            }
        })
    })

    $(document).on("click", ".thirdAssetEdit", function() {
        if ($(this).html() == 'Edit') {
            var btnName = $(this).html('Save');
            // Corrected line to find the closest 'tr' element
            var tr = $(this).closest('tr');

            var id = tr.find('.thirdAssetId').html();
            var nameInput = tr.find('.thirdAssetName');
            var status = tr.find('.thirdAssetStatus ');

            // Enable the input field
            nameInput.prop('disabled', false);
            status.prop('disabled', false);

        } else {
            var btnName = $(this).html('Edit');
            var tr = $(this).closest('tr');

            var id = tr.find('.thirdAssetId').html();
            var nameInput = tr.find('.thirdAssetName');
            var status = tr.find('.thirdAssetStatus');

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
                    chartOfAccountActionAsset: "AssetThirdEditData"
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

    $(document).on("click", '.thirdAssetDelete', function() {
        // Corrected line to find the closest 'tr' element
        var tr = $(this).closest('tr');

        var id = tr.find('.thirdAssetId').html();
        if (confirm("Do you want to delete.")) {

            $.ajax({
                url: "_chartOfAccount.php",
                type: "POST",
                data: {
                    id: id,
                    chartOfAccountActionAsset: "AssetThirdDeleteData"
                },
                success: function(data) {
                    // console.log(data)
                    if (data == 1) {
                        $("#AssetSecondTbody").trigger("change")
                        alert("Deleted Successfully")
                    } else {
                        alert("Error!")
                    }
                }
            })
        }
    })

})

function AssetSecondtoggleAddForm() {
    var addForm = document.getElementById('AssetSecondAddform');
    addForm.classList.toggle('display-block');
}

function AssetSecondModalTable() {
    $(document).ready(function() {
        var assetData = $("#assetFirstSelectId").html()
        // console.log(assetData)
        var tabId = $(".active-tab .TopTab").html();
        $.ajax({
            url: "_chartOfAccount.php",
            type: "POST",
            data: {
                tabId:tabId,
                assetData: assetData,
                chartOfAccountActionAsset: "assetSecondModalTableBodyDataGet"
            },
            success: function(data) {
                $("#assetSecondModalTableBody").html(data)
            }
        })
    })

}

$(document).ready(function() {
    $(document).on("click", ".secondAssetEdit", function() {
        if ($(this).html() == 'Edit') {
            var btnName = $(this).html('Save');
            // Corrected line to find the closest 'tr' element
            var tr = $(this).closest('tr');

            var id = tr.find('.secondAssetId').html();
            var nameInput = tr.find('.secondAssetName');

            // Enable the input field
            nameInput.prop('disabled', false);

        } else {
            var btnName = $(this).html('Edit');
            var tr = $(this).closest('tr');

            var id = tr.find('.secondAssetId').html();
            var nameInput = tr.find('.secondAssetName');

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
                    chartOfAccountActionAsset: "AssetSecondEditData"
                },
                success: function(data) {
                    console.log(data)
                    if (data == 1) {
                        $("#AssetSecondTbody").trigger("change")
                        $("#AssetFirstTbody").trigger("change")

                        AssetSecondModalTable()
                        alert("Added Successfully")
                    } else {
                        alert("Error!")
                    }
                }
            })
        }
    });

    $(document).on("click", '.secondAssetDelete', function() {
        // Corrected line to find the closest 'tr' element
        var tr = $(this).closest('tr');

        var id = tr.find('.secondAssetId').html();
        if (confirm("Do you want to delete.")) {

            $.ajax({
                url: "_chartOfAccount.php",
                type: "POST",
                data: {
                    id: id,
                    chartOfAccountActionAsset: "AssetSecondDeleteData"
                },
                success: function(data) {
                    // console.log(data)
                    if (data == 1) {
                        $("#AssetSecondTbody").trigger("change")
                        $("#AssetFirstTbody").trigger("change")

                        AssetSecondModalTable()
                        alert("Deleted Successfully")
                    } else {
                        alert("Error!")
                    }
                }
            })
        }
    })

})
