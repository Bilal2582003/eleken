// let ownerCount = document.getElementById("ownerCount");
// let ownerCounter = 0;
// let tenantCounter = 0;
// setInterval(() => {
//   if (ownerCounter == 65) {
//     clearInterval();
//   } else {
//     ownerCounter += 1;
//     ownerCount.innerHTML = ownerCounter + "%";
//   }
// }, 30);

// setInterval(() => {
//   if (tenantCounter == 35) {
//     clearInterval();
//   } else {
//     tenantCounter += 1;
//     tenantCount.innerHTML = tenantCounter + "%";
//   }
// }, 30);
function addMaintenanceToggler(clicker) {
  var icon = clicker.lastElementChild.firstElementChild;
  var wholeModal3 = document.getElementsByClassName("wholeModal3")[0];

  if (icon.className == "fa-solid fa-angle-up") {
    // wholeModal3.style.minHeight = "95vh";
    // clicker.parentElement.parentElement.style.minHeight = "95vh";
    clicker.parentElement.parentElement.style.transitionDuration = "1000ms";
    icon.className = "fa-solid fa-angle-down";
    clicker.parentElement.style.height = "50%";
    clicker.parentElement.style.width = "90%";
    clicker.parentElement.style.transitionDuration = "1000ms";
  } else {
    icon.className = "fa-solid fa-angle-up";
    clicker.parentElement.style.height = "54px";
    clicker.parentElement.style.width = "43%";
    clicker.parentElement.style.transitionDuration = "1000ms";
    // wholeModal3.style.minHeight = "70vh";
    // clicker.parentElement.parentElement.style.minHeight = "70vh";
    clicker.parentElement.parentElement.style.transitionDuration = "1000ms";
  }
}
function pageSelector(index) {
  var pageSelectors = document.getElementsByClassName("pageSelectors");
  for (let i = 0; i < pageSelectors.length; i++) {
    if (index != i) {
      // pageSelectors[i].firstElementChild.style.visibility = "hidden";
      // pageSelectors[i].style.color = "rgb(197, 194, 194)";
      // pageSelectors[i].firstElementChild.style.marginRight = "0";
      // pageSelectors[i].firstElementChild.style.marginLeft = "0";
      pageSelectors[i].className = "pageSelectors"
    } else {
      // pageSelectors[i].firstElementChild.style.visibility = "visible";
      // pageSelectors[i].style.color = "white";
      // pageSelectors[i].firstElementChild.style.marginRight = "-10px";
      // pageSelectors[i].firstElementChild.style.marginLeft = "5px";
      pageSelectors[i].className += ' currentPage'
    }
  }
}

function showPassword(element) {
  if (element.parentElement.previousElementSibling.type == "password") {
    element.parentElement.previousElementSibling.type = "text";
    element.className = "fa-solid fa-eye-slash";
  } else {
    element.parentElement.previousElementSibling.type = "password";
    element.className = "fa-solid fa-eye";
  }
}

// function selectedUserSection(e) {
//   var userSelection = document.getElementById("userSelection").children;
//   for (let i = 0; i <= 3; i++) {
//     if (e == i) {
//       userSelection[i].setAttribute("class", "selectedUserSection");
//       // userSelection[i].lastElementChild.style.display = "none"
//     } else {
//       userSelection[i].removeAttribute("class");
//       // userSelection[i].lastElementChild.style.display = "block"
//     }
//   }
// }

function selectedUserTypeSection(e) {
  // var ownerAndTenant = document.getElementById("ownerAndTenant").children;
  var ownerH1 = document.getElementById("ownerH1");
  var ownerCount = document.getElementById("ownerCount");
  var tenantH1 = document.getElementById("tenantH1");
  var tenantCount = document.getElementById("tenantCount");
  // for (let i = 0; i <= 2; i++) {
  if (e == 0) {
    ownerH1.style.color = "#186eb1";
    // ownerH1.style.fontWeight = "bold"
    ownerCount.style.color = "#186eb1";
  } else {
    ownerH1.style.color = "#777";
    // ownerH1.style.fontWeight = "normal"
    ownerCount.style.color = "#777";
  }

  if (e == 1) {
    // ownerAndTenant[1].setAttribute(
    //   "class",
    //   "tenantMainSection selectedUserSection"
    // );
    tenantH1.style.color = "#e5032dbd";
    // tenantH1.style.fontWeight = "bold"
    tenantCount.style.color = "#e5032dbd";
  } else {
    // ownerAndTenant[1].setAttribute("class", "tenantMainSection");
    tenantH1.style.color = "#777";
    // tenantH1.style.fontWeight = "normal"
    tenantCount.style.color = "#777";
  }
  // }
}

