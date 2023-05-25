var filterSelect = document.getElementById("filter");

filterSelect.addEventListener("change", function() {
  var selectedValue = filterSelect.value;

  switch (selectedValue) {
    case "recent":
      reloadPage("recent");
      break;
    case "closed":
      reloadPage("closed");
      break;
    case "open":
      reloadPage("open");
      break;
    case "title":
      reloadPage("title");
      break;
    case "department":
      reloadPage("department");
      break;
    default:
      reloadPage("recent");
      break;
  }
});

function reloadPage(filter) {
  window.location.href = "tickets_page.php?filter=" + filter;
}
