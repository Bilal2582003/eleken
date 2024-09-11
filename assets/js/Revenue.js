function RevenueFirsttoggleAddForm() {
  var addForm = document.getElementById("RevenuefirstAddform");
  addForm.classList.toggle("display-block");
}

function RevenueFirstModalTable() {
  $(document).ready(function () {
    var tabId = $(".active-tab .TopTab").html();
    $.ajax({
      url: "_chartOfAccount.php",
      type: "POST",
      data: {
        tabId: tabId,
        chartOfAccountActionRevenue: "RevenueFirstModalTbodyGet",
      },
      success: function (data) {
        // console.log(data)
        $("#revenueFirstModalTableBody").html(data);
      },
    });
  });
}
// RevenueFirstModalTable();
$(document).ready(function () {
  $(document).on("click", ".firstRevenueEdit", function () {
    if ($(this).html() == "Edit") {
      var btnName = $(this).html("Save");
      // Corrected line to find the closest 'tr' element
      var tr = $(this).closest("tr");

      var id = tr.find(".firstRevenueId").html();
      var nameInput = tr.find(".firstRevenueName");

      // Enable the input field
      nameInput.prop("disabled", false);
    } else {
      var btnName = $(this).html("Edit");
      var tr = $(this).closest("tr");

      var id = tr.find(".firstRevenueId").html();
      var nameInput = tr.find(".firstRevenueName");

      // Enable the input field
      nameInput.prop("disabled", true);
      // Get the value of the input field
      var name = nameInput.val();
      $.ajax({
        url: "_chartOfAccount.php",
        type: "POST",
        data: {
          name: name,
          id: id,
          chartOfAccountActionRevenue: "RevenueFirstEditData",
        },
        success: function (data) {
          // console.log(data)
          if (data == 1) {
            revenueFirstTbodyShow();
            RevenueFirstModalTable();
            alert("Added Successfully");
          } else {
            alert("Error!");
          }
        },
      });
    }
  });

  $(document).on("click", ".firstRevenueDelete", function () {
    // Corrected line to find the closest 'tr' element
    var tr = $(this).closest("tr");

    var id = tr.find(".firstRevenueId").html();
    if (confirm("Do you want to delete.")) {
      $.ajax({
        url: "_chartOfAccount.php",
        type: "POST",
        data: {
          id: id,
          chartOfAccountActionRevenue: "RevenueFirstDeleteData",
        },
        success: function (data) {
          // console.log(data)
          if (data == 1) {
            revenueFirstTbodyShow();
            RevenueFirstModalTable();
            alert("Deleted Successfully");
          } else {
            alert("Error!");
          }
        },
      });
    }
  });
});

function revenueFirstTbodyShow() {
  $(document).ready(function () {
    var tabId = $(".active-tab .TopTab").html();
    $.ajax({
      url: "_chartOfAccount.php",
      type: "POST",
      data: {
        // name: libNatureName,
        tabId: tabId,
        chartOfAccountActionRevenue: "RevenueFirstTbodyGet",
      },
      success: function (data) {
        // console.log(data)
        $("#RevenueFirstTbody").html(data);
      },
    });
  });
}
// revenueFirstTbodyShow();

$(document).ready(function () {
  $("#RevenueFirstTbody").on("change", function () {
    var headID = $(this).val();
    $("#revenueThirdAddOpenModal").prop("disabled", true);

    $("#revenueFirstSelectId").html(headID);
    var tabId = $(".active-tab .TopTab").html();
    $.ajax({
      url: "_chartOfAccount.php",
      type: "POST",
      data: {
        tabId: tabId,
        headID: headID,
        chartOfAccountActionRevenue: "RevenueSecondTbody",
      },
      success: function (data) {
        // console.log(data)
        $("#RevenueSecondTbody").html(data);
        $("#revenueThirdTbody").html("");
      },
    });
  });
});

