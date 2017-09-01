function searchFunction() {

  var input, filter, table, tr, td, i;
  input = document.getElementById("searchBox");
  filter = input.value.toUpperCase();
  table = document.getElementById("contactsTable");
  tr = table.getElementsByTagName("tr");

  for (i = 0; i < tr.length; i++) {
    for (t = 0; t < 4; t++) {
    td = tr[i].getElementsByTagName("td")[t];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
        break;
      } else {
        tr[i].style.display = "none";
      }
    }
    }
  }
}


$( "#addContactForm" ).submit(function( event ) {
   event.preventDefault();
   var url = "contacts/create";

    $.ajax({
           type: "GET",
           url: url,
           data: $("#addContactForm").serialize(),
           success: function(data)
           {
               $("#success_msg").html(data);
               $("#success_msg").show();
               $("#error_msg").hide();
               loadContacts();
           },
           error: function (error) {
               $("#error_msg").html('Error creating contact, that contact email is already in the system or you just plain entered bad data.');
               $("#error_msg").show();
               $("#success_msg").hide();
           }
         });

   $('#addContact').modal('toggle');
});

$( "#editContactForm" ).submit(function( event ) {
   event.preventDefault();
   var url = "contacts/edit";

    $.ajax({
           type: "GET",
           url: url,
           data: $("#editContactForm").serialize(),
           success: function(data)
           {
               $("#success_msg").html(data);
               $("#success_msg").show();
               $("#error_msg").hide();
               loadContacts();
           },
           error: function (error) {
               $("#error_msg").html('Error saving contact, please try again and avoid making the same silly error this time.');
               $("#error_msg").show();
               $("#success_msg").hide();
           }
         });


   $('#editContact').modal('toggle');
});

function editContactDetails( id ) {

   var url = "contacts/details/"+id;

    $.ajax({
           type: "GET",
           url: url,
           success: function(data)
           {
               data = $.parseJSON(data);
               $("#id").val(id);
               $("#efirst_name").val(data.first_name);
               $("#elast_name").val(data.last_name);
               $("#eemail").val(data.email);
               $("#hemail").val(data.email);
               $("#ephone").val(data.phone);
               var customCount = 0;
               var customFields = '<div style="width:100%; padding:10px; text-align:center; font-weight:bold;">Custom Fields</strong></div>';
               if(data.details.length > 0){
                   $.each(data.details, function() {
                       customCount++;
                       customFields += '<div class="form-group">';
                       customFields += '<label for="first_name" class="col-md-4 control-label">Custom Field '+customCount+'</label>';
                       customFields += '<div class="col-md-6">';
                       customFields += '<input id="custom_field_'+customCount+'" type="text" class="form-control" style="width:80%; float:left;" name="custom_field_'+customCount+'" value="'+this.value+'" disabled="disabled">';
                       customFields += '<a onClick="removeDetail('+this.id+');" style="cursor:pointer; float:left; font-size:22px; padding-left:10px;">-</a>';
                       customFields += '</div>';
                       customFields += '</div>';
                   });
               }
               if (customCount < 5) {
                       customCount++;
                       customFields += '<div class="form-group">';
                       customFields += '<label for="first_name" class="col-md-4 control-label">Custom Field '+customCount+'</label>';
                       customFields += '<div class="col-md-6">';
                       customFields += '<input id="custom_field" type="text" class="form-control" style="width:80%; float:left;" name="custom_field" value="" > ';
                       customFields += '<a onClick="addDetail();" style="cursor:pointer; float:left; font-size:22px; padding-left:10px;">+</a>';
                       customFields += '</div>';
                       customFields += '</div>';
               }
               $('#custom_fields').html(customFields);
           },
           error: function (error) {
               console.log('Error: Unable to load contact details.');
           }
         });

};

function loadContacts () {

    var url = "contacts/showall/";

    $.ajax({
           type: "GET",
           url: url,
           success: function(data)
           {
               data = $.parseJSON(data);
               var contactsTable = '<thead><tr><th>Firstname</th><th>Lastname</th><th>Email</th><th>Phone</th><th>Action</th></tr></thead>';
               contactsTable += '<tbody>';
               $.each(data, function() {
                      contactsTable += '<tr>';
                      contactsTable += '<td>'+this.first_name+'</td>';
                      contactsTable += '<td>'+this.last_name+'</td>';
                      contactsTable += '<td>'+this.email+'</td>';
                      contactsTable += '<td>'+this.phone+'</td>';
                      contactsTable += '<td><a style="cursor:pointer;" onClick="editContactDetails('+this.id+');" data-toggle="modal" data-target="#editContact">Edit Contact</a></td>';
                      contactsTable += '</tr>;'
                });
                contactsTable += '</tbody>';
                $('#contactsTable').html(contactsTable);
           },
           error: function (error) {
               console.log('Error: Unable to load contacts.');
           }
         });

};

function addDetail () {

    var url = "contacts/createdetail";

    $.ajax({
           type: "GET",
           url: url,
           data: $("#editContactForm").serialize(),
           success: function(data)
           {
               console.log(data);
               editContactDetails( $('#id').val() )
           },
           error: function (error) {
               console.log('Error: No value passed.');
           }
     });

};

function removeDetail (id) {

    var url = "contacts/removedetail/"+id;

    $.ajax({
           type: "GET",
           url: url,
           success: function(data)
           {
               console.log(data);
               editContactDetails( $('#id').val() )
           },
           error: function (error) {
               console.log('Error: Unable to remove custom field.');
           }
    });
};