function usersListMainHeading() {
  document.getElementById("ownerH1").style.color = "#186eb1";
  // document.getElementById("ownerH1").style.fontWeight = "normal";
  document.getElementById("ownerCount").style.color = "#777";
  document.getElementById("tenantH1").style.color = "#e14eca";
  // document.getElementById("tenantH1").style.fontWeight = "normal";
  document.getElementById("tenantCount").style.color = "#777";
}

function changeActiveStatus(btn) {
  var statusInputField = document.getElementById("statusInputField");
  if (btn.innerHTML == "Active") {
    statusInputField.value = btn.innerHTML;
    statusInputField.style.color = "#61b95b";
    btn.setAttribute("class", "active");
    btn.nextElementSibling.className = "changingBgBtn";
    btn.nextElementSibling.nextElementSibling.className = "changingBgBtn";
  } else if (btn.innerHTML == "Suspended") {
    statusInputField.value = btn.innerHTML;
    statusInputField.style.color = "#ff5f1fb4";
    btn.setAttribute("class", "suspended");
    btn.previousElementSibling.className = "changingBgBtn";
    btn.nextElementSibling.className = "changingBgBtn";
  } else {
    statusInputField.value = btn.innerHTML;
    statusInputField.style.color = "#ee405e";
    btn.setAttribute("class", "blocked");
    btn.previousElementSibling.className = "changingBgBtn";
    btn.previousElementSibling.previousElementSibling.className =
      "changingBgBtn";
  }
}

function changeUserType(btn) {
  var userTypeInputField = document.getElementById("userTypeInputField");
  if (btn.innerHTML == "Owner") {
    userTypeInputField.value = btn.innerHTML;
    userTypeInputField.style.color = "#186eb1";
    btn.className = "ownerChangeBtn";
    btn.nextElementSibling.className = "changingBgBtn";
  } else {
    userTypeInputField.value = btn.innerHTML;
    userTypeInputField.style.color = "#e14eca";
    btn.className = "tenantChangeBtn";
    btn.previousElementSibling.className = "changingBgBtn";
  }
}

function ownerToTenantEffects(key) {
  var tenantDetail = document.getElementById("tenantDetail");
  if (key == 0) {
    tenantDetail.className = "visibilityHidden";
    tenantDetail.lastElementChild.value = "";
  } else {
    tenantDetail.className = "visibilityVisible";
  }
}

function editBtnToggler(btn) {
  var editIcon = '<i class="fa-solid fa-pen-to-square"></i>';
  var saveIcon = '<i class="fa-solid fa-floppy-disk"></i>';
  var editableFields = document.getElementsByClassName("editableFields");
  var userDetailsImg = document.getElementById("userDetailsImg");
  if (btn.innerHTML == `${editIcon} EDIT DETAILS`) {
    btn.innerHTML = `${saveIcon} SAVE CHANGES`;
    btn.style.backgroundColor = "#61b95b";

    for (let i = 0; i < editableFields.length; i++) {
      editableFields[i].disabled = false;
      editableFields[i].style.borderBottom = "1px solid #888";
    }

    userDetailsImg.src = "../images/users/editing.png";
  } else {
    btn.innerHTML = `${editIcon} EDIT DETAILS`;
    btn.style.backgroundColor = "#186eb1";

    for (let i = 0; i < editableFields.length; i++) {
      editableFields[i].disabled = true;
      editableFields[i].style.borderBottom = "none";
    }

    userDetailsImg.src = "../images/users/detailing.png";
  }
}

