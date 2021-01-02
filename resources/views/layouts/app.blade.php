<html>

<head>
    <title>App Name - @yield('title')</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js">
    </script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js">
    </script>

    <style>
        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: #9C27B0;
            color: white;
            text-align: center;
        }

    </style>

</head>

<body>
    @section('sidebar')

    @show

    <div class="modal fade" id="addModal">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <div class="card-body text-center">
                      <h3>Add User</h3>
                  </div>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <div class="card mt-3">
                      <div class="card-body">
                          <form method="post" id="addUser" action="{{ route('products.store') }}">
                            @csrf
                              <div class="form-group">
                                  <label>Name</label>
                                  <input type="text" name="name" id="addName" class="form-control" placeholder="Enter Name" autocomplete="off">
                              </div>
                              <div class="form-group">
                                  <label>Description</label>
                                  <input type="text" name="description" id="addDesc" class="form-control" placeholder="Description" autocomplete="off">
                              </div>
                              <div class="form-group">
                                  <label>Price</label>
                                  <input type="text" name="price" id="addPrice" class="form-control" placeholder="Price" autocomplete="off">
                              </div>
                              <button type="submit" name="submit" class="btn btn-primary btnAdd">Submit</button>
                          </form>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <div class="modal fade" id="updateModal">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <div class="card-body text-center">
                      <h3>Update User</h3>
                  </div>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <div class="card mt-3">
                      <div class="card-body">
                          <form method="post" id="updateProduct" action="{{ route('products.update', $product->id) }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="hdnUserId" id="hdnUserId"/>
                              <div class="form-group">
                                  <label>Name</label>
                                  <input type="text" name="name" id="txtUpdateName" class="form-control" autocomplete="off">
                              </div>
                              <div class="form-group">
                                  <label>Description</label>
                                  <input type="text" name="description" id="txtUpdateDesc" class="form-control" autocomplete="off">
                              </div>
                              <div class="form-group">
                                  <label>Price</label>
                                  <input type="text" name="price" id="txtUpdatePrice" class="form-control" autocomplete="off">
                              </div>
                              <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                          </form>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <div class="modal fade" id="deleteModal">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <div class="card-body text-center">
                      <h3>Delete User: <span id="deleteId"></span></h3>
                  </div>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                    <form method="post" id="deleteForm" action="{{ route('products.destroy', $product->id) }}">
                        @csrf
                        @method('DELETE')
                        <div style="display: none;" id="hdnUserIdDelete"></div>
                        <button type="submit" name="submit" class="btn btn-danger">Delete</button>
                        <button type="submit" class="btn btn-light" id="deleteCancel">Cancel</button>
                    </form>
                </div>
          </div>
      </div>
  </div>
    
    <div class="container" style="margin-top: 100px;">
        @yield('content')
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    
    <script>
       /*function reloadTable() {
        $.ajax({
            url: "/products/",
            datatype: 'html',
            beforeSend: function (f) {
                //$('#userTable').html('Load Table ...');
            },
            success: function (data) {
                //$('#userTable').html(data);
                console.log(data);
                $('.container').html(data);
            }
        })
        }
        reloadTable();*/

       $(document).ready(function () {

           //Add the Product 
            $("#addUser").submit(function(e) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });
                e.preventDefault();
                console.log('mmm');
                var form_action = $("#addUser").attr("action");
                $.ajax({
                    data: $('#addUser').serialize(),
                    url: form_action,
                    type: "POST",
                    dataType: 'json',
                    success: function (res) {
                        console.log(res);
                        $('#addUser')[0].reset();
                        $('#addModal').modal('hide');
                        //$('.container').html('');
                        //reloadTable();
                    },
                    error: function (data) {
                        console.log('errrors');
                    }
                });
            });

            // Open modal when click update product
            $('body').on('click', '.btnUpdate', function (e) {
                e.preventDefault();
                var product_id = $(this).attr('data-id');
                $.ajax({
                    //url: "{{ URL::to('/products/' . $product->id . '/edit') }}",
                    url: "/products/" + product_id + '/edit',
                    type: "GET",
                    dataType: 'json',
                    success: function (res) {
                        console.log(res);
                        $('#updateModal').modal('show');
                        $('#updateProduct #hdnUserId').val(res.product.id);
                        $('#updateProduct #txtUpdateName').val(res.product.name);
                        $('#updateProduct #txtUpdateDesc').val(res.product.description);
                        $('#updateProduct #txtUpdatePrice').val(res.product.price);
                        },
                        error: function (data) {
                            console.log('errrors');
                        }
                }); 
            });

            // update product
            $("#updateProduct").submit(function(e) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });
                e.preventDefault();
                var form_action = $("#updateProduct").attr("action");
                var product_id = document.querySelector("#updateProduct #hdnUserId").value;
                console.log(form_action);
                //console.log(inputVal);
                    $.ajax({
                        data: $('#updateProduct').serialize(),
                        url: "/products/" + product_id,
                        type: "POST",
                        dataType: 'json',
                        success: function (res) {
                            //reloadTable();
                            $('#updateProduct')[0].reset();
                            $('#updateModal').modal('hide');
                        },
                        error: function (data) {
                            console.log('errrors');
                        }
                });
            });

            // Open modal when click delete product
            $('body').on('click', '.btnDelete', function (e) {
                e.preventDefault();
                var product_id = $(this).attr('data-id');
                $.ajax({
                    //url: "{{ URL::to('/products/' . $product->id . '/edit') }}",
                    url: "/products/" + product_id + '/edit',
                    type: "GET",
                    dataType: 'json',
                    success: function (res) {
                        //console.log(res.product.id);
                        $('#deleteModal').modal('show');
                        $('#deleteModal #hdnUserIdDelete').html(res.product.id);
                        $('#deleteModal #deleteId').html(res.product.name);
                        },
                        error: function (data) {
                            console.log('errrors');
                        }
                }); 
            });

            // ajax form for delete product
            $(function () {    
                $("#deleteForm").submit(function (e) {
                    e.preventDefault();
                    var form_data = $(this).serialize(); 
                    console.log(form_data);
                    var product_id = $('#deleteModal #hdnUserIdDelete').text();
                     
                    console.log(product_id);
                    $.ajax({
                        type: "POST", 
                        url: "/products/" + product_id,
                        dataType: "json", // Add datatype
                        data: form_data
                    }).done((data) => {
                        if(data.msg == 'success') {
                            console.log(data);
                            console.log('mmnyah');
                            $('#deleteModal').modal('hide');
                        //loadDataTable();
                        } else {
                            console.log(data);
                            alert("nope");
                        }
                    }).fail(function (data) {
                        console.log(data);
                    });
                }); 
            });

            // hide delete product modal on cancel
            $(function () {    
                document.getElementById("deleteCancel").addEventListener('click', function (e) {
                    e.preventDefault();
                    $('#deleteModal').modal('hide');
                }); 
            });
        });
    </script>
</body>

</html>