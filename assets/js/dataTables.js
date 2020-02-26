$(function() {
  // dataTables
  if ($(".dataTables").length) {
    var urlAdd = $(".dataTables").attr("data-urladd");
    var dataTables = $(".dataTables").DataTable({
      pageLength: 25,
      destroy: true,
      responsive: true,
      ordering: false,
      dom:
        '<"row"<"col-sm-6"B><"col-sm-6"f>><"row"<"col-sm-6"><"col-sm-6">>t<"row"<"col-sm-6"i><"col-sm-6"p>>',
      buttons: [
        {
          text: "Insert Data",
          action: function(e, dt, node, config) {
            window.location = urlAdd;
          }
        }
      ]
    });
  }
  if ($(".dataTable-nobtn").length) {
    var dataTables = $(".dataTable-nobtn").DataTable({
      pageLength: 25,
      destroy: true,
      responsive: true,
      ordering: false,
      dom:
        '<"row"<"col-sm-6"><"col-sm-6"f>><"row"<"col-sm-6"><"col-sm-6">>t<"row"<"col-sm-6"i><"col-sm-6"p>>'
    });
  }
  if ($(".dataExport").length) {
    var urlAdd = $(".dataExport").attr("data-urladd");
    var col = $(".dataExport").attr("data-col");
    var filename = $(".dataExport").attr("data-filename");
    var importUrl = $(".dataExport").attr("data-urlImport");
    var dataTables = $(".dataExport").DataTable({
      pageLength: 25,
      destroy: true,
      responsive: true,
      ordering: false,
      dom:
        '<"row"<"col-sm-6"B><"col-sm-6"f>><"row"<"col-sm-6"><"col-sm-6">>t<"row"<"col-sm-6"i><"col-sm-6"p>>',
      buttons: [
        {
          extend: "csvHtml5",
          text: "EXPORT Data",
          title: filename,
          exportOptions: {
            columns: [col]
          }
        },
        {
          text: "Import Data",
          action: function(e, dt, node, config) {
            window.location = importUrl;
          }
        },
        {
          text: "Insert Data",
          action: function(e, dt, node, config) {
            window.location = urlAdd;
          }
        }
      ]
    });
  }

  if ($("#dataOrders").length) {
    var col = $("#dataOrders").attr("data-col");
    var filename = $("#dataOrders").attr("data-filename");
    var dataTables = $("#dataOrders").DataTable({
      pageLength: 25,
      destroy: true,
      responsive: true,
      ordering: false,
      dom:
        '<"row"<"col-sm-6"B><"col-sm-6"f>><"row"<"col-sm-6"><"col-sm-6">>t<"row"<"col-sm-6"i><"col-sm-6"p>>',
      buttons: [
        {
          extend: "csvHtml5",
          text: "EXPORT Data",
          title: filename,
          exportOptions: {
            columns: [col]
          }
        },
      ]
    });
  }
});