function updateTenantDetails() {
  var tenantDetail = document.getElementById("tenantDetail");
  tenantDetail.lastElementChild.style.color = "#555";
  if (
    (tenantDetail.lastElementChild.value == "" ||
      tenantDetail.lastElementChild.value == "Please Add CNIC here!") &&
    tenantDetail.className == "visibilityVisible"
  ) {
    tenantDetail.lastElementChild.value = "Please Add CNIC here!";
    tenantDetail.lastElementChild.style.color = "#ee405e";
  }
}

// function haltServiceToggler(icon) {
// if (icon.className == "fa-solid fa-toggle-off") {
//     icon.setAttribute("data-toggle", "modal")
//   } else {
//     icon.removeAttribute("data-toggle")
//   }
//   icon.className =
//     icon.className == "fa-solid fa-toggle-off"
//       ? "fa-solid fa-toggle-on"
//       : "fa-solid fa-toggle-off";
//   icon.style.color =
//     icon.className == "fa-solid fa-toggle-off" ? "#555" : "#ee405e";
// }
function haltServiceToggler(icon) {
  if (icon.className == "fa-solid fa-toggle-off haltToggleOff") {
    haltModalClose();
    icon.setAttribute("data-toggle", "modal");
  } else {
    icon.removeAttribute("data-toggle");
    icon.className = "fa-solid fa-toggle-off haltToggleOff";

    haltModalClose();
  }
}
function haltModalClose() {
  let haltOptions = document.getElementsByClassName("haltModalOptions");
  for (let j = 0; j < haltOptions.length; j++) {
    haltOptions[j].checked = false;
  }
  const haltSectionModalOthersInputField = document.getElementById(
    "haltSectionModalOthersInputField"
  );
  haltSectionModalOthersInputField.style.display = "none";
  haltSectionModalOthersInputField.value = "";
}

function ordersTabSectionToggler(tab) {
  const tabSectionBody = document.getElementById("tabSectionBody");
  const tabSectionHaltBody = document.getElementById("tabSectionHaltBody");

  if (tab.innerHTML == "Quota") {
    tabSectionBody.className = "tabSectionDisplayBody";
    tabSectionHaltBody.className = "tabSectionHiddenBody";

    tab.style.background = "white";
    tab.style.color = "#555";
    tab.style.borderRadius = "20px 20px 0 0";
    tab.parentElement.style.paddingLeft = "5px";
    tab.parentElement.style.background = "#283e51";
    tab.parentElement.style.borderTop = "5px solid #283e51";

    tab.parentElement.nextElementSibling.style.background = "#283e51";
    tab.parentElement.nextElementSibling.style.borderRadius = "0 20px 0 20px";
    tab.parentElement.nextElementSibling.style.borderTop = "5px solid #283e51";

    tab.parentElement.nextElementSibling.firstElementChild.style.background =
      "transparent";
    tab.parentElement.nextElementSibling.firstElementChild.style.color =
      "white";
  } else if (tab.innerHTML == "Halt") {
    tabSectionHaltBody.className = "tabSectionDisplayHaltBody";
    tabSectionBody.className = "tabSectionHiddenBody";

    tab.style.background = "white";
    tab.style.color = "#555";
    tab.style.borderRadius = "20px 20px 0 0";
    tab.parentElement.style.paddingRight = "5px";
    // tab.parentElement.style.background = "#4b79a1";
    tab.parentElement.style.background = "#ee405e";
    tab.parentElement.style.borderTop = "5px solid #ee405e";

    tab.parentElement.previousElementSibling.style.background = "#ee405e";
    tab.parentElement.previousElementSibling.style.borderRadius =
      "20px 0 20px 0";
    tab.parentElement.previousElementSibling.style.borderTop =
      "5px solid #ee405e";

    tab.parentElement.previousElementSibling.firstElementChild.style.background =
      "transparent";
    tab.parentElement.previousElementSibling.firstElementChild.style.color =
      "white";
  }
}

