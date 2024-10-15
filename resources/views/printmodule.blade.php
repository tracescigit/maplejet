@extends('dummy.app_new')

@section('content')
<!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet"> -->
<style>
    /* Custom styles */
    body {
        font-family: 'Numans', sans-serif;
        /* background-color: #f8f9fa; */
        /* Light gray background */
    }

    .card {
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        overflow: hidden;
    }

    .card-header {
        background-color: #6c757d;
        color: #fff;
        border-bottom: none;
    }

    .head-print {
        font-size: 30px;
        font-weight: bold;
        text-align: center;
        margin-top: 10px;
        margin-bottom: 20px;
    }

    .form-label {
        font-weight: bold;
    }

    .btn-custom {
        background: linear-gradient(45deg, #700877 0%, #ff2759 100%);
        color: white;
        border-radius: 5px;
        padding: 10px 20px;
        font-size: 14px;
        border: none;
        transition: background-color 0.3s ease;
    }

    .btn-custom:hover {
        background-color: #8a0278;
    }

    .table {
        margin-top: 20px;
    }

    .checkdiv {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .checkdiv span {
        margin-left: 10px;
    }

    .le-checkbox {
        appearance: none;
        position: relative;
        height: 30px;
        width: 30px;
        border-radius: 50%;
        border: 2px solid #ccc;
        cursor: pointer;
    }

    .le-checkbox:checked {
        background-color: #4CAF50;
        border-color: #4CAF50;
    }

    .camera-status {
        font-weight: bold;
    }
</style>

<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <div id="hello"></div>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="content content-components">
    <div class="container">
        <div class="d-flex bg-gray-10">
            <div class="pd-10 flex-grow-1">
                <h4 id="section3" class="mg-b-10 font-weight-bolder">Print Module</h4>
                <p class="mg-b-30">Use this page for <code style="color:#e300be;">Print</code> Jobs.</p>
                <hr>
            </div>

            <div class="pd-10 mg-l-auto">
                <button type=" button" class="btn btn-custom btn-icon" onclick="downloadexcel()"><i data-feather="download" class="mr-1"></i>Export</button>
            </div>
        </div>


        @if(session('status'))
        <div class="alert alert-danger" role="alert">
            {{ session('status') }}
        </div>
        @endif

        <div data-label="Data" class="df-example mg-b-30">

            <form method="POST" action="{{ route('jobs.store') }}">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-8 mx-auto">
                        <label for="job" class="form-label">Select Job</label>
                        <select name="job" id="job" class="form-control">
                            <option value="">Please select</option>
                            @foreach($job as $value)
                            <option value="{{ $value->id }}">{{ $value->code }}</option>
                            @endforeach
                        </select>
                        <div id="job_error" style="color: red;"></div>
                    </div>

                </div>


                <div class="col-md-8 mx-auto">
                    <table class="table table-bordered table-striped">
                        <tbody id="table-body">
                            <tr>
                                <td><strong>Batch:</strong></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><strong>MFG date:</strong></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><strong>EXP Date:</strong></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><strong>Price:</strong></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><strong>Link:</strong></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12 d-flex justify-content-center">
                    <div class="checkdiv mx-4 ">
                        <input type="checkbox" class="le-checkbox thisonetocheck" disabled>
                        <span class="camera-status">Printer Status</span>
                    </div>
                    <div class="checkdiv mx-4">
                        <input type="checkbox" class="le-checkbox thiscameratocheck" disabled>
                        <span class="camera-status">Camera Status</span>
                    </div>

                    <div id="message" style="color:green"></div>
                    <div id="message_error" style="color:red"></div>
                </div>
                <div class="text-center mb-3 col-12 mt-2">
                    <button class="btn btn-success start-print mx-auto" type="button" onclick="ajaxfunction()">Start Print</button>
                    <button class="btn btn-danger button-print mx-3" type="button" onclick="ajaxfunctionstop()">Stop Print</button>
                </div>
            </form>

        </div>
        <div data-label="Camera stats" class="df-example mg-b-30">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="font-weight-bold text-center mb-3">Camera Data Log</h3>
                    <table id="camera-data-table" class="table">
                        <thead>
                            <tr>
                                <th>Serial No</th>
                                <th>Message</th>
                                <th>Data</th>
                                <th>Current Time</th>
                                <th>Remark</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Rows will be added here dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>
            </form>
        </div>
        <!-- Modal HTML -->
        <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="statusModalLabel">Change Job Status</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="statusForm">
                            <div class="form-group">
                                <label for="jobSelect">Select Job</label>
                                <select id="jobSelect" name="jobSelect" class="form-control" required>
                                    @foreach($job as $value)
                                    <option value="{{ $value->id }}">{{ $value->code }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="statusSelect">Select Status</label>
                                <select id="statusSelect" name="statusSelect" class="form-control" required>
                                    <option value="all">Select All</option>
                                    <option value="printed">Printed</option>
                                    <option value="not_printed">Not Printed</option>
                                    <option value="verified">Verified</option>
                                    <option value="not_verified">Not Verified</option>
                                </select>
                            </div>
                            <div id="job_error" class="text-danger"></div> <!-- Error message container -->
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Save changes</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $('.alert').hide();
    var data = '';
    $(document).ready(function() {
        $('#job').change(function() {
            var jobId = $(this).val();
            if (jobId) {
                $.ajax({
                    url: '{{route("print_job")}}',
                    type: 'GET',
                    data: {
                        job_id: jobId
                    },
                    timeout: 300000,
                    success: function(response) {
                        data = response;
                        console.log(response);
                        $('#table-body').html('');

                        function formatDate(dateString) {
                            var date = new Date(dateString);
                            var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
                                "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
                            ];
                            var month = monthNames[date.getMonth()];
                            var year = date.getFullYear();
                            return month + '-' + year;
                        }
                        var html = '<tr>' +
                            '<td><strong>Batch:</strong></td>' +
                            '<td>' + response.batches_name + '</td>' +
                            '</tr>' +
                            '<tr>' +
                            '<td><strong>MFG date:</strong></td>' +
                            '<td>' + formatDate(response.mfg_date) + '</td>' +
                            '</tr>' +
                            '<tr>' +
                            '<td><strong>EXP Date:</strong></td>' +
                            '<td>' + formatDate(response.exp_date) + '</td>' +
                            '</tr>' +
                            '<tr>' +
                            '<td><strong>Price:</strong></td>' +
                            '<td>' + response.price + '</td>' +
                            '</tr>' +
                            '<tr>' +
                            '<td><strong>Link:</strong></td>' +
                            '<td>' + response.url + '</td>' +
                            '</tr>';
                        $('#table-body').html(html);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            } else {
                console.log('Please select a job');
            }
        });

    });
    $(document).ready(function() {
        $('#statusForm').on('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission

            // Serialize the form data
            var formData = $(this).serialize();
            // Make AJAX request
            $.ajax({
                url: '{{ route("downloadexcell") }}', // Ensure this is the correct route
                type: 'GET',
                data: formData,
                xhrFields: {
                    responseType: 'blob' // Ensure response is handled as binary data
                },
                success: function(blob) {
                    var url = window.URL.createObjectURL(blob);
                    var a = document.createElement('a');
                    a.href = url;
                    a.download = 'jobdataexcel.xlsx'; // Set the filename for download
                    document.body.append(a);
                    a.click();
                    a.remove();
                    window.URL.revokeObjectURL(url);
                    console.log('Excel file exported successfully');
                },
                error: function(xhr, status, error) {
                    console.error('Error exporting Excel file:', error);
                }
            });
        });

    });




    function ajaxfunction() {
        if (data) {
            var jobId = $('#job').val();
            if (data.printer_name) {
                $.ajax({
                    url: '{{route("checkprintconnection")}}',
                    type: 'GET',
                    data: {
                        job_id: jobId,
                        data: data
                    },
                    timeout: 300000,
                    success: function(response) {
                        console.log(response);
                        if (response.message == 'Printer connected successfully!') {
                            checkedbox();

                            $.ajax({
                                url: '{{route("SendPrintData")}}',
                                type: 'GET',
                                data: {
                                    job_id: jobId,
                                    data: data
                                },
                                success: function(response) {
                                    console.log(response);
                                    $('#message').html();
                                    $('#message').html(response);
                                    setTimeout(function() {
                                        $('#message').text('');
                                    }, 10000);

                                },
                                error: function(xhr, status, error) {
                                    console.error(xhr.responseText);
                                }
                            });
                        } else {
                            uncheckedbox();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            } else {

                $.ajax({
                    url: '{{route("checkprintconnection")}}',
                    type: 'GET',
                    data: {
                        job_id: jobId,
                        data: data
                    },
                    timeout: 300000,
                    success: function(response) {
                        if (response.message == 'Printer connected successfully!') {

                            $.ajax({
                                url: '{{route("SendPrintData")}}',
                                type: 'GET',
                                data: {
                                    job_id: jobId,
                                    data: data
                                },
                                success: function(response) {
                                    console.log(response);
                                    $('#message').html();
                                    $('#message').html(response);
                                    setTimeout(function() {
                                        $('#message').text('');
                                    }, 10000);

                                },
                                error: function(xhr, status, error) {
                                    console.error(xhr.responseText);
                                }
                            });
                        } else {}
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        } else {
            $('#job_error').html();
            $('#job_error').text("Please Select a Job First");
            setTimeout(function() {
                $('#job_error').text('');
            }, 10000);
        }

    }

    function ajaxfunctionstop() {
        if (data) {
            var jobId = $('#job').val();
            $.ajax({
                url: '{{route("stopprint")}}',
                type: 'GET',
                data: {
                    job_id: jobId,
                    data: data
                },
                timeout: 300000,
                success: function(response) {
                    console.log(response.message);
                    $('#hello').html('');
                    $('#message').html('');
                    $('#hello').text(response.message);
                    $('.alert').show();
                    uncheckedbox();

                    setTimeout(function() {
                        $('.alert').hide();
                    }, 3000);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        } else {
            $('#job_error').html();
            $('#job_error').text("Please Select a Job First");
            setTimeout(function() {
                $('#job_error').text('');
            }, 5000);
        }
    }

    function downloadexcel() {
        $('#statusModal').modal('show'); // Corrected selector: remove the dot before the ID selector
    }


    document.addEventListener("DOMContentLoaded", function() {
        console.log('First DOMContentLoaded listener');

        // Change 'localhost' to your public IP address
        const ws = new WebSocket('ws://localhost:6001'); // Use your public IP address or domain name
        console.log('WebSocket object created');

        const responseContainer = document.getElementById('camera-data-table');

        ws.onopen = function() {
            console.log('WebSocket connection established');
            thiscameratocheck(); // Ensure this function is defined elsewhere
        };

        let serialNo = 1;

        ws.onmessage = function(event) {
            console.log('Message event received');
            const message = event.data;
            console.log('Received message:', message);

            // Handle incoming messages
            if (message) {
                const jobId = $('#job').val();
                console.log('Job ID:', jobId);
                // Validate jobId to ensure it is not empty
                if (!jobId) {
                    $('#job_error').text("Receiving data from Camera. Please Select a Job");
                    setTimeout(function() {
                        $('#job_error').text('');
                    }, 10000);
                    return; // Exit early if no jobId is selected
                }

                // Perform AJAX request
                $.ajax({
                    url: '{{ route("cameradatacheck") }}',
                    type: 'GET',
                    data: {
                        message: message,
                        job_id: jobId,
                        data: data // Ensure 'data' is defined elsewhere
                    },
                    success: function(response) {
                        console.log('AJAX success response:', response);
                        if (response.message !== 'All correct') {
                            appendToTable(serialNo++, response.message, response.data, new Date().toLocaleString(), response.remark || '');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX request failed:', xhr.responseText);
                    }
                });
            } else {
                // Handle case when the message is empty
                $('#job_error').text("No data received from Camera.");
                setTimeout(function() {
                    $('#job_error').text('');
                }, 10000);
            }
        };

        ws.onerror = function(error) {
            console.error('WebSocket error:', error);
        };

        ws.onclose = function() {
            console.log('WebSocket connection closed');
            thiscameratouncheck(); // Ensure this function is defined elsewhere
        };
    });






    function appendToTable(serialNo, message, data, currentTime, remark) {
        const tableBody = $('#camera-data-table tbody');
        const cleanedData = data.replace(/\s+/g, '');
        const newRow = `
        <tr>
            <td>${serialNo}</td>
            <td>${message}</td>
            <td>${cleanedData}</td>
            <td>${currentTime}</td>
            <td>${remark}</td>
        </tr>
    `;
        tableBody.append(newRow);
    }
</script>
<script>
    pentitle = "Checkboxes";

    function checkedbox() {
        $('.thisonetocheck').prop('checked', true);
    }

    function uncheckedbox() {
        $('.thisonetocheck').prop('checked', false);
    }

    function thiscameratocheck() {
        $('.thiscameratocheck').prop('checked', true);
    }

    function thiscameratouncheck() {
        $('.thiscameratocheck').prop('checked', false);
    }
</script>

<script>
    // $(document).ready(function() {
    //     // Function to check camera connection status
    //     function checkCameraConnection() {
    //         $.ajax({
    //             url: '{{ route("dashboard.checkConnection") }}',
    //             type: 'GET',
    //             dataType: 'json',
    //             success: function(response) {
    //                 console.log(response);
    //                 if (response.isCameraConnected) {
    //                     $('#connectionStatus').text('Camera is connected.');
    //                 } else {
    //                     $('#connectionStatus').text('Camera is disconnected.');
    //                 }
    //             },
    //             error: function(xhr, status, error) {
    //                 console.error('Error checking camera connection:', error);
    //             }
    //         });
    //     }

    //     // Initial check when the page loads
    //     checkCameraConnection();

    //     // Repeat check every 5 seconds
    //     setInterval(checkCameraConnection, 5000);
    // });
</script>

@endsection