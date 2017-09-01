@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><a href="/home">Dashboard</a></div>

                <div class="panel-body">

                        <div id="success_msg" class="alert alert-success" style="display:none;">
                        </div>
                        <div id="error_msg" class="alert alert-danger" style="display:none;">
                        </div>
                    <input type="text" id="searchBox" onkeyup="searchFunction()" class="form-control" placeholder="Search any field.."><br />
                    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#addContact">Add New Contact</button>
                    <hr />
                    @if (isset($contacts))
                    <table id="contactsTable" class="table table-striped">
                      <thead>
                        <tr>
                          <th>Firstname</th>
                          <th>Lastname</th>
                          <th>Email</th>
                          <th>Phone</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                    <tbody>
                    @foreach($contacts as $contact)
                      <tr>
                          <td>{{ $contact['first_name'] }}</td>
                          <td>{{ $contact['last_name'] }}</td>
                          <td>{{ $contact['email'] }}</td>
                          <td>{{ $contact['phone'] }}</td>
                          <td><a style="cursor:pointer;" onClick="editContactDetails('{{ $contact['id'] }}');" data-toggle="modal" data-target="#editContact">Edit Contact</a></td>
                      </tr>
                    @endforeach
                    </tbody>
                  </table>
                  @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="addContact" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add New Contact</h4>
      </div>
      <div class="modal-body">
          <form class="form-horizontal" method="POST" id="addContactForm">
          <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}">
                        <div class="form-group">
                            <label for="first_name" class="col-md-4 control-label">First Name</label>

                            <div class="col-md-6">
                                <input id="first_name" type="text" class="form-control" name="first_name" value="" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="last_name" class="col-md-4 control-label">Last Name</label>

                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control" name="last_name" value="" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="" required>
                            </div>
                        </div>

                       <div class="form-group">
                            <label for="phone" class="col-md-4 control-label">Phone</label>

                            <div class="col-md-6">
                                <input id="phone" class="form-control" name="phone" value="" required type="tel" pattern="\d{3}[\-]\d{3}[\-]\d{4}" placeholder="123-456-7890">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Add Contact
                                </button>
                            </div>
                        </div>
                    </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- Edit Modal -->
<div id="editContact" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Contact</h4>
      </div>
      <div class="modal-body">
          <form class="form-horizontal" method="POST" id="editContactForm">
          <input type="hidden" name="id" id="id" value="">
          <input type="hidden" name="hemail" id="hemail" value="">
                        <div class="form-group">
                            <label for="efirst_name" class="col-md-4 control-label">First Name</label>

                            <div class="col-md-6">
                                <input id="efirst_name" type="text" class="form-control" name="efirst_name" value="" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="elast_name" class="col-md-4 control-label">Last Name</label>

                            <div class="col-md-6">
                                <input id="elast_name" type="text" class="form-control" name="elast_name" value="" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="eemail" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="eemail" type="email" class="form-control" name="eemail" disabled="disabled" value="" required>
                            </div>
                        </div>

                       <div class="form-group">
                            <label for="ephone" class="col-md-4 control-label">Phone</label>

                            <div class="col-md-6">
                                <input id="ephone" class="form-control" name="ephone" value="" required type="tel" pattern="\d{3}[\-]\d{3}[\-]\d{4}" placeholder="123-456-7890">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Update Contact
                                </button>
                            </div>
                        </div>

                        <hr>
                        <div id="custom_fields">

                        </div>
                    </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
@endsection