function dailyQuotaEditBtn(editBtn) {
  const dailyQuotaInput = document.getElementById("dailyQuotaInput");
  if (editBtn.innerHTML == "EDIT") {
    editBtn.innerHTML = "SAVE";
    dailyQuotaInput.disabled = false;
    dailyQuotaInput.style.borderBottom = "2px solid #186eb1";
    editBtn.removeAttribute("class");
  } else {
    editBtn.innerHTML = "EDIT";
    dailyQuotaInput.disabled = true;
    dailyQuotaInput.style.borderBottom = "none";
    editBtn.setAttribute("class", "udpateQuota");
  }
}

///// Multiple Selection Functionality on Orders Page

function multipleSelectionFunction(btn) {
  btn.firstElementChild.className =
    btn.firstElementChild.className == "fa-solid fa-bars"
      ? "fa-solid fa-xmark"
      : "fa-solid fa-bars";
  btn.className = btn.className == "embeddedBtn" ? "" : "embeddedBtn";

  // Action Button Container Show
  const multipleSelectedOrderActionBtnDiv = document.getElementById(
    "multipleSelectedOrderActionBtnDiv"
  );
  multipleSelectedOrderActionBtnDiv.className =
    btn.className == "embeddedBtn"
      ? "ordersMutipleSelectionMainDiv"
      : "displayNone";

  // Modal Disable Toggler
  const userDetails =
    document.getElementById("userDetails") ||
    document.getElementById("DisableModal");
  userDetails.id =
    userDetails.id == "userDetails" ? "DisableModal" : "userDetails";

  // Selecting tr
  const orderTableBody = document.getElementById("orderTableBody");
  for (let i = 0; i < orderTableBody.children.length; i++) {
    if (btn.className == "embeddedBtn") {
      orderTableBody.children[i].setAttribute(
        "onclick",
        "selectTrFunction(this)"
      );
    } else {
      orderTableBody.children[i].removeAttribute("onclick");
    }
  }
}

// Row Selecting Toggler
function selectTrFunction(tr) {
  if (tr.style.color == "white") {
    for (let j = 0; j < tr.children.length; j++) {
      tr.children[j].style.backgroundColor = "transparent";
    }
    tr.style.color = "#212529";
    tr.style.opacity = "1";
    tr.className = "";
    loadingData(tr, 0);
  } else {
    for (let i = 0; i < tr.children.length; i++) {
      tr.children[i].style.backgroundColor = "#999";
    }
    tr.style.color = "white";
    tr.style.opacity = "0.5";
    tr.className = "selectedTr";
    loadingData(tr, 1);
  }
}

//  Loading Data into Modal
function loadingData(selectedTr, key) {
  var modalTbody = document.getElementById("modalTbody");
  var orderIdTdTxt = selectedTr.children[0].innerHTML;
  var toTdTxt = selectedTr.children[3].innerHTML;
  var tankerTypeTdTxt = selectedTr.children[2].innerHTML;

  if (key == 1) {
    var tr = document.createElement("tr");

    var orderIdTd = document.createElement("td");
    orderIdTd.append(orderIdTdTxt);

    var toTd = document.createElement("td");
    toTd.append(toTdTxt);

    var tankerTypeTd = document.createElement("td");
    tankerTypeTd.append(tankerTypeTdTxt);
    tankerTypeTd.style.textTransform = "capitalize"

    tr.append(orderIdTd);
    tr.append(toTd);
    tr.append(tankerTypeTd);

    modalTbody.append(tr);
  } else if (key == 0) {
    for (let k = 0; k < modalTbody.children.length; k++) {
      if (modalTbody.children[k].firstElementChild.innerHTML == orderIdTdTxt) {
        modalTbody.removeChild(modalTbody.children[k]);
      }
    }
  }
}

function clearAllModalList() {
  const modalTbody = document.getElementById("modalTbody");
  modalTbody.innerHTML = "";

  const orderTableBody = document.getElementById("orderTableBody");
  for (let i = 0; i < orderTableBody.children.length; i++) {
    orderTableBody.children[i].style.color = "#212529";
    orderTableBody.children[i].style.opacity = "1";
    orderTableBody.children[i].className = " ";
    for (let j = 0; j < orderTableBody.children[i].children.length; j++) {
      orderTableBody.children[i].children[j].style.backgroundColor =
        "transparent";
    }
  }
  multipleSelectionFunction(document.getElementById("sm_ID"));
}

