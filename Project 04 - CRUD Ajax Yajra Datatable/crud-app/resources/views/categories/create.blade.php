<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Create Category</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"
            integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    </head>

    <body>


        <!-- Modal -->
        <div class="modal fade ajax-modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">

            <form action="" id="ajaxForm">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="modal-title"></h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="category_id" id="category_id">
                            <div class="form-group mb-3">
                                <label for="name">Name</label>
                                <input type="text" id="name" name="name" class="form-control">
                                <span id="nameError" class="text-danger error-messages"></span>
                            </div>
                            <div class="form-group mb-1">
                                <label for="type">Type</label>
                                <select id="type" name="type" class="form-control">
                                    <option disabled selected>Choose Option</option>
                                    <option value="electronics">Electronic</option>
                                </select>
                                <span id="typeError" class="text-danger error-messages"></span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="saveBtn"></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Button trigger modal -->
        <div class="row">

            <div class="col-lg-8 offset-2" style="margin-top: 100px">


                <table id="category-table" class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Type</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

            </div>

        </div>



        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
            crossorigin="anonymous"></script>


        <script>

            $(document).ready(function () {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });


                var table = $('#category-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('categories.index') }}",
                    dom: '<"d-flex justify-content-between align-items-center mb-3"l<"custom-btn">f>rtip',
                    columns: [
                        { data: 'id' },
                        { data: 'name' },
                        { data: 'type' },
                        { data: 'action', name: 'action', orderable: false, searchable: false },
                    ],
                    initComplete: function () {
                        // Move your Add Category button into the custom container
                        $('.custom-btn').html(`<a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" id="add_category">Add Category</a>`);
                    }
                });

                $('#modal-title').html('Create Category');
                $('#saveBtn').html('Save Category');

                var form = $('#ajaxForm')[0];

                $('#saveBtn').click(function () {

                    $('.error-messages').html('');

                    var form_data = new FormData(form);
                            
                    $.ajax({
                        url: '{{ route("categories.store")}}',
                        method: 'POST',
                        processData: false,
                        contentType: false,
                        data: form_data,

                        success: function (response) {
                            table.ajax.reload();
                            $('#name').val('');
                            $('#type').val('');
                            $('#category_id').val('');

                            $('.ajax-modal').modal('hide');
                            swal("Success!", response.success, 'success');
                        },

                        error: function (error) {
                            if (error) {
                                $('#nameError').html(error.responseJSON.errors.name)
                                $('#typeError').html(error.responseJSON.errors.type)
                            }
                        }
                    });
                });


                $('body').on('click', '.editButton', function (event) {
                    event.preventDefault(); // prevent page reload

                    var id = $(this).data('id');

                    $.ajax({
                        url: "{{ url('categories') }}/" + id + "/edit",
                        method: 'GET',
                        success: function (response) {
                            $('.ajax-modal').modal('show');
                            $('#modal-title').html('Edit Category');
                            $('#saveBtn').html('Update Category');

                            $('#category_id').val(response.id);
                            $('#name').val(response.name);
                            var type = capitalizeFirstLetter(response.type);
                            $('#type').val(response.type); // Set by value (not ID)

                            // Keep existing dropdown and just select correct option
                            // Optionally update dropdown if needed like this:
                            // $('#type').empty().append('<option selected value="' + response.type + '">' + type + '</option>');

                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
                });

                $('#add_category').click(function () {
                    $('#modal-title').html('Create Category');
                    $('#saveBtn').html('Save Category');
                });

                function capitalizeFirstLetter(word) {
                    return word.charAt(0).toUpperCase() + word.slice(1);
                }


                $('body').on('click', '.delButton', function () {
                    var id = $(this).data('id');

                    $.ajax({
                        url: "{{ url('categories/destroy') }}/" + id,
                        method: 'DELETE',
                        success: function (response) {
                            table.ajax.reload();
                            swal("Success!", response.success, 'success');
                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
                });




            });

        </script>

    </body>

</html>