$(document).ready(function () {
  $("#RevenueFirstAddNew").on("click", function () {
    // alert("yes")
    var RevenueNatureName = $("#RevenueFirstNatureName").val();
    var tabId = $(".active-tab .TopTab").html();
    $.ajax({
      url: "_chartOfAccount.php",
      type: "POST",
      data: {
        tabId: tabId,
        name: RevenueNatureName,
        chartOfAccountActionRevenue: "addRevenueFirstNature",
      },
      success: function (data) {
        if (data != 1) {
          alert("Error!");
        } else {
          alert("Added");
        }
        revenueFirstTbodyShow();
        RevenueFirstModalTable();
      },
    });
  });
  $("#RevenueSecondAddNew").on("click", function () {
    // alert("yes")
    var RevenueNatureName = $("#RevenueSecondNatureName").val();
    var RevenueFirst = $("#revenueFirstSelectId").html();
    var tabId = $(".active-tab .TopTab").html();
    $.ajax({
      url: "_chartOfAccount.php",
      type: "POST",
      data: {
        tabId: tabId,
        r_id: RevenueFirst,
        name: RevenueNatureName,
        chartOfAccountActionRevenue: "addRevenueSecondNature",
      },
      success: function (data) {
        if (data != 1) {
          alert("Error!");
        } else {
          alert("Added");
        }
        $("#RevenueFirstTbody").trigger("change");
        RevenueSecondModalTable();
      },
    });
  });
  $("#RevenueThirdAddNew").on("click", function () {
    // alert("yes")
    var tabId = $(".active-tab .TopTab").html();
    var r_id = $("#revenueFirstSelectId").html();
    var r1_id = $("#RevenueSecondTbody").val();
    var name = $("#RevenueThirdNatureName").val();
    var house = $("#RevenueThirdNatureHouseName").val() != '' ? $("#RevenueThirdNatureHouseName").val() : '-' ;
    var status = $("#RevenueThirdNatureStatusName").val();
    $.ajax({
      url: "_chartOfAccount.php",
      type: "POST",
      data: {
        tabId: tabId,
        r_id: r_id,
        r1_id: r1_id,
        name: name,
        house: house,
        status: status,
        chartOfAccountActionRevenue: "addRevenueThirdNature",
      },
      success: function (data) {
        console.log(data);
        if (data != 1) {
          alert("Error!");
        } else {
          alert("Added");
        }
        $("#RevenueSecondTbody").trigger("change");
      },
    });
  });

  // second modal open by click on dot
  $("#revenueSecondDotImage").on("click", function () {
    RevenueSecondModalTable();
  });

  $("#RevenueSecondTbody").on("change", function () {
    var RevenueSecond = $(this).val();
    var RevenueFirst = $("#revenueFirstSelectId").html();
    var tabId = $(".active-tab .TopTab").html();
    $.ajax({
      url: "_chartOfAccount.php",
      type: "POST",
      data: {
        tabId: tabId,
        r_id: RevenueFirst,
        r1_id: RevenueSecond,
        chartOfAccountActionRevenue: "RevenueThirdTbodyGet",
      },
      success: function (data) {
        // console.log(data)
        $("#revenueThirdTbody").html(data);
        if ($("#RevenueSecondTbody").val() != "") {
          $("#revenueThirdAddOpenModal").prop("disabled", false);
        } else {
          $("#revenueThirdAddOpenModal").prop("disabled", true);
        }
      },
    });
  });

  $(document).on("click", ".thirdRevenueEdit", function () {
    if ($(this).html() == "Edit") {
      var btnName = $(this).html("Save");
      // Corrected line to find the closest 'tr' element
      var tr = $(this).closest("tr");

      var id = tr.find(".thirdRevenueId").html();
      var nameInput = tr.find(".thirdRevenueName");
      var status = tr.find(".thirdRevenueStatus ");

      // Enable the input field
      nameInput.prop("disabled", false);
      status.prop("disabled", false);
    } else {
      var btnName = $(this).html("Edit");
      var tr = $(this).closest("tr");

      var id = tr.find(".thirdRevenueId").html();
      var nameInput = tr.find(".thirdRevenueName");
      var status = tr.find(".thirdRevenueStatus");

      // Enable the input field
      nameInput.prop("disabled", true);
      status.prop("disabled", true);
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
          chartOfAccountActionRevenue: "RevenueThirdEditData",
        },
        success: function (data) {
          // console.log(data)
          if (data == 1) {
            alert("Added Successfully");
          } else {
            alert("Error!");
          }
        },
      });
    }
  });

  $(document).on("click", ".thirdRevenueDelete", function () {
    // Corrected line to find the closest 'tr' element
    var tr = $(this).closest("tr");

    var id = tr.find(".thirdRevenueId").html();
    if (confirm("Do you want to delete.")) {
      $.ajax({
        url: "_chartOfAccount.php",
        type: "POST",
        data: {
          id: id,
          chartOfAccountActionRevenue: "RevenueThirdDeleteData",
        },
        success: function (data) {
          // console.log(data)
          if (data == 1) {
            $("#RevenueSecondTbody").trigger("change");
            alert("Deleted Successfully");
          } else {
            alert("Error!");
          }
        },
      });
    }
  });
});