function previousPaymentsToggler(clicker) {
  const icon = clicker.lastElementChild.firstElementChild;

  if (icon.className == "fa-solid fa-angle-up") {
    icon.className = "fa-solid fa-angle-down";
    clicker.parentElement.style.boxShadow = "none";
    clicker.parentElement.style.height = "70%";
    clicker.parentElement.style.width = "84%";
  } else {
    icon.className = "fa-solid fa-angle-up";
    clicker.parentElement.style.boxShadow = "0px 3px 10px rgb(0 0 0 / 16%)";
    clicker.parentElement.style.height = "54px";
    clicker.parentElement.style.width = "43%";
  }
}

function othersInputFieldToggler(e) {
  const haltSectionModalOthersInputField = document.getElementById(
    "haltSectionModalOthersInputField"
  );

  if (e.lastElementChild.innerHTML != "Others") {
    haltSectionModalOthersInputField.style.display = "none";
  } else {
    haltSectionModalOthersInputField.style.display = "block";
  }
}

function presentationSectionSelector(element) {
  let selectors = document.getElementsByClassName("pieColorsSection");

  for (let i = 0; i < selectors.length; i++) {
    selectors[i].style.boxShadow = "0px 0px 10px rgb(0 0 0/ 20%) inset";
    selectors[i].style.opacity = "0.5";
    selectors[i].style.background =
      "linear-gradient(to right, rgb(255 255 255/ 50%), rgb(255 255 255/ 50%))";
    switch (selectors[i].id) {
      case "Normal_Tankers":
        selectors[i].style.backgroundColor = "rgb(255, 99, 132)";
        break;

      case "Cash_Tankers":
        selectors[i].style.backgroundColor = "rgb(255, 205, 86)";
        break;

      default:
        selectors[i].style.backgroundColor = "rgb(54, 255, 86)";
    }
  }
  element.firstElementChild.style.boxShadow = "0px 3px 5px rgb(0 0 0/ 20%)";
  element.firstElementChild.style.opacity = "1";
  element.firstElementChild.style.background = "transparent";
  switch (element.firstElementChild.id) {
    case "Normal_Tankers":
      element.firstElementChild.style.backgroundColor = "rgb(255, 99, 132)";
      break;

    case "Cash_Tankers":
      element.firstElementChild.style.backgroundColor = "rgb(255, 205, 86)";
      break;

    default:
      element.firstElementChild.style.backgroundColor = "rgb(54, 255, 86)";
  }
}
function pieSelectorsReloader() {
  let selectors = document.getElementsByClassName("pieColorsSection");
  let pieSelectors = document.getElementsByClassName("pieSelectors");

  for (let i = 0; i < selectors.length; i++) {
    pieSelectors[i].style.boxShadow = "none";
    selectors[i].style.boxShadow = "0px 0px 10px rgb(0 0 0/ 20%) inset";
    selectors[i].style.opacity = "0.5";
    selectors[i].style.background =
      "linear-gradient(to right, rgb(255 255 255/ 50%), rgb(255 255 255/ 50%))";
    switch (selectors[i].id) {
      case "Normal_Tankers":
        selectors[i].style.backgroundColor = "rgb(255, 99, 1" + "32)";
        break;

      case "Cash_Tankers":
        selectors[i].style.backgroundColor = "rgb(255, 205, 86)";
        break;

      default:
        selectors[i].style.backgroundColor = "rgb(54, 255, 86)";
    }
  }
}
function viewReceiptRedirector(id) {
  window.location.assign(`./invoice.php?id=${id}`);
}

