<!DOCTYPE html>
<html>
<head>
    <title>laravel Application using AJAX</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body style="background-image: url('http://www.desktopwallpaperhd.net/wallpapers/21/1/winter-wallpaper-tree-snow-sky-mountains-images-goodwp-nature-217793.jpg'); background-repeat: no-repeat;">
<br />
<div class="container box">
    <h3 align="center"></h3><br />
    <div class="panel panel-default">
        <div class="panel-heading">Customer Data</div>
        <div class="panel-body">
            <div id="message"></div>
            <div class="form-group">
                <input type="text" name="search" id="search" class="form-control" placeholder="Search Customer Data" />

            </div>
            <div class="table-responsive">
                {{--<h3 align="center">Total Data : <span id="total_records"></span></h3>--}}
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Customer Name</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>Postal Code</th>
                        <th>Country</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                {{ csrf_field() }}
            </div>
        </div>
    </div>
</div>
</body>
</html>

<script>
    $(document).ready(function(){

        function fetch_customer_data(query = '')
        {
            $.ajax({
                url:"{{ route('live_search.action') }}",
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    var html = '';
                    html += '<tr>';
                    html += '<td contenteditable id="customername"></td>';
                    html += '<td contenteditable id="address"></td>';
                    html += '<td contenteditable id="city"></td>';
                    html += '<td contenteditable id="postalcode"></td>';
                    html += '<td contenteditable id="country"></td>';
                    html += '<td><button type="button" class="btn btn-success btn-xs" id="add">Insert</button></td></tr>';
                    for(var count=0; count < data.length; count++)
                    {
                        html +='<tr>';
                        html +='<td contenteditable class="column_name" data-column_name="customername" data-id="'+data[count].id+'">'+data[count].customername+'</td>';
                        html += '<td contenteditable class="column_name" data-column_name="address" data-id="'+data[count].id+'">'+data[count].address+'</td>';
                        html += '<td contenteditable class="column_name" data-column_name="city" data-id="'+data[count].id+'">'+data[count].city+'</td>';
                        html += '<td contenteditable class="column_name" data-column_name="postalcode" data-id="'+data[count].id+'">'+data[count].postalcode+'</td>';
                        html += '<td contenteditable class="column_name" data-column_name="country" data-id="'+data[count].id+'">'+data[count].country+'</td>';
                        html += '<td><button type="button" class="btn btn-danger btn-xs delete" id="'+data[count].id+'">Delete</button></td></tr>';
                    }
                    $('tbody').html(html);

                    // $('tbody').html(data.table_data);
                    // $('#total_records').text(data.total_data);

                }
            })
        }

        fetch_data();

        function fetch_data()
        {
            $.ajax({
                url:"/live_search/fetch_data",
                dataType:"json",
                success:function(data)
                {
                    var html = '';
                    html += '<tr>';
                    html += '<td contenteditable id="customername"></td>';
                    html += '<td contenteditable id="address"></td>';
                    html += '<td contenteditable id="city"></td>';
                    html += '<td contenteditable id="postalcode"></td>';
                    html += '<td contenteditable id="country"></td>';
                    html += '<td><button type="button" class="btn btn-success btn-xs" id="add">Insert</button></td></tr>';
                    for(var count=0; count < data.length; count++)
                    {
                        html +='<tr>';
                        html +='<td contenteditable class="column_name" data-column_name="customername" data-id="'+data[count].id+'">'+data[count].customername+'</td>';
                        html += '<td contenteditable class="column_name" data-column_name="address" data-id="'+data[count].id+'">'+data[count].address+'</td>';
                        html += '<td contenteditable class="column_name" data-column_name="city" data-id="'+data[count].id+'">'+data[count].city+'</td>';
                        html += '<td contenteditable class="column_name" data-column_name="postalcode" data-id="'+data[count].id+'">'+data[count].postalcode+'</td>';
                        html += '<td contenteditable class="column_name" data-column_name="country" data-id="'+data[count].id+'">'+data[count].country+'</td>';
                        html += '<td><button type="button" class="btn btn-danger btn-xs delete" id="'+data[count].id+'">Delete</button></td></tr>';
                    }
                    $('tbody').html(html);
                }
            });
        }

        var _token = $('input[name="_token"]').val();

        $(document).on('click', '#add', function(){
            var customername = $('#customername').text();
            var address = $('#address').text();
            var city = $('#city').text();
            var postalcode = $('#postalcode').text();
            var country = $('#country').text();
            if(customername != '' && address != '' && city != '' && postalcode != '' && country != '')
            {
                $.ajax({
                    url:"{{ route('LiveSearch.add_data') }}",
                    method:"POST",
                    data:{customername:customername, address:address,city:city,postalcode:postalcode,country:country, _token:_token},
                    success:function(data)
                    {
                        $('#message').html(data);
                        fetch_data();
                    }
                });
            }
            else
            {
                $('#message').html("<div class='alert alert-danger'>Both Fields are required</div>");
            }
        });

        $(document).on('blur', '.column_name', function(){
            var column_name = $(this).data("column_name");
            var column_value = $(this).text();
            var id = $(this).data("id");

            if(column_value != '')
            {
                $.ajax({
                    url:"{{ route('LiveSearch.update_data') }}",
                    method:"POST",
                    data:{column_name:column_name, column_value:column_value, id:id, _token:_token},
                    success:function(data)
                    {
                        $('#message').html(data);
                    }
                })
            }
            else
            {
                $('#message').html("<div class='alert alert-danger'>Enter some value</div>");
            }
        });

        $(document).on('click', '.delete', function(){
            var id = $(this).attr("id");
            if(confirm("Are you sure you want to delete this records?"))
            {
                $.ajax({
                    url:"{{ route('LiveSearch.delete_data') }}",
                    method:"POST",
                    data:{id:id, _token:_token},
                    success:function(data)
                    {
                        $('#message').html(data);
                        fetch_data();
                    }
                });
            }
        });

        $(document).on('keyup', '#search', function(){
            var query = $(this).val();
            fetch_customer_data(query);
        });
    });
</script>