function RevenueSecondtoggleAddForm() {
  var addForm = document.getElementById("RevenueSecondAddform");
  addForm.classList.toggle("display-block");
}

function RevenueSecondModalTable() {
  $(document).ready(function () {
    var revenueData = $("#revenueFirstSelectId").html();
    // console.log(revenueData)
    var tabId = $(".active-tab .TopTab").html();
    $.ajax({
      url: "_chartOfAccount.php",
      type: "POST",
      data: {
        tabId: tabId,
        revenueData: revenueData,
        chartOfAccountActionRevenue: "revenueSecondModalTableBodyDataGet",
      },
      success: function (data) {
        $("#revenueSecondModalTableBody").html(data);
      },
    });
  });
}

$(document).ready(function () {
  $(document).on("click", ".secondRevenueEdit", function () {
    if ($(this).html() == "Edit") {
      var btnName = $(this).html("Save");
      // Corrected line to find the closest 'tr' element
      var tr = $(this).closest("tr");

      var id = tr.find(".secondRevenueId").html();
      var nameInput = tr.find(".secondRevenueName");

      // Enable the input field
      nameInput.prop("disabled", false);
    } else {
      var btnName = $(this).html("Edit");
      var tr = $(this).closest("tr");

      var id = tr.find(".secondRevenueId").html();
      var nameInput = tr.find(".secondRevenueName");

      // Enable the input field
      nameInput.prop("disabled", true);
      // Get the value of the input field
      var name = nameInput.val();
      $.ajax({
        url: "_chartOfAccount.php",
        type: "POST",
        data: {
          name: name,
          id: id,
          chartOfAccountActionRevenue: "RevenueSecondEditData",
        },
        success: function (data) {
          // console.log(data)
          if (data == 1) {
            $("#RevenueSecondTbody").trigger("change");
            $("#RevenueFirstTbody").trigger("change");
            RevenueSecondModalTable();
            alert("Added Successfully");
          } else {
            alert("Error!");
          }
        },
      });
    }
  });

  $(document).on("click", ".secondRevenueDelete", function () {
    // Corrected line to find the closest 'tr' element
    var tr = $(this).closest("tr");

    var id = tr.find(".secondRevenueId").html();
    if (confirm("Do you want to delete.")) {
      $.ajax({
        url: "_chartOfAccount.php",
        type: "POST",
        data: {
          id: id,
          chartOfAccountActionRevenue: "RevenueSecondDeleteData",
        },
        success: function (data) {
          // console.log(data)
          if (data == 1) {
            $("#RevenueSecondTbody").trigger("change");
            $("#RevenueFirstTbody").trigger("change");
            RevenueSecondModalTable();
            alert("Deleted Successfully");
          } else {
            alert("Error!");
          }
        },
      });
    }
  });
});