function extendingAdminBoard(angle_up_down) {
  const orderTableBody = document.getElementById("orderTableBody");
  if (angle_up_down.firstElementChild.className == "fa-solid fa-angle-down") {
    orderTableBody.style.transitionDuration = "800ms";
    orderTableBody.style.minHeight = "480px";
    angle_up_down.firstElementChild.className = "fa-solid fa-angle-up";
  } else if (
    angle_up_down.firstElementChild.className == "fa-solid fa-angle-up"
  ) {
    orderTableBody.style.transitionDuration = "800ms";
    orderTableBody.style.minHeight = "260px";
    angle_up_down.firstElementChild.className = "fa-solid fa-angle-down";
  }
}
function adminModalEditBtnToggler(btn) {
  let adminEditableFields = document.getElementsByClassName(
    "adminEditableFields"
  );
  if (btn.innerHTML == "EDIT") {
    for (let i = 0; i < adminEditableFields.length; i++) {
      adminEditableFields[i].disabled = false;
      adminEditableFields[i].style.borderBottom = "2px solid #ddd";
    }
    btn.innerHTML = "SAVE";
    btn.className = "adminModalEditBtn";
  } else {
    for (let i = 0; i < adminEditableFields.length; i++) {
      adminEditableFields[i].disabled = true;
      adminEditableFields[i].style.borderBottom = "none";
    }
    btn.innerHTML = "EDIT";
    btn.className += " admin_action";
  }
}

function extendResidentialHistory(pressedSection) {
  const forResidentialHistory = document.getElementById(
    "forResidentialHistory"
  );
  const icon = pressedSection.lastElementChild;
  if (icon.className == "fa-solid fa-angle-down") {
    icon.className = "fa-solid fa-angle-up";

    pressedSection.style.boxShadow = "0px 3px 10px rgb(0 0 0 / 16%) inset";

    forResidentialHistory.style.display = "block";
  } else if (icon.className == "fa-solid fa-angle-up") {
    icon.className = "fa-solid fa-angle-down";

    pressedSection.style.boxShadow = "none";

    forResidentialHistory.style.display = "none";
  }
}
function selectingHouseToggler(selectedDiv) {
  if (selectedDiv.className == "unclickedDiv") {
    selectedDiv.style.background = "rgba(13, 116, 233, 0.151)";
    selectedDiv.className = "clickedDiv";
    selectedDiv.style.boxShadow = "0px 3px 10px rgb(0 0 0 / 16%) inset";
  } else if (selectedDiv.className == "clickedDiv") {
    selectedDiv.style.background = "#FAF9F6";
    selectedDiv.className = "unclickedDiv";
    selectedDiv.style.boxShadow = "0px 3px 10px rgb(0 0 0 / 16%)";
  }
}

function selectAllUnits(icon) {
  let allUnits = document.getElementById("houseContainerSection").children;
  if (icon.className == "fa-regular fa-square") {
    icon.className = "fa-solid fa-square-check";
    icon.style.color = "#015e8b";
    for (let i = 0; i < allUnits.length; i++) {
      allUnits[i].style.background = "rgba(13, 116, 233, 0.151)";
      allUnits[i].style.boxShadow = "0px 3px 10px rgb(0 0 0 / 16%) inset";
      allUnits[i].className = "clickedDiv";
    }
  } else {
    icon.className = "fa-regular fa-square";
    icon.style.color = "#666";
    for (let i = 0; i < allUnits.length; i++) {
      allUnits[i].style.background = "#FAF9F6";
      allUnits[i].style.boxShadow = "0px 3px 10px rgb(0 0 0 / 16%)";
      allUnits[i].className = "unclickedDiv";
    }
  }
}

function loadNotificationData() {
  let selectedHouseListing = document.getElementsByClassName(
    "selectedHouseListing"
  )[0];
  let clickedDiv = document.getElementsByClassName("clickedDiv");
  const noSelectedHouseParaTxt = "You didn't Selected any House";
  // console.log(clickedDiv[0])
  if (clickedDiv.length != 0) {
    selectedHouseListing.innerHTML = "";
    selectedHouseListing.style.boxShadow = "none";
    for (let i = 0; i < clickedDiv.length; i++) {
      var houseTitleBtn = document.createElement("button");
      houseTitleBtn.append(clickedDiv[i].innerHTML);
      selectedHouseListing.append(houseTitleBtn);
    }
  } else {
    selectedHouseListing.style.boxShadow = "0px 3px 10px #ddd";
    selectedHouseListing.innerHTML = "";
    var p = document.createElement("p");
    p.append(noSelectedHouseParaTxt);
    selectedHouseListing.append(p);
  }
}

