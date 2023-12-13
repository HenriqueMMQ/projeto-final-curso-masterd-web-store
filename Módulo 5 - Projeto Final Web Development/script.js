function toggleSidebar() {
  sidebar = document.querySelector(".sidebar");
  if (sidebar.style.width === "300px") {
    sidebar.style.width = "0";
  } else {
    sidebar.style.width = "300px";
  }
}

$('seeMoreButton').click(function(event){
  event.preventDefault();
});