function shakeBtn(btn) {
  btn.className = "animate__animated animate__shakeX";
  // removeShakeBtn(btn)
}

function customMaintenanceAmount(btn) {
  if (btn.innerHTML == "Custom") {
    btn.innerHTML = "Save";
    btn.previousElementSibling.disabled = false;
    btn.previousElementSibling.style.borderBottom = "2px solid #ddd";
  } else if (btn.innerHTML == "Save") {
    btn.innerHTML = "Custom";
    btn.previousElementSibling.disabled = true;
    btn.previousElementSibling.style.borderBottom = "none";
  }
}

function addAdminPageSelection(element) {
  if (element.previousElementSibling.className == "fa-solid fa-circle-check checkDisplayNone") {
    element.previousElementSibling.previousElementSibling.checked = true;
    element.previousElementSibling.className = "fa-solid fa-circle-check checkDisplayVisible";
    // element.style.borderBottom = "1px dashed #999";
  } else if (element.previousElementSibling.className == "fa-solid fa-circle-check checkDisplayVisible") {
    element.previousElementSibling.previousElementSibling.checked = false;
    element.previousElementSibling.className = "fa-solid fa-circle-check checkDisplayNone";
    // element.style.borderBottom = "none";
  }
  // console.log(element.innerHTML + " heheeh " + element.previousElementSibling.checked)
}

function exchangeFields(element) {
  const selectElement = document.getElementById("add_type");
  if (element.firstElementChild.className == "fa-solid fa-plus") {
    element.firstElementChild.className = "fa-solid fa-check"
    element.previousElementSibling.style.display = "inline-block"
    element.previousElementSibling.previousElementSibling.style.display = "none"
  } else {
    element.firstElementChild.className = "fa-solid fa-plus"
    element.previousElementSibling.style.display = "none"
    element.previousElementSibling.previousElementSibling.style.display = "inline-block"
    if(element.previousElementSibling.value != "") {
      var option = document.createElement('option');
      option.setAttribute('value', "")
      option.innerHTML = element.previousElementSibling.value
      selectElement.append(option)
      // console.log(selectElement)
      element.previousElementSibling.value = ""
    }
  }
}

function addAmountMaintenance(element) {
  var totalDueId = document.getElementById("totalDueId");
  var dueMonths = document.getElementById("dueMonths").value;
  var dueMonthsArray = dueMonths.split(", ");
  var initialAmount = +totalDueId.value / +dueMonthsArray.length;
  var payingMonths = document.getElementById("payingMonths");
  if (+element.previousElementSibling.value < +totalDueId.value) {
    element.previousElementSibling.value =
      +element.previousElementSibling.value + +initialAmount;
    payingMonths.value = "0" + (+payingMonths.value + 1);
  }
 }


 function paymentMethod(input) {
  const billCashPayment = document.getElementById("billCashPayment");
  const billChequePayment = document.getElementById("billChequePayment");
  const chequeNoId = document.getElementById("chequeNoId");
  if(billChequePayment.checked == true) {
    chequeNoId.style.display = "flex"
    billChequePayment.className="selected_radio_btn";
    billCashPayment.className=""
    // console.log(billCashPayment)
    // console.log(billChequePayment)
  } else if (billCashPayment.checked == true) {
    chequeNoId.style.display = "none"
    billCashPayment.className = "selected_radio_btn"
    billChequePayment.className = ""
    // console.log(billCashPayment)
    // console.log(billChequePayment)
  }
 
}
function deletingDriver(i) {
  var permission = prompt(
    "Are you sure you want to remove this Driver\nType 'Yes'"
  );
  if (permission.toLowerCase() == "yes") {
    i.parentElement.parentElement.remove();
  }
}
